<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Item
 */
class Item
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
     * @var string $name
     */
    private $name;

    /**
     * @var integer $price
     */
    private $price;

    /**
     * @var string $link
     */
    private $link;

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
    
    // TODO Need to make this function part of an interface.
    public function exportData()
    {
        $exportVars = array('id' => $this->id,
                            'name' => $this->name,
                            'price' => $this->price,
                            'link' => $this->link);
        
        return json_encode($exportVars);
    }
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistItem
     */
    private $wishlistItems;

    public function __construct()
    {
        $this->wishlistItems = new \Doctrine\Common\Collections\ArrayCollection();
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
    /**
     * @var integer $asin
     */
    private $asin;


    /**
     * Set asin
     *
     * @param integer $asin
     */
    public function setAsin($asin)
    {
        $this->asin = $asin;
    }

    /**
     * Get asin
     *
     * @return integer 
     */
    public function getAsin()
    {
        return $this->asin;
    }
}