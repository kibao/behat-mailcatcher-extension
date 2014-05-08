<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\Behat\MailCatcherExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Kibao\Behat\MailCatcherExtension\Context\MailCatcherAwareContext;
use Kibao\MailCatcher\ClientInterface;

/**
 * MailCatcher Client aware contexts initializer.
 * Sets MailCatcher Client instance to the MailCatcherAware contexts.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
final class MailCatcherAwareInitializer implements ContextInitializer
{
    private $mailcatcher;

    /**
     * Initializes initializer.
     *
     * @param ClientInterface $mailcatcher
     */
    public function __construct(ClientInterface $mailcatcher)
    {
        $this->mailcatcher = $mailcatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function initializeContext(Context $context)
    {
        if (!$context instanceof MailCatcherAwareContext) {
            return;
        }

        $context->setMailCatcher($this->mailcatcher);
    }
}
