<?php

namespace Wishlist\HomepageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class DefaultController extends Controller
{
    
    public function indexAction($wishlistuser_id)
    {
        $session = $this->getRequest()->getSession();
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $updateRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
        
        $email = $session->get('email_addr');
        
        if(!$email){
            throw $this->createNotFoundException ('500 Internal server error. Please go to wishlist.com and sign in.');
        }

        
        $user = $userRepo->getUserWithEmail($email);

        try {
            $friendUpdates =  $updateRepo->getFriendsUpdates($user->getWishlistuserId());
        }catch(Exception $e){
            $e->getTrace();
        }
        
        return $this->render('WishlistHomepageBundle:Default:index.html.php', array('user' => $user, 'friendUpdates' => $friendUpdates));
    }
}
