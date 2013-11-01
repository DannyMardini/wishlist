<?php

namespace Wishlist\CoreBundle\Services;

use Wishlist\CoreBundle\Entity\Request;

class MailerService
{
    protected $mailer;
    protected $templating;

    function __construct($mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendInvite(Request $request)
    {
        //Get Which User invited this person.
        $userInvited = $request->getUserInvited();

        if($userInvited)
        {
            //If this person was invited by someone, send the friend invite email.

            $userInvitedName = $userInvited->getName();
            $htmlbody = $this->templating->render('WishlistUserBundle:Email:friendinvite.html.php', array('name' => $userInvitedName));
            $textbody = strip_tags($htmlbody).'http://wishenda.com/join';
            
            $this->sendMail($request->getEmail(), $this->getFriendInviteSubject(), $htmlbody, $textbody);
        }
        else
        {
            //Else send the person a standard invite email.

            $htmlbody = $this->templating->render('WishlistUserBundle:Email:standardinvite.html.php');
            $textbody = strip_tags($htmlbody).'http://wishenda.com/join';

            $this->sendMail($request->getEmail(), $this->getStandardInviteSubject(), $htmlbody, $textbody);
        }
    }

    public function sendMail($to, $subject, $htmlBody, $textBody)
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

    public function getStandardInviteSubject()
    {
        return "You've been invited to Wishenda!";
    }

    public function getFriendInviteSubject()
    {
        return "Someone wants help figuring out what to get you!";
    }
}
