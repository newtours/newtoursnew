<?php  

/**
*     Reservation CRUD for supporting Series
*/

use Drupal\Core\Render\Markup;

/**
 * Create REPEATING reservations
 *
 *  NOTE: first reservation has aready been saved at this point - we are just saving the others in series
 *  BUT - we do need to update the original entity with the Series ID
 *
* @param mixed $node
*/
function reserve_reserve_reservation_insert($entity) {

  // when we do a node_save below; it will hit this hook; so if this routine just did the save lets bail
  if (isset($entity->saved)){
    return;
  }

  $repeat_type = $entity->reservation_repeat_type->getString();

  // if No Repeat, do nothing
  if (!$repeat_type) {
    return;
  }

  $eid = $entity->id();
  $start =  $entity->reservation_date->getString();
  $start_yyyy_mm_dd = date('Y-m-d', strtotime($start));
  $end =  date('Y-m-d', strtotime($entity->reservation_repeat_until->getString()));
  $time = $entity->reservation_time->getString();
  $length = $entity->reservation_length->getString();
  $rid = $entity->reservable_id->getString();
  $rtype = $entity->reservable_content_type->getString();
  $ebundle = $rtype . '.' . entity_load($rtype, $rid)->bundle();
  $day = date('l', strtotime($start));
  
  $msg = '';
  switch ($repeat_type) {
    // every day until....
    case 1:
      $skip = '+1 day';
      $back = '-1 day';
      $msg = t('You have booked every day from %start until %end', array('%start' => $start_yyyy_mm_dd, '%end' => $end));
      break;
    
    // this day of the week until..
    case 2:
      $skip = '+7 day';
      $back = '-7 day';
      $msg = t('You have booked every %day from %start until %end', array('%day' => $day, '%start' => $start_yyyy_mm_dd, '%end' => $end));
      break;
  }

  // set NID as Series ID for both the primary entity and the repeat nodes
  $entity->set('reservation_series_id', $eid);

  // then lets save the original reservation with Series ID but set SAVED so we skip the update hook
  $entity->saved = true;
  $entity->save();

  // lets build the rest of the reservations in the series
  $tmp = $entity->createDuplicate();
  $date = $start;
  $failed = array();
  while (strtotime($date) <= strtotime($back, strtotime($end))) {
    $date = date('Y-m-d', strtotime($skip, strtotime($date)));
    
    // must check to see if next booking is available
    // the first one we don't check as we could not have picked it if it wasn't
    if (reserve_is_slot_free($rid, $ebundle, $date, $time, $length)) {
      $new = $tmp->createDuplicate();
      $new->set('reservation_date', $date);
      $new->saved = true;
      $new->save();
    }
    else {
      $failed[] = $date;
    }
  }

  // lets spit out some useful msgs
  // first clear the msg stating we just created the reservation entity
  drupal_get_messages('status');
  drupal_set_message(t('Your reservation series has been booked.'));
  drupal_set_message($msg);
  if (count($failed)) {
    $dates = Markup::create('<br>' . implode('<br>', $failed));
    drupal_set_message(t('The following dates were not booked due to scheduling conflicts: %dates', array('%dates' => $dates)), 'warning');
  }
}

/*
 * to handle Series edits
 *
 * this is only run on the OTHER reservations in series triggered from submitting changes to one of the
 * reservations in that series
 *
 * the changes to which ever reservation is being edited will be done in normal entity_save()
 *
 */
function reserve_reserve_reservation_update($entity) {
  // when we do a node_save below or when we insert from hook_insert above; it will hit this hook - so lets skip
  if (isset($entity->saved)){
    return;
  }

  $sid = $entity->reservation_series_id->getString();
  
  // if not part of a Series or special single only url -> do nothing
  if (!$sid || isset($_GET['single'])) {
    return;
  }
  
  // reservation details
  $start =  $entity->reservation_date->getString();
  $time = $entity->reservation_time->getString();
  $length = $entity->reservation_length->getString();
  $rid = $entity->reservable_id->getString();
  $rtype = $entity->reservable_content_type->getString();
  $ebundle = $rtype . '.' . entity_load($rtype, $rid)->bundle();
  $private = $entity->reservation_private->getString();

  // grab all reservations in this series except the one being submitted
  $ids = \Drupal::service('entity.query')
    ->get('reserve_reservation')
    ->condition('status', TRUE)
    ->condition('reservation_series_id', $sid)
    ->condition('id', $entity->id(), '!=')
    ->execute();
  $results = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->loadMultiple($ids);

  $failed = array();
  foreach ($results as $data) {
    // for now, only allow changing Title, Privacy, Length
    // first 2 are easy; but to change length we need to check if that period is available and if not delete entry from Series
    $data->set('name', $entity->getName());
    $data->set('reservation_private', $private);

    $date = date('Y-m-d', strtotime($data->reservation_date->getString()));
    if (reserve_is_slot_free($rid, $ebundle, $date, $time, $length)) {
      $data->set('reservation_length', $length);
    }
    // if slot is not available; do not update the length of this reservation
    // this is different than D7 version - in D7 we simply deleted the reservation; which seems silly.
    else {
      $failed[] = $date;
    }
    // update this reservation in our series
    $data->saved = true;
    $data->save();
  }

  // lets spit out some useful msgs
  drupal_set_message(t('Your reservation series has been modified.'));
  if (count($failed)) {
    $dates = Markup::create('<br>' . implode('<br>', $failed));
    drupal_set_message(t('NOTE: The following dates did not have their length changed due to scheduling conflicts: %dates', array('%dates' => $dates)), 'warning');
  }  
}

/**
 *
 * Handle deleting other reservations in a series (selected reservation should already be handle through entity->delete()
 *
 * @param $entity
 */
function reserve_reserve_reservation_delete($entity) {
  if($_SESSION['reserve_delete_type']) {
    _reserve_series_delete($entity);
  }
  return;
}

function _reserve_series_delete($entity) {
  $sid = $entity->get('reservation_series_id')->getString();
  // grab all reservations in this series
  $ids = \Drupal::service('entity.query')
    ->get('reserve_reservation')
    ->condition('reservation_series_id', $sid)
    ->execute();
  $results = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->loadMultiple($ids);
  foreach ($results as $result) {
    $result->delete();
  }
  $title = $entity->get('name')->getString();
  drupal_set_message(t('The reservation series @title was deleted.', array('@title' => $title)));  
}
