<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Entity\WishlistItem;
use Wishlist\CoreBundle\Entity\Purchase;
use Wishlist\CoreBundle\Entity\Event;
use Doctrine\ORM\Query\ResultSetMapping;
use \PDOException;

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
    public function newPurchase(WishlistUser $user, WishlistItem $item, Event $event = NULL, \DateTime $gift_date = NULL)
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
        
        $purchaseParams = 'CALL PurchaseItem('.$item->getId().', '.$user->getWishlistuserId().', '.$eventId.', '.$date.')';
         
        //$nquery = $this->getEntityManager()->createNativeQuery('CALL selectPurchase', $rsm);
        $nquery = $this->getEntityManager()->createNativeQuery($purchaseParams, $rsm);
        
        $purchases = $nquery->getResult();
        
        if( count($purchases) )
        {
            $purchase = $purchases[0];
            $item = $purchase->getItem();
        }
        
        /*
        if(isset($event) && isset($gift_date))
        {
            throw new \RuntimeException('Ambiguous notification date for puchase.');
        }
        
        $em = $this->getEntityManager();
        
        $newPurchase = new Purchase();
        $newPurchase->setUser($user);
        $newPurchase->setItem($item);
        
        if($event != NULL)
        {
            $newPurchase->setEvent($event);
            $newPurchase->setGiftDate($event->getEventDate());
        }else if($gift_date != NULL)
        {
            $newPurchase->setGiftDate($gift_date);
        }else
        {
            throw new RuntimeException('A purchase requires an event or date.');
        }
        
        $item->setPurchase($newPurchase);
        
        $em->persist($newPurchase);
        
        try
        {
            $em->flush();
        }catch(PDOException $e)
        {
            //Connection was closed, start a new one.
            $em->getConnection()->beginTransaction();
            //Most likely duplicate key
            if($e->getCode() == "23000")
            {
                $this->overwritePrevPurchase($item, $newPurchase);
            }
        }
         * 
         */
    }
    
    private function overwritePrevPurchase(WishlistItem $item, Purchase $newPurchase)
    {
        $em = $this->getEntityManager();

        //delete old purcahse
        $oldPurchase = $this->getPurchaseByItem($item);
        $this->deletePurchase($oldPurchase);
        
        //enter new purchase
        $em->persist($newPurchase);
        $em->flush();
    }
    
    public function getPurchasesById(/*int*/ $uid)
    {
        $em = $this->getEntityManager();
        
        $q = $em->createQuery('
            SELECT p
            FROM WishlistCoreBundle:Purchase p
            LEFT JOIN p.user usr
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
    
    public function getPurchaseByItem(WishlistItem $item)
    {
        return $this->getPurchaseByItemId($item->getId());
    }
    
    public function deletePurchases($purchaseIds)
    {
        $em = $this->getEntityManager();
        
        foreach ($purchaseIds as $purchaseId)
        {
            $purchase = $this->find($purchaseId);
            $em->remove($purchase);
        }
        
        $em->flush();
    }
    
    public function deletePurchase(Purchase $purchase)
    {
        $em = $this->getEntityManager();
        
        $em->remove($purchase);
        $em->flush();
    }
}