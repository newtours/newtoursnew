<?php
// /libraries/owl/assets/owl.carousel.css
namespace Drupal\tours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'PageSlickCarouselBlock' block.
 *
 * @Block(
 *  id = "page_slick_carousel_block",
 *  admin_label = @Translation("Page Slick Carousel Block"),
 * )
 */
class PageSlickCarouselBlock extends BlockBase {


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

    $carouselData = [
      [
        'image'=>'/sites/default/files/images/carousel/delicate-arch-3-1391955.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],
      [
        'image'=>'/sites/default/files/images/carousel/a-visit-at-the-aiguebelle-s-pa-1408858.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],      [
        'image'=>'/sites/default/files/images/carousel/boston-at-night-1447123.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],      [
        'image'=>'/sites/default/files/images/carousel/delicate-arch-3-1391955.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],      [
        'image'=>'/sites/default/files/images/carousel/canada-1368175.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],      [
        'image'=>'/sites/default/files/images/carousel/mexico-1-1525628.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],      [
        'image'=>'/sites/default/files/images/carousel/medieval-town-1544765.jpg',
        'title'=>'Калифорния',
        'text'=>'Фирменный Маршрут NEW TOURS на протяжении 30 ЛЕТ!',
        'button'=>[
          'link'=>'/regular/california',
          'text'=>' Смотреть все туры'
        ],
        'active'=>true,
      ],
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
          //'#images'=>$topImagesMock,
          '#tours_data'=>$carouselData,
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
