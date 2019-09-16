<?php

namespace Drupal\tours\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'PageTopImageBlock' block.
 *
 * @Block(
 *  id = "page_top_image_block",
 *  admin_label = @Translation("Page Top Image Block"),
 * )
 */
class PageTopImageBlock extends BlockBase {


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
    $markUp = '<div id="top-image-block" class="top-image-block position-relative text-center">'
            . '<div class="d-inline position-absolute" id="top-image-liberty">
                <img src="https://via.placeholder.com/100x160/09f.png/fff?text=1+img" width="100" height="160" border="0" alt="Russian Tour in USA and Canada, Туры по США"   />
              </div>
            <div class="d-inline position-absolute" id="top-image-city">
                <img src="https://via.placeholder.com/795x150/09f.png/fff?text=2+img" width="795" height="150" border="0" alt = "Russian Tour in USA and Canada, Туры по США"   />
            </div>
            <div class="d-inline position-absolute" id="top-image-bus">
                <img src="https://via.placeholder.com/250x150/09f.png/fff?text=3+img" width="250" height="150" border="0" alt = "Russian Tour in USA and Canada, Туры по США"   />
            </div>'
            . '</div>';
    //$build['tours_default_block_tour_name']['#markup'] = $markUp;
                //top_image_block
      $build['tours_default_block_tour_name']['#theme'] = 'top_image_block';
    return $build;
  }

}
