<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\Event;
use Wishlist\CoreBundle\Repository\EventRepository;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \Doctrine\Common\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadEventData implements FixtureInterface,OrderedFixtureInterface{
    
    
    public function load(ObjectManager $manager)
    {                
        $usersRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
        $eventsRepo = $manager->getRepository('WishlistCoreBundle:Event');
        
        $danny = $usersRepo->getUser('Danny Mardini');
        $andrea = $usersRepo->getUser('Andrea Coba');        
        
        $eventsRepo->addEvent( 'Birthday', 1, new DateTime("06/11/1986"), $danny );
        $eventsRepo->addEvent( 'Anniversary with Andrea', 2, new DateTime("06/25/2010"), $danny );
        $eventsRepo->addEvent( 'Anniversary at work', 2, new DateTime("04/15/2010"), $danny );
        $eventsRepo->addEvent( 'Birthday', '1', new DateTime("08/18/1986"), $andrea );
        $eventsRepo->addEvent( 'Anniversary with Danny', 2, new DateTime("06/25/2010"), $andrea );
        
        for($i = 0; $i < 20; $i++)
        {
            $eventsRepo->addEvent( 'testEvent'.$i, 1, new DateTime("06/11/1986"), $danny);
        }
    }

    public function getOrder()
    {
        return 4;
    }
}
?>
