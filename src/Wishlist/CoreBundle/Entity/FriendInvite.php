<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\FriendInvite
 */
class FriendInvite
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $UserInvited;


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
    /**
     * @var string $email
     */
    private $email;


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
}