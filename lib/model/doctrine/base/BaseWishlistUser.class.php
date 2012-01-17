<?php

/**
 * BaseWishlistUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $firstname
 * @property string $lastname
 * @property integer $gender
 * @property datetime $birthdate
 * @property string $email
 * @property integer $wishlistuser_id
 * @property string $password
 * @property Enum $Enum
 * @property Doctrine_Collection $WishlistItems
 * @property Doctrine_Collection $UserUpdates
 * @property Doctrine_Collection $UserEvents
 * 
 * @method string              getFirstname()       Returns the current record's "firstname" value
 * @method string              getLastname()        Returns the current record's "lastname" value
 * @method integer             getGender()          Returns the current record's "gender" value
 * @method datetime            getBirthdate()       Returns the current record's "birthdate" value
 * @method string              getEmail()           Returns the current record's "email" value
 * @method integer             getWishlistuserId()  Returns the current record's "wishlistuser_id" value
 * @method string              getPassword()        Returns the current record's "password" value
 * @method Enum                getEnum()            Returns the current record's "Enum" value
 * @method Doctrine_Collection getWishlistItems()   Returns the current record's "WishlistItems" collection
 * @method Doctrine_Collection getUserUpdates()     Returns the current record's "UserUpdates" collection
 * @method Doctrine_Collection getUserEvents()      Returns the current record's "UserEvents" collection
 * @method WishlistUser        setFirstname()       Sets the current record's "firstname" value
 * @method WishlistUser        setLastname()        Sets the current record's "lastname" value
 * @method WishlistUser        setGender()          Sets the current record's "gender" value
 * @method WishlistUser        setBirthdate()       Sets the current record's "birthdate" value
 * @method WishlistUser        setEmail()           Sets the current record's "email" value
 * @method WishlistUser        setWishlistuserId()  Sets the current record's "wishlistuser_id" value
 * @method WishlistUser        setPassword()        Sets the current record's "password" value
 * @method WishlistUser        setEnum()            Sets the current record's "Enum" value
 * @method WishlistUser        setWishlistItems()   Sets the current record's "WishlistItems" collection
 * @method WishlistUser        setUserUpdates()     Sets the current record's "UserUpdates" collection
 * @method WishlistUser        setUserEvents()      Sets the current record's "UserEvents" collection
 * 
 * @package    wishlist
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWishlistUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('wishlist_user');
        $this->hasColumn('firstname', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => false,
             'length' => 255,
             ));
        $this->hasColumn('lastname', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => false,
             'length' => 255,
             ));
        $this->hasColumn('gender', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             'default' => 1,
             ));
        $this->hasColumn('birthdate', 'datetime', null, array(
             'type' => 'datetime',
             'notnull' => true,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('wishlistuser_id', 'integer', null, array(
             'type' => 'integer',
             'autoincrement' => true,
             'primary' => true,
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Enum', array(
             'local' => 'gender',
             'foreign' => 'value'));

        $this->hasMany('WishlistItem as WishlistItems', array(
             'local' => 'wishlistUser_id',
             'foreign' => 'user_id'));

        $this->hasMany('wishlist_update as UserUpdates', array(
             'local' => 'wishlistUser_id',
             'foreign' => 'user_id'));

        $this->hasMany('Events as UserEvents', array(
             'local' => 'wishlistUser_id',
             'foreign' => 'wishlistuser_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}