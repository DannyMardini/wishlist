<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\Purchase;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \DateTime;

class WishlistController extends Controller
{
    // STATUS CODES -- 
    const SC_NOTMODIFIED = 304;
    const SC_INTERNALSERVERERROR = 500;
    const SC_CONFLICT = 409;
    
    /**
    * Executes add new wishlist item action
    *
    */
    public function showWishlistAction(/*WishlistUser*/ $user)
    {
        $session = $this->getRequest()->getSession();
        $loggedInUserId = $session->get('user_id');
        
        if( !($user instanceof WishlistUser) )
        {
            throw new Exception('Invalid parameter');
        }
        
        $userId = $user->getWishlistuserId();
        
        $selfWishlist = ($loggedInUserId == $userId ) ? true : false;
        return $this->render('WishlistListBundle:Default:wishlist.html.php', array( 'selfWishlist' => $selfWishlist, 
                                                                                    'wishlistItems' => $user->getWishlistItems(),
                                                                                    'events' => $user->getEvents(),
                                                                                    'user' => $user,
                                                                                    'loggedInUserId' => $loggedInUserId));
    }
    
    public function newWishlistAction()
    {
        $session = $this->getRequest()->getSession(); 
        $name = urldecode($this->getRequest()->get('name'));
        $price = $this->getRequest()->get('price');
        $link = $this->getRequest()->get('link');
        $quantity = $this->getRequest()->get('quantity');
        $comment = $this->getRequest()->get('comment');
        $isPrivate = ($this->getRequest()->get('isprivate') == "checked");
        $loggedInUserId = $session->get('user_id');
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
                
        if( !isset ($name) || ($name == "") 
          || !isset ($price) || ($price == "") 
          || !isset ($link) || ($link == ""))
        {
            // The item was not fully defined.            
            return new Response("", WishlistController::SC_INTERNALSERVERERROR);
        }
        
        $wishRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $added = $wishRepo->makeWish($name, $price, $link, $isPrivate, $comment, $quantity, $user);
        
        if(!$added){   
            // The item was not added because it already exists    
            $response  = new Response();
            $response->setContent($this->showWishlistAction($user));
            $response->setStatusCode(WishlistController::SC_NOTMODIFIED);
            return $response;
        }
        
        return $this->showWishlistAction($user);
    }
    
    public function getItemAction($itemId)
    {
        try{
        $response = new Response();
        $wishlistItem = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem')->findOneBy(array('id' => $itemId));
        
        if($wishlistItem)
        {
            $response->setContent($wishlistItem->exportData());
            $response->headers->set('Content-Type', 'application/json');
        }
        else
        {
            $alert = array('error_message' => 'This item is no longer on your friends wishlist.');
            $response->setContent(json_encode($alert));
            $response->headers->set('Content-Type', 'application/json');
        }
        
        
        return $response;
        
        }
        catch (\Exception $e)
        {
           $response  = new Response($e->getMessage());           
           return $response;
        }
    }

    /**
    * Executes delete wishlist item action
    *
    */     
    public function deleteWishlistAction()
    {        
        $session = $this->getRequest()->getSession();
        $deletedItemName = urldecode($this->getRequest()->get('name'));
        $loggedInUserId = $session->get('user_id');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        $wishRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $wishRepo->deleteWish($deletedItemName, $user);        
        
        $selfWishlist = ($user->getWishlistUserId() == $loggedInUserId)? true:false;
        
        return $this->showWishlistAction($user);
    }
    
    public function purchaseItemAction()
    {
        $request = $this->getRequest()->request;
        $wishlistItemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $eventRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Event');
        $session = $this->getRequest()->getSession();
        
        $wishlistItemId = $request->get('id'); 
        $purchaseData = $request->get('purchaseData');
        $type = $request->get('type');
        
        $wishlistitem = $wishlistItemRepo->find($wishlistItemId);
        $purchaser = $userRepo->find($session->get('user_id'));
        $event = NULL;
        $date = NULL;
        
        
        if($type == Purchase::TYPE_EVENT)
        {
            $event = $eventRepo->find($purchaseData);
        }
        else if ($type == Purchase::TYPE_DATE)
        {
            $date = DateTime::createFromFormat('D M d Y', $purchaseData);
        }
        
        try {
            $purchaseRepo->newPurchase($purchaser, $wishlistitem, $event, $date);
        }
        catch (\Exception $e)
        {
           $response  = new Response($e->getMessage());           
           return $response;
        }

        if($event == NULL && $date == NULL)
        {
            return new Exception("Unknown purchase type.");
        }
        
        return new Response();
    }
}
?>
