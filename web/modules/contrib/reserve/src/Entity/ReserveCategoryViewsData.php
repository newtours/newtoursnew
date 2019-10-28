<?php

namespace Drupal\reserve\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for reservation categories.
 */
class ReserveCategoryViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['reserve_category']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Reservation Category'),
      'help' => $this->t('The Reservation Category ID.'),
    );

    return $data;
  }

}
