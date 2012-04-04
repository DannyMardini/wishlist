<?php

namespace Wishlist\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\NoResultException;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('WishlistCoreBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function navBarAction()
    {
        try
        {
            $uid = $this->getRequest()->getSession()->get('user_id'); //The logged in user id.
            $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->getUserWithId($uid);
        }catch(Exception $e){
            throw $this->createNotFoundException('Please to go the Frontpage to sign on');
        }
        
        return $this->render('WishlistCoreBundle:Default:navbar.html.php', array('user' => $user));
    }
}
