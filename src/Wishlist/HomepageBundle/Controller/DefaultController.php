<?php

namespace Wishlist\HomepageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function indexAction($wishlistuser_id)
    {
        $session = $this->getRequest()->getSession();        
        
        $email = $session->get('email_addr');
        
        if(!$email){
            throw $this->createNotFoundException ('500 Internal server error. Please go to wishlist.com and sign in.');
        }

        
        //return new Response('<html><body>Hello test test!</body></html>');
        
        return $this->render('WishlistHomepageBundle:Default:index.html.php', array('email' => $email));

        
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
