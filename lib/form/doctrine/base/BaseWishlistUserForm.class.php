<?php

/**
 * WishlistUser form base class.
 *
 * @method WishlistUser getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWishlistUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormInputText(),
      'is_male'          => new sfWidgetFormInputCheckbox(),
      'age'              => new sfWidgetFormInputText(),
      'email'            => new sfWidgetFormInputText(),
      'wishlistuser_id'  => new sfWidgetFormInputHidden(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'friendships_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Friendship')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'is_male'          => new sfValidatorBoolean(array('required' => false)),
      'age'              => new sfValidatorInteger(array('required' => false)),
      'email'            => new sfValidatorString(array('max_length' => 255)),
      'wishlistuser_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('wishlistuser_id')), 'empty_value' => $this->getObject()->get('wishlistuser_id'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'friendships_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Friendship', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wishlist_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WishlistUser';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['friendships_list']))
    {
      $this->setDefault('friendships_list', $this->object->Friendships->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveFriendshipsList($con);

    parent::doSave($con);
  }

  public function saveFriendshipsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['friendships_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Friendships->getPrimaryKeys();
    $values = $this->getValue('friendships_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Friendships', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Friendships', array_values($link));
    }
  }

}
