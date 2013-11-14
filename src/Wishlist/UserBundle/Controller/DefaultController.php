<?php

namespace Wishlist\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Doctrine\ORM\NoResultException;
use Wishlist\CoreBundle\Entity\WishlistUser;
use Wishlist\CoreBundle\Services\PicService;
use Wishlist\CoreBundle\Entity\Request;
use \DateTime;


class DefaultController extends Controller
{
    // STATUS CODES -- 
    const SC_OK = 200;
    const SC_BAD_REQUEST = 400;

    // Private variables used by controller actions
    private $loggedInUserTest;
    
    public function __construct()
    {
        //$loggedInUserId = $this->getRequest()->getSession()->get('user_id');
        //$loggedInUserTest = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
    }
    
    public function wishlistAction()
    {
        $user = $this->getLoggedInUser();                
            
        if (!isset($user)){
            return new Response("No User Found", DefaultController::SC_OK);
        }
        
        $wishlistItems = $user->getWishlistItems();
        if(!isset($wishlistItems))
        {
            return new Response("No Wishes found for this User", DefaultController::SC_OK);
        }
        
        return $this->render('WishlistUserBundle:Giftbox:wishlist.html.php', array('user' => $user));
    }
    
    private function getLoggedInUserId()
    {
        return $this->getRequest()->getSession()->get('user_id');
    }
    
