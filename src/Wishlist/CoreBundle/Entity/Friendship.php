<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Friendship
 *
 * @author Danny
 */

namespace Wishlist\CoreBundle\Entity;
    
    
class Friendship {
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
     * @var integer $friend_id
     */
    private $friend_id;


    /**
     * Set friend_id
     *
     * @param integer $friendId
     */
    private function setFriendId($friendId)
    {
        $this->friend_id = $friendId;
    }

    /**
     * Get friend_id
     *
     * @return integer 
     */
    public function getFriendId()
    {
        return $this->friend_id;
    }
    
    public function setFriend(\Wishlist\CoreBundle\Entity\WishlistUser $friend)
    {
        $this->setFriendId($friend->getWishlistuserId());
    }
}