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

class ReserveDailyHoursForm extends ConfigFormBase {

    /**
    * Returns a unique string identifying the form.
    *
    * @return string
    *   The unique string identifying the form.
    */
  public function getFormId() {
    return 'ReserveDailyHours';
  }

  /**
 * {@inheritdoc}
 */
  protected function getEditableConfigNames() {
    return [
      'reserve.monthly_hours',
    ];
  }

  /**
   * Form constructor for the Hours / Daily Hours configuration page.
   *
  */
  public function buildForm(array $form, FormStateInterface $form_state, $passed_month = null) {
    $cur_months = reserve_current_months();
    $selected_month = ($passed_month == 'yyyy_mm') ? date('Y_m') : $passed_month;
    $monthly_hours = $this->config('reserve.monthly_hours')->get($selected_month);

    // create a form to pick a month.
    $month_options = array();
    $first = current($cur_months);
    foreach ($cur_months as $cur_month) {
      $yyyy_mm = $cur_month['YYYY_MM'];
      $display = t($cur_month['display']);
      $month_options[$yyyy_mm] = t($cur_month['display']);
    }
    $form['select_month'] = array(
      '#type' => 'container',
      '#weight' => -2000,
    );
    $form['select_month']['month'] = array(
      '#title' => t('Month'),
      '#type' => 'select',
      '#options' => $month_options,
      '#default_value' => $selected_month,
    );
    $form['select_month']['save'] = array(
      '#type' => 'submit',
      '#value' => t('Select a month'),
      '#name' => 'select',
    );

    // Return a form to update the hours for each day of selected month.
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

    $yyyy_mm = $selected_month;
    $month = intval(substr($yyyy_mm, 5));
    $year = substr($yyyy_mm, 0, 4);
    $month_display = date('F Y', mktime(0, 0, 0, $month, 1, $year));
    // Days in the month.
    $days = date('t', mktime(0, 0, 0, $month, 1, $year));

    // if we don't have Hours set for this Month, let's use default values
    if (isset($monthly_hours)) {
      $mo_hours = $monthly_hours;
    }
    else {
      $mo_hours = reserve_default_monthly_hours($year, $month);
    }

    // From Header
    $form['#tree'] = TRUE;
    $form['month_display'] = array(
      '#prefix' => '<br /><b>',
      '#suffix' => '</b><br />',
      '#markup' => $month_display,
      '#weight' => -100,
    );
    $form['note'] = array(
      '#markup' => t('Asterisk (*) indicates that the hours have been changed from the default'),
      '#weight' => -99,
    );

    for ($day = 0; $day < $days; $day++) {
      // Day of week.
      $dow = date('l', mktime(0, 0, 0, $month, $day + 1, $year));
      $changed_hours = ($mo_hours[($day * 5)] == 'O') ? '*' : '';
      $day_hours = array();
      $day_hours[] = $mo_hours[($day * 5) + 1];
      $day_hours[] = $mo_hours[($day * 5) + 2];
      $day_hours[] = $mo_hours[($day * 5) + 3];
      $day_hours[] = $mo_hours[($day * 5) + 4];
      $display_hours = reserve_hours_display($day_hours);
      $title = ($day + 1) . ' ' . $dow . ' (' . $display_hours . ') ' . $changed_hours;
      $form['day_' . $day] = array(
        '#type' => 'details',
        '#title' => $title,
        '#open' => FALSE,
        '#weight' => -9 + ($day * 2),
      );
      $form['day_' . $day]['first_shift_open_' . $day] = array(
        '#title' => t('First shift open'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $mo_hours[($day * 5) + 1],
        //'#weight' => -9 + ($day * 2) + 1,
      );
      $form['day_' . $day]['first_shift_close_' . $day] = array(
        '#title' => t('First shift close'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $mo_hours[($day * 5) + 2],
        //'#weight' => -9 + ($day * 10) + 2,
      );
      $form['day_' . $day]['second_shift_open_' . $day] = array(
        '#title' => t('Second shift open'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $mo_hours[($day * 5) + 3],
        //'#weight' => -90 + ($day * 10) + 3,
      );
      $form['day_' . $day]['second_shift_close_' . $day] = array(
        '#title' => t('Second shift close'),
        '#type' => 'select',
        '#options' => $options,
        '#default_value' => $mo_hours[($day * 5) + 4],
        //'#weight' => -90 + ($day * 10) + 4,
      );
    }
    $form['save'] = array(
      '#type' => 'submit',
      '#value' => t('Save configuration'),
      '#weight' => 400,
      '#name' => 'save',
    );
    $form['reset'] = array(
      '#type' => 'submit',
      '#value' => t('Reset to defaults'),
      '#weight' => 401,
      '#name' => 'reset',
    );
    $form['month'] = array(
      '#type' => 'value',
      '#value' => $selected_month,
    );

    return $form;
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
    $yyyy_mm = $form_state->getUserInput()['select_month']['month'];
    $month = intval(substr($yyyy_mm, 5));
    $year = substr($yyyy_mm, 0, 4);

    if ($form_state->getTriggeringElement()['#name'] == 'select') {
      $form_state->setRedirect('reserve.settings.hours.daily', array('passed_month' => $yyyy_mm));
      return;
    }

    if ($form_state->getTriggeringElement()['#name'] == 'save') {
      // Days in the month.
      $days = date('t', mktime(0, 0, 0, $month, 1, $year));

      $updated_mo_hours = array();
      $default_hours = \Drupal::config('reserve.default_hours')->get('data');
      for ($day = 0; $day < $days; $day++) {
        // User entered hours for a single day.
        $day_first_open = $values['day_' . $day]['first_shift_open_' . $day];
        $day_first_close = $values['day_' . $day]['first_shift_close_' . $day];
        $day_second_open = $values['day_' . $day]['second_shift_open_' . $day];
        $day_second_close = $values['day_' . $day]['second_shift_close_' . $day];
        // Default hours for the day of the week.
        // Day of week.
        $dow = date('w', mktime(0, 0, 0, $month, $day + 1, $year));
        $default_first_open = $default_hours[($dow * 4) + 0];
        $default_first_close = $default_hours[($dow * 4) + 1];
        $default_second_open = $default_hours[($dow * 4) + 2];
        $default_second_close = $default_hours[($dow * 4) + 3];
        // Compare user entered hours to default for the day of the week.
        if (($day_first_open == $default_first_open) &&
          ($day_first_close == $default_first_close) &&
          ($day_second_open == $default_second_open) &&
          ($day_second_close == $default_second_close)) {
          $day_is_default = TRUE;
        }
        else {
          $day_is_default = FALSE;
        }
        // Update the monthly hours record.
        $updated_mo_hours[($day * 5)] = ($day_is_default) ? 'D' : 'O';
        $updated_mo_hours[($day * 5) + 1] = $day_first_open;
        $updated_mo_hours[($day * 5) + 2] = $day_first_close;
        $updated_mo_hours[($day * 5) + 3] = $day_second_open;
        $updated_mo_hours[($day * 5) + 4] = $day_second_close;
      }
      $confirmation = t('Daily overrides set for %month', array('%month' => date('F', mktime(0, 0, 0, $month, 10))));
    }

    if ($form_state->getTriggeringElement()['#name'] == 'reset') {
      $updated_mo_hours = reserve_default_monthly_hours($year, $month);
      $confirmation = t('Daily overrides cleared for %month', array('%month' => date('F', mktime(0, 0, 0, $month, 10))));
    }

    // save updates or defaults (reset) for this month
    $this->config('reserve.monthly_hours')
      ->set($yyyy_mm, $updated_mo_hours)
      ->save();
    drupal_set_message($confirmation);
  }
}
