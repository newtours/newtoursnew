<?php

/**
 * alters for Reservation form
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Link;
use Drupal\Core\Url;

function reserve_form_reserve_reservation_form_alter(array &$form, FormStateInterface $form_state) {
  // params either passed in on url -  CREATE
  // or pulled from node - EDIT

  $_SESSION['reserve_delete_type'] = null;

  // Retrieve an array which contains the path pieces.
  $current_path = \Drupal::service('path.current')->getPath();
  $path_args = explode('/', $current_path);

  // for case of std reservation add form - this should likely be blocked; but leave for development
  if (count($path_args) <= 3) return;

  $length = 30;
  // for modal form call
  if ($path_args[2] == 'ajax') {
    $path_args = explode('/', $_GET['path'] );
    $length = 30 * $_GET['count'];
  };

  //if (user_access('administer site configuration') && isset($_GET['edit']) && $_GET['edit'] == 'standard') {
  // return;
  //}

  // EDIT
  // only allow editing: Group Name, Private, Duration (shorten or longer if available to extend)
  // also, allow Cancelling
  $edit = false;
  if ($path_args[3] == 'edit') {
    $edit = true;
    $res = $form_state->getFormObject()->getEntity();
    $rid = $res->id();
    $eid = $res->reservable_id->getString();
    $entity_type = $res->reservable_content_type->getString();
    $series_id = $res->reservation_series_id->getString();
    $d = $res->reservation_date->getString();
    $yyyymmdd = date('Y-m-d', strtotime($d));
    $t = $res->reservation_time->getString();
  }

  // CREATE NEW
  else {
    $month = $path_args[3];
    $day = $path_args[4];
    $t = $path_args[5];
    $eid = $path_args[6];
    $ebundle = $path_args[7];
    $entity_type = ebundle_split($ebundle, 'type');
    // determine if this year or next year
    $year = reserve_which_year($month, $day);
    $yyyymmdd = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
    $d = $yyyymmdd . ' 00:00:00';
  }

  $entity = entity_load($entity_type, $eid);
  $bundle = $entity->bundle();
  $date = date('l, M d, Y', strtotime($d));
  $time = reserve_display_time($t);
  $bundle_info = \Drupal::service("entity_type.bundle.info")->getAllBundleInfo();
  $bundleName = $bundle_info[$entity->getEntityTypeId()][$entity->bundle()]['label'];

  // set default Group Name as name of current user
  $form['name']['widget'][0]['value']['#default_value'] = $form['name']['widget'][0]['value']['#default_value'] ?
    $form['name']['widget'][0]['value']['#default_value'] :
    \Drupal::currentUser()->getDisplayName();

  // set values taken from URL
  $form['reservation_date']['widget'][0]['value']['#default_value'] = DrupalDateTime::createFromTimestamp(strtotime($yyyymmdd));
  $form['reservation_time']['widget'][0]['value']['#default_value'] = $t;
  $form['reservation_length']['widget']['#default_value'] = $form['reservation_length']['widget']['#default_value'] ?
    $form['reservation_length']['widget']['#default_value'] :
    $length;
  $form['reservable_id']['widget'][0]['value']['#default_value'] = $entity->id();
  $form['reservable_content_type']['widget']['#default_value'] = $entity_type;
  $form['reservation_ebundle']['widget'][0]['value']['#default_value'] = isset($form['reservation_ebundle']['widget'][0]['value']['#default_value']) ?
    $form['reservation_ebundle']['widget'][0]['value']['#default_value'] :
    $ebundle;

  if (!$GLOBALS['debug']) {
    // hide fields that have been filled from URL
    $form['reservation_date']['#access'] = false;
    $form['reservation_time']['#access'] = false;
    $form['user_id']['#access'] = false;
    $form['reservable_id']['#access'] = false;
    $form['reservable_content_type']['#access'] = false;

    // in prep for having better lockout of having slot taken by another user; let's also hide Length
    $form['reservation_length']['#access'] = false;

    // hide other fields we don't want to show
    $form['user_id']['#access'] = false;
    $form['reservation_series_id']['#access'] = false;
    $form['reservation_ebundle']['#access'] = false;
  }

  // if we are editing; let's do some extra things:
  //  - disable Repeat options
  //  - (series) add msg that we are editing a series and link to edit just that entry
  if ($edit) {
    //$bundle = $entity->getType();
    $ebundle = $entity_type . '.' . $bundle;

    // Special handling for Series reservations
    if ($series_id) {
      $modal = ['attributes' => [
        'class' => ['use-ajax'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => json_encode(['width' => 700])
      ]];
      // if we are in a Series, lets disable selectors so we can still show what type of series, but not allow changing
      $form['reservation_repeat_type']['#disabled'] = TRUE;
      $form['reservation_repeat_until']['#disabled'] = TRUE;

      if (isset($_GET['single'])) {
        $series_link = Link::fromTextAndUrl(t('Click here'), Url::fromUri('internal:/reserve_reservation/' . $rid . '/edit', $modal))->toString();
        $message = t('NOTE: you are editing a SINGLE day in a SERIES of reservations. Any changes made here will impact only the reservation  
        for this day. %link if you want to edit the entire series.', array('%link' => $series_link));
        // relabel Delete
        $form['actions']['delete']['#title'] = t('Cancel Reservation for This Day');
      }
      else {
        $single_link = Link::fromTextAndUrl('Click here', Url::fromUri('internal:/reserve_reservation/' . $rid . '/edit',
          ['query' => ['single' => 1]] + $modal))->toString();
        $message = t('NOTE: you are editing a SERIES of reservations. Any changes made here will impact all reservations in this 
        series. %link if you only want to edit this specific day in this series.', array('%link' => $single_link));
        // remove single node delete and add Delete Series button
        //unset($form['actions']['delete']);
        /*$form['actions']['delete_series'] = array(
          '#type' => 'submit',
          '#value' => t('Cancel Entire Reservation Series'),
          '#weight' => 20,
          '#submit' => array('_reserve_series_delete'),
        );*/
        $form['series'] = ['#type' => 'hidden', '#value' => true];
        $form['actions']['delete']['#title'] = t('Cancel Entire Reservation Series');

        // not sure any other way to pass info from here to delete hook
        $_SESSION['reserve_delete_type'] = 'series';
      }

      // add psuedo message for Series forms. Can't use std drupal messages as they do not work in modals
      $form['message'] = [
        '#type' => 'markup',
        '#weight' => -25,
        '#markup' => '
      <div class="messages__wrapper layout-container">
      <div role="contentinfo" aria-label="Warning message" class="messages messages--warning">' .
          $message .
          '</div></div>',
      ];
    }
    else {
      // but if not in Series, lets remove altogether
      $form['reservation_repeat_type']['#access'] = FALSE;
      $form['reservation_repeat_until']['#access'] = FALSE;
      // and if not part of a series; let's change DELETE button
      $form['actions']['delete']['#title'] = t('Cancel Reservation');
    }
  }

  // this is required to post drupal_messages as this is not in modal tpl by default
  $form['status_messages'] = [
    '#type' => 'status_messages',
    '#weight' => -50,
  ];

  $lengthDisplay = $form['reservation_length']['widget']['#options'][$length];
  $form['reservation_heading'] = [
    '#type' => 'markup',
    '#weight' => -20,
    '#markup' => '
      <h2 class="reservation-h2">' . t('Reservation booking for') . ':</h2><div><strong>' . $bundleName . ': ' . $entity->label() . '</strong></div>
      <div><strong>' . t('Date') . ': ' . $date . '</strong></div>
      <div><strong>' . t('Time') . ': ' . $time . '</strong></div>
      <div><strong>' . t('Length') . ': ' . $lengthDisplay . '</strong></div>
      <br>',
  ];

  // always redirect back to reservations calendar page
  $form['ebundle'] = ['#type' => 'hidden', '#value' => $ebundle];
  $form['month'] = ['#type' => 'hidden', '#value' => date('m', strtotime($yyyymmdd))];
  $form['day'] = ['#type' => 'hidden', '#value' => date('d', strtotime($yyyymmdd))];
  $form['actions']['submit']['#submit'][] = 'reserve_return_to_reservations_page';

  // limit valid lengths so we have no overlaps
  // this really only applies for EDIT now as we pick length in UI for CREATE
  $validlengths = reserve_valid_lengths($eid, $ebundle, $yyyymmdd, $t);
  foreach ($validlengths as $length) {
    if ($length['is_valid']) {
      $lengths[] = $length['length'];
    }
  }
  foreach ($form['reservation_length']['widget']['#options'] as $slot => &$option) {
    if (!in_array($slot, $lengths)) {
      unset($form['reservation_length']['widget']['#options'][$slot]);
    }
  }

  $form['reservation_repeat_until']['#states'] = array(
    'visible' => array(
      ':input[name="reservation_repeat_type"]' => array('!value' => '0'),
    ),
  );

  return;
}

