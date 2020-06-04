<?php
// /libraries/owl/assets/owl.carousel.css
namespace Drupal\tours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'PageTopCarouselBlock' block.
 *
 * @Block(
 *  id = "page_top_carousel_block",
 *  admin_label = @Translation("Page Top Carousel Block"),
 * )
 */
class PageTopCarouselBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
         'tour_name' => $this->t(''),
        ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
      //$config = $this->getConfiguration();
    $form['tour_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Tour Name'),
      '#description' => $this->t('Tour Main name'),
      '#default_value' => $this->configuration['tour_name'],
      '#maxlength' => 255,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['tour_name'] = $form_state->getValue('tour_name');
  }

  /**
   * {@inheritdoc}
   * /sites/default/files/images/statue_liberty2.png
   * /sites/default/files/images/newyork.png
   * /sites/default/files/images/bus2.png
   * https://placeholder.com/#How_To_Use_Our_Placeholders
   */



  public function build() {
    $build = [];
    $basePath = (base_path() == '/') ? '' : base_path();
    $defaulImageLocation = $basePath .'/sites/default/files/images/carousel';
    $topImages = [
        $defaulImageLocation.'statue_liberty2.png',
        $defaulImageLocation.'newyork.png',
        $defaulImageLocation.'bus2.png'
    ];
    $topImagesMock = [
        'http://placehold.it/350x100?text=1',
        'http://placehold.it/350x100?text=2',
        'http://placehold.it/350x100?text=3',
        'http://placehold.it/350x100?text=4',
        'http://placehold.it/350x100?text=5',
        'http://placehold.it/350x100?text=6',
        'http://placehold.it/350x100?text=7',
    ];

      $build = [
          '#theme' => 'carousels_top',
          '#image_source'=> $defaulImageLocation,
          '#images'=>$topImagesMock,
          '#attached' => [
              'library' => [
                //'tours/respTable',
                //'tours/main-carousel',
                'tours/slick-carousel',
                //'core/drupal.dialog.ajax'
              ],
              'drupalSettings' => [
              'tourData' => 'test',
              ]
            ],
          ];
    return $build;
  }

}
