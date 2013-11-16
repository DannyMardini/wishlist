<?php
namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Wishlist\CoreBundle\Entity\PurchaseRepository;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\WishlistUserRepository;
use Wishlist\CoreBundle\Repository\ItemRepository;
use Wishlist\CoreBundle\Repository\WishlistItemRepository;
use \DateTime;

class LoadPurchaseData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $itemRepo = $manager->getRepository('WishlistCoreBundle:Item');
        $purchaseRepo = $manager->getRepository('WishlistCoreBundle:Purchase');
        $wishlistItemRepo = $manager->getRepository('WishlistCoreBundle:WishlistItem');
        $eventRepo = $manager->getRepository('WishlistCoreBundle:Event');
        $dummyDate = DateTime::createFromFormat('m/d/Y', '1/1/2013');
        
        $danny = $userRepo->getUser('Danny Mardini');
        $andrea = $userRepo->getUser('Andrea Coba');
        
        $nerfGun = $itemRepo->findOneByName('Nerf gun');
        $purse = $itemRepo->findOneByName('purse');
        $bouncyBall = $itemRepo->findOneByName('Bouncy ball');
        $macbook = $itemRepo->findOneByName('Macbook');
        $Bug = $itemRepo->findOneByName('Bug');
        
        $dannysWish = $wishlistItemRepo->getWishlistItemForUser($nerfGun, $danny);
        $andreasWish = $wishlistItemRepo->getWishlistItemForUser($purse, $andrea);
        $andreasBall = $wishlistItemRepo->getWishlistItemForUser($bouncyBall, $andrea);
        $andreasMacbook = $wishlistItemRepo->getWishlistItemForUser($macbook, $andrea);
        $andreasBug = $wishlistItemRepo->getWishlistItemForUser($Bug, $andrea);
        
        $events = $eventRepo->getAllUserEvents($andrea->getWishlistUserId());
        $event = $events[0];

        $purchaseRepo->newPurchase($danny, $dannysWish, NULL, $dummyDate);
        $purchaseRepo->newPurchase($danny, $andreasBall, $event, NULL);
        $purchaseRepo->newPurchase($danny, $andreasMacbook, $event, NULL);
        $purchaseRepo->newPurchase($danny, $andreasBug, $event, NULL);
        
        $purchaseRepo->newPurchase($andrea, $andreasWish, NULL, $dummyDate);
   }
    
    public function getOrder()
    {
        return 5;
    }
}

?>
