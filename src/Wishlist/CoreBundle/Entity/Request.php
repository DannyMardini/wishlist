<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Request
 */
class Request
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $email
     */
    private $email;


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
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $UserInvited;


    /**
     * Set UserInvited
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $userInvited
     */
    public function setUserInvited(\Wishlist\CoreBundle\Entity\WishlistUser $userInvited)
    {
        $this->UserInvited = $userInvited;
    }

    /**
     * Get UserInvited
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getUserInvited()
    {
        return $this->UserInvited;
    }
}