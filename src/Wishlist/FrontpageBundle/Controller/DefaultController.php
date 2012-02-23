<?php

namespace Wishlist\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php', array("showUserAdded" => "hullo"));
    }
    
    public function navBarAction($username)
    {
        return $this->render('WishlistFrontpageBundle:Default:navBarTest.html.php', array('username' => $username));
    }
}
