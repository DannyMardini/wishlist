<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \Doctrine\Common\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadRequestData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $requestRepo = $manager->getRepository('WishlistCoreBundle:Request');

        $danny = $userRepo->getUser('Danny Mardini');
        $andrea = $userRepo->getUser('Andrea Coba');        

        $requestRepo->addInviteToQueue('hoho@ho.com');
        $requestRepo->addInviteToQueue('hoohaw@ho.com', $danny);
        $requestRepo->addInviteToQueue('omg@ho.com', $andrea);
    }
    
    public function getOrder()
    {
        return 3;
    }
}
