<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Purchase
 */
class Purchase
{
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
     * @var datetime $date
     */
    private $date;


    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @var datetime $notify_date
     */
    private $notify_date;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $user;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistItem
     */
    private $item;


    /**
     * Set notify_date
     *
     * @param datetime $notifyDate
     */
    public function setNotifyDate($notifyDate)
    {
        $this->notify_date = $notifyDate;
    }

    /**
     * Get notify_date
     *
     * @return datetime 
     */
    public function getNotifyDate()
    {
        return $this->notify_date;
    }

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
     * @param Wishlist\CoreBundle\Entity\WishlistItem $item
     */
    public function setItem(\Wishlist\CoreBundle\Entity\WishlistItem $item)
    {
        $this->item = $item;
    }

    /**
     * Get item
     *
     * @return Wishlist\CoreBundle\Entity\WishlistItem 
     */
    public function getItem()
    {
        return $this->item;
    }
}