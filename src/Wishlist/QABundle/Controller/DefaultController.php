<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function gettingStartedAction()
    {
        return $this->render('WishlistQABundle:Default:GettingStarted.html.php');
    }
    
    public function wishlistHelpAction()
    {
        return $this->render('WishlistQABundle:Default:WishlistHelp.html.php');
    }
}
