<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\Behat\MailCatcherExtension\EventListener;

use Behat\Behat\EventDispatcher\Event\ExampleTested;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Kibao\MailCatcher\ClientInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * MailCatcher Purge Listener.
 * Purges MailCatcher before scenario.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class PurgeListener implements EventSubscriberInterface
{
    /**
     * @var ClientInterface
     */
    protected $mailcatcher;

    public function __construct(ClientInterface $mailcatcher)
    {
        $this->mailcatcher = $mailcatcher;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScenarioTested::BEFORE => array('purge', 15),
            ExampleTested::BEFORE => array('purge', 15),
        );
    }

    public function purge()
    {
        $this->mailcatcher->purge();
    }
}
