<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadItemData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $itemRepo = $manager->getRepository('WishlistCoreBundle:Item');
        
        $danny = $userRepo->getUser('Danny Mardini');
        $andrea = $userRepo->getUser('Andrea Coba');
        $jorge = $userRepo->getUser('Jorge Thatcher');
        $steve = $userRepo->getUser('Steven Lac');
        
        $itemRepo->makeWish('purse', 50000, 'www.purse.com', true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->makeWish('Bouncy ball', 1000, 'www.bounce.com', true, 'It bounces!', 1, $andrea);
        $itemRepo->makeWish('Macbook', 100000, 'www.apple.com', true, 'it\'s perfect', 1, $andrea);
        $itemRepo->makeWish('Zumba Fitness videos', 10000, 'www.zumba.com', true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->makeWish('Pink gold watch', 20000, 'www.watch.com', true, 'it\'s pink', 1, $andrea);
        $itemRepo->makeWish('Bug', 1, 'www.bugisbug.com', true, 'bug? this is bug.', 1, $andrea);
        
        $itemRepo->makeWish('Metal Gear Solid', 3000, 'www.mgs.com', true, 'EMOTION', 1, $danny);
        $itemRepo->makeWish('Nerf gun', 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $danny);
        
        $itemRepo->makeWish('Lineage II', 5000, 'www.lineage2.com', true, 'Grindin\' till we dyin\'', 1, $jorge);
        $itemRepo->makeWish('Metal Gear Solid Peace Walker', 50000, 'www.mgs.com', true, 'HOOHAW EMOTION', 1, $steve);
    }
    
    public function getOrder()
    {
        return 4;
    }
}

?>