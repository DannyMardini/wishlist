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
        
        //Only want to notify granted items to the logged in user.
        $nonNotifiedGranted = null;
        if($userId == $loggedInUserId)
        {
            $nonNotifiedGranted = $user->getNonNotifiedGrantedItems();
        }
        
        $selfWishlist = ($loggedInUserId == $userId ) ? true : false;
        return $this->render('WishlistListBundle:Default:wishlist.html.php', array( 'selfWishlist' => $selfWishlist, 
                                                                                    'wishlistItems' => $user->getUngrantedItems(),
                                                                                    'nonNotifiedGranted' => $nonNotifiedGranted,
                                                                                    'events' => $user->getEvents(),
                                                                                    'user' => $user,
                                                                                    'loggedInUserId' => $loggedInUserId));
    }
    
    public function newWishlistAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession(); 
        $name = urldecode($request->get('name'));
        $asin = $request->get('asin');
        $image = $request->get('image');
        $price = $request->get('price');
        $link = $request->get('link');
        $quantity = $request->get('quantity');
        $comment = $request->get('comment');
        $isPrivate = false;  // we are not supporting private items yet
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
        $added = $wishRepo->makeWish($name, $asin, $image, $price, $link, $isPrivate, $comment, $quantity, $user);
        
        if(!$added){   
            // The item was not added because it already exists    
            $response  = new Response();
            $response->setContent($this->showWishlistAction($user));
            $response->setStatusCode(WishlistController::SC_NOTMODIFIED);
            return $response;
        }
        
        return $this->showWishlistAction($user);
    }

    public function itemSearchAction()
    {
        $request = $this->getRequest()->request;
        $amazonSearch = $this->get('amazon_search_service');

        $keywords = $request->get('keywords');
        if(!isset($keywords))
        {
            return new Response();
        }

        //replace all white space with single + characters.
        $keywords = implode("+", explode(" ", $keywords));
        
        $searchResults = $amazonSearch->itemSearch("All", $keywords);
        return $this->render('WishlistDialogBundle:Default:itemSearchResults.html.php', array('items' => $searchResults));
    }
    
    public function itemSelectAction()
    {
        $request = $this->getRequest()->request;
        $amazonSearch = $this->get('amazon_search_service');
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Item');

        $asin = $request->get('ASIN');
        if(!isset($asin))
        {
            return new Response('failure');
        }

        $item = $amazonSearch->itemLookup($keywords);
        if(!isset($item))
        {
            return new Response('failure');
        }

        $item = $itemRepo->addItem($item);
        if(isset($item))
        {
            //if this function returned the new item then it was persisted.
            return new Response('success');
        }

        return new Response('failure');
    }
    
    public function updateWishlistAction()
    {
        $session = $this->getRequest()->getSession();
        $id = $this->getRequest()->get('id');
        $name = urldecode($this->getRequest()->get('name'));
        $price = $this->getRequest()->get('price');
        $link = $this->getRequest()->get('link');
        $quantity = $this->getRequest()->get('quantity');
        $comment = $this->getRequest()->get('comment');
        $isPrivate = false;     //($this->getRequest()->get('isprivate') == "checked");
        $loggedInUserId = $session->get('user_id');
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        
        if( !isset ($id) || ($id == "")
          || !isset ($name) || ($name == "") 
          || !isset ($price) || ($price == "") 
          || !isset ($link) || ($link == ""))
        {
            // The item was not fully defined.            
            return new Response("", WishlistController::SC_INTERNALSERVERERROR);
        }
        
        $wishRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $updated = $wishRepo->updateWish($id, $name, $price, $link, $isPrivate, $comment, $quantity, $user);
        
        if(!$updated){   
            // The item was not updated
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
        $deletedItemId = $this->getRequest()->get('itemId');
        $loggedInUserId = $session->get('user_id');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        $wishRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $wishRepo->deleteWish($deletedItemId, $user);        
        
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

    public function grantedItemNotifiedAction()
    {
        $request = $this->getRequest()->request;
        $wishItemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');

        try
        {
            $notifiedItemIds = $request->get('notifiedItems');
            if(!isset($notifiedItemIds))
            {
                throw new \Exception();
            }
            $notifiedItems = $wishItemRepo->getWishlistItems($notifiedItemIds);
            $wishItemRepo->grantWishesNotified($notifiedItems);
        }
        catch(\Exception $e)
        {
            return new Response('failure');
        }

        return new Response('success');
    }
}
?>
