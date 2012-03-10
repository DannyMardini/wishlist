<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadWishlistUserData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $enumRepo = $manager->getRepository('WishlistCoreBundle:Enum');
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        
        $userRepo->addNewUser("Danny", "Mardini", new DateTime("06/11/1986"), "dannymardini@gmail.com", $enumRepo->findOneByName('male'), "hoohaw");
        $userRepo->addNewUser("Andrea", "Coba", new DateTime("08/18/1986"), "andee@g.c", $enumRepo->findOneByName('female'), "dingaling");
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1;
    }
}

?>