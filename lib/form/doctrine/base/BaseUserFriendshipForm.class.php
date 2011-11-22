<?php

/**
 * UserFriendship form base class.
 *
 * @method UserFriendship getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserFriendshipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'wishlistuser_id' => new sfWidgetFormInputHidden(),
      'friendship_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'wishlistuser_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('wishlistuser_id')), 'empty_value' => $this->getObject()->get('wishlistuser_id'), 'required' => false)),
      'friendship_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('friendship_id')), 'empty_value' => $this->getObject()->get('friendship_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_friendship[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserFriendship';
  }

}
