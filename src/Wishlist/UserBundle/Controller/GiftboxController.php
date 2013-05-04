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
        
//        return $this->render('WishlistUserBundle:Giftbox:wishlist.html.php', array('wishlistItems' => $wishlistItems));
        return $this->render('WishlistUserBundle:Giftbox:wishlist.html.php', array('user' => $user));
    }
    
    public function shoppinglistAction()
    {
        $userId = $this->getLoggedInUserId();
        
        return $this->render('WishlistUserBundle:Giftbox:shoppinglist.html.php', array('userId' => $userId));
    }
    
    public function eventsAction()
    {
        $user = $this->getLoggedInUser();
        
        $events = $user->getEvents();
        
        return $this->render('WishlistUserBundle:Giftbox:events.html.php', array('events' => $events));
    }
    
    public function friendsAction()
    {
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');        
        $user = $this->getLoggedInUser();
        
        $friends = $userRepo->getFriendsOf($user);
                
        return $this->render('WishlistUserBundle:Giftbox:friends.html.php', array('friends' => $friends));
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
