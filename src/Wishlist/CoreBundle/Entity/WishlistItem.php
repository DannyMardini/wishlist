<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\WishlistItem
 */
class WishlistItem
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var integer $price
     */
    protected $price;

    /**
     * @var string $link
     */
    protected $link;

    /**
     * @var boolean $is_public
     */
    protected $is_public;

    /**
     * @var string $comment
     */
    protected $comment;

    /**
     * @var integer $quantity
     */
    protected $quantity;

    /**
     * @var integer $user_id
     */
    protected $user_id;
    
    protected $wishlistUser;


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
     * Set price
     *
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
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

    /**
     * Get wishlistUser
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getWishlistUser()
    {
        return $this->wishlistUser;
    }
    
    // TODO Need to make this function part of an interface.
    public function exportData()
    {
        $exportVars = array('id' => $this->id,
                            'name' => $this->name,
                            'price' => $this->price,
                            'link' => $this->link,
                            'comment' => $this->getComment(),
                            'quantity' => $this->quantity);
        
        return json_encode($exportVars);
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $purchaser;


    /**
     * Set purchaser
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $purchaser
     */
    public function setPurchaser(\Wishlist\CoreBundle\Entity\WishlistUser $purchaser)
    {
        $this->purchaser = $purchaser;
    }

    /**
     * Get purchaser
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getPurchaser()
    {
        return $this->purchaser;
    }
}