<?php

namespace Wishlist\CoreBundle\Services;

class PicService
{
    function __construct()
    {
    }
    
    public function getProfileUrl(/*int*/ $wishlistUserId)
    {
        return "/images/user/".$wishlistUserId."/profile.jpg";
    }
}

?>