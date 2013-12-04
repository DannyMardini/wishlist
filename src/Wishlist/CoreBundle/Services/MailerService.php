<?php

namespace Wishlist\CoreBundle\Services;

use Wishlist\CoreBundle\Entity\Request;
use Wishlist\CoreBundle\Entity\Token;

class MailerService
{
    protected $mailer;
    protected $templating;
    protected $doctrine;

    function __construct($mailer, $templating, $doctrine)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->doctrine = $doctrine;
    }

    public function sendInvite(Request $request)
    {
        //Get Which User invited this person.
        $userInvited = $request->getUserInvited();

        if($userInvited)
        {
            //If this person was invited by someone, send the friend invite email.

            $userInvitedName = $userInvited->getName();
            $htmlbody = $this->templating->render('WishlistUserBundle:Email:friendinvite.html.php', array('name' => $userInvitedName, 'acceptId' => $request->getAcceptString()));
            $textbody = strip_tags($htmlbody).'http://wishenda.com/join';
            
            $this->sendMail($request->getEmail(), $this->getFriendInviteSubject(), $htmlbody, $textbody);
        }
        else
        {
            //Else send the person a standard invite email.

            $htmlbody = $this->templating->render('WishlistUserBundle:Email:standardinvite.html.php', array('acceptId' => $request->getAcceptString()));
            $textbody = strip_tags($htmlbody).'http://wishenda.com/join';

            $this->sendMail($request->getEmail(), $this->getStandardInviteSubject(), $htmlbody, $textbody);
        }

        $em = $this->doctrine->getEntityManager();
        $request->setDateLastInvited(new \DateTime('now'));
        $em->flush();
    }
    
    public function sendResetPasswordEmail(Token $token)
    {
        $userEmail = $token->getUser()->getEmail();
        $htmlbody = $this->templating->render('WishlistUserBundle:Email:submitNewPassword.html.php', 
                array('token' => $token->getToken(), 'username' => $token->getUser()->getName(), 'email' => $userEmail));
        $textbody = strip_tags($htmlbody).'http://wishenda.com/password/submitnewview/';
        $this->sendMail($userEmail, "Reset your password on Wishenda", $htmlbody, $textbody);
        $em = $this->doctrine->getEntityManager();
        $em->flush();
    }    

    public function sendMail($to, $subject, $htmlBody, $textBody)
    {
        $textBody = urldecode($textBody);
        $htmlBody = urldecode($htmlBody);
        
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
        return "Create your account on Wishenda!";
    }

    public function getFriendInviteSubject()
    {
        return "Your friend needs help figuring out what to get you!";
    }
}
