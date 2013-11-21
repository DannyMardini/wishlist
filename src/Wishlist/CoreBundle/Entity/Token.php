<?php

namespace Wishlist\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist\CoreBundle\Entity\Token
 */
class Token
{
    const RESET_PASSWORD_REQUEST = 1;
    
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $token
     */
    private $token;

    /**
     * @var integer $tokenType
     */
    private $tokenType;

    /**
     * @var Wishlist\CoreBundle\Entity\WishlistUser
     */
    private $user;


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
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set tokenType
     *
     * @param integer $tokenType
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * Get tokenType
     *
     * @return integer 
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * Set user
     *
     * @param Wishlist\CoreBundle\Entity\WishlistUser $user
     */
    public function setUser(\Wishlist\CoreBundle\Entity\WishlistUser $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Wishlist\CoreBundle\Entity\WishlistUser 
     */
    public function getUser()
    {
        return $this->user;
    }
}