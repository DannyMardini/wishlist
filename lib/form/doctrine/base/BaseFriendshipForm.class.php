<?php

/**
 * Friendship form base class.
 *
 * @method Friendship getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFriendshipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormTextarea(),
      'friendship_id'       => new sfWidgetFormInputHidden(),
      'wishlist_users_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'WishlistUser')),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'friendship_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('friendship_id')), 'empty_value' => $this->getObject()->get('friendship_id'), 'required' => false)),
      'wishlist_users_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'WishlistUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('friendship[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendship';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['wishlist_users_list']))
    {
      $this->setDefault('wishlist_users_list', $this->object->WishlistUsers->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveWishlistUsersList($con);

    parent::doSave($con);
  }

  public function saveWishlistUsersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['wishlist_users_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->WishlistUsers->getPrimaryKeys();
    $values = $this->getValue('wishlist_users_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('WishlistUsers', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('WishlistUsers', array_values($link));
    }
  }

}
