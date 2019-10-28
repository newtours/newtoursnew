<?php

namespace Drupal\reserve\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

module_load_include('inc', 'reserve', 'reserve.admin');

/**
* Class ReserveCategorySettingsForm.
*
* @package Drupal\reserve\Form
*
* @ingroup reserve
*/

class ReserveDefaultHoursForm extends ConfigFormBase {

  /**
    * Returns a unique string identifying the form.
    *
    * @return string
    *   The unique string identifying the form.
  */
  public function getFormId() {
    return 'ReserveDefaultHours';
  }

  /**
 * {@inheritdoc}
 */
  protected function getEditableConfigNames() {
    return [
      'reserve.default_hours',
      'reserve.monthly_hours',
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
    $default_hours = $this->config('reserve.default_hours')->get('data');

    $hours = reserve_hours();

    // Select box options.
    $options = array();
    $options['9999'] = t('Select the time');
    $options['0000'] = t('Midnight - start of day');
    foreach ($hours as $hour) {
      $time = $hour['time'];
      $display = t($hour['display']);
      if ($time != '0000') {
        $options[$time] = $display;
      }
    }
    $options['2400'] = t('Midnight - end of day');
    // Get saved default hours.
    if (!$default_hours) {
      for ($x = 0; $x < 28; $x++) {
        $default_hours[$x] = '9999';
      }
    }
    $days = array(
      t('Sunday'),
      t('Monday'),
      t('Tuesday'),
      t('Wednesday'),
      t('Thursday'),
      t('Friday'),
      t('Saturday'),
    );
    $form['#tree'] = TRUE;
    for ($day = 0; $day < 7; $day++) {
      $day_hours = array();
      $day_hours[] = $default_hours[($day * 4)];
      $day_hours[] = $default_hours[($day * 4) + 1];
      $day_hours[] = $default_hours[($day * 4) + 2];
      $day_hours[] = $default_hours[($day * 4) + 3];
      $display_hours = reserve_hours_display($day_hours);
      $form['day_' . $day] = array(
        '#type' => 'details',
        '#title' => $days[$day] . ' (' . $display_hours . ')',
        '#open' => FALSE,
        '#weight' => -90 + ($day * 10),
      );
      $form['day_' . $day]['first_shift_open_' . $day] = array(
        '#title' => t('First shift open'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $default_hours[($day * 4)],
        '#weight' => -90 + ($day * 10) + 1,
      );
      $form['day_' . $day]['first_shift_close_' . $day] = array(
        '#title' => t('First shift close'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $default_hours[($day * 4) + 1],
        '#weight' => -90 + ($day * 10) + 2,
      );
      $form['day_' . $day]['second_shift_open_' . $day] = array(
        '#title' => t('Second shift open'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $default_hours[($day * 4) + 2],
        '#weight' => -90 + ($day * 10) + 3,
      );
      $form['day_' . $day]['second_shift_close_' . $day] = array(
        '#title' => t('Second shift close'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $default_hours[($day * 4) + 3],
        '#weight' => -90 + ($day * 10) + 4,
      );
    }
    $form['save'] = array(
      '#type' => 'submit',
      '#value' => t('Save configuration'),
      '#weight' => 100,
      '#name' => 'save',
    );
    $form['reset'] = array(
      '#type' => 'submit',
      '#value' => t('Reset to defaults'),
      '#weight' => 101,
      '#name' => 'reset',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $days = array(
      t('Sunday'),
      t('Monday'),
      t('Tuesday'),
      t('Wednesday'),
      t('Thursday'),
      t('Friday'),
      t('Saturday'),
    );
    if ($form_state->getTriggeringElement()['#name'] == 'save') {
      for ($day = 0; $day < 7; $day++) {
        $open = TRUE;
        $second_shift = FALSE;
        $first_shift_open = $values['day_' . $day]['first_shift_open_' . $day];
        $first_shift_close = $values['day_' . $day]['first_shift_close_' . $day];
        $second_shift_open = $values['day_' . $day]['second_shift_open_' . $day];
        $second_shift_close = $values['day_' . $day]['second_shift_close_' . $day];
        $int_first_shift_open = intval($values['day_' . $day]['first_shift_open_' . $day]);
        $int_first_shift_close = intval($values['day_' . $day]['first_shift_close_' . $day]);
        $int_second_shift_open = intval($values['day_' . $day]['second_shift_open_' . $day]);
        $int_second_shift_close = intval($values['day_' . $day]['second_shift_close_' . $day]);
        // Closed.
        if (($int_first_shift_open == 9999) && ($int_first_shift_close == 9999) && ($int_second_shift_open == 9999) && ($int_second_shift_close == 9999)) {
          $open = FALSE;
        }
        // First shift.
        if ($open) {
          if ($int_first_shift_open == 9999) {
            $field = $form_state->getCompleteForm()['day_' . $day]['first_shift_open_' . $day];
            $message = t('%day - First shift open is required.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_first_shift_close == 9999) {
            $field = $form_state->getCompleteForm()['day_' . $day]['first_shift_close_' . $day];
            $message = t('%day - First shift close is required.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_first_shift_open >= $int_first_shift_close) {
            $field = $form_state->getCompleteForm()['day_' . $day]['first_shift_close_' . $day];
            $message = t('%day - First shift close must be later than first shift open.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
        }
        // Second shift.
        if ($open) {
          if (($int_second_shift_open != 9999) || ($int_second_shift_close != 9999)) {
            $second_shift = TRUE;
          }
        }
        if ($second_shift) {
          if (($int_first_shift_open == 9999) && ($int_first_shift_close == 9999)) {
            $field = 'day_' . $day . '][second_shift_open_' . $day;
            $field = $form_state->getCompleteForm()['day_' . $day]['second_shift_open_' . $day];
            $message = t('%day - Cannot have a second shift without a first shift.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_second_shift_open == 9999) {
            $field = $form_state->getCompleteForm()['day_' . $day]['second_shift_open_' . $day];
            $message = t('%day - Second shift open is missing.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_second_shift_close == 9999) {
            $field = $form_state->getCompleteForm()['day_' . $day]['second_shift_close_' . $day];
            $message = t('%day - Second shift close is missing.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_second_shift_open <= $int_first_shift_close) {
            $field = $form_state->getCompleteForm()['day_' . $day]['second_shift_open_' . $day];
            $message = t('%day - Second shift open must be later than first shift close.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
          elseif ($int_second_shift_open >= $int_second_shift_close) {
            $field = $form_state->getCompleteForm()['day_' . $day]['second_shift_close_' . $day];
            $message = t('%day - Second shift close must be later than second shift opten.', array('%day' => $days[$day]));
            $form_state->setError($field, $message);
          }
        }
      }
    }
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

    $default_hours = array();
    if ($form_state->getTriggeringElement()['#name'] == 'save') {
      for ($day = 0; $day < 7; $day++) {
        $default_hours[] = $values['day_' . $day]['first_shift_open_' . $day];
        $default_hours[] = $values['day_' . $day]['first_shift_close_' . $day];
        $default_hours[] = $values['day_' . $day]['second_shift_open_' . $day];
        $default_hours[] = $values['day_' . $day]['second_shift_close_' . $day];
      }
      $confirmation = t(RESERVE_SAVE_CONFIRMATION_MSG);
    }
    if ($form_state->getTriggeringElement()['#name'] == 'reset') {
      for ($day = 0; $day < 7; $day++) {
        $default_hours[] = '9999';
        $default_hours[] = '9999';
        $default_hours[] = '9999';
        $default_hours[] = '9999';
      }
      $confirmation = t(RESERVE_RESET_CONFIRMATION_MSG);
    }

    // Update monthly hours based on changes to defaults.
    $monthly_hours = \Drupal::config('reserve.monthly_hours')->get('data');
    foreach ($monthly_hours as $yyyy_mm => $mo_hours) {
      // this shouldnt be required; but just here until i figure out where monthly hours is being corrupted
      if (!is_array($mo_hours)) {
        unset($monthly_hours[$yyyy_mm]);
        continue;
      }
      $month = intval(substr($yyyy_mm, 5));
      $year = substr($yyyy_mm, 0, 4);
      // Days in the month.
      $days = date('t', mktime(0, 0, 0, $month, 1, (int) $year));
      $updated_mo_hours = array();
      for ($day = 0; $day < $days; $day++) {
        $default_ind = $mo_hours[($day * 5)];
        if ($default_ind == 'D') {
          // Update monthly hours with default day of week hours.
          // Day of the week.
          $dow = date('w', mktime(0, 0, 0, $month, $day + 1, (int) $year));
          $updated_mo_hours[($day * 5)] = 'D';
          $updated_mo_hours[($day * 5) + 1] = $default_hours[($dow * 4)];
          $updated_mo_hours[($day * 5) + 2] = $default_hours[($dow * 4) + 1];
          $updated_mo_hours[($day * 5) + 3] = $default_hours[($dow * 4) + 2];
          $updated_mo_hours[($day * 5) + 4] = $default_hours[($dow * 4) + 3];
        }
        elseif ($default_ind == 'O') {
          // Leave monthly hours unchanged.
          $updated_mo_hours[($day * 5)] = 'O';
          $updated_mo_hours[($day * 5) + 1] = $mo_hours[($day * 5) + 1];
          $updated_mo_hours[($day * 5) + 2] = $mo_hours[($day * 5) + 2];
          $updated_mo_hours[($day * 5) + 3] = $mo_hours[($day * 5) + 3];
          $updated_mo_hours[($day * 5) + 4] = $mo_hours[($day * 5) + 4];
        }
      }
      $monthly_hours[$yyyy_mm] = $updated_mo_hours;
    }

    $this->config('reserve.default_hours')
      ->set('data', $default_hours)
      ->save();
    drupal_set_message($confirmation);

    // save updated monthly override hours
    $this->config('reserve.monthly_hours')
      ->set('data', $monthly_hours)
      ->save();
    drupal_set_message(t('Daily overrides updated with new defaults.'));
  }

}
