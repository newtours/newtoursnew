<?php

namespace Drupal\tours\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\views_templates\ViewsTemplateLoaderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
//require_once("/libraries/vendor/autoload.php");

/**
 * Class DefaultOrderForm.
 */
class DefaultOrderForm extends FormBase {

  /**
   * Drupal\views_templates\ViewsTemplateLoaderInterface definition.
   *
   * @var \Drupal\views_templates\ViewsTemplateLoaderInterface
   */
  protected $viewsTemplatesLoader;
  /**
   * Constructs a new DefaultOrderForm object.
   */
  public function __construct( ViewsTemplateLoaderInterface $views_templates_loader,
                                EntityTypeManagerInterface $entity_type_manager )
  {

      $this->viewsTemplatesLoader = $views_templates_loader;
      $this->entityTypeManager = $entity_type_manager->getListBuilder('node')->getStorage();

      // Tours
      $tours_ent_ids = $this->entityTypeManager->getQuery()
            ->condition('type', 'tours')
            ->condition('status', 1)
            ->sort('field_tour_name', 'ASC')
            ->execute();

      $toursEntities =  $this->entityTypeManager->loadMultiple($tours_ent_ids);
      foreach ($toursEntities as $key=>$value) {
          $this->tourList[$key] = strip_tags($value->field_tour_name->value);  //getValue()[0]['value']); - if use language
          $this->tourListbyDirection[$key] = $value->field_tour_tour_direction->target_id;
      }
      // Just in case below
      //asort($this->tourListbyDirection);
//var_dump($this->_getTourList(72));exit;
      //var_dump();
        // Directions
      $type_ent_ids = $this->entityTypeManager->getQuery()
          ->condition('type', 'tour_direction')
          ->condition('status', 1)
          ->sort('field_direction_name', 'ASC')
          ->execute();
      $directionsEntities =  $this->entityTypeManager->loadMultiple($type_ent_ids);
      foreach ($directionsEntities as $key=>$value) {
          $this->directionsList[$key] = strip_tags($value->field_direction_name->value);  //getValue()[0]['value']); - if use language
      }

  }

  public static function create(ContainerInterface $container) {
    $view =   \Drupal\views\Views::getView('tours_list');
      $view->setDisplay('entity_reference_1');
      $view->execute();
      $view->setItemsPerPage(10);
      $view->setOffset(0);
      $view->usePager();
      //$view->serialize();
      $result = $view->result;
      foreach($result as $key=>$value) {
          $entity = $value->_entity;
          $title = $entity->get('title')->getValue()[0]['value'];
          //echo $title . '<br/>';
      }

    return new static(
        $container->get('views_templates.loader'),
        $container->get('entity_type.manager')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'default_order_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

      // Get the form values and raw input (unvalidated values).
      $values = $form_state->getValues();
      // Define a wrapper id to populate new content into.
      $ajax_wrapper = 'tour-ajax-wrapper';

    $form['tour'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Tour'),
      '#weight' => '0',
    ];

    $defaultDirectionValue = isset($values['tour_direction']) ? $values['tour_direction'] : key($this->directionsList);
    $form['tour']['tour_direction'] = [
        '#type' => 'select',
        '#empty_value' => '',
        '#empty_option' => '- Select Direction -',
        '#default_value' => $defaultDirectionValue,
        '#title' => $this->t('Direction'),
        '#options' => $this->directionsList,
        '#size' => 1,
        '#weight' => '0',
        '#ajax' => [
            'callback' => [$this,'_tourDirectionChange'],
            'event' => 'change',
            'wrapper' => 'tour-ajax-wrapper',
        ],

    ];
    $form['tour']['tour_name'] = [
        '#type' => 'select',
        '#empty_value' => '',
        '#empty_option' => '- Select Tour -',
        '#default_value' => (isset($values['tour_name']) ? $values['tour_name'] : ''),
        '#title' => $this->t('Tour'),
        '#options' => $this->_getTourList($defaultDirectionValue),
        '#prefix' => '<div id="tour-ajax-wrapper">',
        '#suffix' => '</div>',
        '#size' => 1,
        '#weight' => '0',
        '#ajax' => [
            'callback' => [$this,'_tourSelectChange'],
            'event' => 'change',
            'wrapper' => 'date-ajax-wrapper',
        ],
    ];

      // Build a wrapper for the ajax response.
      $form['tour_date_container'] = [
          '#type' => 'container',
          '#attributes' => [
              'id' => 'date-ajax-wrapper',
          ]
      ];
      // ONLY LOADED IN AJAX RESPONSE OR IF FORM STATE VALUES POPULATED.
      if (!empty($values) && !empty($values['tour_direction'])) {
          $form['tour_ajax_container']['tour_response'] = [
              '#markup' => 'The current select value is ' . $values['tour_direction'],
          ];
      }


      $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }


    public function _tourSelectChange(array $form, FormStateInterface $form_state) {
        // Return the element that will replace the wrapper (we return itself).
        //$form['tour_ajax_container']['tour_response'] =  'blabala';
        return $form['tour_ajax_container'];
    }

    public function _tourDirectionChange(array $form, FormStateInterface $form_state) {
        // Return the element that will replace the wrapper (we return itself).
        //$form['tour_ajax_container']['tour_response'] =  'blabala';
        return $form['tour']['tour_name'];
    }

    /**
     * @param $direction
     * @return array
     */
    public function _getTourList($direction)
    {
        $return = [];
        //var_dump($this->tourListbyDirection);
        foreach($this->tourListbyDirection as $key=>$value) {
            if($direction == $value) {
                $return[$key] = $this->tourList[$key];
            }

        }
        return $return;
    }

    /**
     * @param $tour
     */
    public function _getTourDates ($tour)
    {
        // Tours
        $dates_ent_ids = $this->entityTypeManager->getQuery()
            ->condition('type', 'tour_dates')
            ->condition('status', 1)
            ->condition('field_tour_date_tour',$tour)
            ->sort('field_tour_date', 'ASC')
            ->execute();

        $toursEntities =  $this->entityTypeManager->loadMultiple($dates_ent_ids);
        foreach ($toursEntities as $key=>$value) {
            $this->tourList[$key] = strip_tags($value->field_tour_name->value);  //getValue()[0]['value']); - if use language
            $this->tourListbyDirection[$key] = $value->field_tour_tour_direction->target_id;
        }
    }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
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
