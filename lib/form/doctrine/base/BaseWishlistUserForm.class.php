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
      'name'            => new sfWidgetFormInputText(),
      'gender'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Enum'), 'add_empty' => true)),
      'birthdate'       => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'wishlistuser_id' => new sfWidgetFormInputHidden(),
      'password'        => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'gender'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Enum'), 'required' => false)),
      'birthdate'       => new sfValidatorPass(),
      'email'           => new sfValidatorString(array('max_length' => 255)),
      'wishlistuser_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('wishlistuser_id')), 'empty_value' => $this->getObject()->get('wishlistuser_id'), 'required' => false)),
      'password'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
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

}
