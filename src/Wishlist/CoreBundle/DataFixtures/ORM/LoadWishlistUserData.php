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
        $birthdate = new DateTime("06/11/1986");
        $enumRepo = $manager->getRepository('WishlistCoreBundle:Enum');
        $maleEnum = $enumRepo->findOneByName('male');
        
        $this->addUser($manager, "Danny", "Mardini", $birthdate, "dannymardini@gmail.com", $maleEnum, "hoohaw");
        $this->addUser($manager, "Andrea", "Coba", new DateTime("08/18/1986"), "andee@g.c", $enumRepo->findOneByName('female'), "dingaling");
        
        $manager->flush();
    }

    public function addUser(ObjectManager $manager, $firstname, $lastname, DateTime $birthdate, $email, $gender, $password)
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
    
    public function getOrder()
    {
        return 1;
    }
}

?>