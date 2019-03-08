<?php

namespace Drupal\tours\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\views_templates\ViewsTemplateLoaderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
require_once("libraries/vendor/autoload.php");

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

      $type_ent_ids = $this->entityTypeManager->getQuery()
            ->condition('type', 'tours')
            ->condition('status', 1)
            ->sort('field_tour_name', 'ASC')
            ->execute();

      $toursEntities =  $this->entityTypeManager->loadMultiple($type_ent_ids);


      foreach ($toursEntities as $key=>$value) {

          $this->tourList[$key] = strip_tags($value->field_tour_name->value);  //getValue()[0]['value']); - if use language
      }
      //var_dump($this->tourList);exit;

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
    $form['tour'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Tour'),
      '#weight' => '0',
    ];
    $form['tour_name'] = [
      '#type' => 'select',
      '#title' => $this->t('Tour Name'),
      '#options' => $this->tourList,
      '#size' => 5,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
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
