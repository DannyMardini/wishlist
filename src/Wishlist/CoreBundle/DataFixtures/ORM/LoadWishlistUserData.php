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
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        
        //TODO Change the Enum class to encapsulate the gender enums.
        $userRepo->addNewUser("Danny Mardini", new DateTime("06/11/1986"), "dannymardini@gmail.com", WishlistUser::GENDER_MALE, "hoohaw");        
        $userRepo->addNewUser("Andrea Coba", new DateTime("08/18/1986"), "andee@g.c", WishlistUser::GENDER_FEMALE, "dingaling");
        
        $userRepo->addNewUser("Steven Lac", new DateTime('6/4/1985'), "stevocpp@gmail.com", WishlistUser::GENDER_MALE, "hullo");
        $userRepo->addNewUser("Jorge Thatcher", new DateTime('7/20/1970'), "ndnwarrior777@yahoo.com", WishlistUser::GENDER_MALE, 'yourface');
        $userRepo->addNewUser("Rima Mardini", new DateTime('5/29/1980'), "rmardini@cox.net", WishlistUser::GENDER_FEMALE, 'prada');
        
        for($i = 0; $i < 12; $i++)
        {
            $name = "Test User".$i;
            $userRepo->addNewUser($name, new DateTime('7/20/1970'), "test@yahoo.com", 
                    ($i % 2 == 0 )?WishlistUser::GENDER_MALE : WishlistUser::GENDER_FEMALE, "test");
        }
        
        $userRepo->addNewUser("Angie Test", new DateTime("08/18/1986"), "angie@yahoo.com", WishlistUser::GENDER_FEMALE, "gongaling");
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1;
    }
}

?>