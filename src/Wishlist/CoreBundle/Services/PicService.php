<?php

namespace Wishlist\CoreBundle\Services;

class PicService
{
    const defaultProfilePic = "/images/default_avatar.gif";
    const defaultProfileThumb = "/images/default_avatar_thumb.gif";


    function __construct()
    {
    }
    
    public static function getProfileUrl(/*int*/ $wishlistUserId)
    {
        $pic_url = "images/user/".$wishlistUserId."/profile.jpg";
        
        if(file_exists($pic_url))
        {
            return '/'.$pic_url;
        }
        
        return PicService::defaultProfilePic;
    }
    
    public static function getProfileThumb(/*int*/ $wishlistUserId)
    {
        $pic_url = "images/user/".$wishlistUserId."/profile_thumb.jpg";
        
        if(file_exists($pic_url))
        {
            return '/'.$pic_url;
        }
        
        return PicService::defaultProfileThumb;
    }
}

?>