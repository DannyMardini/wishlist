<?php

namespace Wishlist\FriendlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        //return new Response('<html><body>Hello Bibim!</body></html>');
        
        return $this->render('WishlistFriendlistBundle:Default:index.html.php', array('user' => 'andrea', '[1,2]' => ''));
        
        $wishlist_user = WishlistUserTable::getInstance()->find($request->getParameter('wishlistuser_id'));
        
        if(!$wishlist_user){
            throw $this->createNotFoundException ('500 Internal server error(user not found in database "friendlist"). Please refresh your browser and try again.');
        }

        $this->user = $wishlist_user->getFirstname();
        $this->friends = FriendshipTable::getInstance()->getFriendsOf($request->getParameter('wishlistuser_id'));
    }
}
