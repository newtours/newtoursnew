<?php

namespace Drupal\reserve\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining reservation categories.
 *
 * @ingroup reserve
 */
interface ReserveCategoryInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Reservation Category name.
   *
   * @return string
   *   Name of the Reservation Category.
   */
  public function getName();

  /**
   * Sets the Reservation Category name.
   *
   * @param string $name
   *   The Reservation Category name.
   *
   * @return \Drupal\reserve\Entity\ReserveCategoryInterface
   *   The called Reservation Category entity.
   */
  public function setName($name);

  /**
   * Returns the Reservation Category published status indicator.
   *
   * Unpublished Reservation Category are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Reservation Category is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Reservation Category.
   *
   * @param bool $published
   *   TRUE to set this Reservation Category to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\reserve\Entity\ReserveCategoryInterface
   *   The called Reservation Category entity.
   */
  public function setPublished($published);

}
