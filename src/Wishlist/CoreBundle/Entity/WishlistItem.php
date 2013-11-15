<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Item
 */
class WishlistItem
{
  
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $item
     */
    private $item;

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
     * Set item
     *
     * @param integer $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * Get item
     *
     * @return integer 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @var Wishlist\CoreBundle\Entity\Purchase
     */
    private $purchase;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $wishlistUser;


    /**
     * Set purchase
     *
     * @param Wishlist\CoreBundle\Entity\Purchase $purchase
     */
    public function setPurchase(\Wishlist\CoreBundle\Entity\Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Get purchase
     *
     * @return Wishlist\CoreBundle\Entity\Purchase 
     */
    public function getPurchase()
    {
        return $this->purchase;
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
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set is_public
     *
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->is_public = $isPublic;
    }

    /**
     * Get is_public
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->is_public;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
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
    
    // TODO Need to make this function part of an interface.
    public function exportData()
    {
        $genericItem = $this->getItem();
        $exportVars = array('id' => $this->id,
                            'name' => $genericItem->getName(),
                            'price' => $genericItem->getPrice(),
                            'link' => $genericItem->getLink(),
                            'comment' => $this->getComment(),
                            'quantity' => $this->quantity,
                            'public' => $this->getIsPublic());
        
        return json_encode($exportVars);
    }
    
    public function getPurchaser()
    {
        if($this->isPurchased())
        {
            return $this->purchase->getUser();
        }
        
        throw new Exception("Item is not purchased");
    }
    
    public function isPurchased()
    {
        if($this->purchase instanceof Purchase)
        {
            return true;
        }
        return false;
    }
    /**
     * @var boolean $is_public
     */
    private $is_public;

    /**
     * @var string $comment
     */
    private $comment;

    /**
     * @var integer $quantity
     */
    private $quantity;


    /**
     * Set comment
     *
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
    /**
     * @var boolean $is_active
     */
    private $is_active;


    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    /**
     * @var boolean $granted
     */
    private $granted;


    /**
     * Set granted
     *
     * @param boolean $granted
     */
    public function setGranted($granted)
    {
        $this->granted = $granted;
    }

    /**
     * Get granted
     *
     * @return boolean 
     */
    public function getGranted()
    {
        return $this->granted;
    }
    /**
     * @var boolean $grantedNotified
     */
    private $grantedNotified;


    /**
     * Set grantedNotified
     *
     * @param boolean $grantedNotified
     */
    public function setGrantedNotified($grantedNotified)
    {
        $this->grantedNotified = $grantedNotified;
    }

    /**
     * Get grantedNotified
     *
     * @return boolean 
     */
    public function getGrantedNotified()
    {
        return $this->grantedNotified;
    }
}