/*
 * redirect Delete confirmation form back to Calendar
 * there should be a pass arg info to this form like we do from edit form; but until i figure that out..
 */
function reserve_form_reserve_reservation_delete_form_alter(array &$form, FormStateInterface $form_state) {
  // Retrieve an array which contains the path pieces.
  $refer_path = $_SERVER[HTTP_REFERER];
  $path_args = explode('/', $refer_path);

  $month = $path_args[6];
  $day = $path_args[7];
  $ebundle = $path_args[4];

  $year = reserve_which_year($month, $day);
  $yyyymmdd = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));

  $form['ebundle'] = ['#type' => 'hidden', '#value' => $ebundle];
  $form['month'] = ['#type' => 'hidden', '#value' => date('m', strtotime($yyyymmdd))];
  $form['day'] = ['#type' => 'hidden', '#value' => date('d', strtotime($yyyymmdd))];

  $form['actions']['submit']['#submit'][] = 'reserve_return_to_reservations_page';
}

/**
 * Custom submit handler for login form.
 */
function reserve_return_to_reservations_page($form, FormStateInterface $form_state) {
  $arguments = [
    'ebundle' => $form_state->getValue('ebundle'),
    'selected_month' => $form_state->getValue('month'),
    'selected_day' => $form_state->getValue('day'),
  ];
  $form_state->setRedirect('reserve.calendar', $arguments);
}