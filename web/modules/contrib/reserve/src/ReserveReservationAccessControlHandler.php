<?php

namespace Drupal\reserve;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Reservation entity.
 *
 * @see \Drupal\reserve\Entity\ReserveReservation.
 */
class ReserveReservationAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\reserve\Entity\ReserveReservationInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          $access = AccessResult::allowedIfHasPermission($account, 'view unpublished reservations');
        }
        $access = AccessResult::allowedIfHasPermission($account, 'view published reservations');
        break;

      case 'update':
        $access = AccessResult::allowedIfHasPermission($account, 'edit any reservation');
        if (!$access->isAllowed() && $account->hasPermission('edit own reservation')) {
          $access = $access->orIf(AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity));
        }
        break;

      case 'delete':
        $access =  AccessResult::allowedIfHasPermission($account, 'delete any reservation');
        break;

      // Unknown operation, no opinion.
      default:
        $access = AccessResult::neutral();
    }

    return $access;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add reservations');
  }

}
