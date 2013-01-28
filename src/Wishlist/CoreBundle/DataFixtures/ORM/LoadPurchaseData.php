<?php
namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Wishlist\CoreBundle\Entity\PurchaseRepository;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\WishlistUserRepository;
use \DateTime;

class LoadPurchaseData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
//        $itemRepo = $manager->getRepository('WishlistCoreBundle:Item');
//        $purchaseRepo = $manager->getRepository('WishlistCoreBundle:Purchase');
//        $dummyDate = DateTime::createFromFormat('m/d/Y', '1/1/2013');
//        
//        $danny = $userRepo->getUser('Danny Mardini');
//        $andrea = $userRepo->getUser('Andrea Coba');
//                
//        $nerfGun = $itemRepo->findOneByName('Nerf gun');
//        $purse = $itemRepo->findOneByName('purse');
//
//        $purchaseRepo->newPurchase($danny, $purse, NULL, $dummyDate);
//        $purchaseRepo->newPurchase($andrea, $nerfGun, NULL, $dummyDate);
   }
    
    public function getOrder()
    {
        return 5;
    }
}

?>
