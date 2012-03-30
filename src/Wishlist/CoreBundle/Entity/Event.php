<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Event
 */
class Event
{
    const TYPE_BIRTHDAY = 1;
    const TYPE_ANNIVERSARY = 2;
    
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $wishlistuser_id
     */
    private $wishlistuser_id;

    /**
     * @var integer $eventType
     */
    private $eventType;

    /**
     * @var datetime $eventDate
     */
    private $eventDate;


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
     * Set wishlistuser_id
     *
     * @param integer $wishlistuserId
     */
    public function setWishlistuserId($wishlistuserId)
    {
        $this->wishlistuser_id = $wishlistuserId;
    }

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
     * Set eventType
     *
     * @param integer $eventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * Get eventType
     *
     * @return integer 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set eventDate
     *
     * @param datetime $eventDate
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * Get eventDate
     *
     * @return datetime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
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
    
    public function getFormattedTimestamp($dateTimeOrig)
    {                         
        $submittedDateTime = $dateTimeOrig->getTimestamp();
        $thisYear = (date('Y') == date('Y', $submittedDateTime));
        
        if ( $thisYear > 0 )
        {                     
            $thisWeek = date('W') == date('W', $submittedDateTime);      
            if( $thisWeek > 0 )
            {
                $yesterday = date('j', $submittedDateTime) == (date('j')-1);
                $today = date('j') == date('j', $submittedDateTime);
                
                if( $yesterday > 0 )
                {
                    return " Yesterday @ ".date("g:i a", $submittedDateTime);
                }
                else if( $today > 0 )
                {
                    return "Today @".date(" g:i a", $submittedDateTime); 
                }
                else
                {
                    return date(  "l \@ g:i a", $submittedDateTime); 
                }
            }
            else
            {
                return date(  "F jS \@ g:i a", $submittedDateTime); 
            }
        }
        else
        {                        
            $seconds = time() - $submittedDateTime;
            $days = round($seconds / (24*60*60));            
            
            $yesterday = $days <= 1;
            $thisWeek = (round($days / 7)) <= 1;
               
            if($yesterday > 0)
            {
                return " yesterday @ ".date("g:i a", $submittedDateTime);
            }
            else if($thisWeek > 0)
            {
                return date(  "l \@ g:i a", $submittedDateTime);
            }
            else
            {
                return date(  "F jS, Y, g:i a", $submittedDateTime); 
            }
        }
    }    
}