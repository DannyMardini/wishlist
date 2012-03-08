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
    protected $usera_id;
    protected $userb_id;
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
     * Set usera_id
     *
     * @param integer $useraId
     */
    public function setUseraId($useraId)
    {
        $this->usera_id = $useraId;
    }

    /**
     * Get usera_id
     *
     * @return integer 
     */
    public function getUseraId()
    {
        return $this->usera_id;
    }

    /**
     * Set userb_id
     *
     * @param integer $userbId
     */
    public function setUserbId($userbId)
    {
        $this->userb_id = $userbId;
    }

    /**
     * Get userb_id
     *
     * @return integer 
     */
    public function getUserbId()
    {
        return $this->userb_id;
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