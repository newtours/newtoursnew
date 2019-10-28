<?php

namespace Drupal\reserve;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Reservation Category entity.
 *
 * @see \Drupal\reserve\Entity\ReserveCategory.
 */
class ReserveCategoryAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\reserve\Entity\ReserveCategoryInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished reservation categories');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published reservation categories');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit reservation categories');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete reservation categories');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add reservation categories');
  }

}
