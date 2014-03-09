<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadWishlistItemData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $itemRepo = $manager->getRepository('WishlistCoreBundle:WishlistItem');
        
        $danny = $userRepo->getUser('Danny Mardini');
        $andrea = $userRepo->getUser('Andrea Coba');
        $jorge = $userRepo->getUser('Jorge Thatcher');
        $steve = $userRepo->getUser('Steven Lac');
        $rima = $userRepo->getUser('Rima Mardini');
        
        $itemRepo->makeWish('purse', null, null, 50000, 'www.purse.com', true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->makeWish('Bouncy ball', null, null, 1000, 'www.bounce.com', true, 'It bounces!', 1, $andrea);
        $itemRepo->makeWish('Macbook', null, null, 100000, 'www.apple.com', true, 'it\'s perfect', 1, $andrea);
        $itemRepo->makeWish('Zumba Fitness videos', null, null, 10000, 'www.zumba.com', true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->makeWish('Pink gold watch', null, null, 20000, 'www.watch.com', true, 'it\'s pink', 1, $andrea);
        $itemRepo->makeWish('Bug', null, null, 1, 'www.bugisbug.com', true, 'bug? this is bug.', 1, $andrea);
        $itemRepo->makeWish('purse2', null, null, 50000, 'www.purse.com', true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->makeWish('Bouncy ball2', null, null, 1000, 'www.bounce.com', true, 'It bounces!', 1, $andrea);
        $itemRepo->makeWish('Macbook2', null, null, 100000, 'www.apple.com', true, 'it\'s perfect', 1, $andrea);
        $itemRepo->makeWish('Zumba Fitness videos2', null, null, 10000, 'www.zumba.com', true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->makeWish('Pink gold watch2', null, null, 20000, 'www.watch.com', true, 'it\'s pink', 1, $andrea);
        $itemRepo->makeWish('Bug2', null, null, 1, 'www.bugisbug.com', true, 'bug? this is bug.', 1, $andrea);
        $itemRepo->makeWish('purse3', null, null, 50000, 'www.purse.com', true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->makeWish('Bouncy ball3', null, null, 1000, 'www.bounce.com', true, 'It bounces!', 1, $andrea);
        $itemRepo->makeWish('Macbook3', null, null, 100000, 'www.apple.com', true, 'it\'s perfect', 1, $andrea);
        $itemRepo->makeWish('Zumba Fitness videos3', null, null, 10000, 'www.zumba.com', true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->makeWish('Pink gold watch3', null, null, 20000, 'www.watch.com', true, 'it\'s pink', 1, $andrea);
        $itemRepo->makeWish('Bug3', null, null, 1, 'www.bugisbug.com', true, 'bug? this is bug.', 1, $andrea);  
        $itemRepo->makeWish('Metal Gear Solid', null, null, 3000, 'www.mgs.com', true, 'EMOTION', 1, $andrea);  
        $itemRepo->makeWish('Nerf gun', null, null, 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $andrea);  
        $itemRepo->makeWish('Lineage II', null, null, 5000, 'www.lineage2.com', true, 'Grindin\' till we dyin\'', 1, $andrea);  
        $itemRepo->makeWish('Metal Gear Solid2', null, null, 3000, 'www.mgs.com', true, 'EMOTION', 1, $andrea);  
        $itemRepo->makeWish('Nerf gun2', null, null, 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $andrea);  
        $itemRepo->makeWish('Lineage II2', null, null, 5000, 'www.lineage2.com', true, 'Grindin\' till we dyin\'', 1, $andrea);  
        $itemRepo->makeWish('Metal Gear Solid3', null, null, 3000, 'www.mgs.com', true, 'EMOTION', 1, $andrea);  
        $itemRepo->makeWish('Nerf gun3', null, null, 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $andrea);  
        $itemRepo->makeWish('Lineage II3', null, null, 5000, 'www.lineage2.com', true, 'Grindin\' till we dyin\'', 1, $andrea);          
        
        
        $itemRepo->makeWish('Metal Gear Solid', null, null, 3000, 'www.mgs.com', true, 'EMOTION', 1, $danny);
        $itemRepo->makeWish('Nerf gun', null, null, 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $danny);
        
        $itemRepo->makeWish('Lineage II', null, null, 5000, 'www.lineage2.com', true, 'Grindin\' till we dyin\'', 1, $jorge);
        $itemRepo->makeWish('Metal Gear Solid Peace Walker', null, null, 50000, 'www.mgs.com', true, 'HOOHAW EMOTION', 1, $steve);
        
        $itemRepo->makeWish('necklace', null, null, 50000, 'www.necklace.com', true, 'Bug. this is a necklace.', 1, $rima);
        $itemRepo->makeWish('ring', null, null, 50000, 'www.ring.com', true, 'Bug. this is a ring.', 1, $rima);
    }
    
    public function getOrder()
    {
        return 4;
    }
}

?>