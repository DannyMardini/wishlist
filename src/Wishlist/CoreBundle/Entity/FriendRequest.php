<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\FriendRequest
 */
class FriendRequest
{
    const STATE_UNREAD = 0;
    const STATE_READ = 1;

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
     * @var integer $state
     */
    private $state;

    /**
     * @var string $text
     */
    private $text;


    /**
     * Set state
     *
     * @param integer $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set text
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
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
    /**
     * @var integer $userRequested
     */
    private $userRequested;


    /**
     * Set userRequested
     *
     * @param integer $userRequested
     */
    public function setUserRequested($userRequested)
    {
        $this->userRequested = $userRequested;
    }

    /**
     * Get userRequested
     *
     * @return integer 
     */
    public function getUserRequested()
    {
        return $this->userRequested;
    }
}