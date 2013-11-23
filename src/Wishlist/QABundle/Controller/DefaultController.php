<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\Request;
use Wishlist\CoreBundle\Entity\Token;


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
    
    public function resetpasswordrequestAction()
    {
        try
        {
            $response = "";
            $email = $this->getRequest()->get('email');
            $user = null;
            $token = null;
            
            if(!$email)
            {
                $response = "The email was not filled in, please fill it in correctly. -Wishlist Team";
            }
            else
            {
                try {
                    $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
                    $user = $userRepo->getUserWithEmail($email);
                }
                catch(\Doctrine\ORM\NoResultException $e)
                {
                    return new Response ('Error: The email does not pertain to a user. Please retry with the correct email.');                    
                }
                
                $tokenRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Token');
                
                // Add reset-password token to the Token table for this user and send an email to the user
                $bytes = openssl_random_pseudo_bytes(Request::ACCEPT_STR_MAX_LENGTH, $cstrong);
                $randTokenId = bin2hex($bytes);
                
                $token = $tokenRepo->addNewToken($randTokenId, TOKEN::RESET_PASSWORD_REQUEST, $user); // 1: reset password token type
                $this->get("Mailer_Service")->sendResetPasswordEmail($token);
                $response = 'Success:You will receive an email shortly!';
            }
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while sending the message. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }        
    }
    
    public function SaveNewPasswordAction()
    {
        $error_message = 'Error:The request could not be processed. Please submit a new password reset request and try again with the new link that is emailed to you.';
        
        // check if the user with this email has a token pending for reset password
        $tokenRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Token');
        $tokenId = $this->getRequest()->query->get('token');
        $email = $this->getRequest()->query->get('email');
        if(!isset($tokenId) || !isset($email)) 
        {
            return new Response($error_message, DefaultController::SC_BAD_REQUEST);
        }
        
        $userToken = $tokenRepo->findOneByToken($tokenId);
        if(!isset($userToken)) 
        {
            return new Response($error_message, DefaultController::SC_BAD_REQUEST);
        }
        
        if( $userToken->getUser()->getEmail() != $email )
        {
            return new Response($error_message, DefaultController::SC_BAD_REQUEST);
        }
        
        $password1 = $this->getRequest()->get('new_password1');
        $password2 = $this->getRequest()->get('new_password2');
        if($password1 != $password2)
        {
            return new Response('Error:The request could not be completed because the passwords did not match. Please make sure the passwords match and try again. ');
        }
        
        // if yes, save the new password 
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $user = $userRepo->getUserWithEmail($email);
        
        if(!isset($user))
        {
            return new Response('Error:The request could not be processed. Please submit a new password reset request and try again with the new link that is emailed to you.', DefaultController::SC_BAD_REQUEST);
        }
        
        $userRepo->updatePassword($password1, $user);        
        
        // remove the token from the token table
        $tokenRepo->removeToken($userToken);        
        
        // send back a success message
        return new Response("Success:Password was successfully changed!");
    }

    public function SubmitNewPasswordAction()
    {
        return $this->render('WishlistQABundle:default:submitnewpassword.html.php');
    }     
    
    public function ForgotPasswordAction()
    {
        return $this->render('WishlistQABundle:default:resetpassword.html.php');
    }    
}
