<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\WishlistUpdate
 */
class WishlistUpdate
{
    /**
     * @var integer $template
     */
    private $template;

    /**
     * @var integer $type
     */
    private $type;

    /**
     * @var string $message
     */
    private $message;

    /**
     * @var datetime $datetime
     */
    private $datetime;
    
    private static $templateEnums = array(
        "TYPE_1" => 1,
        "TYPE_2" => 2,
    );
    
    private static $typeEnums = array(
        "ADD_ITEM" => 1,
        "REMOVE_ITEM" => 2,
        "ADD_FRIEND" => 3,
        "REMOVE_FRIEND" => 4
    );

    public static function templateEnums(/*string*/ $name = null)
    {
        return WishlistUpdate::$templateEnums[$name];
    }
    
    public static function typeEnums(/*string*/ $name = null)
    {
        return WishlistUpdate::$typeEnums[$name];
    }

        /**
     * Set template
     *
     * @param integer $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Get template
     *
     * @return integer 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set type
     *
     * @param integer $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set datetime
     *
     * @param datetime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * Get datetime
     *
     * @return datetime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
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
    
//    public function createAndSaveUpdate($type, $message, $datetime, $user_id)
//    {     
//        $template = "";
//        
//        switch ($type) // default templates
//        {
//            case 1: // Added Item
//              $template = 1;
//              break;
//            case 2: // Removed Item
//              $template = 1;
//              break;
//            case 3:  // Added new friend
//              $template = 2;
//              break;
//            default:
//              break;
//        }
//        
//        $this->setTemplate($template);
//        $this->setTemplate($type);
//        $this->setTemplate($message);
//        $this->setTemplate($datetime);
//        $this->setTemplate($user_id);
//        
//        $this->save();
//    }

    public function getFormattedTimestamp()
    {                         
        $submittedDateTime = $this->getDatetime()->getTimestamp();
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
    
    public function getFormattedTimestamp2()
    {
        $now = time();
        $submitted = new DateTime($this->getDateTime());
        $submittedTimeStamp = $submitted->getTimestamp();
        
        $seconds = $now - $submittedTimeStamp;
        $minutes = round($seconds / 60);
        $hours = round($minutes / 60);
        $days = round($hours / 24);
        $weeks = round($days / 7);  
        
        if( $weeks > 1) // just show the full date
        {
            return date(  "F j, Y, g:i a", $submittedTimeStamp);            
        }
        
        if( $weeks > 0 )
        {
            return $weeks." weeks ago";
            
        }else if( $days > 0 )
        {
            if($days >= 1 && $days < 2)
            {
                return " yesterday";
            }
            
            return $days." days ago";
            
        }else if( $hours > 0 )
        {
            if( $hours == 1 )
                return $hours." hour ago at ".date("g:i a", $submittedTimeStamp);
            
            return $hours." hours ago at ".date("g:i a", $submittedTimeStamp);
            
        }else if( $minutes > 0 )
        {
            return $minutes." minutes ago";
        }else
        {
            return $seconds." seconds ago";
        }
    }
}