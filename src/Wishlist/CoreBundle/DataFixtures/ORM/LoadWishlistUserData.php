<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \DateTime;

class LoadWishlistUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $birthdate = new DateTime("06/11/1986");
        $enumRepo = $manager->getRepository('WishlistCoreBundle:Enum');
        $maleEnum = $enumRepo->findOneByName('male');
        
        addUser($manager, "Danny", "Mardini", $birthdate, "hoohaw@gmail.com", $maleEnum, "hoohaw");
        
        $manager->flush();
    }

    public function addUser(ObjectManager $manager, String $firstname, String $lastname, DateTime $birthdate, String $email, Enum $gender, String $password)
    {
        $user = new WishlistUser();
        
        $user->setBirthdate($birthdate);
        $user->setEmail($email);
        $user->setGender($gender);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        $manager->persist($user);
    }
}

?>