<?php

namespace Drupal\tours;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
/**
 * Class ToursData.
 */
class ToursData implements ToursDataInterface {

  /**
   * Constructs a new ToursData object.
   */
  public function __construct( EntityTypeManagerInterface $entity_type_manager) {
      $this->nodeStorage = $entity_type_manager->getListBuilder('node')
          ->getStorage();

  }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('entity_type.manager')
        );
    }
    /**
     * @param $tour - field_tour_old_rowid
     */
  public function getFullTourData ( $tour)
  {


  }


    /**
     * @param $tour - field_tour_old_rowid
     */
  public function getTour ($tour)
  {
      if (isset($tour)) {
          $entity_ids = $this->nodeStorage
              ->loadByProperties([
                  'type' => 'tours',
                  'field_tour_old_rowid' => $tour,
              ]);

          if (count($entity_ids) == 1) {
              // exists also, but not using in this case
              // $node_storage->loadMultiple($nids);
              // No need again load entity
              //$node = $this->entityTypeManager()->load(key($entity_ids));
                $nodeKey = key($entity_ids); // this is node Id
                $tourDate = $this->showTourDates([$nodeKey]);
                $tourPrice = $this->showTourPrice([$nodeKey]);

              $node = $entity_ids[$nodeKey];  // current($entity_ids) or reset
              $tourData[$nodeKey] = [
                  'tour_rowid'=>$node->field_tour_old_rowid->value,
                  'tour_name'=>$node->field_tour_name->value,
                  'tour_link'=> $node->field_tour_base_link->value,
                  'tour_image'=> $node->field_tour_base_picture->value,
                  'tour_days'=>  $node->field_tour_days->value ,
                  'field_tour_days_prefix'=>$node->field_tour_days_prefix->value,
                  'field_tour_days_suffix'=>$node->field_tour_days_suffix->value,
                  'title'=>$node->getTitle(),
                  'tour_dates'=>$tourDate,
                  'tour_prices'=>$tourPrice,
                  'tour_type'=> $node->field_tour_tour_type->target_id
              ];
              return $tourData;
          } else {
            return [];
          }
      }

  }


    /**
     * @param null $list - array of tour ids
     * @param null $date - particular date
     * @param null $output
     * @return array|JsonResponse
     */
    public function showTourDates ($list = null,$date = NULL)
    {

        if (isset($date)) {
            $datesEntity = $this->nodeStorage
                ->loadByProperties([
                    'type' => 'tour_dates',
                    'field_tour_date' => $date,
                    'field_tour_date_tour' => $list,
                ]);
        } else {
            $datesEntity = $this->nodeStorage
                ->loadByProperties([
                    'type' => 'tour_dates',
                    'field_tour_date_tour' => $list,
                ]);
        }
        if (0 == count($datesEntity)){
            return [];
        }


        foreach ($datesEntity as $key=>$value) {
            $dates[$value->field_tour_date->value] = [
                'date_nodeid'=>$key,
                'dates_tour'=>$value->field_tour_date_tour->target_id,
                'date_date'=>$value->field_tour_date->value,
                'date_suffix'=>$value->field_tour_date_suffix->value,
                'date_prefix'=>$value->field_tour_date_prefix->value,
                'dates_tour_rowid'=>$value->field_tour_date_old_tour_rowid->value,
                'date_remark'=>$value->field_tour_date_remark->value,
                'date_generated'=>$value->field_tour_date_generated_from->value,

            ];
        }
        return isset($dates) ? $dates : NULL;
    }


    public function showTourPrice ( $list = [])
    {
        if (isset($list)) {
            $pricesEntity = $this->nodeStorage
                ->loadByProperties([
                    'type' => 'tour_prices',
                    'field_tour_price_tour' => $list,
                ]);
        }

        if (0 == count($pricesEntity)){
            return [];
        }
        foreach ($pricesEntity as $key=>$value) {
            $prices[$value->field_tour_price_tour_rowid->value][] = [
                'price_nodeid'=>$key,
                'price_tour'=>$value->field_tour_price_tour->target_id,
                'price_main'=>$value->field_tour_main_price->value,
                'price_3'=>$value->field_tour_price_3->value,
                'price_4'=>$value->field_tour_price_4->value,
                'price_single'=>$value->field_tour_price_single->value,
                'price_kids'=>$value->field_tour_price_kids->value,
                'price_lux'=>$value->field_tour_price_lux->value,
                'price_promo'=>$value->field_tour_price_promo->value,
                'price_flight'=>$value->field_tour_price_flight->value,
                'price_without_flight'=>$value->field_tour_price_without_flight->value,
                'price_suffix'=>$value->field_tour_date_suffix->value,
                'price_prefix'=>$value->field_tour_date_prefix->value,
                'price_tour_rowid'=>$value->field_tour_price_tour_rowid->value,
                'price_tour_old'=>$value->field_tour_old_price->value,
                'price_tour_is_flight'=>$value->field_tour_price_is_flight->value

            ];
        }
        return isset($prices) ? $prices : NULL;

    }

    public function showTourType ( $typeNodeId )
    {

        return $this->nodeStorage->load($typeNodeId);

    }
}
