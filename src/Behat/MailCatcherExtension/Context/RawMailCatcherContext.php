<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\Behat\MailCatcherExtension\Context;

use Behat\Behat\Context\Context;
use Kibao\MailCatcher\ClientInterface;

/**
 * RawMailCatcher context for Behat BDD tool.
 * Provides preconfigured MailCatcher with basic methods.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class RawMailCatcherContext implements Context, MailCatcherAwareContext
{

    /**
     * @var ClientInterface
     */
    protected $mailcatcher;

    /**
     * Sets MailCatcher Client instance.
     *
     * @param ClientInterface $mailcatcher
     */
    public function setMailCatcher(ClientInterface $mailcatcher)
    {
        $this->mailcatcher = $mailcatcher;
    }

    public function assertNumMails($count)
    {
        $count = (int) $count;
        $actual = $this->mailcatcher->count();

        if ($count !== $actual) {
            throw new \InvalidArgumentException(sprintf('Expected %d mails to be sent, got %d.', $count, $actual));
        }
    }

    public function purge()
    {
        $this->mailcatcher->purge();
    }
}
