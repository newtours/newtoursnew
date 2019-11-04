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


    protected $_productTypesDefault = [
        'tours',
        'hotel',
        'flight'
    ];

    protected $_productTypeVariationsDefault = [
        'regular_one_day',
        'regular_bus_hotel',
        'regular_flight',
        'stars_bus',
        'stars_flight',
        'private_bus',
        'private_flight',
        'international'
    ];

    public function __construct (ToursData $toursData)
    {
        $this->toursData = $toursData;
        $this->nodeStorage = $this->entityTypeManager()->getStorage('node');
        $this->ProductStorage = $this->entityTypeManager()->getStorage('commerce_product');
        $this->ProductVariationStorage = $this->entityTypeManager()->getStorage('commerce_product_variation');
        $this->store = $store = \Drupal\commerce_store\Entity\Store::load(1);
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
   * https://www.drupal.org/project/commerce/issues/2811529
   * Createproduct.
   *
   * @return string
   *   Return Hello string.
   *
   * commerce_product
   *
   *   product is a storage of commerce_product
   *   variation is storage of commerce_product_variation
   *   price is a core/lib/Drupal/Core/Field/FieldItemList
   */
  public function createProduct($tour = null) {
      //$this->getProductTypes();exit;
$tour = 65;
//var_dump($entity_ids);exit;
      $tourData = $this->toursData->getTour($tour);

      $tourNodeId = key($tourData);
      $this->_determineTourProductType($tourData[$tourNodeId]);
      //var_dump($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_nodeid']);exit;
      $nTours = count($tourData);

      $product = $this->ProductStorage
          ->loadByProperties([
              //'type' => 'commerce_product',
              'field_order_tour_tour' => $tourNodeId,
          ]);//var_dump($product);exit;


      //var_dump($productPrice[6]);exit;
      //echo '<br/>';
      //var_dump($product);exit;
      if (count($product) > 0 ) {
          //var_dump($product[key($product)]->getVariationIds());exit;
          $productVariationIds = $product[key($product)]->getVariationIds();
          $productVariations = $this->ProductVariationStorage
              ->loadByProperties([
                  //'type' => 'commerce_product',
                  'variation_id' => $productVariationIds,
              ]);
          if (count($productVariations) > 0 ) {
              foreach ($productVariations as $key=>$value) {
                  $productPrice[$key] = [
                      'value'=> $value->get('price')->getValue()
                  ];
              }
          }
      } else {
          // Create variation
          $variation[] = $this->createProductVariation($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_main']);
          if(isset($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_child'])) {

          }

          /**
          $variation = [
              ProductVariation::create([
              'type' => 'price_main',
              'sku' => 'price_maian',
              'price' => new Price($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_main'], 'USD'),

          ]),
          ];
           */
//var_dump($variation);exit;
          // Create product using variations previously saved
          $product = Product::create([
              'type' => 'tour',
              'title' => t($tourData[$tourNodeId]['tour_name']),
              'field_order_tour_tour' => $tourNodeId,
              'variations' => $variation,
              'field_product_type_price' =>$tourData[$tourNodeId]['tour_prices'][$tour][0]['price_nodeid'],
          ]);
          $product->save();
      }
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: createProduct - created tours ' . $nTours )
    ];
  }


    public function createProductVariation ($price, $attribute = [])
    {

       // The price of the variation.
        if(0 == count($attribute)) {
            $price = new Price($price, 'USD');
            // Default variotion
            $variation = ProductVariation::create([
                'type' => 'default', // The default variation type is 'default'.
                'sku' => 'tour_price', // The variation sku.
                'status' => 1, // The product status. 0 for disabled, 1 for enabled.
                'price' => $price,
            ]);
            $variation->save();
        } else {

            // Now we make the variation like we did above, except we also have to state the attribute for color.
            $variation = \Drupal\commerce_product\Entity\ProductVariation::create([
                'type' => $attribute['variation_type'], // The default variation type is 'default'.
                'sku' => 'test-product-01', // The variation sku.
                'status' => 1, // The product status. 0 for disabled, 1 for enabled.
                'price' => $price,
                'attribute_color' => $attribute['attribute'], // Set the attribute_color to the value entity, can use id as well.
            ]);
            $variation->save();
        }
        return $variation;

    }

    public function createProductType ($id)
    {
        $productType = \Drupal\commerce_product\Entity\ProductType::create([
            'id' => $id,
            'label' => 'Product Type with Price Variations',
            'status' => 1, // 0 for disabled, 1 for enabled
            'description' => 'Tour Prices Variations', // Optional
            'variationType' => 'variation_type_with_color', // The variation type we want to reference for this
            'injectVariationFields' => TRUE, // Optional - defaults to true
        ]);
        $productType->save();

// These three functions must be called to add the appropriate fields to the type
        commerce_product_add_variations_field($productType);
        commerce_product_add_stores_field($productType);
        commerce_product_add_body_field($productType);
    }

    protected function _createProductVariationType ($variationType = 'variation_type_tour_prices')
    {
// Create the new variation type.
        $variationType = \Drupal\commerce_product\Entity\ProductVariationType::create([
            'status' => 1, // Status, 0 for disabled, 1 for enabled.
            'id' => $variationType,
            'label' => 'Variation for ' ,  $variationType,
            'orderItemType' => 'default', // Order item type to reference. Default is 'default'.
            'generateTitle' => TRUE, // True to generate titles based off of attribute values.
        ]);
        $variationType->save();

// The actual attribute we want to make. Super creative 'color' being used as an example.
        $priceAttribute = \Drupal\commerce_product\Entity\ProductAttribute::create([
            'id' => 'prices',
            'label' => 'Product Attribute Tour Prices ',
        ]);
        $priceAttribute->save();

// The service that adds the attribute to the variation type.
        $fieldManager = \Drupal::service('commerce_product.attribute_field_manager');
        $fieldManager->createField($priceAttribute, $variationType->id());

// Making the individual attribute values for 'color'.
        $regular = $this->_createProductVarationAttribute ( 'regular' , $attribute = 'prices');
        $child = $this->_createProductVarationAttribute ( 'child' , $attribute = 'prices');
        $teen = $this->_createProductVarationAttribute ( 'teen' , $attribute = 'prices');


    }


    /**
     * @param $name
     * Possible value: 'regular', 'child', 'teen'
     * @param string $attribute
     * @return \Drupal\Core\Entity\EntityInterface|string|static
     */
    protected function _createProductVarationAttribute ( $name , $attribute = 'prices')
    {

        $attribute = \Drupal\commerce_product\Entity\ProductAttributeValue::create([
            'attribute' => $attribute, // The attribute we are referencing.
            'name' => $name, // Name of the actual value.
        ]);
        $attribute->save();
        return $attribute;

    }

    /**
     * Get all product types
     * @return array
     */
    public function getProductTypes() {
        $product_types = \Drupal\commerce_product\Entity\ProductType::loadMultiple();
        //var_dump(array_keys($product_types));exit;
        return array_keys($product_types);
    }

    /**
     * Need explicit assign if tour with flight, in tour_type
     * @param $tourData
     * @return string
     */
    protected function _determineTourProductType ($tourData)
    {
        $tourType = $this->toursData->showTourType($tourData['tour_type']);
        //$tourPrices = $tourData['tour_prices'][$tourData['tour_rowid']];
        //var_dump($tourPrices);exit;
        if('1' == $tourData['tour_days'] && 1 == $tourType->field_tour_type_rowid->value) {
            return 'regular_one_day';
        }elseif('1'< $tourData['tour_days'] && 2 == $tourType->field_tour_type_rowid->value  ) {
            return 'regular_flight';

        } elseif ('1'< $tourData['tour_days'] && 1 == $tourType->field_tour_type_rowid->value) {
            return 'regular_bus_hotel'  ;
        }
        var_dump($tourData);exit;

    }
}
