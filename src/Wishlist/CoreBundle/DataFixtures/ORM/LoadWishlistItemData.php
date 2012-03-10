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
        
        
        $itemRepo->addItem('purse', 50000, 'www.purse.com', true, 'This is a purse', 1, $andrea);
        $itemRepo->addItem('Bouncy ball', 1000, 'www.bounce.com', true, 'It bounces!', 1, $andrea);
        $itemRepo->addItem('Macbook', 100000, 'www.apple.com', true, 'it\'s perfect', 1, $andrea);
        $itemRepo->addItem('Zumba Fitness videos', 10000, 'www.zumba.com', true, 'Get your booty shakin\'', 1, $andrea);
        $itemRepo->addItem('Pink gold watch', 20000, 'www.watch.com', true, 'it\'s pink', 1, $andrea);
        
        
        $itemRepo->addItem('Metal Gear Solid', 3000, 'www.mgs.com', true, 'EMOTION', 1, $danny);
        $itemRepo->addItem('Nerf gun', 2000, 'www.nerf.com', true, 'cap in yo ass', 1, $danny);
        
    }
    
    public function getOrder()
    {
        return 3;
    }
}

?>