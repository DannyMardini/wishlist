<?php

/**
 * Event form base class.
 *
 * @method Event getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'wishlistuser_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'add_empty' => false)),
      'event_date'      => new sfWidgetFormInputText(),
      'event_type'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'wishlistuser_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'))),
      'event_date'      => new sfValidatorPass(),
      'event_type'      => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Event';
  }

}
