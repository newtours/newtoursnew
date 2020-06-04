<?php

namespace Drupal\tours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'PageFooterBlock' block.
 *
 * @Block(
 *  id = "page_footer_block",
 *  admin_label = @Translation("Page Footer Block"),
 * )
 */
class PageFooterBlock extends BlockBase {


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
    $defaulImageLocation = $basePath .'/sites/default/files/images/';
    $topImages = [
        $defaulImageLocation.'statue_liberty2.png',
        $defaulImageLocation.'newyork.png',
        $defaulImageLocation.'bus2.png'
    ];
    $topImagesMock = [
        'https://via.placeholder.com/100x160/09f.png/fff?text=1+img',
        'https://via.placeholder.com/795x150/09f.png/fff?text=2+img',
        'https://via.placeholder.com/250x150/09f.png/fff?text=3+img'
    ];

    //$build['tours_default_block_tour_name']['#markup'] = $markUp;
                //top_image_block
      $build = [
          '#theme' => 'page_default_footer',
          '#image_source'=> $defaulImageLocation,
          '#images'=>$topImages
          ];
    return $build;
  }

}
