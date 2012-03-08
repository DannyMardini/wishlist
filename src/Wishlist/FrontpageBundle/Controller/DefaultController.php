<?php

namespace Wishlist\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php', 
                array("showUserAdded" => "hullo", "loginURL" => "/app_dev.php/Frontpage/validateLogin"));
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
                    $response = "continue,".$userId;
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
            $response = "Sorry about this! An issue occurred while validating your emal and password. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }


    }
}
