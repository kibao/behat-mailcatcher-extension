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
 * MailCatcher Client aware interface for contexts.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface  MailCatcherAwareContext extends Context
{
    /**
     * Sets MailCatcher Client instance.
     *
     * @param ClientInterface $mailcatcher
     */
    public function setMailCatcher(ClientInterface $mailcatcher);
}
