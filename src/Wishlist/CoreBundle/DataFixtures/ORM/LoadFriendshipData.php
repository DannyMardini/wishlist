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

class LoadFriendshipData implements FixtureInterface,OrderedFixtureInterface{
    
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $friendships = $manager->getRepository('WishlistCoreBundle:Friendship');
        
        $danny = $users->getUser('Danny Mardini');
        $andrea = $users->getUser('Andrea Coba');
        $steve = $users->getUser('Steven Lac');
        $jorge = $users->getUser('Jorge Thatcher');
        
        $friendships->addNewFriendship($danny, $andrea);
        $friendships->addNewFriendship($danny, $steve);
        $friendships->addNewFriendship($danny, $jorge);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}

?>
