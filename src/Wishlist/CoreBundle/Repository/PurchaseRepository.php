<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Entity\WishlistItem;
use Wishlist\CoreBundle\Entity\Item;
use Wishlist\CoreBundle\Entity\PurchaseEventTypes;
use Wishlist\CoreBundle\Entity\Event;
use Doctrine\ORM\Query\ResultSetMapping;


/**
 * PurchaseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseRepository extends EntityRepository
{  
    
    /*
     * This function accepts either an event or a gift_date, but not both.
     */
    public function newPurchase(WishlistUser $user, WishlistItem $wishlistItem, Event $event = NULL, \DateTime $gift_date = NULL)
    {
        
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('Wishlist\CoreBundle\Entity\Purchase', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addMetaResult('p', 'item_id', 'item');
        $rsm->addMetaResult('p', 'user_id', 'user');
        $rsm->addMetaResult('p', 'event_id', 'event');
        $rsm->addFieldResult('p', 'gift_date', 'gift_date');
        
        if( isset($gift_date) )
        {
            $date = '\''.$gift_date->format('Y-m-d').'\'';
        }else
        {
            $date = 'NULL';
        }
        
        if( isset($event) )
        {
            $eventId = $event->getId();
        }else
        {
            $eventId = 'NULL';
        }
        
        $genericItem = $wishlistItem->getItem();
        $purchasePromised = $wishlistItem->getPurchase();
        $itemRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:WishlistItem');
        $selfPurchaseItem = $itemRepo->getWishlistItemForUser($genericItem, $user);
        
        
        if(isset($purchasePromised) && !isset($selfPurchaseItem) )
        {
            // cannot overwrite an already promised purchase by another friend
            throw new Exception("This wish was already promised by another friend."); 
        }
        
        // if user is purchasing for themselves, remove the existing purchase promise
        if(isset($selfPurchaseItem) && isset($purchasePromised))
        {
            $this->deletePurchase($purchasePromised, PurchaseEventTypes::RemovedFromWishlist);
        }
        
        // Add the item to the users shopping list
        $purchaseParams = 'CALL PurchaseItem('.
                $wishlistItem->getId().
                ', '.
                $user->getWishlistuserId().
                ', '.
                $eventId.
                ', '.
                $date.
         ')';
        $nquery = $this->getEntityManager()->createNativeQuery($purchaseParams, $rsm);
        return $nquery->getResult();
    }
    
    public function getPurchasesById(/*int*/ $uid)
    {
        $em = $this->getEntityManager();
        
        $q = $em->createQuery('
            SELECT p
            FROM WishlistCoreBundle:Purchase p
            LEFT JOIN p.wishlistUser usr
            where usr.wishlistuser_id = :uid')
                ->setParameter('uid', $uid);
        
        return $q->getResult();
    }
    
    public function getPurchaseByItemId(/*int*/ $itemId)
    {
        $em = $this->getEntityManager();
        
        $q = $em->createQuery('
            SELECT p
            FROM WishlistCoreBundle:Purchase p
            LEFT JOIN p.item item
            where item.id = :itemId')
                ->setParameter('itemId', $itemId);
        
        return $q->getOneOrNullResult();
    }
    
    public function getPurchasesByUser(WishlistUser $user)
    {
        return $this->getPurchasesById($user->getWishlistuserId());
    }
    
    public function getPurchaseByItem(Item $item)
    {
        return $this->getPurchaseByItemId($item->getId());
    }
    
    public function deletePurchases($purchaseIds, $event_type)
    {
        $em = $this->getEntityManager();
        $message = "";
        
        foreach ($purchaseIds as $purchaseId)
        {
            $message = $message . $this->deletePurchase($this->find($purchaseId), $event_type);
        }
        
        $em->flush();
        return $message;
    }
    
    public function deletePurchase($purchase, $event_type)
    {
        $message = (isset($event_type) && isset($purchase)) ? "" : " An invalid purchase and/or event was passed in. Contact the Wishlist Admins for assistance. "; 

        // if there's no message generated, it means the parameters are valid and continue with the delete.
        if(strlen($message) <= 0)
        {
            $em = $this->getEntityManager();
            $em->remove($purchase);
            $em->flush();

            $this->purchaseEventNotification($event_type);
        }
        
        return $message;
    }

    // TO DO: send notification to user. Explaining why the item was removed from 
    // their purchase list. It could be one of 2 reasons:
    // The user removed it themselves OR the item was auto removed by the system because
    // the friend removed the wish from their wishlist    
    private function purchaseEventNotification($event_type)
    {
        $success = false;        
        
        switch($event_type)
        {        
            case PurchaseEventTypes::RemovedFromWishlist :
                /* TO DO:
                 * send alert
                 * SUBJECT: "Wishlist Notification: An Item has been removed from your shopping list",
                MESSAGE: "The following item was removed from your shopping list because your friend has removed it from their wishlist",
                EMAILS: "andreacoba@gmail.com;dannymardini@gmail.com"
                 */
                break;
            case PurchaseEventTypes::RemovedFromShoppingList :
                break;            
            case PurchaseEventTypes::Purchased :
                break;
            case PurchaseEventTypes::Added :
                break;
            default :
                break;
        }
        
        return $success;
    }
}

