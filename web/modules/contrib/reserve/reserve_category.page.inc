<?php

/**
 * @file
 * Contains reserve_category.page.inc.
 *
 * Page callback for reservation categories.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Reservation Category templates.
 *
 * Default template: reserve_category.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_reserve_category(array &$variables) {
  // Fetch ReserveCategory Entity Object.
  $reserve_category = $variables['elements']['#reserve_category'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
