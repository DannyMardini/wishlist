<?php

namespace Wishlist\WishlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    
    
    public function newAction($name, $price, $link)
    {
        $session = $this->getRequest()->getSession();        
        $loggedInUserId = $session->get('user_id');
        $loggedInUserEmail = $session->get('email_addr');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
                
        if( !isset ($name) || !isset ($price) || !isset ($link))
            return;

        if(($name == "") || ($price == "") || ($link == ""))
            return;        

        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $itemRepo->addItem($name, $price, $link, true, 'default comment', 1, $user);          
        
        return $this->render('WishlistWishlistBundle:Default:index.html.php', 
                array('loggedInUserEmail' => $loggedInUserEmail,
                      'wishlistItems' => $user->getWishlistItems(),
                      'wishlistUserEmail' => $loggedInUserEmail));
    }
}
