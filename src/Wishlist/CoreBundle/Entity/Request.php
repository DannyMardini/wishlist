<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Request
 */
class Request
{
    const ACCEPT_STR_MAX_LENGTH = 10;
    
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $email
     */
    private $email;
    
    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $userInvited;


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
     * Set userInvited
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $userInvited
     */
    public function setUserInvited(\Wishlist\CoreBundle\Entity\WishlistUser $userInvited)
    {
        $this->userInvited = $userInvited;
    }

    /**
     * Get userInvited
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getUserInvited()
    {
        return $this->userInvited;
    }
    /**
     * @var string $acceptString
     */
    private $acceptString;


    /**
     * Set acceptString
     *
     * @param string $acceptString
     */
    public function setAcceptString($acceptString)
    {
        $this->acceptString = $acceptString;
    }

    /**
     * Get acceptString
     *
     * @return string 
     */
    public function getAcceptString()
    {
        return $this->acceptString;
    }
    /**
     * @var datetime $dateLastInvited
     */
    private $dateLastInvited;


    /**
     * Set dateLastInvited
     *
     * @param datetime $dateLastInvited
     */
    public function setDateLastInvited($dateLastInvited)
    {
        $this->dateLastInvited = $dateLastInvited;
    }

    /**
     * Get dateLastInvited
     *
     * @return datetime 
     */
    public function getDateLastInvited()
    {
        return $this->dateLastInvited;
    }
}