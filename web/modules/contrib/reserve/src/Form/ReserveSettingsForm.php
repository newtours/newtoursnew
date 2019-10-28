<?php

namespace Drupal\reserve\Form;

use Drupal\Core\Form\ConfigFormBase;
//use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Class ReserveCategorySettingsForm.
*
* @package Drupal\reserve\Form
*
* @ingroup reserve
*/

class ReserveSettingsForm extends ConfigFormBase {

    /**
    * Returns a unique string identifying the form.
    *
    * @return string
    *   The unique string identifying the form.
    */
  public function getFormId() {
    return 'ReserveSettings';
  }

  /**
 * {@inheritdoc}
 */
  protected function getEditableConfigNames() {
    return [
      'reserve.settings',
    ];
  }

  /**
   * Defines the settings form for reservation categories.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('reserve.settings');
    $form['header']['#markup'] = 'Settings form for general Reserve settings. @TODO - make Category based';

    $options = array(
      '30' => '30',
      '60' => '60',
      '90' => '90',
      '120' => '120',
      '150' => '150',
      '180' => '180',
      '210' => '210',
      '240' => '240',
      '270' => '270',
      '300' => '300',
    );

    $form['reservations_per_user'] = array(
      '#title' => t('Open reservations per user'),
      '#type' => 'textfield',
      '#maxlength' => 2,
      '#size' => 2,
      '#description' => t('The maximum number of reservations that one particular user can have open at any time. Default is 4. Enter 0 to indicate
        no limit.'),
      '#default_value' => $config->get('reservations_per_user') ? $config->get('reservations_per_user') : 4,
    );

    $form['reservations_per_day'] = array(
      '#title' => t('Reservations per day'),
      '#type' => 'textfield',
      '#maxlength' => 2,
      '#size' => 2,
      '#description' => t('The maximum number of reservations that one user can make for a single day. Default is 1. Enter 0 to indicate
        no limit.'),
      '#default_value' => $config->get('reservations_per_day') ? $config->get('reservations_per_day') : 1,
    );

    $form['reservation_max_length_standard'] = array(
      '#title' => t('Maximum reservation length (standard)'),
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $config->get('reservation_max_length_standard') ? $config->get('reservation_max_length_standard') : 120,
      '#description' => t('The maximum amount of time (in minutes) which a reservation can be made by a user with "Create new reservations (extended)" 
        privilege. Default is 120.'),
    );

    $form['reservation_max_length_extended'] = array(
      '#title' => t('Maximum reservation length (extended)'),
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $config->get('reservation_max_length_extended') ? $config->get('reservation_max_length_extended') : 120,
      '#description' => t('The maximum amount of time (in minutes) which a reservation can be made by a user with "Create new reservations (extended)" 
        privilege. Default is 120.'),
    );

    // @todo what is this for?
    $form['reservation_end_early'] = array(
      '#title' => t('End reservations 15 minutes before closing time.'),
      '#type' => 'checkbox',
      '#return_value' => 1,
      '#default_value' => $config->get('reservation_end_early') ? $config->get('reservation_end_early') : 0,
      '#description' => t('All reservations end 15 minutes before closing time.'),
    );

    $form['show_before_after_hours'] = array(
      '#title' => t('Time to show on calendar before/after open slots'),
      '#type' => 'select',
      '#options' => array(0 => '0 hours', 1 => t('1 hour'), 2 => t('2 hours'), '3' => t('All day')),
      '#default_value' => $config->get('show_before_after_hours') ? $config->get('advanced_booking_admin') : 3,
      '#description' => t('The number of hours before the first and last open slots for the day that are shown on the calendar. The default is to display the entire day.'),
    );

    // @todo decide if worth porting this to D8
    $form['calendar_flipped'] = array(
      '#title' => t('Flip orientation of calendar display.'),
      '#type' => 'checkbox',
      '#return_value' => 1,
      '#default_value' => $config->get('calendar_flipped') ? $config->get('calendar_flipped') : 0,
      '#description' => t('The default orientation of the calendar display has rooms listed along the top and hours along the left side. Selecting this checkbox will
      flip this to display hours along the top and the rooms listed along the left side. This can be useful for categories with a very large number of rooms. NOTE:
      custom CSS will most likely be required to allow all the hour slots to fit the width of your theme.'),
    );

    $form['calendar_compressed_labels'] = array(
      '#title' => t('Use smaller labels on calendar display.'),
      '#type' => 'checkbox',
      '#return_value' => 1,
      '#default_value' => $config->get('calendar_compressed_labels') ? $config->get('calendar_compressed_labels') : 0,
      '#description' => t('The default display shows the reserve entity title on both sides of the calendar display. Selecting this option shows only the room title on one side.'),
    );

    $form['date_displays'] = array(
      '#type' => 'details',
      '#title' => t('Date and time display formats'),
      '#open' => FALSE,
    );

    $form['date_displays']['date_format'] = array(
      '#type' => 'textfield',
      '#title' => t('Date format for the popup date picker to select calendar date.'),
      '#description' => t('Enter format in the form "y/m/d", "m/d/y", etc.'),
      '#default_value' => $config->get('date_format') ? $config->get('date_format') : 'y/m/d',
    );

    $form['date_displays']['hour_format'] = array(
      '#type' => 'radios',
      '#title' => t('Hour format for the calendar display.'),
      '#description' => t('Select either 2:00 PM or 14:00 display format.'),
      '#default_value' => $config->get('hour_format') ? $config->get('hour_format') : 0,
      '#options' => array(0 => '1:00 PM', 1 => '13:00'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      if (stristr('form_', $key)) continue;
      if (is_object($values[$key])) continue;
      $this->config('reserve.settings')->set($key, $value);
    }
    $this->config('reserve.settings')->save();
    drupal_set_message(RESERVE_SAVE_CONFIRMATION_MSG);
  }

}
