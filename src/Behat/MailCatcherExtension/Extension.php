<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\Behat\MailCatcherExtension;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * MailCatcher extension for Behat class.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class Extension implements ExtensionInterface
{
    const MAILCATCHER_ID = 'kibao.mailcatcher.client';
    const CONNECTION_ID = 'kibao.mailcatcher.connection';

    const DEFAULT_CLIENT_ID = 'kibao.mailcatcher.client.default';
    const GUZZLE_ID = 'kibao.mailcatcher.guzzle.client';
    const CONNECTION_GUZZLE_ID = 'kibao.mailcatcher.connection.guzzle';
    const ADDRESS_TRANSFORMER_ID = 'kibao.mailcatcher.transformer.address';
    const MESSAGE_TRANSFORMER_ID = 'kibao.mailcatcher.transformer.message';

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'kibao_mailcatcher';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $boolFilter = function ($v) {
            $filtered = filter_var($v, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            return (null === $filtered) ? $v : $filtered;
        };

        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('client')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('url')->defaultValue('http://localhost')->end()
                        ->scalarNode('port')->defaultValue('1080')->end()
                    ->end()
                ->end()
                ->booleanNode('purge_before_scenario')
                    ->beforeNormalization()
                        ->ifString()->then($boolFilter)
                    ->end()
                    ->defaultTrue()
                ->end()
                ->scalarNode('mailcatcher_client')->defaultValue(self::DEFAULT_CLIENT_ID)->end()
                ->scalarNode('mailcatcher_connection')->defaultValue(self::CONNECTION_GUZZLE_ID)->end()
            ->end()
        ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadTransformers($container);
        $this->loadGuzzleConnection($container, $config);
        $this->loadClient($container);
        $this->loadContextInitializer($container);

        if ($config['purge_before_scenario']) {
            $this->loadPurgeListener($container);
        }

        $container->setAlias(self::CONNECTION_ID, $config['mailcatcher_connection']);
        $container->setAlias(self::MAILCATCHER_ID, $config['mailcatcher_client']);
    }

    private function loadTransformers(ContainerBuilder $container)
    {
        $container->setDefinition(self::ADDRESS_TRANSFORMER_ID, new Definition('Kibao\MailCatcher\Transformer\ArrayToAddressTransformer'));
        $messageTransformer = new Definition('Kibao\MailCatcher\Transformer\ArrayToMessageTransformer', array(
            new Reference(self::ADDRESS_TRANSFORMER_ID)
        ));
        $container->setDefinition(self::MESSAGE_TRANSFORMER_ID, $messageTransformer);
    }

    private function loadGuzzleConnection(ContainerBuilder $container, $config)
    {
        $container->setDefinition(self::GUZZLE_ID, new Definition('\Guzzle\Http\Client', array(
            $config['client']['url'] . ':' . $config['client']['port']
        )));

        $container->setDefinition(self::CONNECTION_GUZZLE_ID, new Definition('Kibao\MailCatcher\Connection\GuzzleConnection', array(
            new Reference(self::GUZZLE_ID),
        )));
    }

    private function loadClient(ContainerBuilder $container)
    {
        $container->setDefinition(self::DEFAULT_CLIENT_ID, new Definition('Kibao\MailCatcher\Client', array(
            new Reference(self::MESSAGE_TRANSFORMER_ID),
            new Reference(self::CONNECTION_ID),
        )));
    }

    private function loadContextInitializer(ContainerBuilder $container)
    {
        $definition = new Definition('Kibao\Behat\MailCatcherExtension\Context\Initializer\MailCatcherAwareInitializer', array(
            new Reference(self::MAILCATCHER_ID),
        ));
        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('kibao.mailcatcher.context_initializer.mailcatcher_aware', $definition);
    }

    private function loadPurgeListener(ContainerBuilder $container)
    {
        $definition =  new Definition('Kibao\Behat\MailCatcherExtension\EventListener\PurgeListener', array(
            new Reference(self::MAILCATCHER_ID),
        ));
        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, array('priority' => 0));
        $container->setDefinition('kibao.mailcatcher.event_listener.purge_listener', $definition);
    }

}
