<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\Event;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function addEvent( $name, $type, $datetime, WishlistUser $wishlistUser )
    {
        $newEvent = new Event();
        $newEvent->setName($name);
        $newEvent->setEventType($type);
        $newEvent->setEventDate($datetime);
        $newEvent->setWishlistUser($wishlistUser);

        $this->getEntityManager()->persist($newEvent);
        $this->getEntityManager()->flush();       
    }
    
    public function getFriendEvents(/*int*/ $userId)
    {                                     
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('Wishlist\CoreBundle\Entity\Event', 'e');
        $rsm->addFieldResult('e', 'id', 'id');
        $rsm->addFieldResult('e', 'name', 'name');
        $rsm->addFieldResult('e', 'eventType', 'eventType');
        $rsm->addFieldResult('e', 'eventDate', 'eventDate');
        $rsm->addJoinedEntityResult('Wishlist\CoreBundle\Entity\WishlistUser' , 'u', 'e', 'wishlistUser');
        $rsm->addFieldResult('u', 'wishlistuser_id', 'wishlistuser_id');
        $rsm->addFieldResult('u', 'firstname', 'firstname');
        $rsm->addFieldResult('u', 'lastname', 'lastname');
        $rsm->addFieldResult('u', 'birthdate', 'birthdate');
        $rsm->addFieldResult('u', 'email', 'email');
        $rsm->addFieldResult('u', 'password', 'password');
        $rsm->addFieldResult('u', 'gender', 'gender');
        

        $query = $this->_em->createNativeQuery("
            select * 
            from event e left join wishlistuser u on u.wishlistuser_id = e.user_id  
            where  e.user_id in 
                ( select f.friend_id  from friendship f  where f.user_id = ? )  
            and  date_format(e.eventDate, '%c-%e') < date_format(date_add(now(), interval 1 MONTH),'%c-%e')
            order by date_format(e.eventDate, '%c-%e') asc",
        $rsm);
        
        $query->setParameter(1, $userId);

        $events = $query->getResult();        
                
        return $events;
    }
}