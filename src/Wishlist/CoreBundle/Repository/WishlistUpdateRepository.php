<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Wishlist\CoreBundle\Entity\WishlistUpdate;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Entity\WishlistItem;
use \DateTime;

/**
 * WishlistUpdateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WishlistUpdateRepository extends EntityRepository
{
    public function addNewUpdate($template, $type, $message, $datetime, WishlistUser $user)
    {
        $newUpdate = new WishlistUpdate();
        
        $newUpdate->setTemplate($template);
        $newUpdate->setType($type);
        $newUpdate->setMessage($message);
        $newUpdate->setDatetime($datetime);
        $newUpdate->setWishlistUser($user);
        
        $this->getEntityManager()->persist($newUpdate);
        $this->getEntityManager()->flush();
    }
    
    public function addNewItem(WishlistUser $user, WishlistItem $wishlistItem)
    {
        if($user->getGender() == WishlistUser::GENDER_MALE)
        {
            $gender_attribute = "his";
        }
        else
        {
            $gender_attribute = "her";
        }

        $message = $user->getName().
                " added <a href='#' onclick='openWishDialog(".$wishlistItem->getId().", {selfWishlist: \"0\"}, setupItemView)'>".$wishlistItem->getItem()->getName().
                "</a> to ".$gender_attribute." wishlist";
        
        $this->addNewUpdate(WishlistUpdate::TEMPLATE_TYPE_1,
                WishlistUpdate::TYPE_ADD_ITEM,
                $message,
                new DateTime('now'),
                $user);
    }
    
    public function getFriendsUpdatesByUser(WishlistUser $user)
    {
    }
    
    public function getFriendsUpdates(/*int*/ $userId)
    {                                           
        $q = $this->getEntityManager()->createQuery('
            SELECT u, usr_1
            FROM WishlistCoreBundle:WishlistUpdate u
            LEFT JOIN u.wishlistUser usr_1
            WHERE usr_1.wishlistuser_id IN 
            (SELECT f.friend_id FROM WishlistCoreBundle:Friendship f LEFT JOIN f.wishlistUser usr_2 WHERE usr_2.wishlistuser_id = :uid)
            AND u.datetime > date_sub(current_date(), 10, \'DAY\') ORDER BY u.datetime DESC')
                ->setParameter('uid', $userId);
        
        return $q->getResult();
    }
}