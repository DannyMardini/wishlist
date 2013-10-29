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
    public function addInviteToQueue(/*string*/ $theEmail, /*WishlistUser*/ $userInvited=null)
    {
        //todo: Have to generate a random "invite" number
        $bytes = openssl_random_pseudo_bytes(Request::ACCEPT_STR_MAX_LENGTH, $cstrong);
        $randHex = bin2hex($bytes);

        $newInvite = $this->findInvite($theEmail);
        
        if(!$newInvite){
            $newInvite = new Request();
            $newInvite->setEmail($theEmail);
            if($userInvited) {
                $newInvite->setUserInvited($userInvited);
            }
            $newInvite->setAcceptString($randHex);
            $this->getEntityManager()->persist($newInvite);
            $this->getEntityManager()->flush();
        }
        
        return $newInvite;
    }
    
    public function findInvite(/*string*/ $email)
    {
       $em = $this->getEntityManager();       
        
        $q = $em->createQuery('
            SELECT i
            FROM WishlistCoreBundle:Request i
            WHERE i.email = :theEmail')
                ->setParameters(array('theEmail' => $email));
                      
        $itemInDatabase = $q->getOneOrNullResult();  
        return $itemInDatabase;        
    }
    
    public function removeInvite(Request $request)
    {
        $em = $this->getEntityManager();
        
        $em->remove($request);
        $em->flush();
    }
}

?>
