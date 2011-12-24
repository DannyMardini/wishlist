<?php

/**
 * Updates filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUpdatesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'template' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subject'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'datetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'template' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'subject'  => new sfValidatorPass(array('required' => false)),
      'message'  => new sfValidatorPass(array('required' => false)),
      'datetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('updates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Updates';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'template' => 'Number',
      'type'     => 'Number',
      'subject'  => 'Text',
      'message'  => 'Text',
      'datetime' => 'Date',
    );
  }
}
