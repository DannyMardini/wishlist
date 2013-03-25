<?php

namespace Wishlist\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class EntityServicesController extends Controller
{
    public function getItemInfoAction()
    {
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $itemId = $this->getRequest()->request->get('id');
        
        $item = $itemRepo->find($itemId);
        
        
        return new Response($item->exportData());
    }
}
