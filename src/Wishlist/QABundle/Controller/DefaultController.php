<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function helpAction()
    {
        return $this->render('WishlistQABundle:Default:Help.html.php');
    }
    
    public function gettingStartedAction()
    {
        return $this->render('WishlistQABundle:Default:GettingStarted.html.php');
    }
    
    public function wishlistHelpAction()
    {
        return $this->render('WishlistQABundle:Default:WishlistHelp.html.php');
    }
    
    public function contactSupportAction()
    {
        return $this->render('WishlistQABundle:Default:ContactSupport.html.php');
    }
    
    public function resetPasswordRequestAction()
    {
        try
        {
            $response = "";
            $email = $this->getRequest()->get('email');
            $link = "";
            
            if(!$email)
            {
                $response = "The email was not filled in, please fill it in correctly. -Wishlist Team";
            }
            else
            {
                $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
                $user = $userRepo->getUserWithEmail($email);
                
                if(!isset($user))
                {
                    return new Response ('The email does not pertain to a user. Please retry with the correct email.');
                }
                
                $full_message = 'Hello ' . $user->getName() . ' We received a request to reset your password. ' . 
                            ' If you did not submit this request please contact our Support Team immediately by emailing wishendasupport@wishnda.com ' .
                            ' Otherwise please click the following link to reset your password: ' . $link;
                $this->get("Mailer_Service")->sendMail("wishthrowaway@gmail.com", "User Inquiry", $full_message, $full_message);
                $response = 'success';
                
                // the link has to pass in the user ID so that we can know what user is changing their password
                // also set a flag in the DB to let us know that the user is waiting to change their password
                // only change it if this flag is set in the DB, else don't do anything.
                
                
            }
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while sending the message. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }        
    }
}
