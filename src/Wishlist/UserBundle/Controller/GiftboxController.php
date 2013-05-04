<?php

namespace Wishlist\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GiftboxController extends Controller
{
    
    public function wishlistAction()
    {
        $user = $this->getLoggedInUser();
        
        if (!isset($user))
            return;
        
        $wishlistItems = $user->getWishlistItems();
        if(!isset($wishlistItems))
        {
            return;
        }
        
        return $this->render('WishlistUserBundle:Giftbox:wishlist.html.php', array('user' => $user));
    }
    
    private function getLoggedInUserId()
    {
        return $this->getRequest()->getSession()->get('user_id');
    }
    
    private function getLoggedInUser()
    {
        $loggedInUserId = $this->getLoggedInUserId();
        return $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
    }
    
}

?>
