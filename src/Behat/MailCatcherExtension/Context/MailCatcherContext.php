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

/**
 * MailCatcher context for Behat BDD tool.
 * Provides MailCatcher base step definitions.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class MailCatcherContext extends RawMailCatcherContext implements TranslatableContext
{
    /**
     * @Then /^(?P<count>\d+) mails? should be sent$/
     */
    public function assertNumMails($count)
    {
        parent::assertNumMails($count);
    }

    /**
     * @When /^(?:|I )purge mails$/
     */
    public function purge()
    {
        parent::purge();
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
