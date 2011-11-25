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
      'id'       => new sfWidgetFormInputHidden(),
      'usera_id' => new sfWidgetFormInputText(),
      'userb_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'usera_id' => new sfValidatorInteger(),
      'userb_id' => new sfValidatorInteger(),
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

}
