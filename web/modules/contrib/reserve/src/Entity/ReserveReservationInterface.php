<?php

namespace Drupal\reserve\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining reservations.
 *
 * @ingroup reserve
 */
interface ReserveReservationInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Reservation name.
   *
   * @return string
   *   Name of the Reservation.
   */
  public function getName();

  /**
   * Sets the Reservation name.
   *
   * @param string $name
   *   The Reservation name.
   *
   * @return \Drupal\reserve\Entity\ReserveReservationInterface
   *   The called Reservation entity.
   */
  public function setName($name);

  /**
   * Gets the Reservation creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Reservation.
   */
  public function getCreatedTime();

  /**
   * Sets the Reservation creation timestamp.
   *
   * @param int $timestamp
   *   The Reservation creation timestamp.
   *
   * @return \Drupal\reserve\Entity\ReserveReservationInterface
   *   The called Reservation entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Reservation published status indicator.
   *
   * Unpublished Reservation are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Reservation is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Reservation.
   *
   * @param bool $published
   *   TRUE to set this Reservation to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\reserve\Entity\ReserveReservationInterface
   *   The called Reservation entity.
   */
  public function setPublished($published);

}
