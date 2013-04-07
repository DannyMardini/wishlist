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
        $newWish->setIsActive(true);
        $this->getEntityManager()->persist($newWish);
        $this->getEntityManager()->flush(); 
        
        $updateRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
        $updateRepo->addNewItem($wishlistUser, $newItem); 
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
    
    public function deleteWish( $deletedWishName, WishlistUser $wishlistUser)
    {
        // remove the wish from the users wishlist
        $em = $this->getEntityManager();  
        $userId = $wishlistUser->getWishlistuserId(); 
        
        $q = $em->createQuery('
            SELECT i 
            FROM WishlistCoreBundle:WishlistItem i 
            LEFT JOIN i.wishlistUser usr 
            LEFT JOIN i.item itm 
            WHERE itm.name = :itemName AND usr.wishlistuser_id = :userId')
            ->setParameters(array('itemName' => $deletedWishName, 'userId' => $userId));

        $wishToDelete = $q->getOneOrNullResult();
        
        if(!isset($wishToDelete))
        {
            throw new Exception("Wishlist Item could not be found.");            
        }
        
        $itemId = $wishToDelete->getItem()->getId();
        $purchaseRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:Purchase');                       
        $purchase = $wishToDelete->getPurchase();
        $purchaseRepo->deletePurchase($purchase);
        
        $em->remove($wishToDelete);
        $em->flush();
    }
}