<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Item
 */
class Item
{
    const CURRENCY_UNIT_CENT = 0;
    const CURRENCY_UNIT_DOLLAR = 1;
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
    public function setPrice($price, $unit=Item::CURRENCY_UNIT_CENT)
    {
        //Store price in cents. If the floor of the price does not equal
        //the price then it must have a decimal in it.
        if($unit === Item::CURRENCY_UNIT_CENT) {
            $this->price = floor($price);
        }
        else if($unit === Item::CURRENCY_UNIT_DOLLAR){ 
            $this->price = floor((100 * $price));
        }
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice($unit=Item::CURRENCY_UNIT_CENT)
    {
        if($unit === Item::CURRENCY_UNIT_CENT) {
            return $this->price;
        }
        else if($unit === Item::CURRENCY_UNIT_DOLLAR){ 
            return ($this->price / 100);
        }    
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
     * @var text $mediumImage
     */
    private $mediumImage;


    /**
     * Set mediumImage
     *
     * @param text $mediumImage
     */
    public function setMediumImage($mediumImage)
    {
        $this->mediumImage = $mediumImage;
    }

    /**
     * Get mediumImage
     *
     * @return text 
     */
    public function getMediumImage()
    {
        return $this->mediumImage;
    }
    /**
     * @var text $smallImage
     */
    private $smallImage;

    /**
     * @var text $LargeImage
     */
    private $LargeImage;


    /**
     * Set smallImage
     *
     * @param text $smallImage
     */
    public function setSmallImage($smallImage)
    {
        $this->smallImage = $smallImage;
    }

    /**
     * Get smallImage
     *
     * @return text 
     */
    public function getSmallImage()
    {
        return $this->smallImage;
    }

    /**
     * Set LargeImage
     *
     * @param text $largeImage
     */
    public function setLargeImage($largeImage)
    {
        $this->LargeImage = $largeImage;
    }

    /**
     * Get LargeImage
     *
     * @return text 
     */
    public function getLargeImage()
    {
        return $this->LargeImage;
    }
    /**
     * @var integer $vendorId
     */
    private $vendorId;


    /**
     * Set vendorId
     *
     * @param integer $vendorId
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    /**
     * Get vendorId
     *
     * @return integer 
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }
}