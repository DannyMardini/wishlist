<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadFriendshipData
 *
 * @author andreacoba
 */

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\Friendship;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \Doctrine\Common\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadFriendshipData implements FixtureInterface,OrderedFixtureInterface{
    
    private $manager; //ObjectManager
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        
        $users = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        
        $userA = $users->getUser('Danny Mardini');
        $userB = $users->getUser('Andrea Coba');
                
        $this->addNewFriendship($userA, $userB);
        
        $manager->flush();
    }
    
    private function addNewFriendship(WishlistUser $userA, WishlistUser $userB)
    {
        $this->addNewFriendLink($userA, $userB);
        $this->addNewFriendLink($userB, $userA);
    }
    
    private function addNewFriendLink(WishlistUser $userA, WishlistUser $userB)
    {
        $friendship = new Friendship();
        
        $friendship->setUseraId($userA->getWishlistuserId());
        $friendship->setUserbId($userB->getWishlistuserId());
        
        $this->manager->persist($friendship);
    }
    
    public function getOrder()
    {
        return 2;
    }
}

?>
