<?php

namespace Wishlist\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Wishlist\CoreBundle\Entity\WishlistUpdate;
use Wishlist\CoreBundle\Repository\EnumRepository;
use \Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use \DateTime;

class LoadWishlistUpdateData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $userRepo = $manager->getRepository('WishlistCoreBundle:WishlistUser');
//        $updateRepo = $manager->getRepository('WishlistCoreBundle:WishlistUpdate');
//        
//        $danny = $userRepo->getUser("Danny Mardini");
//        $andrea = $userRepo->getUser("Andrea Coba");
//        $steve = $userRepo->getUser('Steven Lac');
//        $jorge = $userRepo->getUser('Jorge Thatcher');
//        
//        $updateRepo->addNewItem($jorge, $item);
////        $updateRepo->addNewUpdate(
////                WishlistUpdate::templateEnums('TYPE_1'),
////                WishlistUpdate::typeEnums('ADD_ITEM'),
////                "Jorge added <a href='#' onclick='openDialog(1)'>Lineage II</a> to his wishlist",
////                new DateTime('2012-3-15 12:00:00'),
////                $jorge);
//        
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums('TYPE_1'),
//                WishlistUpdate::typeEnums('ADD_ITEM'),
//                "Steven added <a href='#' onclick='openDialog(1)'>Metal Gear Solid</a> to his wishlist",
//                new DateTime('2012-3-15 12:00:00'),
//                $steve);
//        
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums("TYPE_1"),
//                WishlistUpdate::typeEnums("REMOVE_ITEM"),
//                "Andrea removed <a href='#' onclick='openDialog(1)'>Guess Purse</a> from her wishlist", 
//                new DateTime("2011-12-23 03:00:00"),
//                $andrea);
//        
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums("TYPE_2"),
//                WishlistUpdate::typeEnums("ADD_FRIEND"),
//                "Is now friends with <a href='user/4'>Uyen Vu</a>",
//                new DateTime("2011-12-24 04:00:00"),
//                $andrea);
//        
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums("TYPE_1"),
//                WishlistUpdate::typeEnums("ADD_ITEM"),
//                "Danny added <a href='#' onclick='openDialog(1)'>Skyrim</a> to his wishlist",
//                new DateTime("2011-12-31 08:00:00"),
//                $danny);
//
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums("TYPE_2"),
//                WishlistUpdate::typeEnums("ADD_FRIEND"),
//                "Is now friends with <a href='user/5/'>Blanca Edmiston</a>",
//                new DateTime("2012-01-6 08:00:00"),
//                $andrea);
//
//        $updateRepo->addNewUpdate(
//                WishlistUpdate::templateEnums("TYPE_1"),
//                WishlistUpdate::typeEnums("ADD_ITEM"),
//                "Danny added <a href='#' onclick='openDialog(1)'>Battlefield</a> to his wishlist",
//                new DateTime("2011-10-23 08:00:00"),
//                $danny);
    }
    
    public function getOrder()
    {
        return 4;
    }
}

?>