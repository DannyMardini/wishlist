<?php

namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller
{
    public function friendlistAction()
    {
    }
    
    public function shoppinglistAction()
    {
    }
    
    /**
    * Executes add new wishlist item action
    *
    */      
    public function newWishlistAction()
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
        
        return $this->render('WishlistListBundle:Default:wishlist.html.php', array('selfWishlist' => true, 'wishlistItems' => $user->getWishlistItems()));
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
    public function deleteWishlistAction()
    {        
        $session = $this->getRequest()->getSession();
        $deletedItemName = $this->getRequest()->get('name');
        $loggedInUserId = $session->get('user_id');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $itemRepo->deleteItem($deletedItemName, $user);        
        
        $selfWishlist = ($user->getWishlistUserId() == $loggedInUserId)? true:false;
        
        return $this->render('WishlistListBundle:Default:wishlist.html.php', array('selfWishlist' => $selfWishlist, 'wishlistItems' => $user->getWishlistItems()));
    }
}
