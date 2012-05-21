<?php

namespace Wishlist\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Entity\Event;


class DefaultController extends Controller
{
    public function showHomepageAction()
    {
        $session = $this->getRequest()->getSession();
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $updateRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
        $eventRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Event');
        
        $email = $session->get('email_addr');
        
        if(!$email){
            throw $this->createNotFoundException ('500 Internal server error. Please go to wishlist.com and sign in.');
        }

        
        $user = $userRepo->getUserWithEmail($email);

        try {
            $friendUpdates =  $updateRepo->getFriendsUpdates($user->getWishlistuserId());
            $friendEvents = $eventRepo->getFriendsEvents($user->getWishlistuserId());
        }catch(Exception $e){
            $e->getTrace();
        }
        
        return $this->render('WishlistUserBundle:Default:homepage.html.php', array('user' => $user, 'friendUpdates' => $friendUpdates, 'friendEvents' => $friendEvents));
    }
    
    public function showFriendpageAction(/*int*/ $user_id)
    {
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        
        try{
            $wishlist_user = $userRepo->getUserWithId($user_id);
            $friends = $userRepo->getFriendsOf($wishlist_user);
        }catch(Exception $e){
            $e->getTrace();
        }
        
        $username = $wishlist_user->getFirstname()." ".$wishlist_user->getLastname();
        
        return $this->render('WishlistUserBundle:Default:friendpage.html.php', array('friends' => $friends, 'username' => $username));
    }
    
    public function showUserpageAction(/*int*/ $user_id)
    {
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        
        try
        {
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            $wishlist_user = $userRepo->getUserWithId($user_id);
            $loggedIn_user = $userRepo->getUserWithId($loggedInUserId);
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId))
                throw $this->createNotFoundException('Please to go the Frontpage to sign on');
            else
                throw $this->createNotFoundException('Could not find user');
        }
        
        if(!($loggedInUserId == $user_id) && !WishlistUser::areFriends($wishlist_user, $loggedIn_user))
        {
            throw new AccessDeniedHttpException('You cannot view this page since you are not a friend.');
        }

        return $this->render('WishlistUserBundle:Default:userpage.html.php', array('wishlist_user' => $wishlist_user, 'loggedInUserId' => $loggedInUserId));
    }
    
    public function showShoppinglistPageAction()
    {
        $loggedInId = $this->getRequest()->getSession()->get('user_id');

        return $this->render('WishlistUserBundle:Default:shoppinglistPage.html.php', array('userId' => $loggedInId));
    }
    
    public function showAccountSettingsAction()
    {
        try{
            
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            
            return $this->render('WishlistUserBundle:Default:accountsettings.html.php', array('userId' => $loggedInUserId));
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId)){
                throw $this->createNotFoundException('Please to go the Frontpage to sign on');
            }
            else {
                throw $this->createNotFoundException('Could not find user');
            }
        }        
    }
    
    public function uploadUserImageAction(){
        try{
            $response = 'Image cannot be shown';
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            $path = "images/temp/".$loggedInUserId."/";
            $slashlessPath = "images/temp/".$loggedInUserId;
            
            $foundDir = is_dir($slashlessPath);
            
            if(!$foundDir) // add the user directory before saving the temp image
            {
                mkdir($slashlessPath, 0777);
            }
            
            // continue on to save the image in the user directory
            $valid_formats = array("jpg", "png", "gif", "bmp");
            if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
            {
                $name = $_FILES['photoimg']['name'];
                $size = $_FILES['photoimg']['size'];
			
                if(strlen($name))
                {
                    list($txt, $ext) = explode(".", $name);
                    if(in_array(strtolower($ext),$valid_formats))
                    {
                        if($size<(1024*1024))
                        {                  
                            $actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
                            $actual_image_name = "profile.".$ext;
                            
                            $tmp = $_FILES['photoimg']['tmp_name'];
                            
                            if(move_uploaded_file($tmp, $path . $actual_image_name))
                            {
                                //mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");                                
                                $response = "<img src='/".$path.$actual_image_name."'  class='preview'>";
                            }
                            else
                                $response = "failed";
                        }
                    }
                }
            }    
            
           return new Response($response);
        }
        catch(Exception $e){
            return new Response("An issue occurred, please try again later or try a different image");
        }
    }
}
