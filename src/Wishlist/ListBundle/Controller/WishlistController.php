<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\Purchase;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \DateTime;

class WishlistController extends Controller
{
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
                                                                                    'user' => $user));
    }
    
    public function newWishlistAction()
    {
        $session = $this->getRequest()->getSession(); 
       
        $name = $this->getRequest()->get('name');
        $price = $this->getRequest()->get('price');
        $link = $this->getRequest()->get('link');
        $quantity = $this->getRequest()->get('quantity');
        $comment = $this->getRequest()->get('comment');
        $isPrivate = ($this->getRequest()->get('isprivate') == "checked");
        
        $loggedInUserId = $session->get('user_id');
        $loggedInUserEmail = $session->get('email_addr');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
                
        if( !isset ($name) || ($name == "") 
                || !isset ($price) || ($price == "") 
                || !isset ($link) || ($link == ""))
        {
            return;
        }

        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');        
        $itemRepo->addItem($name, $price, $link, $isPrivate, $comment, $quantity, $user);          
        
        return $this->showWishlistAction($user);
    }
    
    public function getWishlistItemAction($itemId)
    {
        $response = new Response();
        $item = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem')->findOneBy(array('id' => $itemId));
        
        $response->setContent($item->exportData());
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
    * Executes delete wishlist item action
    *
    */     
    public function deleteWishlistAction()
    {        
        $session = $this->getRequest()->getSession();
        $deletedItemName = $this->getRequest()->get('name');
        $loggedInUserId = $session->get('user_id');
        
        $user = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $itemRepo->deleteItem($deletedItemName, $user);        
        
        $selfWishlist = ($user->getWishlistUserId() == $loggedInUserId)? true:false;
        
        return $this->showWishlistAction($user);
    }
    
    public function purchaseItemAction()
    {
        $request = $this->getRequest()->request;
        
        $itemRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistItem');
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $eventRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Event');
        $session = $this->getRequest()->getSession();
        
        $itemId = $request->get('id');
        $purchaseData = $request->get('purchaseData');
        $type = $request->get('type');
        
        $item = $itemRepo->find($itemId);
        $purchaser = $userRepo->find($session->get('user_id'));
        
        if($type == Purchase::TYPE_EVENT)
        {
            $event = $eventRepo->find($purchaseData);

            $purchaseRepo->newPurchase($purchaser, $item, $event);
            
        }else if ($type == Purchase::TYPE_DATE)
        {
            $date = DateTime::createFromFormat('D M d Y', $purchaseData);
            
            $purchaseRepo->newPurchase($purchaser, $item, NULL, $date);
            
        }else
        {
            return new Exception("Unknown purchase type.");
        }
        
        return new Response();
    }
}
?>
