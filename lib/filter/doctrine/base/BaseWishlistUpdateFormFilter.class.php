<?php

/**
 * WishlistUpdate filter form base class.
 *
 * @package    wishlist
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWishlistUpdateFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'template' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'datetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('WishlistUser'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'template' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'message'  => new sfValidatorPass(array('required' => false)),
      'datetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('WishlistUser'), 'column' => 'wishlistuser_id')),
    ));

    $this->widgetSchema->setNameFormat('wishlist_update_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WishlistUpdate';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'template' => 'Number',
      'type'     => 'Number',
      'message'  => 'Text',
      'datetime' => 'Date',
      'user_id'  => 'ForeignKey',
    );
  }
}
