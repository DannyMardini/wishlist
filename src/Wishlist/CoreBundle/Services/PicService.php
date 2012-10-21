<?php

namespace Wishlist\CoreBundle\Services;

class PicService
{
    const default_pic = "/images/default_avatar.gif";


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
        
        return PicService::default_pic;
    }
    
    public static function getProfileThumb(/*int*/ $wishlistUserId)
    {
        $pic_url = "images/user/".$wishlistUserId."/profile_thumb.jpg";
        
        if(file_exists($pic_url))
        {
            return '/'.$pic_url;
        }
        
        return PicService::default_pic;
    }
}

?>