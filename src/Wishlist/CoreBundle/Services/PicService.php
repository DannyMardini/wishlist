<?php

namespace Wishlist\CoreBundle\Services;

class PicService
{
    const defaultProfilePic = "/images/default_avatar.gif";
    const defaultProfileThumb = "/images/default_avatar_thumb.gif";

    protected $envFolder;
    protected $kernel;

    function __construct($kernel)
    {
        $this->kernel = $kernel;
        
        if ($kernel->getEnvironment() === 'prod') {
            $this->envFolder = 'prod/';
        }
        else {
            $this->envFolder = 'dev/';
        }
    }
    
    public function getProfileUrl(/*int*/ $wishlistUserId)
    {
        $matched = glob("images/".$this->envFolder."user/".PicService::hashProfileFname($wishlistUserId).".*");
        
        if(count($matched))
        {
            return '/'.$matched[0];
        }
        
        return PicService::defaultProfilePic;
    }
    
    public function getProfileThumb(/*int*/ $wishlistUserId)
    {
        //$pic_url = "images/user/".$wishlistUserId."/profile_thumb.jpg";
        $matched = glob("images/".$this->envFolder."user/".PicService::hashProfileThumbFname($wishlistUserId).".*");
        
        if(count($matched))
        {
            return '/'.$matched[0];
        }
        
        return PicService::defaultProfileThumb;
    }
    
    public function uploadTempProfilePic(/*int*/$userId, /*string*/$ext, /*string*/$tmp)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $finalFname = strtolower('images/'.$this->envFolder.'temp/'.$hashedFname.'.'.$ext);
        if(!move_uploaded_file($tmp, $finalFname))
        {
            throw new \Exception('Upload failed');
        }
        
        return $finalFname;
    }
    
    public function tempProfilePicExists(/*int*/$userId)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/'.$this->envFolder.'temp/'.$hashedFname.'.*');
        return count($matched);
    }
    
    public function persistTempProfilePic(/*int*/$userId)
    {
        //delete old profile pic
        if(!PicService::deleteProfilePic($userId))
        {
            return false;
        }
        
        $ret = false;        
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/'.$this->envFolder.'temp/'.$hashedFname.'.*');
        if(count($matched) == 1)
        {
            $fname = basename($matched[0]);
            $ret = rename('images/'.$this->envFolder.'temp/'.$fname, 'images/'.$this->envFolder.'user/'.$fname);
            if(true == $ret) //if rename was successful.
            {
                //Create a thumbnail of the profile.
                $ret = PicService::createProfileThumb($userId, 'images/'.$this->envFolder.'user/'.$fname);
            }
        }
        
        return $ret;
    }
    
    private function deleteProfilePic($userId)
    {
        $hashedFname = PicService::hashProfileFname($userId);
        $matched = glob('images/'.$this->envFolder.'user/'.$hashedFname.'.*');
        
        foreach($matched as $match)
        {
            if(false === unlink($match))
            {
                return false;
            }
        }
        return true;
    }

    private function createProfileThumb(/*int*/$userId, $profilePic)
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
            return imagejpeg($thumbImg, 'images/'.$this->envFolder.'user/'.PicService::hashProfileThumbFname($userId).'.jpg');
        }

        return false;
    }
    
    private function hashProfileFname(/*int*/$userId)
    {
        return hash('sha1', $userId.'profile');
    }

    private function hashProfileThumbFname(/*int*/$userId)
    {
        return hash('sha1', $userId.'profile_thumb');
    }
}

?>
