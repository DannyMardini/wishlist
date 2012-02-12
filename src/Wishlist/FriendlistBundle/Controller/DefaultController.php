<?php

namespace Wishlist\FriendlistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Wishlist\CoreBundle\Entity\Friendship;
use Wishlist\CoreBundle\Entity\WishlistUser;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $request = Request::createFromGlobals()->request;   
        
        //return new Response('<html><body>Hello Bibim!</body></html>');        
        
        $wishlist_user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($request->get('wishlistuser_id'));
        
        if(!$wishlist_user){
            throw $this->createNotFoundException ('500 Internal server error(user not found in database "friendlist"). Please refresh your browser and try again.');
        }
        
        $this->user = $wishlist_user->getFirstname();
//        
//       // $this->friends = $this->getDoctrine()->getRepository('WishlistCoreBundle:Friendship')->
//        $this->friends = FriendshipTable::getInstance()->getFriendsOf($request->getParameter('wishlistuser_id'));
//        
          return $this->render('WishlistFriendlistBundle:Default:index.html.php', array('user' => 'andrea', '[1,2]' => ''));
    }
}
