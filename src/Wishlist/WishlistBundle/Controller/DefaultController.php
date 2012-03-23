<?php

namespace Wishlist\WishlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Wishlist\CoreBundle\Entity\WishlistItem;


class DefaultController extends Controller
{
    
    public function indexAction($wishlistuser_id)
    {                        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($wishlistuser_id);
        
        if(!$user){
            throw $this->createNotFoundException ('500 Internal server error(user not found in database). Please refresh your browser and try again.');
        }
        
        $session = $this->getRequest()->getSession();        
        $loggedInUserEmail = $session->get('email_addr');
        $wishlistUserEmail = $user->getEmail();
        $wishlistItems = $user->getWishlistItems();
        
        
        
        return $this->render('WishlistWishlistBundle:Default:index.html.php', 
                array('wishlistUserEmail' => $wishlistUserEmail, 
                    'wishlistItems' => $wishlistItems,
                    'loggedInUserEmail' => $loggedInUserEmail));  
    }
    
    
    /**
    * Executes show wishlist item action
    *
    */    
    public function showAction($wishlistuser_id)
    {        
        return $this->render('WishlistWishlistBundle:Default:showSuccess.html.php', array('user_id' => $wishlistuser_id));
    } 
    
    /**
    * Executes add new wishlist item action
    *
    */      
    public function newAction()
    {
        $session = $this->getRequest()->getSession(); 
       
        $name = $this->getRequest()->get('name');
        $price = $this->getRequest()->get('price');
        $link = $this->getRequest()->get('link');
        
        $loggedInUserId = $session->get('user_id');
        $loggedInUserEmail = $session->get('email_addr');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
                
        if( !isset ($name) || !isset ($price) || !isset ($link))
            return;

        if(($name == "") || ($price == "") || ($link == ""))
            return;        

        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');        
        $itemRepo->addItem($name, $price, $link, true, 'default comment', 1, $user);          
        
        return $this->render('WishlistWishlistBundle:Default:index.html.php', array('selfWishlist' => true, 'wishlistItems' => $user->getWishlistItems()));
    }
    
    public function getWishlistItemAction($itemId)
    {
        $response = new Response();
        $item = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem')->findOneBy(array('id' => $itemId));
        
        $response->setContent($item->exportData());
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
    * Executes delete wishlist item action
    *
    */     
    public function deleteAction()
    {        
        $session = $this->getRequest()->getSession();
        $deletedItemName = $this->getRequest()->get('name');
        $loggedInUserId = $session->get('user_id');
        $loggedInUserEmail = $session->get('email_addr');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $itemRepo->deleteItem($deletedItemName, $user);        
        
        return $this->render('WishlistWishlistBundle:Default:index.html.php', 
                array('loggedInUserEmail' => $loggedInUserEmail,
                        'wishlistItems' => $user->getWishlistItems(),
                        'wishlistUserEmail' => $loggedInUserEmail));
    }    
}
