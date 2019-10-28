<?php

namespace Drupal\reserve\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Class ReserveCategorySettingsForm.
*
* @package Drupal\reserve\Form
*
* @ingroup reserve
*/

class ReserveDisplayForm extends ConfigFormBase {

    /**
    * Returns a unique string identifying the form.
    *
    * @return string
    *   The unique string identifying the form.
    */
  public function getFormId() {
    return 'ReserveDisplaySettings';
  }

  /**
 * {@inheritdoc}
 */
  protected function getEditableConfigNames() {
    return [
      'reserve.display',
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
    $config = $this->config('reserve.display');
    $form['ReserveDisplay']['#markup'] = 'Settings form for text displayed throughout the Reserve UI.';

    $length_options = array(
      '30' => '30',
      '60' => '60',
      '90' => '90',
      '120' => '120',
      '150' => '150',
      '180' => '180',
      '240' => '240',
      '360' => '360',
      '480' => '480',
      '600' => '600',
      '720' => '720',
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
    /*$values = $form_state->getValues();
    $this->config('reserve.category.hours.settings')
      ->set('calendar_title', $values['calendar_title'])
      ->set('advanced_booking_standard', $values['advanced_booking_standard'])
      ->set('advanced_booking_admin', $values['advanced_booking_admin'])
      ->save();*/
  }

}
