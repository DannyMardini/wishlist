<?php

namespace Wishlist\CoreBundle\Services;

use Wishlist\CoreBundle\Entity\Request;
use Wishlist\CoreBundle\Entity\Token;
use Wishlist\CoreBundle\Entity\Purchase;
use Wishlist\CoreBundle\Entity\PurchaseEventTypes;

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
    
    public function getStandardUpdatePurchaseSubject()
    {
        return "A shopping list item has been updated on Wishenda!";
    }    

    public function getStandardFriendConfirmationSubject()
    {
        return "You have a new friend on Wishenda!";
    }

    public function getStandardFriendRequestSubject()
    {
        return "You have a friend request on Wishenda!";
    }    
    
    public function getFriendInviteSubject()
    {
        return "Your friend has invited you to join Wishenda!";
    }
    
    public function getStandardExpiredPurchasesSubject()
    {
        return "You have expired shopping list items on Wishenda!";
    }
    
    public function sendFriendConfirmation($userA, $userB)
    {
        $success = false;
        $htmlbody = null; 
        $textbody = null;
        
        if(!isset($userA) || !isset($userB))
        {
            return $success;
        }
        
        $htmlbody = $this->templating->render('WishlistUserBundle:Email:friendConfirmation.html.php', 
                array('name' => $userA->getFirstName(), 'friendname' => $userB->getName()));
        $textbody = strip_tags($htmlbody);
        if(isset($htmlbody) && isset($textbody))
        {
            $this->sendMail($userA->getEmail(), $this->getStandardFriendConfirmationSubject(), $htmlbody, $textbody);
            $success = true;
        }
        
        return $success;        
    }
    
    public function sendFriendRequest($requester, $friend, $notificationId)
    {
        // Send email to A letting them know that B wants to be their friend
        $success = false;
        $htmlbody = null; 
        $textbody = null;
        
        if(!isset($requester) || !isset($friend))
        {
            return $success;
        }
        
        $htmlbody = $this->templating->render('WishlistUserBundle:Email:friendRequest.html.php', 
                array('name' => $friend->getFirstName(), 
                    'friendname' => $requester->getName(), 
                    'notificationId' => $notificationId));
        $textbody = strip_tags($htmlbody);
        
        if(isset($htmlbody) && isset($textbody))
        {
            $this->sendMail($friend->getEmail(), $this->getStandardFriendRequestSubject(), $htmlbody, $textbody);
        }
        
        return $success;        
    }
    
    public function sendExpiredPurchaseReminder($user)
    {
        // Send email to A letting them know that B wants to be their friend
        $success = false;
        $htmlbody = null; 
        $textbody = null;
        
        if(!isset($user))
        {
            return $success;
        }
        
        $htmlbody = $this->templating->render('WishlistUserBundle:Email:expiredPurchasesReminder.html.php', 
                array('name' => $user->getFirstName()));
        $textbody = strip_tags($htmlbody);

        try 
        {
            if(isset($htmlbody) && isset($textbody))
            {        
                $this->sendMail($user->getEmail(), $this->getStandardExpiredPurchasesSubject(), $htmlbody, $textbody);
                $success = true;
            }
        }
        catch(Exception $e)
        {
            $success = false;
        }
        
        return $success;        
    }
    
    // TO DO: send notification to user. Explaining why the item was removed from 
    // their purchase list. It could be one of 2 reasons:
    // The user removed it themselves OR the item was auto removed by the system because
    // the friend removed the wish from their wishlist    
    private function purchaseEventNotification($event_type, $purchase)
    {
        $success = false;
        
        if(!isset($purchase))
        {
            return $success;
        }
        
        $itemName = $purchase->getItem()->getName();
        $userFullName = $purchase->getWishlistUser()->getName();
        $userFirstName = $purchase->getWishlistUser()->getFirstName();
        $thePurchaserEmail = $purchase->getUser()->getEmail();
        $htmlbody = null;
        $textbody = null;
        
        switch($event_type)
        {        
            case PurchaseEventTypes::RemovedFromWishlist :
                $htmlbody = "Hello! <br /><br />The following item: " + $itemName + " which you planned to purchase for " + 
                    $userFullName + " has been removed from your shopping list! <br />" + $userFirstName + 
                    " removed it from their wish list.";                
                $textbody = strip_tags($htmlbody);
                break;
            case PurchaseEventTypes::RemovedFromShoppingList :
                // not necessary to email the users since they already got a confirmation message in the GUI 
                // when they remove an item from their own shopping list
                break;            
            case PurchaseEventTypes::Purchased :
                $htmlbody = "Hello! <br /><br />The following item: " + $itemName + " which you planned to purchase for " + 
                    $userFullName + " has been removed from your shopping list! <br />" +
                    " You should have already purchased it and surprised your friend with the gift by now!<br /> " +
                    " If not, HURRY and do it! As of today, the item was removed from " + $userFullName + "'s wish list, " +
                    " and they know that one of their friends bought it for them!! ";
                $textbody = strip_tags($htmlbody);                
                break;
            case PurchaseEventTypes::Added :
                // not necessary to email the users since they already got a confirmation message in the GUI 
                // when they remove an item from their own shopping list                
                break;
            case PurchaseEventTypes::EventRemoved :
                $htmlbody = "Hello! <br /><br />The following item: " + $itemName + " which you planned to purchase for " + 
                    $userFullName + " has been removed from your shopping list! <br />" +
                    " The event that you were going to get the gift for was canceled/removed from Wishenda by your friend.";
                $textbody = strip_tags($htmlbody);
                break;            
            default :
                break;
        }
        
        if(isset($htmlbody) && isset($textbody))
        {
            $this->sendMail($thePurchaserEmail, $this->getStandardUpdatePurchaseSubject(), $htmlbody, $textbody);
        }
        
        return $success;
    }    
}
