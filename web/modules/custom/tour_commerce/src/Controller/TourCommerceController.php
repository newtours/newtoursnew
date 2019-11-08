<?php

namespace Drupal\tour_commerce\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_price\Price;

use Drupal\tours\ToursData;


/**
 * Refer to https://docs.drupalcommerce.org/commerce2/developer-guide/products/overview/terminology
 * Class TourCommerceController.
 */
class TourCommerceController extends ControllerBase {


    protected $_productTypesDefault = [
        'default'=>[
            'label'=>'Default Tour Type Product'
        ],
        'tour'=>[
            'label'=>' Tour Type Product'
        ],
        'hotel'=>[
            'label'=>'Hotel Type Product'
        ],
        'flight'=>[
            'label'=>'Flight Type Product'
        ]
    ];

    protected $_productTypeVariationsDefault = [
        'regular_one_day',
        'regular_bus_hotel',
        'regular_flight',
        'stars_bus',
        'stars_flight',
        'stars_hotel',
        'private_bus',
        'private_flight',
        'international'
    ];

    protected $_productAttributeDefault = [
        'age_related_child_teen'=>[
            'adult',
            'child',
            'teen'
        ],
        'accomodation'=>[
            'Standart (Two person in Room)',
            'single',
            'third',
            'fourth'
        ],
        'flight_related'=>[
            'without flight',
            'with flight',
            'one way flight'
        ],

        'age_related2'=>[
            'adult1',
            'child1',
            'teen1'
        ],
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
     * Initial  method to  build all store fields
     */
    public function buildArchitecture ()
    {

        $productTypes = $this->getProductTypes();

        foreach($this->_productTypesDefault as $key=>$value) {

            if (!in_array($key,$productTypes)) {
                $this->createProductType($key);
            }
        }

        $productAttribute = $this->getProductAttributes();
        foreach($this->_productAttributeDefault as $key=>$value) {
            if (!in_array($key,$productAttribute)) {
                $this->_createProductVariationType($key,'default');
            }
        }


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
      $this->buildArchitecture();
$tour = 65;
      echo 'getProductTypes ';
        var_dump($this->getProductTypes());
      echo '<br/>';
      echo 'getProductVariations ';
        var_dump($this->getProductVariations());
      echo '<br/>';
      echo 'getProductAttributes ';
        var_dump($this->getProductAttributes());
      echo '<br/>';
      echo 'getProductVariationTypes ';
        var_dump($this->getProductTypeVariations());exit;
      $tourData = $this->toursData->getTour($tour);

      $tourNodeId = key($tourData);
      $productType = $this->_determineTourProductType($tourData[$tourNodeId]);
      $productVariationType = $this->_determineProductTypeVariation($tourData[$tourNodeId]);

      //var_dump($productVariationType);exit;
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
          $variation[] = $this->createProductVariation($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_main'],['variation_type'=>$productVariationType,'attribute'=>'general']);
          if(isset($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_child'])) {
              $variation[] = $this->createProductVariation($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_child'],['variation_type'=>$productVariationType,'attribute'=>'price_child']);
          }
          if(isset($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_flight'])) {
              $variation[] = $this->createProductVariation($tourData[$tourNodeId]['tour_prices'][$tour][0]['price_flight'],['variation_type'=>$productVariationType,'attribute'=>'price_flight']);
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
            $variation = ProductVariation::create([
                'type' => $attribute['variation_type'], // The default variation type is 'default'.
                'sku' => 'test-product-01', // The variation sku.
                'status' => 1, // The product status. 0 for disabled, 1 for enabled.
                'price' => $price,
                'attribute_price' => $attribute['attribute'], // Set the attribute_color to the value entity, can use id as well.
            ]);
            $variation->save();
        }
        return $variation;

    }

    /**
     * Create Product type (default,tour,hotel,)
     * @param $id
     */
    public function createProductType ($id)
    {
        $properties =  $this->_productTypesDefault[$id];
        $productType = \Drupal\commerce_product\Entity\ProductType::create([
            'id' => $id,
            'label' => isset($properties['label']) ? $properties['label'] :'Product Type with Price Variations',
            'status' => isset($properties['status']) ? $properties['status'] :1, // 0 for disabled, 1 for enabled
            'description' => isset($properties['description']) ? $properties['description'] : 'Default Tour Prices Variations', // Optional
            'variationType' => isset($properties['variation_type']) ? $properties['variation_type'] :'default', // The variation type we want to reference for this
            'injectVariationFields' => TRUE, // Optional - defaults to true
        ]);
        $productType->save();

// These three functions must be called to add the appropriate fields to the type
        commerce_product_add_variations_field($productType);
        commerce_product_add_stores_field($productType);
        commerce_product_add_body_field($productType);
    }


    /**
     * @param string $variationType
     */
    protected function _createProductVariationType ($variation,$variationTypeId = 'default')
    {
// Create the new variation type.
        /**
        $variationType = \Drupal\commerce_product\Entity\ProductVariationType::create([
            'status' => 1, // Status, 0 for disabled, 1 for enabled.
            'id' => $variation,
            'label' => 'Variation for ' .  $variation,
            'orderItemType' => 'default', // Order item type to reference. Default is 'default'.
            'generateTitle' => TRUE, // True to generate titles based off of attribute values.
        ]);
        $variationType->save();
*/
// The actual attribute we want to make. Super creative 'color' being used as an example.
        $id = $variation;
        $priceAttribute = \Drupal\commerce_product\Entity\ProductAttribute::create([
            'id' => $id,
            'label' => 'Attribute for '.$id,
        ]);
        $priceAttribute->save();

// The service that adds the attribute to the variation type.
        $fieldManager = \Drupal::service('commerce_product.attribute_field_manager');
        $fieldManager->createField($priceAttribute,$variationTypeId ); // $variationType->id()
        foreach($this->_productAttributeDefault[$variation] as $key=>$value) {
            $variationCreate[$variation] = $this->_createProductVarationAttribute ( $value, $id);
        }
// Making the individual attribute values for 'color'.
        //$regular = $this->_createProductVarationAttribute ( 'regular' , $id);
        //$child = $this->_createProductVarationAttribute ( 'child' ,$id);
       // $teen = $this->_createProductVarationAttribute ( 'teen' , $id);
        return $variationCreate;


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

    /** Type of Product, like tour,hotel,bus.flight
     * Get all product types
     * @return array
     */
    public function getProductTypes() {
        $productTypes = \Drupal\commerce_product\Entity\ProductType::loadMultiple();
        //var_dump(array_keys($product_types));exit;
        return array_keys($productTypes);
    }

    /**
     * Variation of Product Type. Like regular_bus, regular_bus_hotel, regular_flight etc
     * @return array
     */
    public function getProductTypeVariations ()
    {
        $productVariationTypes = \Drupal\commerce_product\Entity\ProductVariationType::loadMultiple();
        //var_dump(array_keys($product_types));exit;
        return array_keys($productVariationTypes);

    }
    public function getProductAttributes ()
    {
        $productAttribute = \Drupal\commerce_product\Entity\ProductAttribute::loadMultiple();
        //var_dump(array_keys($product_types));exit;
        return array_keys($productAttribute);

    }

    public function getProductVariations ()
    {
        $productVariations = \Drupal\commerce_product\Entity\ProductVariation::loadMultiple();
        //var_dump(array_keys($product_types));exit;
        return array_keys($productVariations);

    }



    /**
     * Need explicit assign if tour with flight, in tour_type
     * @param $tourData
     * @return string
     */
    protected function _determineTourProductType ($tourData)
    {
            return 'tour';
        //var_dump($tourData);exit;
    }

    protected function _determineProductTypeVariation ($tourData)
    {
        $tourType = $this->toursData->showTourType($tourData['tour_type']);
        $tourPrices = $tourData['tour_prices'][$tourData['tour_rowid']];
        //var_dump( $tourPrices[0]['price_tour_is_flight']);exit;
        if('1' == $tourData['tour_days'] && 1 == $tourType->field_tour_type_rowid->value) {
            return 'regular_one_day';
        }elseif('1'< $tourData['tour_days'] && 1 == $tourPrices[0]['price_tour_is_flight']) {
            return 'regular_flight';

        } elseif ('1'< $tourData['tour_days'] && 0 == $tourPrices[0]['price_tour_is_flight']) {
            return 'regular_bus_hotel'  ;
        } elseif ('1'== $tourData['tour_days'] && 8 == $tourType->field_tour_type_rowid->value) {
            return 'stars_bus'  ;
        } elseif ('1'<$tourData['tour_days'] && 8 == $tourType->field_tour_type_rowid->value && 0 == $tourPrices['price_tour_is_flight']) {
            return 'stars_hotel'  ;
        }
        //var_dump($tourData);exit;
    }
}
