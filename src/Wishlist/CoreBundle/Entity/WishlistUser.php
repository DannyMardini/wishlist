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
use Wishlist\CoreBundle\Library\StoPasswordHash;

class WishlistUser {
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
        $this->password = StoPasswordHash::hashBcrypt($password);
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
    
    public function getProfileUrl($picService)
    {
        return $picService->getProfileUrl($this->wishlistuser_id);
    }
    
    public function getProfileThumb($picService)
    {
        return $picService->getProfileThumb($this->wishlistuser_id);
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

    /**
     * Add wishlistItems
     *
     * @param Wishlist\CoreBundle\Entity\Item $wishlistItems
     */
    public function addItem(\Wishlist\CoreBundle\Entity\Item $wishlistItems)
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

    public function getUngrantedItems()
    {
        $items = array();

        foreach($this->wishlistItems as $wishlistItem)
        {
            if($wishlistItem->getGranted() != true)
            {
                $items[] = $wishlistItem;
            }
        }

        return $items;
    }

    public function getGrantedItems()
    {
        $items = array();

        foreach($this->wishlistItems as $wishlistItem)
        {
            if($wishlistItem->getGranted() == true)
            {
                $items[] = $wishlistItem;
            }
        }

        return $items;
    }

    public function getNonNotifiedGrantedItems()
    {
        $items = array();
        $grantedItems = $this->getGrantedItems();

        foreach($grantedItems as $grantedItem)
        {
            if($grantedItem->getConcluded() != true)
            {
                $items[] = $grantedItem;
            }
        }

        return $items;
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
     * Add purchases
     *
     * @param Wishlist\CoreBundle\Entity\Purchase $purchases
     */
    public function addPurchase(\Wishlist\CoreBundle\Entity\Purchase $purchases)
    {
        $this->purchases[] = $purchases;
    }

    /**
     * toJSON
     * 
     * Turns object into JSON format. It is required to create an array out of 
     * protected members because json_encode will not encode protected and private
     * class members on it's own.
     */    
    public function toJSON($picService)
    {
        $exportvars = array('wishlistuser_id' => $this->wishlistuser_id,
                            'name' => $this->name,
                            'profileUrl' => $this->getProfileUrl($picService));
        
        return json_encode($exportvars);
    }
    /**
     * @var string $name
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get first name
     *
     * @return string 
     */
    public function getFirstName()
    {
        $explodedName = explode(' ', $this->name);
        if(count($explodedName) > 0)
        {
            return $explodedName[0];
        }
        
        return "";
    }

    /**
     * Get last name
     *
     * @return string 
     */
    public function getLastName()
    {
        $explodedName = explode(' ', $this->name);
        if(count($explodedName) > 1)
        {
            return $explodedName[1];
        }
        
        return "";
    }
    /**
     * @var Wishlist\CoreBundle\Entity\Notification
     */
    private $notifications;


    /**
     * Add notifications
     *
     * @param Wishlist\CoreBundle\Entity\Notification $notifications
     */
    public function addNotification(\Wishlist\CoreBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;
    }

    /**
     * Get notifications
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
    /**
     * @var Wishlist\CoreBundle\Entity\Request
     */
    private $friendsRequested;


    /**
     * Add friendsRequested
     *
     * @param Wishlist\CoreBundle\Entity\Request $friendsRequested
     */
    public function addRequest(\Wishlist\CoreBundle\Entity\Request $friendsRequested)
    {
        $this->friendsRequested[] = $friendsRequested;
    }

    /**
     * Get friendsRequested
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFriendsRequested()
    {
        return $this->friendsRequested;
    }
}