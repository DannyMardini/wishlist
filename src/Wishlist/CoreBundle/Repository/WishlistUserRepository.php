<?php

namespace Wishlist\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Wishlist\CoreBundle\Entity\WishlistUser;
use \DateTime;

/**
 * WishlistUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WishlistUserRepository extends EntityRepository
{
    public function getUser($fullname)
    {
        $name = explode(" ", $fullname);
        $first = $name[0];
        $last = $name[1];
        
        return $this->findOneBy(array('firstname' => $first, 'lastname' => $last));
    }
    
    public function addUser(WishlistUser $user)
    {
        $em = $this->getEntityManager();
        
        if(!isset($user))
        {
            throw new \Exception("Error, user not defined!");
        }
        
        $em->persist($user);
        $em->flush();
    }
    
    public function addNewUser($firstname, $lastname, DateTime $birthdate, $email, $gender, $password)
    {
        $user = new WishlistUser();
        
        $user->setBirthdate($birthdate);
        $user->setEmail($email);
        $user->setGender($gender);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        
        $this->addUser($user);        
    }
    
//    public static function addWishlistUser( $email )
//    {
//        $em = $this->getEntityManager();
//        
//        $new_wishlistUser = new WishlistUser();
//        $new_wishlistUser->setEmail($email);
//        $new_wishlistUser->setName('Blanca Edmiston');
//        $new_wishlistUser->setGender(1);
//        $new_wishlistUser->setAge(50);
//        $new_wishlistUser->setPassword('iLoveBob');
//        $new_wishlistUser->save();
//    }
    
    public function validateEmailAndPassword( $email, $password )
    {
        try
        {                                                    
            $q = $this->getEntityManager()
                    ->createQuery('SELECT w FROM WishlistCoreBundle:WishlistUser w WHERE w.email = :email AND w.password = :password')
                    ->setParameter('email', $email)
                    ->setParameter('password', $password);
            
            $userQueryResults = $q->getResult();
            
            $userId = 0;
                        
            foreach ($userQueryResults as $user)
            {
                $userId = $user->getWishlistuserId();
            }        
            
            return $userId;
        }catch(Exception $e)
        {
            return 0;
        }
    }
    
    public function getUserWithEmail( /*string*/ $email )
    {
        $user = $this->findOneBy(array('email' => $email));

        if(!isset ($user))
        {
            throw new NoResultException();
        }

        return $user;
    }
    
    public function getUserWithId( /*int*/ $id )
    {
        $user = $this->findOneBy(array('wishlistuser_id' => $id));
        
        if( !isset($user) )
        {
            throw new NoResultException();
        }
        
        return $user;
    }
    
    public function getFriendsOf(WishlistUser $user)
    {
        $friendships = $user->getFriendships();
        
        foreach($friendships as $friendship)
        {
            $friends[] = $this->getUserWithId($friendship->getFriendId());
        }
        
        return $friends;
    }
}