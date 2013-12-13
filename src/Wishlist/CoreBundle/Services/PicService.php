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
        //$pic_url = "images/user/".$wishlistUserId."/profile_thumb.jpg";
        $matched = glob("images/user/".PicService::hashProfileThumbFname($wishlistUserId).".*");
        
        if(count($matched))
        {
            return '/'.$matched[0];
        }
        
        return PicService::defaultProfileThumb;
    }
    
    public static function uploadTempProfilePic(/*int*/$userId, /*string*/$ext, /*string*/$tmp)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $finalFname = strtolower('images/temp/'.$hashedFname.'.'.$ext);
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
        //delete old profile pic
        if(!PicService::deleteProfilePic($userId))
        {
            return false;
        }
        
        $ret = false;        
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/temp/'.$hashedFname.'.*');
        if(count($matched) == 1)
        {
            $fname = basename($matched[0]);
            $ret = rename('images/temp/'.$fname, 'images/user/'.$fname);
            if(true == $ret) //if rename was successful.
            {
                //Create a thumbnail of the profile.
                $ret = PicService::createProfileThumb($userId, 'images/user/'.$fname);
            }
        }
        
        return $ret;
    }
    
    private static function deleteProfilePic($userId)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/user/'.$hashedFname.'.*');
        
        foreach($matched as $match)
        {
            if(false === unlink($match))
            {
                return false;
            }
        }
        return true;
    }

    private static function createProfileThumb(/*int*/$userId, $profilePic)
    {
        $size = getimagesize($profilePic);
        switch($size['mime'])
        {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($profilePic);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($profilePic);
            break;
        case 'image/png':
            $image = imagecreatefrompng($profilePic);
            break;
        default:
            return false;
        }

        $thumbImg = ImageCreateTrueColor(30, 30);
        
        if(imageCopyResampled($thumbImg, $image, 0, 0, 0, 0, 30, 30, imagesx($image), imagesy($image)))
        {
            return imagejpeg($thumbImg, 'images/user/'.PicService::hashProfileThumbFname($userId).'.jpg');
        }

        return false;
    }
    
    private static function hashProfileFname(/*int*/$userId)
    {
        return hash('sha1', $userId.'profile');
    }

    private static function hashProfileThumbFname(/*int*/$userId)
    {
        return hash('sha1', $userId.'profile_thumb');
    }
}

?>
