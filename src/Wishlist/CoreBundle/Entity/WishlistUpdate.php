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
}