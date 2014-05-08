<?php

/*
 * This file is part of the Behat MailCatcherExtension package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct($mailcatcher_smtp_host, $mailcatcher_smtp_port)
    {
        $this->mailcatcher_smtp_host = $mailcatcher_smtp_host;
        $this->mailcatcher_smtp_port = $mailcatcher_smtp_port;
    }

    /**
     * @When I send email to :email with message :body
     */
    public function iSendEmailWithMessage($email, $body)
    {
        $message = new \Swift_Message('Subject', $body);
        $message->setSender('john@example.com');
        $message->setTo($email);

        $this->sendEmail($message);
    }

    private function sendEmail(\Swift_Message $message)
    {
        $transport = \Swift_SmtpTransport::newInstance($this->mailcatcher_smtp_host, $this->mailcatcher_smtp_port);
        $mailer = \Swift_Mailer::newInstance($transport);

        if (!$mailer->send($message)) {
            throw new \RuntimeException('Unable to send message');
        }
        $transport->stop();
    }

}
