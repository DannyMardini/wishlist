<?php

/**
 * Friendship filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFriendshipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usera_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'userb_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'usera_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'userb_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('friendship_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendship';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'usera_id' => 'Number',
      'userb_id' => 'Number',
    );
  }
}
