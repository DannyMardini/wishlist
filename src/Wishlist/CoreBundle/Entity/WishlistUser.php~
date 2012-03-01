<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WishlistUser
 *
 * @author Danny
 */

use Doctrine\Common\Collections\ArrayCollection;

namespace Wishlist\CoreBundle\Entity;

class WishlistUser {
    protected $firstname;
    protected $lastname;
    protected $gender = 1;
    protected $birthdate;
    protected $email;
    protected $wishlistuser_id;
    protected $password;
    protected $wishlistItems;

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
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthdate
     *
     * @param datetime $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * Get birthdate
     *
     * @return datetime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $friendships;

    public function __construct()
    {
        $this->friendships = new ArrayCollection();
        $this->wishlistItems = new ArrayCollection();
    }
    
    /**
     * Add friendships
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $friendships
     */
    public function addWishlistUser(\Wishlist\CoreBundle\Entity\WishlistUser $friendships)
    {
        $this->friendships[] = $friendships;
    }

    /**
     * Get friendships
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFriendships()
    {
        return $this->friendships;
    }

    /**
     * Add wishlistItems
     *
     * @param Wishlist\CoreBundle\Entity\WishlistItem $wishlistItems
     */
    public function addWishlistItem(\Wishlist\CoreBundle\Entity\WishlistItem $wishlistItems)
    {
        $this->wishlistItems[] = $wishlistItems;
    }

    /**
     * Get wishlistItems
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWishlistItems()
    {
        return $this->wishlistItems;
    }
}