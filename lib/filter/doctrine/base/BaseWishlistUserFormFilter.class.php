<?php

/**
 * WishlistUser filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWishlistUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_male'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'age'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'friendships_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Friendship')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'is_male'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'age'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email'            => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'friendships_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Friendship', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wishlist_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addFriendshipsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('UserFriendship.friendship_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'WishlistUser';
  }

  public function getFields()
  {
    return array(
      'name'             => 'Text',
      'is_male'          => 'Boolean',
      'age'              => 'Number',
      'email'            => 'Text',
      'wishlistuser_id'  => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'friendships_list' => 'ManyKey',
    );
  }
}
