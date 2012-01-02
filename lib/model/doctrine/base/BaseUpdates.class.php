<?php

/**
 * BaseUpdates
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $template
 * @property integer $type
 * @property string $subject
 * @property string $message
 * @property datetime $datetime
 * @property integer $user_id
 * @property WishlistUser $WishlistUser
 * 
 * @method integer      getTemplate()     Returns the current record's "template" value
 * @method integer      getType()         Returns the current record's "type" value
 * @method string       getSubject()      Returns the current record's "subject" value
 * @method string       getMessage()      Returns the current record's "message" value
 * @method datetime     getDatetime()     Returns the current record's "datetime" value
 * @method integer      getUserId()       Returns the current record's "user_id" value
 * @method WishlistUser getWishlistUser() Returns the current record's "WishlistUser" value
 * @method Updates      setTemplate()     Sets the current record's "template" value
 * @method Updates      setType()         Sets the current record's "type" value
 * @method Updates      setSubject()      Sets the current record's "subject" value
 * @method Updates      setMessage()      Sets the current record's "message" value
 * @method Updates      setDatetime()     Sets the current record's "datetime" value
 * @method Updates      setUserId()       Sets the current record's "user_id" value
 * @method Updates      setWishlistUser() Sets the current record's "WishlistUser" value
 * 
 * @package    wishlist
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUpdates extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('updates');
        $this->hasColumn('template', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('type', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('subject', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('datetime', 'datetime', null, array(
             'type' => 'datetime',
             'notnull' => true,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('WishlistUser', array(
             'local' => 'user_id',
             'foreign' => 'wishlistUser_id',
             'onDelete' => 'CASCADE'));
    }
}