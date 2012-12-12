<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\Purchase;
use \DateTime;

class FriendlistController extends Controller
{
    public function friendlistAction(/*int*/ $user_id)
    {
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $friends = $userRepo->getFriendsOf($userRepo->getUserWithId($user_id));
        
        return $this->render('WishlistListBundle:Default:friendlist.html.php', array('friends' => $friends));
    }
}
?>
