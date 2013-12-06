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

        $date = 'NULL';
        $eventId = 'NULL';
        
        if( isset($gift_date) )
        {
            $date = '\''.$gift_date->format('Y-m-d').'\'';
        }
        else if( isset($event) )
        {
            $eventId = $event->getId();
            //Make a temp date using the event month/day + this year.
            $currentDate = getdate();
            $eventDate = getdate($event->getEventDate()->getTimestamp());
            $tmpDate = \DateTime::createFromFormat('Y-m-d', $currentDate['year'].'-'.$eventDate['mon'].'-'.$eventDate['mday']);
            
            //If the date has already passed, must have meant for next year.
            if($tmpDate->getTimestamp() < time())
            {
                $tmpDate->add(new \DateInterval('P1Y'));
            }

            $date = '\''.$tmpDate->format('Y-m-d').'\'';
        }
        else
        {
            throw new \Exception('Must enter a date or event.');
        }
        
        $purchasePromised = $wishlistItem->getPurchase();
        $selfPurchaseItem = ($wishlistItem->getWishlistUser() == $user);
        
        if(isset($purchasePromised) && !$selfPurchaseItem )
        {
            // cannot overwrite an already promised purchase by another friend
            throw new \Exception("This wish was already promised by another friend."); 
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

    public function getPurchases($purchaseIds)
    {
        if(!isset($purchaseIds))
        {
            return null;
        }

        $em = $this->getEntityManager();

        $q = $em->createQuery('
            SELECT p
            FROM WishlistCoreBundle:Purchase p
            WHERE p.id IN (:purchaseIds)')
            ->setParameter('purchaseIds', $purchaseIds);

        return $q->getResult();
    }

    public function completePurchase($purchase)
    {
        $em = $this->getEntityManager();
        $wishlistItemRepo = $em->getRepository('WishlistCoreBundle:WishlistItem');
        $em->remove($purchase);
        $wishlistItemRepo->grantWish($purchase->getItem(), $purchase->getWishlistUser());
    }

    public function completePurchases($purchases)
    {
        $em = $this->getEntityManager();

        foreach($purchases as $purchase)
        {
            $this->completePurchase($purchase);
        }

        $em->flush();
    }

    public function getExpiredPurchases(/*int*/ $uid)
    {
        //Just do the dates for now, worry about the events afterwards.
        $em = $this->getEntityManager();

        $q = $em->createQuery('
            SELECT p 
            FROM WishlistCoreBundle:Purchase p
            LEFT JOIN p.wishlistUser usr
            LEFT JOIN p.event e
            where usr.wishlistuser_id = :uid AND p.gift_date < CURRENT_DATE()')
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
        
        foreach ($purchaseIds as $purchaseId)
        {
            $this->deletePurchase($this->find($purchaseId), $event_type);
        }
        
        $em->flush();
    }
    
    public function deletePurchase($purchase, $event_type)
    {
        if(!isset($event_type) || !isset($purchase)){
            return false; // on_error
        }
        
        $em = $this->getEntityManager();
        $em->remove($purchase);
        $em->flush();

        $this->purchaseEventNotification($event_type);
        
        return true; // on_success
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

