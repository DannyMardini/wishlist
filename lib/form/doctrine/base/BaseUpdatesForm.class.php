<?php

/**
 * Updates form base class.
 *
 * @method Updates getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUpdatesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'template' => new sfWidgetFormInputText(),
      'type'     => new sfWidgetFormInputText(),
      'subject'  => new sfWidgetFormInputText(),
      'message'  => new sfWidgetFormInputText(),
      'datetime' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'template' => new sfValidatorInteger(),
      'type'     => new sfValidatorInteger(),
      'subject'  => new sfValidatorString(array('max_length' => 255)),
      'message'  => new sfValidatorString(array('max_length' => 255)),
      'datetime' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('updates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Updates';
  }

}
