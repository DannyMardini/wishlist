<?php

/**
 * WishlistUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WishlistUserTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object WishlistUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('WishlistUser');
    }
    
    public static function addNewUser( $email )
    {
       $new_user = new WishlistUser();
       $new_user->setEmail($email);
       $new_user->setName("puchito");
       $new_user->setAge(23);
       $new_user->save();
    }
}