<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Kibao\Behat\MailCatcherExtension;

use PhpSpec\ObjectBehavior;

class ExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kibao\Behat\MailCatcherExtension\Extension');
    }

    function it_is_named_kibao_mailcatcher()
    {
        $this->getConfigKey()->shouldReturn('kibao_mailcatcher');
    }
}