    private function getLoggedInUser()
    {
        $loggedInUserId = $this->getLoggedInUserId();
        return $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);
    }
    
    public function showHomepageAction()
    {
        $session = $this->getRequest()->getSession();
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $updateRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
        $eventRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Event');
        
        $email = $session->get('email_addr');
        
        if(!$email){
            return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');            
        }

        $user = $userRepo->getUserWithEmail($email);
        
        //TODO: Re-evaluate this, I'm not sure I need wishlisteItems.
        return $this->render('WishlistUserBundle:Default:homepage.html.php', array( 'user' => $user));
    }

    //TODO: These friendpage actions should really go in their own separate controller.
    public function showFriendpageAction()
    {
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        
        $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
        $loggedInUser = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);

        if($loggedInUser)
        {
            return $this->render('WishlistUserBundle:Default:friendpage.html.php', array('friends' => $userRepo->getFriendsOf($loggedInUser), 'username' => $loggedInUser->getName()));
        }

        return new Response();
    }
    
    public function friendSearchAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $friendshipRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Friendship');
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
        $user = $userRepo->getUserWithId($session->get('user_id'));
        
        //Get the search term from the request object
        $searchTerm = $request->get('searchTerm');
        
        //Search the repository for the search term.
        $friends = $friendshipRepo->searchFriends($user, $searchTerm);
        
        //Search the user repos for some new friends.
        $persons = $userRepo->searchPersons($user, $searchTerm);
        
        //Transform friends into json
        $results = "{\"friends\":[";
        
        foreach ($friends as $friend)
        {
            //$results[] = $friend->toJSON();
            $results .= $friend->toJSON().",";
        }
        
        $results = rtrim($results, ",");
        
        //Search for persons in the user database. If you were wanting to search
        //for and add your friends this is how you would do it.
        $results .= "],\"persons\":[";
        
        foreach ($persons as $person)
        {
            //TODO: Remove this check once I have replaced the sql query string.
            if(!WishlistUser::areFriends($user, $person))
            {
                $results .= $person->toJSON().",";
            }
        }
        
        $results = rtrim($results, ",");
        $results .="]}";
        
        //Return results.
        
        return new Response($results);
    }
    
    public function friendAddAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $notificationRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Notification');
        $friendshipRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Friendship');

        $loggedInUserId = $session->get('user_id');
        $newFriendId = $request->get('personId');
        
        if(is_numeric($newFriendId))
        {
            $newFriendId = intval($newFriendId);
        }
        else
        {
            throw new \Exception('New friend ID not numeric');
        }

        $loggedInUser = $userRepo->getUserWithId($loggedInUserId);
        $newFriend = $userRepo->getUserWithId($newFriendId);

        //If the complement request already exists let's just make them friends!
        $complementNotification = $notificationRepo->complementNotification($loggedInUser, $newFriendId);

        if(isset($complementNotification)) 
        {
            //add friend
            $friendshipRepo->addNewFriendship($loggedInUser, $newFriend);
            $notificationRepo->removeNotification($complementNotification);
        }
        else if(!($notificationRepo->notificationExists($loggedInUserId, $newFriendId))) //Does the request already exist?
        {
            //If not, add a new request!
            $notificationRepo->addNotification($newFriend, $loggedInUser->getWishlistuserId(), $loggedInUser->getName().' wants to be your friend.');
        }

        return new Response();
    }

    public function unfriendAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $friendRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Friendship');

        try {
            $loggedInUserId = $session->get('user_id');
            $loggedInUser = $userRepo->getUserWithId($loggedInUserId);

            $unfriendId = $request->get('userid');
            if(!$unfriendId)
            {
                return new Response('fail');
            }

            $userToUnfriend = $userRepo->getUserWithId($unfriendId);
            if(!$userToUnfriend)
            {
                return new Response('fail');
            }

            if(!WishlistUser::areFriends($loggedInUser, $userToUnfriend))
            {
                return new Response('fail');
            }

            $friendRepo->removeFriendship($loggedInUser, $userToUnfriend);
        }
        catch(Exception $e)
        {
            return new Response('fail');
        }
        
        return new Response('success');
    }
    
    public function friendInviteAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        $email = $request->get('email');

        if(!isset($email) || $email == '')
        {
            return new Response('', SC_BAD_REQUEST);
        }
        
        try {
            
            $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
            $requestRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Request');
            
            $userExists = $userRepo->findOneByEmail($email);
            if(isset($userExists))
            {
                //Can't invite a user which already exists.
                throw new Exception();
            }
            
            $userInvited = $userRepo->getUserWithId($session->get('user_id'));
            $userInvitedName = $userInvited->getName();

            $newInvite = $requestRepo->addInviteToQueue($email, $userInvited);

            $htmlbody = $this->renderView('WishlistUserBundle:Email:friendinvite.html.php', array('name' => $userInvitedName));
            $textbody = strip_tags($htmlbody).'http://wishenda.com/join';
            $message = \Swift_Message::newInstance()
                ->setSubject($userInvitedName.' doesn\'t know what to get you!')
                ->setFrom('wishthrowaway@gmail.com')
                ->setTo($newInvite->getEmail())
                ->setBody($htmlbody, 'text/html')
                ->addPart($textbody, 'text/plain');

            if (!$this->get('mailer')->send($message))
            {
                throw new Exception();
            }
        }
        catch(Exception $e)
        {
            return new Response('fail');
        }

        return new Response('success');
    }

    public function friendRequestAcceptAction(/*int*/ $notificationId)
    {
        $session = $this->getRequest()->getSession();
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $notificationRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Notification');
        $friendshipRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Friendship');
        
        $loggedInUserId = $session->get('user_id');
        $loggedInUser = $userRepo->getUserWithId($loggedInUserId);
        $notification = $notificationRepo->getNotificationWithId($notificationId);

        //Check if this notificationId belongs to this user
        if($loggedInUser == $notification->getWishlistUser())
        {
            $newFriend = $userRepo->getUserWithId($notification->getUserRequested());
            if(isset($newFriend))
            {
                $friendshipRepo->addNewFriendship($loggedInUser, $newFriend);
                $notificationRepo->removeNotification($notification);
            }
        }

        return new Response();
    }
    
    public function friendRequestIgnoreAction(/*int*/ $notificationId)
    {
        $session = $this->getRequest()->getSession();
        $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
        $notificationRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Notification');
        
        $loggedInUserId = $session->get('user_id');
        $loggedInUser = $userRepo->getUserWithId($loggedInUserId);
        $notification = $notificationRepo->getNotificationWithId($notificationId);
        
        if($loggedInUser == $notification->getWishlistUser())
        {
            $notificationRepo->removeNotification($notification);
        }

        return new Response();
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
            
            if(!isset($loggedInUserId)){
                $message = 'Please go to the frontpage to sign in.';
                return $this->render('WishlistCoreBundle:Default:friendlyErrorNotification.html.php', array('message' => $message));
            }
            else {
                // get the original user information to pre-populate the form
                $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
                $user = $userRepo->getUserWithId($loggedInUserId);
                $originalPassword = $user->getPassword();
                $name = $user->getName();
                $email = $user->getEmail();
                $gender = $user->getGender();
                $profileImage = "<img id='user_image' src='" . PicService::getProfileUrl($loggedInUserId) . "'  class='preview'>";
                
                return $this->render('WishlistUserBundle:Default:accountsettings.html.php', array('userId' => $loggedInUserId, 'name' => $name,
                    'email' => $email, 'originalPassword' => $originalPassword,
                    'gender' => $gender, 'profileImage' => $profileImage));
            }
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId)){
                throw $this->createNotFoundException('Please to go the Frontpage to sign in');
            }
            else {
                throw $this->createNotFoundException('Could not find user');
            }
        }        
    }
    
    public function saveAccountSettingsAction()
    {
        $response = 'could not save changes. please try again later.';
        try{
            //throw new \Exception($response);
            $requestRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Request');
            
            $updateSettings = false;
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            $slashlessImagePath = "images/temp/".$loggedInUserId;
            $foundDir = is_dir($slashlessImagePath);

            // save image to user page if user uploaded a new image
            if($foundDir) // move image to official user image and remove temp folder
            {
                // TO DO
            }

            if(!isset($loggedInUserId))
            {
                $updateSettings = false;
                
                $acceptIdQuery = $this->getRequest()->query->get('acceptId');
                if(!isset($acceptIdQuery))
                {
                    throw new \Exception($response);
                }

                $requestInvite = $requestRepo->findOneByAcceptString($acceptIdQuery); //Check to see if this is not found.
                if(!isset($requestInvite))
                {
                    throw new \Exception($response);
                }
                
                $email = $requestInvite->getEmail();
            }
            else
            {
                $updateSettings = true;
            }
            
            $full_name = $this->getRequest()->get('fullname');
            //$email = $this->getRequest()->get('email');
            $new_password = $this->getRequest()->get('new_password');
            $old_password = $this->getRequest()->get('old_password');
            $birthdate = \DateTime::createFromFormat('Y-m-d', '2012-10-23');
            $gender = intval($this->getRequest()->get('gender'));
            
            // TO DO 
            // get the user then compare the users info to the variables above to check for changes.
            $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');;
            
            if ($updateSettings)
            {
                $user = $userRepo->getUserWithId($loggedInUserId);
                if (strlen($full_name) > 0 && $full_name !== $user->getFullName()) {
                    $user->setFullName($full_name);
                }
                
                /* Don't allow users to update their emails just yet.
                if (strlen($email) > 0 && $email !== $user->getEmail() ) {
                    $user->setEmail($email);
                }
                */
                
                if (strlen($new_password) > 0 && $new_password !== $user->getPassword()) {
                    if ($old_password !== $user->getPassword()) {
                        $response = "Incorrect old_password";
                        throw new \Exception($response);
                    }
                    $user->setPassword($new_password);
                }
            }
            else //newUser
            {
                if (strlen($full_name) > 0 && strlen($email) > 0 && strlen($new_password) > 0) {
                    $userRepo->addNewUser($full_name, $birthdate, $email, $gender, $new_password);
                    $requestRepo->removeInvite($requestInvite);
                }
            }
        }
        catch(\Exception $e){
            return new Response($response);
        }
        
        return new Response('Success');
    }
    
    public function uploadUserImageAction()
    {
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
                                $response = "<img id='user_image' src='/".$path.$actual_image_name."'  class='preview'>";
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

    public function showLifeEventsManagerAction()
    {
       try{
            
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            
            if(!isset($loggedInUserId)){
                $message = 'Please to go the Frontpage to sign in';
                return $this->render('WishlistCoreBundle:Default:friendlyErrorNotification.html.php', array('message' => $message));                
            }
            else {
                // get the original user information to pre-populate the form
                $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
                $eventRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Event');
                $events = $eventRepo->getAllUserEvents($loggedInUserId);
                
                return $this->render('WishlistUserBundle:Default:lifeEventsManager.html.php', array('events' => $events));
            }
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId)){
                throw $this->createNotFoundException('Please to go the Frontpage to sign in');
            }
            else {
                throw $this->createNotFoundException('Could not find user');
            }
        }    
    }

    public function saveEventAction()
    {
        try {
           $name = stripslashes($this->getRequest()->get('name'));
           $time = $this->getRequest()->get('date');
           $type = $this->getRequest()->get('type');
           
           $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
           $wishlistUser = $userRepo->getUserWithId($this->getRequest()->getSession()->get('user_id'));
           
           $eventRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Event');
           $newId = $eventRepo->addEvent( $name, intval($type), new DateTime($time), $wishlistUser);
           return new Response($newId);
        } 
        catch(Exception $e){
            $message = "An issue has occurred. Contact the wishlist support for assistance. Message:".$e->getMessage();
            return new Response($message);
        }
    }
    
    public function removeEventAction()
    {
        try {
           $eventId = $this->getRequest()->get('id');
           $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
           $wishlistUser = $userRepo->getUserWithId($this->getRequest()->getSession()->get('user_id'));
           
           if($wishlistUser)
           {
                $eventRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Event');
                $saved = $eventRepo->removeEvent( $eventId );
                $response = ($saved == 'true' ? (string)$eventId : '0');
                return new Response( $response );
           }
        } 
        catch(Exception $e){
            return new Response('0');
        }
    }

    public function newAccountUserAction()
    {
        $requestRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Request');
        
        $acceptIdQuery = $this->getRequest()->query->get('acceptId');
        if(!isset($acceptIdQuery)) 
        {
            return new Response('failure', DefaultController::SC_BAD_REQUEST);
        }

        $requestInvite = $requestRepo->findOneByAcceptString($acceptIdQuery);
        if(!isset($requestInvite)) 
        {
            return new Response('failure', DefaultController::SC_BAD_REQUEST);
        }

        return $this->render('WishlistUserBundle:Default:newAccountUser.html.php', array('email' => $requestInvite->getEmail()));
    }
    
    public function newAccountFriendAction()
    {
        return $this->render('WishlistUserBundle:Default:newAccountFriend.html.php');
    }
    
    public function updatesAction()
    {
        $updateRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUpdate');
        
        $friendUpdates =  $updateRepo->getFriendsUpdates($this->getLoggedInUserId());
        
        return $this->render('WishlistListBundle:Default:updatelist.html.php', array('updates' => $friendUpdates));
    }
    
    public function uploadUserImage()
    {
        return new Response();
    }
}
