<?php

/**
 * Event filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEventFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'wishlistuser_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'add_empty' => true)),
      'event_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'event_type'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'wishlistuser_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WishlistUser'), 'column' => 'wishlistuser_id')),
      'event_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'event_type'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Event';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'wishlistuser_id' => 'ForeignKey',
      'event_date'      => 'Date',
      'event_type'      => 'Number',
    );
  }
}
