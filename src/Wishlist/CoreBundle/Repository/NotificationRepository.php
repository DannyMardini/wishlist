<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\Notification;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository
{
    public function addNotification(\Wishlist\CoreBundle\Entity\WishlistUser $wishlistUser, /*int*/ $user, $text)
    {
        $newFriendRequest = new Notification();
        $newFriendRequest->setText($text);
        $newFriendRequest->setState(Notification::STATE_UNREAD);
        $newFriendRequest->setWishlistUser($wishlistUser);
        $newFriendRequest->setUserRequested($user);

        $this->getEntityManager()->persist($newFriendRequest);
        $this->getEntityManager()->flush();
        return $newFriendRequest;
    }

    public function removeNotifications($notifications)
    {
        $em  = $this->getEntityManager();

        foreach ($notifications as $notification)
        {
            $em->remove($notification);
        }
        $em->flush();
    }

    public function removeNotification($notification)
    {
        $this->removeNotifications(array($notification));
    }

    public function getNotificationWithId(/*int*/ $notificationId)
    {
        $notification = $this->findOneBy(array('id' => $notificationId));

        if( !isset($notification) )
        {
            throw new NoResultException();
        }

        return $notification;
    }

    public function complementNotification(/*int*/ $userRequestedId, /*int*/ $targetId)
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT n FROM WishlistCoreBundle:Notification n JOIN n.wishlistUser u WHERE u.wishlistuser_id = :targetId AND n.userRequested = :userRequestedId')
            ->setParameters(array('targetId' => $userRequestedId, 'userRequestedId' => $targetId));

        return $q->getOneOrNullResult();
    }

    public function notificationExists(/*int*/ $userRequestedId, /*int*/ $targetId)
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT n FROM WishlistCoreBundle:Notification n JOIN n.wishlistUser u WHERE u.wishlistuser_id = :targetId AND n.userRequested = :userRequestedId')
            ->setParameters(array('targetId' => $targetId, 'userRequestedId' => $userRequestedId));

        $qResults = $q->getOneOrNullResult();

        if(!$qResults)
        {
            return false;
        }

        return true;
    }
}
