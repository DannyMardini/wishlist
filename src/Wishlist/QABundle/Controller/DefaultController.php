<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function helpAction()
    {
        return $this->render('WishlistQABundle:Default:Help.html.php');
    }
    
    public function gettingStartedAction()
    {
        return $this->render('WishlistQABundle:Default:GettingStarted.html.php');
    }
    
    public function wishlistHelpAction()
    {
        return $this->render('WishlistQABundle:Default:WishlistHelp.html.php');
    }
    
    public function contactSupportAction()
    {
        return $this->render('WishlistQABundle:Default:ContactSupport.html.php');
    }
    
    public function sendResetPasswordEmail()
    {
        return $this->render('WishlistQABundle:Default:ContactSupport.html.php');
    }    
}
