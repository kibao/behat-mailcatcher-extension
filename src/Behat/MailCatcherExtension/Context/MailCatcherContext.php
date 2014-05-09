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
use Behat\Behat\Context\TranslatableContext;
use Kibao\MailCatcher\ClientInterface;

/**
 * MailCatcher context for Behat BDD tool.
 * Provides MailCatcher base step definitions.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class MailCatcherContext implements Context, MailCatcherAwareContext, TranslatableContext
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

    /**
     * @Then /^(?P<count>\d+) mails? should be sent$/
     */
    public function mailShouldBeSent($count)
    {
        $count = (int) $count;
        $actual = $this->mailcatcher->count();

        if ($count !== $actual) {
            throw new \InvalidArgumentException(sprintf('Expected %d mails to be sent, got %d.', $count, $actual));
        }
    }

    /**
     * @When /^(?:|I )purge mails$/
     */
    public function purge()
    {
        $this->mailcatcher->purge();
    }

    /**
     * Returns list of definition translation resources paths.
     *
     * @return string[]
     */
    public static function getTranslationResources()
    {
        return glob(__DIR__ . '/../../../../i18n/*.xliff');
    }

}
