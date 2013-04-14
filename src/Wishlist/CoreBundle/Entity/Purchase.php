<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class PurchaseEventTypes
{
    const Purchased = 0;                // The purchase was completed        
    const RemovedFromShoppingList = 1;  // The user removed the purchase from their shopping list
    const RemovedFromWishlist = 2;      // The friend removed the wish from their wishlist
    const Added = 3;                    // A Wish Item was added to the shopping list
    // etc.
}  

/**
 * Wishlist\CoreBundle\Entity\Purchase
 */
class Purchase
{
    const TYPE_EVENT = "Event";
    const TYPE_DATE = "Date";     
    
    /**
     * @var integer $id
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $user;

    /**
     * @var Wishlist\CoreBundle\Entity\Item
     */
    private $item;

    /**
     * Set user
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $user
     */
    public function setUser(\Wishlist\CoreBundle\Entity\WishlistUser $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set item
     *
     * @param Wishlist\CoreBundle\Entity\Item $item
     */
    public function setItem(\Wishlist\CoreBundle\Entity\Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get item
     *
     * @return Wishlist\CoreBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\Event
     */
    private $event;


    /**
     * Set event
     *
     * @param Wishlist\CoreBundle\Entity\Event $event
     */
    public function setEvent(\Wishlist\CoreBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return Wishlist\CoreBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
    /**
     * @var date $gift_date
     */
    private $gift_date;

    /**
     * Set gift_date
     *
     * @param date $giftDate
     */
    public function setGiftDate($giftDate)
    {
        $this->gift_date = $giftDate;
    }

    /**
     * Get gift_date
     *
     * @return date 
     */
    public function getGiftDate()
    {
        return $this->gift_date;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $wishlistUser;


    /**
     * Set wishlistUser
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $wishlistUser
     */
    public function setWishlistUser(\Wishlist\CoreBundle\Entity\WishlistUser $wishlistUser)
    {
        $this->wishlistUser = $wishlistUser;
    }

    /**
     * Get wishlistUser
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getWishlistUser()
    {
        return $this->wishlistUser;
    }
}