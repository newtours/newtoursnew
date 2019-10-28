<?php

namespace Drupal\reserve\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class CalendarDatePicker.
 */
class CalendarDatePicker extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'calendarDatePicker';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Retrieve an array which contains the path pieces.
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);

    $form['date'] = [
      '#type' => 'date',
      '#description' => $this->t('Click in box to select date.'),
    ];

    if (count($path_args) >= 5) {
      $date = date('Y') . '-' . $path_args[4] . '-' . $path_args[5];
      $form['date']['#default_value'] = $date;
    }
    else {
      $form['date']['#default_value'] = date('Y-m-d');
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }
  }

}
