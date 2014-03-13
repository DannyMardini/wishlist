<?php

namespace Wishlist\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\NoResultException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();
        $email = $session->get('email_addr');
        $userId = $session->get('user_id');
        if(isset($email) && isset($userId))
        {
            $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
            $user = $userRepo->getUserWithEmail($email);
            return $this->render('WishlistUserBundle:Default:homepage.html.php', array( 'user' => $user));
        }
        return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');
    }

    public function logoutAction()
    {
        $session = $this->getRequest()->getSession();
        $session->set('email_addr', '');
        $session->set('user_id', '');
        $session->clear();

        return new Response('success');
    }
    
    public function validateLoginAction()
    {                  
        try
        {
            $response = "";
            $email = $this->getRequest()->get('email');
            $password = $this->getRequest()->get('password');
            $userId = null;

            if(!$email || !$password)
            {
                $response = "Sorry about this! The system could not read your email and/or password. Please refresh your browser and try again. <br /><br />-Wishlist Team";           
            }
            else
            {
                try {
                    $userId = $this->getDoctrine()->getEntityManager()->
                        getRepository('WishlistCoreBundle:WishlistUser')->validateEmailAndPassword($email, $password);
                }
                catch(\Exception $e)
                {
                    $msg = $e->getMessage();
                    $response = $msg;
                }
                
                if($userId)
                {
                    $session = $this->getRequest()->getSession();
                    $session->set('email_addr', $email);
                    $session->set('user_id', $userId);
                    $response = "continue";
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
            $mailer = $this->get("instant_mailer_service");
            
            if(!$email)
            {   
                $response = "Sorry about this! The system could not read your email. Please refresh your browser and try again. <br /><br />-Wishlist Team";           
            }
            
            $userExists = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->findOneByEmail($email);
            
            if($userExists)
            {
                return new Response('It seems you are already a member of wishlist, please log in!');
            }
            
            // make a database call to store the email in the invite queue
            $requestInvite = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Request')->addInviteToQueue($email, null);
            $mailer->sendInvite($requestInvite);
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while submitting your request. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }
    }
}
