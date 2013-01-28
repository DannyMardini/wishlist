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

namespace Wishlist\CoreBundle\Entity;

use Wishlist\CoreBundle\Services\PicService;

class WishlistUser {
    protected $firstname;
    protected $lastname;
    protected $gender = 1;
    protected $birthdate;
    protected $email;
    protected $wishlistuser_id;
    protected $password;
    protected $wishlistItems;
    
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

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
     * @return integer $gender 
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    /**
     * Get gender
     *
     * @return string form of gender.
     */
    public function getGenderString()
    {
        if($this->gender == WishlistUser::GENDER_MALE)
        {
            return "Male";
        }else
        {
            return "Female";
        }        
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
     * @param Wishlist\CoreBundle\Entity\Item $wishlistItems
     */
    public function addItems(\Wishlist\CoreBundle\Entity\Item $items)
    {
        $this->wishlistItems[] = $items;
    }

    /**
     * Get wishlistItems
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->wishlistItems;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUpdate
     */
    private $wishlistUpdates;


    /**
     * Add wishlistUpdates
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUpdate $wishlistUpdates
     */
    public function addWishlistUpdate(\Wishlist\CoreBundle\Entity\WishlistUpdate $wishlistUpdates)
    {
        $this->wishlistUpdates[] = $wishlistUpdates;
    }

    /**
     * Get wishlistUpdates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWishlistUpdates()
    {
        return $this->wishlistUpdates;
    }
    
    public static function areFriends(WishlistUser $usera, WishlistUser $userb)
    {
        $friendships = $usera->getFriendships();
        foreach ( $friendships as $friendship )
        {
            if( $friendship->getFriendId() == $userb->getWishlistuserId() )
            {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Add friendships
     *
     * @param Wishlist\CoreBundle\Entity\Friendship $friendships
     */
    public function addFriendship(\Wishlist\CoreBundle\Entity\Friendship $friendships)
    {
        $this->friendships[] = $friendships;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\Event
     */
    private $events;


    /**
     * Add events
     *
     * @param Wishlist\CoreBundle\Entity\Event $events
     */
    public function addEvent(\Wishlist\CoreBundle\Entity\Event $events)
    {
        $this->events[] = $events;
    }

    /**
     * Get events
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
    
    public function getProfileUrl()
    {
        return PicService::getProfileUrl($this->wishlistuser_id);
    }
    
    public function getProfileThumb()
    {
        return PicService::getProfileThumb($this->wishlistuser_id);
    }
    /**
     * @var Wishlist\CoreBundle\Entity\Item
     */
    private $purchases;


    /**
     * Get purchases
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPurchases()
    {
        return $this->purchases;
    }
}