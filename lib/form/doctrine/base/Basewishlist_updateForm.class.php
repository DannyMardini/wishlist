<?php

/**
 * wishlist_update form base class.
 *
 * @method wishlist_update getObject() Returns the current form's model object
 *
 * @package    wishlist
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basewishlist_updateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'template' => new sfWidgetFormInputText(),
      'type'     => new sfWidgetFormInputText(),
      'message'  => new sfWidgetFormInputText(),
      'datetime' => new sfWidgetFormInputText(),
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'template' => new sfValidatorInteger(),
      'type'     => new sfValidatorInteger(),
      'message'  => new sfValidatorString(array('max_length' => 255)),
      'datetime' => new sfValidatorPass(),
      'user_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wishlist_update[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'wishlist_update';
  }

}
