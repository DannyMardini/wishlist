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
        
        $email = $session->get('email_addr');
        
        if(!$email){
            throw $this->createNotFoundException ('500 Internal server error. Please go to wishlist.com and sign in.');
        }

        
        $user = $userRepo->getUserWithEmail($email);
        
        return $this->render('WishlistHomepageBundle:Default:index.html.php', array('user' => $user));

        
        try {
            /*
            $this->user = WishlistUserTable::getInstance()->getUserWithEmail($email);

            if ($this->user->getPassword() != $pass)
            {
                throw new Exception('Incorrect password');
            }

            $_SESSION['user'] = $this->user->getEmail();
            $this->friendUpdates = WishlistUpdateTable::getInstance()->GetFriendsUpdates($this->user->getWishlistuser_id());
             * 
             */
        }catch(Exception $e){
            $e->getTrace();
        }                         
    }
}
