<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class EventlistController extends Controller
{
    public function eventlistAction()
    {
        $request = $this->getRequest();
        $wlItemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        
        $wlItemId = $request->request->get('itemId');
        $wlItem = $wlItemRepo->findOneById($wlItemId);
        if(!$wlItemId || !$wlItem)
        {
            return new Response('Failure', 400); //Bad request
        }

        $user = $wlItem->getWishlistUser();
        $events = $user->getEvents();

        return $this->render('WishlistListBundle:Default:eventlist.html.php', array('events' => $events));
    }
}
