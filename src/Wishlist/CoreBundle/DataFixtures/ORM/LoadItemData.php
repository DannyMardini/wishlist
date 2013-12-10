<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadItemData implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $itemRepo = $manager->getRepository('WishlistCoreBundle:Item');
        
        $danny = $userRepo->getUser('Danny Mardini');
        $andrea = $userRepo->getUser('Andrea Coba');
        $jorge = $userRepo->getUser('Jorge Thatcher');
        $steve = $userRepo->getUser('Steven Lac');
       
        $itemRepo->newItem('purse', 50000, 'www.purse.com'); //, true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->newItem('Bouncy ball', 1000, 'www.bounce.com'); //, true, 'It bounces!', 1, $andrea);
        $itemRepo->newItem('Macbook', 100000, 'www.apple.com'); //, true, 'it\'s perfect', 1, $andrea);
        $itemRepo->newItem('Zumba Fitness videos', 10000, 'www.zumba.com'); //, true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->newItem('Pink gold watch', 20000, 'www.watch.com'); //, true, 'it\'s pink', 1, $andrea);
        $itemRepo->newItem('Bug', 1, 'www.bugisbug.com'); //, true, 'bug? this is bug.', 1, $andrea);
        $itemRepo->newItem('Metal Gear Solid', 3000, 'www.mgs.com'); //, true, 'EMOTION', 1, $danny);
        $itemRepo->newItem('Nerf gun', 2000, 'www.nerf.com'); //, true, 'cap in yo ass', 1, $danny);
        $itemRepo->newItem('Lineage II', 5000, 'www.lineage2.com'); //, true, 'Grindin\' till we dyin\'', 1, $jorge);
        $itemRepo->newItem('Metal Gear Solid Peace Walker', 50000, 'www.mgs.com'); //, true, 'HOOHAW EMOTION', 1, $steve);
        
        $itemRepo->newItem('purse2', 50000, 'www.purse.com'); //, true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->newItem('Bouncy ball2', 1000, 'www.bounce.com'); //, true, 'It bounces!', 1, $andrea);
        $itemRepo->newItem('Macbook2', 100000, 'www.apple.com'); //, true, 'it\'s perfect', 1, $andrea);
        $itemRepo->newItem('Zumba Fitness videos2', 10000, 'www.zumba.com'); //, true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->newItem('Pink gold watch2', 20000, 'www.watch.com'); //, true, 'it\'s pink', 1, $andrea);
        $itemRepo->newItem('Bug2', 1, 'www.bugisbug.com'); //, true, 'bug? this is bug.', 1, $andrea);
        $itemRepo->newItem('Metal Gear Solid2', 3000, 'www.mgs.com'); //, true, 'EMOTION', 1, $danny);
        $itemRepo->newItem('Nerf gun2', 2000, 'www.nerf.com'); //, true, 'cap in yo ass', 1, $danny);
        $itemRepo->newItem('Lineage II2', 5000, 'www.lineage2.com'); //, true, 'Grindin\' till we dyin\'', 1, $jorge);
        $itemRepo->newItem('Metal Gear Solid Peace Walker2', 50000, 'www.mgs.com'); //, true, 'HOOHAW EMOTION', 1, $steve);
        
        $itemRepo->newItem('purse3', 50000, 'www.purse.com'); //, true, 'Bug. this is a purse.', 1, $andrea);
        $itemRepo->newItem('Bouncy ball3', 1000, 'www.bounce.com'); //, true, 'It bounces!', 1, $andrea);
        $itemRepo->newItem('Macbook3', 100000, 'www.apple.com'); //, true, 'it\'s perfect', 1, $andrea);
        $itemRepo->newItem('Zumba Fitness videos3', 10000, 'www.zumba.com'); //, true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->newItem('Pink gold watch3', 20000, 'www.watch.com'); //, true, 'it\'s pink', 1, $andrea);
        $itemRepo->newItem('Bug3', 1, 'www.bugisbug.com'); //, true, 'bug? this is bug.', 1, $andrea);
        $itemRepo->newItem('Metal Gear Solid3', 3000, 'www.mgs.com'); //, true, 'EMOTION', 1, $danny);
        $itemRepo->newItem('Nerf gun3', 2000, 'www.nerf.com'); //, true, 'cap in yo ass', 1, $danny);
        $itemRepo->newItem('Lineage II3', 5000, 'www.lineage2.com'); //, true, 'Grindin\' till we dyin\'', 1, $jorge);
        $itemRepo->newItem('Metal Gear Solid Peace Walker3', 50000, 'www.mgs.com'); //, true, 'HOOHAW EMOTION', 1, $steve);        
    }
    
    public function getOrder()
    {
        return 3;
    }
}

?>