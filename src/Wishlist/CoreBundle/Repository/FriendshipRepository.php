<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Wishlist\CoreBundle\Entity\Friendship;
use Wishlist\CoreBundle\Entity\WishlistUser;

/**
 * FrienshipRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FriendshipRepository extends EntityRepository
{
    public function addNewFriendship(WishlistUser $userA, WishlistUser $userB)
    {
        $this->addNewFriendLink($userA, $userB);
        $this->addNewFriendLink($userB, $userA);
        
        $this->getEntityManager()->flush();
    }
    
    private function addNewFriendLink(WishlistUser $userA, WishlistUser $userB)
    {
        $friendship = new Friendship();
        
        $friendship->setWishlistUser($userA);
        $friendship->setFriend($userB);
        
        $this->getEntityManager()->persist($friendship);
    }
    
    public function searchFriends(WishlistUser $user, /*string*/ $searchTerm)
    {
        $userRepo = $this->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $friends = $userRepo->getFriendsOf($user);
        $results = array();
        
        if( strlen($searchTerm) == 0 )
        {
            //return all friends if search term doesn't even contain one term.
            return $friends;
        }
        
        $explodedSearchTerm = explode(" ", $searchTerm);
        
        foreach ($friends as $friend)
        {
            
            if( $this->friendNameMatches($friend, $explodedSearchTerm))
            {
                $results[] = $friend;
            }
                        
            //Don't return friend as search term didn't match first name.
        }
        
        return $results;
    }
    
    private function friendNameMatches($friend, $searchTermArray)
    {
        $nameArray = explode(" ", strtoupper($friend->getName()));
        
        foreach($searchTermArray as $searchTerm)
        {
            $termFound = false;
            foreach($nameArray as $name)
            {
                if(strncmp($name, strtoupper($searchTerm), strlen($searchTerm)) == 0)
                {
                    $termFound = true;
                    break;
                }
            }
            
            if($termFound == false)
            {
                return false;
            }
        }
        
        return true;
    }
}