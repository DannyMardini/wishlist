<?php

namespace Wishlist\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();
        $session->set('email_addr', '');
        $session->set('user_id', '');
        $session->clear();
        
        return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');
    }
    
    public function navBarAction($username)
    {
        return $this->render('WishlistFrontpageBundle:Default:navBarTest.html.php', array('username' => $username));
    }
    
    public function validateLoginAction()
    {                  
        try
        {
            $response = "";
            $email = $this->getRequest()->get('email');
            $password = $this->getRequest()->get('password');

            if(!$email || !$password)
            {
                $response = "Sorry about this! The system could not read your email and/or password. Please refresh your browser and try again. <br /><br />-Wishlist Team";           
            }
            else
            {
                $userId = $this->getDoctrine()->getEntityManager()->
                        getRepository('WishlistCoreBundle:WishlistUser')->validateEmailAndPassword($email, $password);

                if($userId)
                {
                    $session = $this->getRequest()->getSession();
                    $session->set('email_addr', $email);
                    $session->set('user_id', $userId);
                    $response = "continue";
                }
                else
                {
                    $response = "The member could not be found, please check your email and password and try again. <br /><br />-Wishlist Team";              
                }
            }
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while validating your email and password. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }


    }
    
    public function requestInviteAction()
    {
        try {
            $response = "The invite request has been submitted! We will contact you when we are ready for you to join!";
            $email = $this->getRequest()->get('email');
            
            if(!$email)
            {   
                $response = "Sorry about this! The system could not read your email. Please refresh your browser and try again. <br /><br />-Wishlist Team";           
            }
            
            // make a database call to store the email in the invite queue
            $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Request')->addInviteToQueue($email, null);           
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while submitting your request. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }
    }
}
