<?php

/**
 * Friendship filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFriendshipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormFilterInput(),
      'wishlist_users_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'WishlistUser')),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorPass(array('required' => false)),
      'wishlist_users_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'WishlistUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('friendship_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addWishlistUsersListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.UserFriendship UserFriendship')
      ->andWhereIn('UserFriendship.wishlistuser_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Friendship';
  }

  public function getFields()
  {
    return array(
      'name'                => 'Text',
      'friendship_id'       => 'Number',
      'wishlist_users_list' => 'ManyKey',
    );
  }
}
