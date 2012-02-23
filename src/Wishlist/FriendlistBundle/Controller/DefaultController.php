<?php

namespace Wishlist\FriendlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Wishlist\CoreBundle\Entity\Friendship;
use Wishlist\CoreBundle\Entity\WishlistUser;


class DefaultController extends Controller
{
    
    public function indexAction($wishlistuser_id)
    {        
        $userId = $wishlistuser_id; 
        
        $wishlist_user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($userId);
        
        if(!$wishlist_user){
            throw $this->createNotFoundException ('500 Internal server error(user not found in database "friendlist"). Please refresh your browser and try again.');
        }
        
        $user = $wishlist_user->getFirstname();
        
        //$friends = $wishlist_user->getFriendships();
        
        $friendships = $this->getDoctrine()->getRepository('WishlistCoreBundle:Friendship')->findBy(array('usera_id' => $wishlist_user->getWishlistuserId()));
        
        $friends = array();
        
        foreach($friendships as $friendship)
        {
            $friends[] = $wishlist_user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($friendship->getUserbId());
        }
        
        
        return $this->render('WishlistFriendlistBundle:Default:index.html.php', array('user' => $user, 'friends' => $friends)); //'[1,2]'
    }
}
