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
        $matched = glob("images/user/".PicService::hashProfileFname($wishlistUserId).".*");
        
        if(count($matched))
        {
            return '/'.$matched[0];
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
    
    public static function uploadTempProfilePic(/*int*/$userId, /*string*/$ext, /*string*/$tmp)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $finalFname = 'images/temp/'.$hashedFname.'.'.$ext;
        if(!move_uploaded_file($tmp, $finalFname))
        {
            throw new \Exception('Upload failed');
        }
        
        return $finalFname;
    }
    
    public static function tempProfilePicExists(/*int*/$userId)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/temp/'.$hashedFname.'.*');
        return count($matched);
    }
    
    public static function persistTempProfilePic(/*int*/$userId)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/temp/'.$hashedFname.'.*');
        if(count($matched) == 1)
        {
            $fname = basename($matched[0]);
            return rename('images/temp/'.$fname, 'images/user/'.$fname);
        }
        
        return false;
    }
    
    private static function hashProfileFname(/*int*/$userId)
    {
        return hash('sha1', $userId.'profile');
    }
}

?>