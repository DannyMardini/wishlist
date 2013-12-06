<?php

namespace Wishlist\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('WishlistCoreBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function navBarAction()
    {
        try
        {
            $uid = $this->getRequest()->getSession()->get('user_id'); //The logged in user id.
            $user = null;
            if($uid!=null) 
            {
                $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->getUserWithId($uid);
            }
        }
        catch(Exception $e)
        {
            throw $this->createNotFoundException('Please to go the Frontpage to sign on');
        }
        
        return $this->render('WishlistCoreBundle:Default:navbar.html.php', array('user' => $user));
    }
    
    public function NotifyAdminAction()
    {                  
        try
        {
            $response = "";
            $subject = $this->getRequest()->get('subject');
            $email = $this->getRequest()->get('email');
            $fullname = $this->getRequest()->get('fullname');
            $message = $this->getRequest()->get('message');
            
            if(!$email || !$fullname || !$message || !$subject)
            {
                $response = "The form items were not all filled in. Please try again after all fields are filled. -Wishlist Team";
            }
            else
            {
                $full_message = ' from: ' . $fullname . '  email: ' . $email . '  message: ' . $message;
                $this->get("Mailer_Service")->sendMail("wishthrowaway@gmail.com", "User Inquiry", $full_message, $full_message);
                $response = 'success';
            }
            
            return new Response($response);
        }
        catch(Exception $e)
        {
            $response = "Sorry about this! An issue occurred while sending the message. Please refresh your browser and try again. <br /><br />-Wishlist Team";
            return $this->renderText($response);
        }
    }
    
    public function termsAction()
    {
        return $this->render('WishlistCoreBundle:Default:terms.html.php');
    }
    
    public function privacypolicyAction()
    {
        return $this->render('WishlistCoreBundle:Default:privacypolicy.html.php');
    }

    public function itemSearchAction()
    {
        $request = $this->getRequest()->request;
        $amazonSearch = $this->get('amazon_search_service');

        $keywords = $request->get('keywords');
        if(!isset($keywords))
        {
            return new Response();
        }

        //replace all white space with single + characters.
        $keywords = implode("+", explode(" ", $keywords));
        
        $searchResults = $amazonSearch->itemSearch("All", $keywords);
        return $this->render('WishlistDialogBundle:Default:itemSearchResults.html.php', array('items' => $searchResults));
    }

    public function itemSelectAction()
    {
        $request = $this->getRequest()->request;
        $amazonSearch = $this->get('amazon_search_service');
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Item');

        $asin = $request->get('ASIN');
        if(!isset($asin))
        {
            return new Response('failure');
        }

        $item = $amazonSearch->itemLookup($keywords);
        if(!isset($item))
        {
            return new Response('failure');
        }

        $item = $itemRepo->addItem($item);
        if(isset($item))
        {
            //if this function returned the new item then it was persisted.
            return new Response('success');
        }

        return new Response('failure');
    }
}
