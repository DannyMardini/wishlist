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
use Wishlist\CoreBundle\Repository\FrienshipRepository;
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
        $friendships = $manager->getRepository('WishlistCoreBundle:Friendship');
        
        $userA = $users->getUser('Danny Mardini');
        $userB = $users->getUser('Andrea Coba');
                
        $friendships->addNewFriendship($userA, $userB);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}

?>
