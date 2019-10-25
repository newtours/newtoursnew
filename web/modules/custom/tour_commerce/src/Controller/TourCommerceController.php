<?php

namespace Drupal\tour_commerce\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_price\Price;

use Drupal\tours\ToursData;


/**
 * Class TourCommerceController.
 */
class TourCommerceController extends ControllerBase {


    public function __construct (ToursData $toursData)
    {
        $this->toursData = $toursData;
        $this->nodeStorage = $this->entityTypeManager()->getStorage('node');
        $this->ProductStorage = $this->entityTypeManager()->getStorage('commerce_product');
    }


    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('tours.data')
        );
    }

  /**
   * Createproduct.
   *
   * @return string
   *   Return Hello string.
   *
   * commerce_product
   */
  public function createProduct($tour = null) {

$tour = 65;
//var_dump($entity_ids);exit;
      $tourData = $this->toursData->getTour($tour);
      $tourNodeId = key($tourData);
      //var_dump($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_main']);exit;
      $nTours = count($tourData);

      $product = $this->ProductStorage
          ->loadByProperties([
              //'type' => 'commerce_product',
              'field_order_tour_tour' => $tourNodeId,
          ]);
      if (count($product) > 0 ) {
          var_dump($product);
      } else {
          // Create variation
          $variation = [
              ProductVariation::create([
              'type' => 'default',
              'sku' => 'var1',
              'price' => new Price($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_main'], 'USD'),
          ]),
          ];

          // Create product using variations previously saved
          $product = Product::create([
              'type' => 'default',
              'title' => t($tourData[$tourNodeId]['tour_name']),
              'field_order_tour_tour' => $tourNodeId,
              'variations' => $variation,
          ]);
          $product->save();
      }
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: createProduct - created tours ' . $nTours )
    ];
  }

}
