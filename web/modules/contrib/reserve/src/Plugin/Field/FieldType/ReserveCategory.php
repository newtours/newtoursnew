<?php
  
namespace Drupal\reserve\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;


/**
 * Class ReserveCategory for Category selection field type
 *
 * @FieldType(
 *   id = "reserve_category",
 *   label = @Translation("Reserve Category"),
 *   description = @Translation("A selection field to assign which Reserve Category this entity is grouped under."),
 *   default_widget = "reserve_category_select",
 *   default_formatter = "reserve_category_formatter",
 *   category = @Translation("Reference"),
 *   cardinality = 1,
 * )
 * 
 */
class ReserveCategory extends FieldItemBase implements FieldItemInterface {
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'cid' => array(
          'type' => 'int',
          'not null' => TRUE,
        ),
      ),
      'indexes' => array(
        'cid' => array('cid'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('cid')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['cid'] = DataDefinition::create('integer')
      ->setLabel(t('Category'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    // get a list of all Reserve Categories
    $ids = \Drupal::entityQuery('reserve_category')->sort('name', 'ASC')->execute();
    $categories =  \Drupal\reserve\Entity\ReserveCategory::loadMultiple($ids);
    $options = array();
    foreach ($categories as $cat) {
      $options[$cat->id()] = $cat->label();
    }

    $element = [];

    $element['categories'] = [
      '#type' => 'checkboxes',
      '#title' => t('Allowed categories'),
      '#description' => t('Select which categories should be available for this bundle.'),
      '#default_value' => $this->getSetting('categories'),
      '#options' => $options,
    ];

    $element['calendar_header'] = [
      '#type' => 'textarea',
      '#title' => t('Calendar header'),
      '#description' => t('Optional header text to add above the calendar for this bundle.'),
      '#default_value' => $this->getSetting('calendar_header') ?
        $this->getSetting('calendar_header') :
        t('You may set optional header text under the field settings for the Reserve Category field for this bundle.')
    ];

    $element['reservation_instructions'] = [
      '#type' => 'textarea',
      '#title' => t('Reservation instructions'),
      '#description' => t('Optional reservation instructions to add below the calendar for this bundle.'),
      '#default_value' => $this->getSetting('reservation_instructions') ?
        $this->getSetting('reservation_instructions') :
        t('You may set optional reservation instructions under the field settings for the Reserve Category field for this bundle.')
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'categories' => [],
      'calendar_header' => null,
      'reservation_instructions' => null,
    ] + parent::defaultFieldSettings();
  }

}