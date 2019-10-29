<?php

namespace Drupal\nt_hotels\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HotelsController.
 */
class HotelsController extends ControllerBase {

  /**
   * Createhotel.
   *
   * @return string
   *   Return Hello string.
   */
  public function createHotel() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: createHotel')
    ];
  }

}
