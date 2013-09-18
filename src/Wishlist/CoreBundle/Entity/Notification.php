<?php
//TODO: This class should be a base class to other types of notifications like friend requests.
//TODO: Text should also be generated so it's all the same. The way it is now it is very easy to make
//two like-type requests have completely different structured texts.
namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Notification
 */
class Notification
{
    const STATE_UNREAD = 0;
    const STATE_READ = 1;
    
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $userRequested
     */
    private $userRequested;

    /**
     * @var integer $state
     */
    private $state;

    /**
     * @var string $text
     */
    private $text;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $wishlistUser;


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