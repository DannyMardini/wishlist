<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function helpAction()
    {
        return $this->render('WishlistQABundle:Default:help.html.php');
    }
}
