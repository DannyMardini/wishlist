<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Event
 */
class Event
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $wishlistuser_id
     */
    private $wishlistuser_id;

    /**
     * @var integer $eventType
     */
    private $eventType;

    /**
     * @var datetime $eventDate
     */
    private $eventDate;


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
     * Set wishlistuser_id
     *
     * @param integer $wishlistuserId
     */
    public function setWishlistuserId($wishlistuserId)
    {
        $this->wishlistuser_id = $wishlistuserId;
    }

    /**
     * Get wishlistuser_id
     *
     * @return integer 
     */
    public function getWishlistuserId()
    {
        return $this->wishlistuser_id;
    }

    /**
     * Set eventType
     *
     * @param integer $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * Get eventType
     *
     * @return integer 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set eventDate
     *
     * @param datetime $eventDate
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * Get eventDate
     *
     * @return datetime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
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