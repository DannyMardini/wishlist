<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \DateTime;

class LoadWishlistUserData implements FixtureInterface
{
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $birthdate = new DateTime("06/11/1986");
        
        $user = new WishlistUser();
        $user->setBirthdate($birthdate);
        $user->setEmail("hoohaw@email.com");
        $user->setGender(1);
        $user->setFirstname("danny");
        $user->setLastname("Mardini");
        $user->setPassword("hoohaw");
        
        $manager->persist($user);
        $manager->flush();
    }
}

?>