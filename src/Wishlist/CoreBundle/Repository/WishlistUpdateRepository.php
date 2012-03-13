<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\WishlistUpdate;
use Wishlist\CoreBundle\Entity\WishlistUser;

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
}