<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\Request;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestRepository
 *
 * @author andeecoba
 */
class RequestRepository extends EntityRepository {
    //put your code here
     /*
     * This function accepts either an event or a gift_date, but not both.
     */
    public function addInviteToQueue(/*string*/ $theEmail, /*WishlistUser*/ $userInvited)
    {
        $newInvite = new Request();
        $newInvite->setEmail($theEmail);
        $this->getEntityManager()->persist($newInvite);
        $this->getEntityManager()->flush();
        
        return $newInvite;
    }
}

?>
