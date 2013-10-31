<?php

namespace Wishlist\CoreBundle\Services;

class MailerService
{
    protected $mailer;

    function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    function sendMail($to, $subject, $htmlBody, $textBody)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('wishthrowaway@gmail.com')
            ->setTo($to)
            ->setBody($htmlBody, 'text/html')
            ->addPart($textBody, 'text/plain');
        
        if (!$this->mailer->send($message))
        {
            throw new Exception();
        }
    }

}
