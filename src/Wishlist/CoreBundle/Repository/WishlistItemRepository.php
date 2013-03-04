<?php

namespace Wishlist\CoreBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\Item;
use Wishlist\CoreBundle\Entity\WishlistItem;
use Wishlist\CoreBundle\Entity\WishlistUser;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WishlistItemRepository extends EntityRepository
{
    public function makeWish($name, $price, $link, $isPublic, $comment, $quantity, WishlistUser $wishlistUser)
    {
        $itemRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:Item');
        $newItem = $itemRepo->addItem($name, $price, $link, $isPublic, $comment, $quantity, $wishlistUser);
        
        // associating the user to an item
        $newWish = new WishlistItem();
        $newWish->setItem($newItem);
        $newWish->setIsPublic($isPublic);
        $newWish->setComment($comment);
        $newWish->setQuantity($quantity);
        $newWish->setWishlistUser($wishlistUser);
        $this->getEntityManager()->persist($newWish);
        $this->getEntityManager()->flush();
    }
    
    public function checkUserWishlist($item, $user)
    {
       $em = $this->getEntityManager();       
        
        $q = $em->createQuery('
            SELECT i
            FROM WishlistCoreBundle:Item i
            LEFT JOIN WishlistCoreBundle:Item usr
            WHERE i.name = :itemName AND usr.wishlistuser_id = :userId')
                ->setParameters(array('itemName' => $item->getName(), 'userId' => $user->getWishlistuserId()));
                      
        $itemInDatabase = $q->getOneOrNullResult();  
        return $itemInDatabase;
    } 
//    
//    public function addItem( $name, $price, $link, $isPublic, $comment, $quantity, WishlistUser $wishlistUser)
//    {
//        $newItem = new Item();
//        $newItem->setName($name);
//        $newItem->setPrice($price);
//        $newItem->setLink($link);
//        $newItem->setIsPublic($isPublic);
//        $newItem->setComment($comment);
//        $newItem->setQuantity($quantity);
//        $newItem->setWishlistUser($wishlistUser);
//        
//        
//        // check if the item already exists for this user
//        $itemExists = $this->checkItemExists($newItem);
//        
//        if(!$itemExists){
//            $this->getEntityManager()->persist($newItem);
//            $this->getEntityManager()->flush();
//
//            $updateRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
//            $updateRepo->addNewItem($wishlistUser, $newItem);
//        }
//    }
//    
//    public function checkItemExists($item)
//    {
//       $em = $this->getEntityManager();       
//        
//        $q = $em->createQuery('
//            SELECT i
//            FROM WishlistCoreBundle:Item i
//            LEFT JOIN i.wishlistUser usr
//            WHERE i.name = :itemName AND usr.wishlistuser_id = :userId')
//                ->setParameters(array('itemName' => $item->getName(), 'userId' => $item->getWishlistUser()->getWishlistuserId()));
//                      
//        $itemInDatabase = $q->getOneOrNullResult();  
//        return $itemInDatabase;
//    }
    
    public function deleteItem( $deletedItemName, WishlistUser $wishlistUser)
    {
        $em = $this->getEntityManager();       
        
        $q = $em->createQuery('
            SELECT i
            FROM WishlistCoreBundle:Item i
            LEFT JOIN i.wishlistUser usr
            WHERE i.name = :itemName AND usr.wishlistuser_id = :userId')
                ->setParameters(array('itemName' => $deletedItemName, 'userId' => $wishlistUser->getWishlistuserId()));        
                      
        $itemToDelete = $q->getOneOrNullResult();
        
        $q2 = $em->createQuery('
            SELECT i FROM WishlistCoreBundle:Purchase i
            WHERE i.item = :itemId')
                ->setParameters(array( 'itemId' => $itemToDelete->getId() ));
        
        $purchase = $q2->getOneOrNullResult();
        
        if(isset($purchase)) // remove any purchases associated to this item
        {
            $em->remove($purchase);
            $em->flush();
        }
        
        $likeVar = '\'%openDialog('.$itemToDelete->getId().')%\'';
        $q3 = $em ->createQuery('
            SELECT i FROM WishlistCoreBundle:WishlistUpdate i
            WHERE i.message like :likeVar')
                ->setParameters(array( 'likeVar' => $likeVar ));
        
        $updates = $q3 ->getOneOrNullResult();
        
        if(isset($updates)) // deactivate any updates associated to this item
        {
            $em->remove($updates);
            $em->flush();
        }
        
        $em->remove($itemToDelete);
        $em->flush();                
    }
}