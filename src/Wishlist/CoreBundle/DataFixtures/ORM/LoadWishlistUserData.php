<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \DateTime;

class LoadWishlistUserData implements FixtureInterface
{
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $birthdate = new DateTime("06/11/1986");
        
        $enumRepo = $manager->getRepository('WishlistCoreBundle:Enum');
        
        $maleEnum = $enumRepo->findOneByName('male');
        
        $user = new WishlistUser();
        $user->setBirthdate($birthdate);
        $user->setEmail("hoohaw@email.com");
        $user->setGender($maleEnum);
        $user->setFirstname("danny");
        $user->setLastname("Mardini");
        $user->setPassword("hoohaw");
        
        $manager->persist($user);
        $manager->flush();
    }
}

?>