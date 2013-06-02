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
        
        // check if this user already has this item as a wish
        $isWish = $this->checkUserWishlist($newItem, $wishlistUser);
        
        if(isset($isWish))
        {
            return false; // item is already a wish
        }
        
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
        return true;
    }
    
    public function checkUserWishlist($item, $user)
    {
       $em = $this->getEntityManager();       
        
        $q = $em->createQuery('
            SELECT i 
            FROM WishlistCoreBundle:WishlistItem i 
            WHERE i.item = :itemId and i.wishlistUser = :userId')
                ->setParameters(array('itemId' => $item->getId(), 'userId' => $user->getWishlistuserId()));
                      
        $itemInDatabase = $q->getOneOrNullResult();  
        return $itemInDatabase;
    } 
    
    /**
     * Get wishlistItem for a user 
     */
    public function getWishlistItemForUser(Item $item, WishlistUser $user)
    {
        $q = $this->getEntityManager()->createQuery('
            SELECT i 
            FROM WishlistCoreBundle:WishlistItem i 
            WHERE i.item = :itemId AND i.wishlistUser = :userId')
                ->setParameters(array('itemId' => $item->getId(), 'userId' => $user->getWishlistuserId())
            );
                      
        return $q->getOneOrNullResult();  
    }
    
    /*
     * Method called when a user removes an item from their wishlist
     */
    public function deleteWish( $deletedWishName, WishlistUser $wishlistUser)
    {
        // remove the wish from the users wishlist
        $em = $this->getEntityManager();  
        $userId = $wishlistUser->getWishlistuserId(); 
        
        // grab the wish item being deleted for the user
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
        
        // search for and remove the promised purchase of this wish (if it exists)
        $purchaseRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:Purchase');        
        $purchaseRepo->deletePurchase($wishToDelete->getPurchase(), PurchaseEventTypes::RemovedFromWishlist);
        
        $em->remove($wishToDelete);
        $em->flush();
    }
}