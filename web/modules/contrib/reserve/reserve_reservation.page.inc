<?php

/**
 * @file
 * Contains reserve_reservation.page.inc.
 *
 * Page callback for reservations.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Reservation templates.
 *
 * Default template: reserve_reservation.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_reserve_reservation(array &$variables) {
  // Fetch ReserveReservation Entity Object.
  $reserve_reservation = $variables['elements']['#reserve_reservation'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
