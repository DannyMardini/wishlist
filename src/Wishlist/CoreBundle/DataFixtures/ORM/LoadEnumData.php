<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\Enum;
use \DateTime;

class LoadEnumData implements FixtureInterface
{
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $enum1 = new Enum();
        $enum1->setType('gender');
        $enum1->setName('male');
        $enum1->setValue(0);
        
        $enum2 = new Enum();
        $enum2->setType('gender');
        $enum2->setName('female');
        $enum2->setValue(2);
        
        $manager->persist($enum1);
        $manager->persist($enum2);
        $manager->flush();
    }
}

?>