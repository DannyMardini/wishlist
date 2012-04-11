<?php

namespace Wishlist\QABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('WishlistQABundle:Default:index.html.twig', array('name' => $name));
    }
}
