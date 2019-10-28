<?php

namespace Drupal\reserve\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'reserve_category_select' widget.
 *
 * @FieldWidget(
 *   id = "reserve_category_select",
 *   module = "reserve",
 *   label = @Translation("Select list"),
 *   field_types = {
 *     "reserve_category"
 *   }
 * )
 */
class ReserveCategorySelect extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $cid = isset($items[$delta]->cid) ? $items[$delta]->cid : '';

    // get a list of all Reserve Categories for this bundle
    $set = $items->getSettings()['categories'];

    $ids = \Drupal::entityQuery('reserve_category')->sort('name', 'ASC')->execute();
    $categories =  \Drupal\reserve\Entity\ReserveCategory::loadMultiple($ids);
    $options = array();
    foreach ($categories as $key => $cat) {
      if (!in_array($key, $set)) continue;
      $options[$cat->id()] = $cat->label();
    }

    $element += [
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $cid,
    ];

    return array('cid' => $element);
  }

}