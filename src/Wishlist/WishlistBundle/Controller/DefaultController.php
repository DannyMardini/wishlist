<?php

namespace Wishlist\WishlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($wishlistuser_id)
    {
        //return $this->render('WishlistWishlistBundle:Default:index.html.twig', array('user_id' => $wishlistuser_id));
                
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($wishlistuser_id);
        
        if(!$user){
            throw $this->createNotFoundException ('500 Internal server error(user not found in database). Please refresh your browser and try again.');
        }
        
        $wishlist_user_email = $user->getEmail();
        $wishlist_items = $user->getWishlistItems();
        
        
        return $this->render('WishlistWishlistBundle:Default:index.html.twig', array('wishlist_user_email' => $wishlist_user_email, 'wishlist_items' => $wishlist_items));  
    }
    
    
//    public function getWishlistItemAction()
//    {
//        $item = WishlistItemTable::getInstance()->find($request->getParameter('wishlistitem_id'));  
//        return $this->renderText($item->exportData());
//    }
          
}
