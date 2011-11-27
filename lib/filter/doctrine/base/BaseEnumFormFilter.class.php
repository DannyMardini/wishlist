<?php

/**
 * Enum filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEnumFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'  => new sfValidatorPass(array('required' => false)),
      'value' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WishlistUser'), 'column' => 'wishlistuser_id')),
    ));

    $this->widgetSchema->setNameFormat('enum_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Enum';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'name'  => 'Text',
      'value' => 'ForeignKey',
    );
  }
}
