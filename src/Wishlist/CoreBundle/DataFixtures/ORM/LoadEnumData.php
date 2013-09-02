<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\Enum;
use Wishlist\CoreBundle\Entity\WishlistUpdate;
use Wishlist\CoreBundle\Entity\Notification;
use \DateTime;

class LoadEnumData implements FixtureInterface
{
    /*
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $manager;
    
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $this->manager = $manager;
        
        $this->newEnum('gender', 'male', 1);
        $this->newEnum('gender', 'female', 2);
        
        $this->newEnum('WishlistUpdate', 'TYPE_1', WishlistUpdate::TEMPLATE_TYPE_1);
        $this->newEnum('WishlistUpdate', 'TYPE_2', WishlistUpdate::TEMPLATE_TYPE_2);        
        $this->newEnum('WishlistUpdate', 'ADD_ITEM', WishlistUpdate::TYPE_ADD_ITEM);
        $this->newEnum('WishlistUpdate', 'REMOVE_ITEM', WishlistUpdate::TYPE_REMOVE_ITEM);
        $this->newEnum('WishlistUpdate', 'ADD_FRIEND', WishlistUpdate::TYPE_ADD_FRIEND);
        $this->newEnum('WishlistUpdate', 'REMOVE_FRIEND', WishlistUpdate::TYPE_REMOVE_FRIEND);
        
        $this->newEnum('Notification', 'STATE_UNREAD', Notification::STATE_UNREAD);
        $this->newEnum('Notification', 'STATE_READ', Notification::STATE_READ);
         
        $manager->flush();
    }
    
    public function newEnum(/*string*/ $type, /*string*/ $name, /*int*/ $value)
    {
        $enum = new Enum();
        $enum->setType($type);
        $enum->setName($name);
        $enum->setValue($value);
        
        $this->manager->persist($enum);
    }
}

?>