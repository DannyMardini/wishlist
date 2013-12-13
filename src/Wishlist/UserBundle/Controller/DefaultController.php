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
use Wishlist\CoreBundle\Library\StoPasswordHash;


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
        $email = $session->get('email_addr');
        
        if(!$email){
            return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');            
        }

        $user = $userRepo->getUserWithEmail($email);
        
        return $this->render('WishlistUserBundle:Default:homepage.html.php', array( 'user' => $user));
    }
    
    public function showFriendpageAction()
    {
        $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');        
        $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
        $loggedInUser = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser')->find($loggedInUserId);

        if(!$loggedInUser){
            return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');            
        }        
        
        return $this->render('WishlistUserBundle:Default:friendpage.html.php', array('friends' => $userRepo->getFriendsOf($loggedInUser), 'username' => $loggedInUser->getName()));
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
        $loggedInUserId;
        
        try
        {
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            $wishlist_user = $userRepo->getUserWithId($user_id);
            $loggedIn_user = $userRepo->getUserWithId($loggedInUserId);
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId))
            {
                return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');                
            }
            else
            {
                $message = 'The system encountered an issue finding this user. Please refresh the page and try again later.';
                return $this->render('WishlistCoreBundle:Default:friendlyErrorNotification.html.php', array('message' => $message));                
            }
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
        
        if(!isset($loggedInId)){
            return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');
        }

        return $this->render('WishlistUserBundle:Default:shoppinglistPage.html.php', array('userId' => $loggedInId));
    }
    
    public function showAccountSettingsAction()
    {
        try{
            
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            
            if(!isset($loggedInUserId))
            {
                return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');
            }
            else 
            {
                // get the original user information to pre-populate the form
                $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');
                $user = $userRepo->getUserWithId($loggedInUserId);
                $name = $user->getName();
                $email = $user->getEmail();
                $birthdate = $user->getBirthdate()->format('m-d-Y');
                $gender = $user->getGender();
                $profileImage = "<img id='user_image' src='" . PicService::getProfileUrl($loggedInUserId) . "'  class='preview'>";
                
                return $this->render('WishlistUserBundle:Default:accountsettings.html.php', array('userId' => $loggedInUserId, 'name' => $name,
                    'email' => $email, 'birthdate' => $birthdate, 'gender' => $gender, 'profileImage' => $profileImage));
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
        $request = $this->getRequest();
        $response = 'The settings could not be saved, please try again later.';
        try{
            $requestRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Request');
            $updateSettings = false;
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            $slashlessImagePath = "images/temp/".$loggedInUserId;
            $foundDir = is_dir($slashlessImagePath);

            // save image to user page if user uploaded a new image
            if($foundDir) // move image to official user image and remove temp folder
            {
                // TODO
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
            
            $full_name = $request->get('fullname');
            $new_password = $request->get('new_password');
            $birthDay = $request->get('birthDay');
            $birthMonth = $request->get('birthMonth');
            $birthYear = $request->get('birthYear');
            $old_password = $request->get('old_password');
            $birthdate = \DateTime::createFromFormat('Y-m-d', $birthYear.'-'.$birthMonth.'-'.$birthDay);
            $gender = intval($this->getRequest()->get('gender'));
            
            // TO DO 
            // get the user then compare the users info to the variables above to check for changes.
            $userRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:WishlistUser');;
            
            if ($updateSettings)
            {
                $user = $userRepo->getUserWithId($loggedInUserId);
                if (strlen($full_name) > 0 && $full_name !== $user->getName()) {
                    $user->setName($full_name);
                }
                
                if(isset($gender))
                {
                    $user->setGender($gender);
                }
                
                if (isset($birthdate) && $birthdate != $user->getBirthdate())
                {
                    $user->setBirthdate($birthdate);
                }
                
                // validate that the user is older than or exactly 13
                $today = getdate();
                $day = $today["mday"];
                $month = $today["mon"];
                $year = $today["year"];
                $thirteenYearsAgo = $today["year"]-13;
                $iBirthYear = (int)$birthYear;
                $iBirthMonth = (int)$birthMonth;
                $iBirthDay = (int)$birthDay;
                $isYoungerThan13 = $iBirthYear > $thirteenYearsAgo ||
                                $iBirthYear >= $thirteenYearsAgo && $iBirthMonth > $month ||
                                $iBirthYear >= $thirteenYearsAgo && $iBirthMonth >= $month &&  $iBirthDay > $day; // $birthDay <= $day && $birthMonth <= $month && $birthYear <= $thirteenYearsAgo;
                
                if($isYoungerThan13)
                {
                    $response = "You must be 13 year or older to join Wishenda.";
                    throw new \Exception($response);
                }
                
                if (strlen($new_password) > 0 && $new_password !== $user->getPassword()) {
                    if (!StoPasswordHash::verifyPassword($old_password, $user->getPassword())) {
                        $response = "The old password was not correct. Please fix it and try again.";
                        throw new \Exception($response);
                    }
                    $user->setPassword($new_password);
                }
                
                if(PicService::tempProfilePicExists($loggedInUserId))
                {
                    if(!PicService::persistTempProfilePic($loggedInUserId))
                    {
                        throw new \Exception('Could not save new profile picture');
                    }
                }
                $this->getDoctrine()->getEntityManager()->flush();
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
        $request = $this->getRequest();
        try{
            $response = 'Image cannot be shown';
            $loggedInUserId = $request->getSession()->get('user_id');
            $slashlessPath = "images/temp/".$loggedInUserId;
            
            // continue on to save the image in the user directory
            $valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
            
            if($request->getMethod() === 'POST')
            {
                $name = $_FILES['photoimg']['name'];
                $size = $_FILES['photoimg']['size'];
			
                if(strlen($name))
                {
                    $txt = substr($name, 0, strrpos($name, "."));
                    $ext = ltrim(strrchr($name, "."), ".");
                    if(in_array(strtolower($ext),$valid_formats))
                    {
                        if($size<(1024*1024))
                        {                  
                            $tmp = $_FILES['photoimg']['tmp_name'];
                            
                            $image_loc = PicService::uploadTempProfilePic($loggedInUserId, $ext, $tmp);
                            
                            $response = "<img id='user_image' src='/".$image_loc."'  class='preview'>";
                        }
                    }
                }
            }    
        }
        catch(Exception $e){
            return new Response("An issue occurred, please try again later or try a different image");
        }
        
        return new Response($response);
    }

    public function showLifeEventsManagerAction()
    {
       try{
            $loggedInUserId = $this->getRequest()->getSession()->get('user_id');
            
            if(!isset($loggedInUserId))
            {
                return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');                
            }
            else {
                // get the original user information to pre-populate the form
                $eventRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Event');
                $events = $eventRepo->getAllUserEvents($loggedInUserId);
                
                return $this->render('WishlistUserBundle:Default:lifeEventsManager.html.php', array('events' => $events));
            }
            
        }catch(NoResultException $e)
        {
            if(!isset($loggedInUserId)){
                return $this->render('WishlistFrontpageBundle:Default:indexSuccess.html.php');                
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
           $month= $this->getRequest()->get('month');
           $day = $this->getRequest()->get('day');
           $type = $this->getRequest()->get('type');

           if(!isset($name))
           {
               throw new \Exception('Name was not given');
           }
           if(!isset($month))
           {
               throw new \Exception('Month was not given');
           }
           if(!isset($day))
           {
               throw new \Exception('Day was not given');
           }
           if(!isset($type))
           {
               throw new \Exception('Type was not even');
           }

           //2004 is my graduation date and a leap year so feb 29 would be true if someone chooses
           //Feb 29.
           if(!checkdate($month, $day, 2004))
           {
               throw new Exception('Date was not valid');
           }
           
           $userRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:WishlistUser');
           $wishlistUser = $userRepo->getUserWithId($this->getRequest()->getSession()->get('user_id'));
           
           $eventRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Event');
           $eventDate = new DateTime();
           $eventDate->setDate(2004, $month, $day);
           $newId = $eventRepo->addEvent( $name, intval($type), $eventDate, $wishlistUser);
           return new Response($newId);
        } 
        catch(\Exception $e){
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
        $error_message = null;
        $error_message_invalidkey = 'Sorry about this, the link to setup your account is no longer valid! Please try requesting another invite: <a href="http://www.wishenda.com" target="_blank" >Wishenda</a>';
        
        $acceptIdQuery = $this->getRequest()->query->get('acceptId');
        if(!isset($acceptIdQuery)) 
        {
            $error_message = $error_message_invalidkey;
        }

        $requestInvite = $requestRepo->findOneByAcceptString($acceptIdQuery);
        if(!isset($requestInvite)) 
        {
            $error_message = $error_message_invalidkey;
        }
        
        if(count($error_message) > 0)
        {
            return $this->render('WishlistCoreBundle:Default:friendlyErrorNotification.html.php', array('message' => $error_message));
        }

        return $this->render('WishlistUserBundle:Default:newAccountUser.html.php', array('email' => $requestInvite->getEmail()));
    }
    
    public function newAccountFriendAction()
    {
        return $this->newAccountUserAction();
        //This is not working right now.
        //return $this->render('WishlistUserBundle:Default:newAccountFriend.html.php');
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

    public function completePurchases()
    {
        $session = $this->getRequest()->getSession();
        $purchaseRepo = $this->getDoctrine()->getEntityManager()->getRepository('WishlistCoreBundle:Purchase');

        try
        {
            $purchaseIds = $session->get('purchaseIds');
            $purchases = $purchaseRepo->getPurchases($purchaseIds);

            $purchaseRepo->completePurchases($purchases);
        }
        catch(\Exception $e)
        {
            return new Response('failure');
        }

        return new Response('success');
    }
}
