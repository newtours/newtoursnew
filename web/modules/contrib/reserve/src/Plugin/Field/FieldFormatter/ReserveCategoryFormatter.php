<?php

namespace Drupal\reserve\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "reserve_category_formatter",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "reserve_category"
 *   }
 * )
 */
class ReserveCategoryFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $settings = $this->getSettings();
    $summary[] = t('Displays the Reserve Category.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $category =  \Drupal\reserve\Entity\ReserveCategory::load($item->cid);
      // Render each element as markup.
      $element[$delta] = [
        '#type' => 'markup',
        '#markup' => $category->label(),
      ];
    }

    return $element;
  }

}