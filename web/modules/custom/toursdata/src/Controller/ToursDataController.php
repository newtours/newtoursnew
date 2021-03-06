<?php

namespace Drupal\toursdata\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Database\Database;

use Symfony\Component\HttpFoundation\JsonResponse;

use PHPSQLParser\PHPSQLParser;

/**
 * Class ToursDataController.
 */
class ToursDataController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;
  /**
   * Symfony\Component\DependencyInjection\ContainerAwareInterface definition.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerAwareInterface
   */
  protected $entityQuery;
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

    /**
     * @var array
     */
    protected $_weekArray = [
        'четв'=>'Thursday',
        'воск'=>'Sunday',
        'сре'=>'Wednesday',
        'Суб'=> 'Saturday',
        'вторн'=>'Tuesday',
        'пон'=>'Monday',
        'пят'=>'Friday'
    ];
    /**
     * @var array
     */
    protected $_weekDays = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    protected $__tableMainRefernceFields =
        [
            'tour_dates'=>'field_tour_date_tour' ,
            'tour_prices'=>'field_tour_price_tour',
            'tour_boarding_places_time'=> 'field_boarding_time_tour',
        ];

  /**
   * Constructs a new ToursDataController object.
   */
  public function __construct(EntityManagerInterface $entity_manager, ContainerAwareInterface $entity_query, EntityTypeManagerInterface $entity_type_manager) {
    $this->entityManager = $entity_manager;
    $this->entityQuery = $entity_query;

     // !!! Actually not using here
      // ControllerBase has  method entityTypeManager()
    $this->entityTypeManager = $entity_type_manager->getListBuilder('node')
                                                    ->getStorage();

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('entity.query'),
      $container->get('entity_type.manager')
    );
  }


    /**
     * To delete all content
     * @code
     *   $result = \Drupal::entityQuery('node')
     *  ->condition('type', 'tour_direction')
     *  ->execute();
     *
     *   entity_delete_multiple('node', $result);exit;
     *  #code_end
     *
     */
    public function updateFromSource ($table,$id='all')
    {

        if ('all' == $id) $id = FALSE;
        switch ($table) {
            case 'all':
                $return = $this->_updateAllTables($id);
                break;
            case 'tours':
                $return = $this->_updateToursTable($id);
                break;
            // dates not call directly
            case 'dates':
                //$return =  $this->_updateDatesTable ( $id );
                $return = '';
                break;
            case 'directions':
                $return =  $this->_updateDirectionsTable ( $id );
                break;
            case 'places':
                $return =  $this->_updatePlacesTable ( $id );
                break;
            case 'types':
                $return =  $this->_updateTypesTable ( $id );
                break;
            case 'districts':
                $return =  $this->_updateDistrictsTable($id);
                break;
            case 'boarding':
                $return =  $this->_updateBoardingPlacesTime($id);
                break;
            case 'prices':
                $return = $this->_updatePricesTabel($id);
                break;
            case 'hotels';
                return $this->_updateHotels();
            case 'files':
                if('stars' == $id) {
                    $return = $this->_updateFromStarsFile(null);
                }
                elseif ('regular' == $id ) {
                    $return = $this->_updateFromDataFile(null);
                }
                break;
            case 'countries':
                $list = (\Drupal\Core\Locale\CountryManager::getStandardList());
                foreach($list as $key=>$value) {
                    echo ($key . '=>' .(string) $value);
                }
                //print_r($list['US']);
                exit;
            default:
                $return =  'Nothing did';

        }
        if (is_array($return)) {
            $result = '';
            foreach ($return as $key=>$value) {
                $result .= $key . '=>' . (is_array($value) ? implode(',->',$value) : $value). '<br/>';
            }
        }
        return [
            '#type' => 'markup',
            '#markup' => $result
        ];
    }


    /**
     * Structure
     *
     * field_tour_base_link
    field_tour_base_picture
    field_tour_date_01
    field_tour_date_02
    field_tour_date_03
    field_tour_date_04
    field_tour_date_05
    field_tour_date_06
    field_tour_date_07
    field_tour_date_08
    field_tour_date_09
    field_tour_date_10
    field_tour_date_11
    field_tour_date_12
    field_tour_dates
    field_tour_dates_remark_legasy_
    field_tour_days
    field_tour_days_old_remarks
    field_tour_days_prefix
    field_tour_days_suffix
    field_tour_direction
    field_tour_old_rowid
    field_tour_name
    field_tour_nights
    field_tour_nights_old_remark
    field_tour_nights_prefix
    field_tour_nights_suffix
    field_tour_price
    field_tour_descr
    field_tour_startdate
    field_tour_tour_direction
    field_tour_tour_type
    field_tour_week_days

     *
     * PLease admit that dates generated only on update tour, not in initial created
     * Due the dates table can be huge and on creating need run dates creating after node save - we dont know node id yet
     * For dates can create additional method with tour entity id
     * @code
     * @param $id
     * @return array
     */
    protected function _updateToursTable ( $id )
    {

// Delete multiple entities at once.
//\Drupal::entityTypeManager()->getStorage($entity_type)->delete(array($id1 => $entity1, $id2 => $entity2));

        $curYear = date("Y");
        $yearPrefix = ( $curYear & 1 ) ? $curYear: $curYear + 1;
        $datesResult = '';

        $db = $this->_setExternalConnection();
        if ($id)  {
            $data = $db->select('tours','t')
                ->fields('t')
                ->condition('tour_rowid',$id, '=')
                ->execute();
        }
        else {
            $data = $db->select('tours','t')
                ->fields('t')
                ->execute();
        }
        $result = array();
        // Close external connection
        \Drupal\Core\Database\Database::setActiveConnection();

// ######## Delete multiple
        /**
        $tours_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tours'
            ]);
        //$this->entityTypeManager()->delete($tours_ent_ids);
        var_dump(($tours_ent_ids));//exit;
         */
//#################

        // Load directions
        $direction_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tour_direction'
            ]);
        if (0 == count($direction_ent_ids)){
            return 'Directions  not exists, need insert it first';
        }
        foreach ($direction_ent_ids as $key=>$value) {
            $direction[$value->field_direction_rowid->value]  = $key;
        }
        // Load Types
        $type_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tour_types'
            ]);
        if (0 == count($type_ent_ids)){
            return 'Types table not exists, need insert it first';
        }
        foreach ($type_ent_ids as $key=>$value) {
            $types[$value->field_tour_type_rowid->value]  = $key;
        }
//var_dump($types);
//echo '<br/><br/><br/>';
//var_dump($direction);

        foreach ($data as $m=>$tour){
            // $entity_ids - is array of nodes, keyed by node Id
            $entity_ids = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tours',
                    'field_tour_old_rowid' => $tour->tour_rowid,
                ]);
//var_dump($tour->tour_rowid);
//var_dump(count($entity_ids));echo '<br/><br/><br/>';
            // if more than one entity in array - this is wrong need cleanup
            if (1 < count($entity_ids)) return 'Exists multiple tours with the same id ' . $tour->tour_rowid;
            elseif (count($entity_ids) == 1) {
                // exists also, but not using in this case
                // $node_storage->loadMultiple($nids);
                // No need again load entity
                //$node = $this->entityTypeManager()->load(key($entity_ids));
                $nodeKey = key($entity_ids); // this is node Id
                $node = $entity_ids[$nodeKey];  // current($entity_ids) or reset
//var_dump($node);
                $node->setTitle(strip_tags($tour->tour_name));
                $node->field_tour_name->value =  $tour->tour_name;
                $node->field_tour_active->value= $tour->tour_active;
                $node->field_tour_price->value = (float) $tour->tour_price;
                $node->field_tour_descr->value = $tour->tour_descr ;
                $node->field_tour_base_link->value = $tour->tour_link;
                $node->field_tour_base_picture->value = $tour->tour_picture;
                $node->field_tour_days->value   =$tour->tour_ndays;
                $node->field_tour_days_old_remarks->value=$tour->tour_ndays_rem;
                $node->field_tour_direction->value=$tour->tour_direction;
                $node->field_tour_nights->value=$tour->tour_nnights;
                $node->field_tour_nights_old_remark->value=$tour->tour_nnights_rem;
                $node->field_tour_week_days->value=$tour->tour_week_days;
                $node->field_tour_dates_remark_legasy_->value=$tour->tour_date_remark;
                //$node->field_tour_old_rowid->value =$tour->tour_rowid; // No need refresh

                $node->field_tour_descr->value = $tour->tour_descr;
                // 'field_tour_type'=>$tour->tour_type,

                $node->field_tour_tour_type->target_id = $types[$tour->tour_type];
                $node->field_tour_tour_direction->target_id = $direction[$tour->tour_direction];


                // Dates section
                $start = true; // import key, due dates deleted after every update - delete only when start Month 01
                if (isset($tour->tour_week_days) && !empty(trim($tour->tour_week_days))) {
                    //var_dump($tour->tour_week_days);
                    $datesResult .= $this->_updateDatesTable ( $nodeKey, $tour->tour_rowid,
                        [ $yearPrefix=>$tour->tour_week_days],$start);
                } else {
                    for ($i = 1; $i < 13; $i++) {
                        if ($i < 10) {
                            $node->{'field_tour_date_0' . $i}->value = $tour->{'tour_m0' . $i . '_days'};
                            $datesResult .=$this->_updateDatesTable($nodeKey, $tour->tour_rowid,
                                [$yearPrefix => [
                                    '0' . $i => $tour->{'tour_m0' . $i . '_days'}
                                ]
                                ], $start);
                        } else {
                            $node->{'field_tour_date_' . $i}->value = $tour->{'tour_m' . $i . '_days'};
                            $datesResult .= $this->_updateDatesTable($nodeKey, $tour->tour_rowid,
                                [$yearPrefix => [
                                    $i => $tour->{'tour_m' . $i . '_days'}
                                ]
                                ], $start);
                        }
                        $start = false;
                    }
                }


                $added =  $node->save(key($entity_ids));
                if (2 == $added) {
                    $entityArray[$tour->tour_rowid] = 'edited -  ' . $node->id() . ' <br/>DATES ' .$datesResult;
                    if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                }

            } else {

                $node = $this->entityTypeManager()->create(
                    ['type' => 'tours',
                        'title' => strip_tags($tour->tour_name),
                        'field_tour_name' => $tour->tour_name,
                        'field_tour_price' => (float) $tour->tour_price,
                        'field_tour_active'=>$tour->tour_active,
                        'field_tour_base_link'=>$tour->tour_link,
                        'field_tour_base_picture'=>$tour->tour_picture,
                        'field_tour_days'=>$tour->tour_ndays,
                        'field_tour_days_old_remarks'=>$tour->tour_ndays_rem,
                        'field_tour_direction'=>$tour->tour_direction,
                        'field_tour_nights'=>$tour->tour_nnights,
                        'field_tour_nights_old_remark'=>$tour->tour_nnights_rem,
                        'field_tour_old_rowid'=>$tour->tour_rowid,
                        'field_tour_descr'=>$tour->tour_descr,
                        // 'field_tour_type'=>$tour->tour_type,
                        'field_tour_week_days'=>$tour->tour_week_days,
                        'field_tour_dates_remark_legasy_'=>$tour->tour_date_remark,
                    ]);
                $node->field_tour_tour_type->target_id = $types[$tour->tour_type];
                $node->field_tour_tour_direction->target_id = $direction[$tour->tour_direction];

                // Dates section
                for($i=1;$i<13;$i++) {
                    if ($i < 10) {
                        $node->{'field_tour_date_0'.$i}->value = $tour->{'tour_m0'.$i.'_days'};
                    } else {
                        $node->{'field_tour_date_'.$i}->value = $tour->{'tour_m'.$i.'_days'};
                    }
                }

                $added =  $node->save();
                if (1 == $added) {
                    $entityArray[$tour->tour_rowid] = 'saved -  ' . $node->id() . $datesResult;
                }

            }

            //echo '<br/><br/>';
            //var_dump($entityArray);

//exit;
        }
        return $entityArray;
        //  \Drupal\Core\Database\Database::setActiveConnection();
        //var_dump($entityArray);exit  ;
        //$resShow = implode(',',$entityArray);
        return array(
            '#type' => 'markup',
            '#markup' => $this->t( 'Update tours with id ' . $resShow),
        );

    }

    /**
     * @param $entity - entity Id
     * @param array $ids like 'year'=> 'month'=>[data]
     * @param $tour_id - old td_tour field - tour_rowid of tour. This is major key to avoid duplicate entries
     * @param bool $external - just in case if decide export from external. NOT USE USUALLY, in this case $entity - td_roiwd
     * Structure
     * @code
     * field_tour_date
     * field_tour_date_generated_from
     * field_tour_date_old_rowd
     * field_tour_date_old_tour_rowid
     * field_tour_date_prefix
     * field_tour_date_remark
     * field_tour_date_suffix
     * field_tour_date_tour
     * @endcode
     * @return array
     */
    protected function _updateDatesTable ( $entity, $tour_rowid, array $ids, $start = true, $external = false )
    {
//var_dump($ids);
        // Avoid duplicate entries in tour_dates entity table. Key here is $tour_rowid, not $entity
        if ($start) {
            $entityIdsArray = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_dates',
                    'field_tour_date_old_tour_rowid' => $tour_rowid,
                ]);
            }

            // to avoid delete, below array for update dates if exists
        if (count($entityIdsArray) > 0) {    
        foreach($entityIdsArray as $key=>$value) {
                //var_dump($value->field_tour_date->value);
                //var_dump($value->getTitle());echo '=>' . $key . '</br>';
                $datesEntityArray[$value->field_tour_date->value] = [
                    'node'=>$key,
                    'type' => 'tour_dates',
                    'title'=>$value->getTitle(),
                    'data'=>[
                        'field_tour_date' => $value->field_tour_date->value,
                        'field_tour_date_old_tour_rowid' => $value->field_tour_date_old_tour_rowid->value,
                        'field_tour_date_suffix' => $value->field_tour_date_suffix->value,
                        'field_tour_date_prefix' => $value->field_tour_date_prefix->value,
                        'field_tour_date_generated_from'=>$value->field_tour_date_generated_from->value
                    ],
                    'entity'=>[
                        $key=>$value,
                    ]
                    
                ];    
            }
        }


            //if (count($entityIdsArray)) {
            //    $this->entityTypeManager()->delete($entityIdsArray);
            //}
       
//exit;
        if (count($ids) == 0) {
            return 'Source dates array is empty';
        }
            foreach ($ids as $key=>$value) {
                $tourDateString = null;
                $year = $key;
                $dateArrays = NULL;

                if (is_array($value)) {
                    foreach ($value as $m => $data) {
                        $month = $m;
                        $dates = explode(',', $data);
                        if (count($dates) > 0) {
                            foreach ($dates as $date) {
                                $suffix = '';
                                $prefix = '';
                                $int = (int)filter_var($date, FILTER_SANITIZE_NUMBER_INT);
                                if (!empty($int)) {
                                    $TourDateTime = \DateTime::createFromFormat('Y-m-d', $year . '-' . $month . '-' . $int);
                                    //$tourDateString = $TourDateTime->format('Y-m-d\TH:i:s');
                                    $tourDateString = $year . '-' . $month . '-' . ((1 == strlen($int)) ? '0' . $int : $int);
                                    $title = $tour_rowid . ' @' . $tourDateString;
                                    if (false !== strpos($date, '*')) {
                                        $suffix = '*';
                                    }
                                    if(isset($datesEntityArray[$tourDateString])) {
                                        //$datesEntityArray[$tourDateString]['data']['field_tour_date_suffix'] = $suffix;
                                        //$datesEntityArray[$tourDateString]['data']['field_tour_date_prefix'] = $prefix;
                                        $datesEntityArray[$tourDateString]['data']['title'] = $title;
                                        $nodeId = $nodeId = $this->_createDateNode($datesEntityArray[$tourDateString],true);
                                        unset($datesEntityArray[$tourDateString]);
                                    } else {
                                    $nodeId = $this->_createDateNode(
                                        [ $entity =>
                                            ['title' => $title,
                                            'type' => 'tour_dates',
                                            'field_tour_date' => $tourDateString,
                                            'field_tour_date_old_tour_rowid' => $tour_rowid,
                                            'field_tour_date_suffix' => $suffix,
                                            'field_tour_date_prefix' => $prefix,
                                                'field_tour_date_generated_from' => 'Date string array  of ' . $month
                                            ]
                                        ]);
                                    }
                                    if ($nodeId) {
                                        $entityArray[$tour_rowid][$nodeId] = 'saved -  ' . $tourDateString;
                                    }
                                    //echo $nodeId . ' ' . $tourDateString . '<br/>';
                                    //var_dump($tourDateString);
                                } else {
                                    if (!empty($date)) {
                                        $dateArrays = [];
                                        $date = strtolower($date);
//echo '420 ' .$date .'=>>>> ';
                                        foreach($this->_weekArray as $weekArrayKey=>$weekArrayValue) {
                                            if (false !== strpos($date,strtolower($weekArrayKey))) {
 //echo ($weekArrayValue) . ' ';
//echo $weekArrayKey . ' ' . '<br/>';
                                                $dateArrays = array_merge($dateArrays,$this->getAllDaysInAMonth($year, $month, $weekArrayValue));
                                            }                                            
                                        }
//echo '******<br/>';
// var_dump($dateArrays);
//echo '******<br/>';
                                    }
                                }
                                if (isset($dateArrays) && count($dateArrays)> 0) {
                                    foreach ($dateArrays as $dateOfArray) {
                                        $weekDay = $dateOfArray->format('Y-m-d');
                                        $title = $tour_rowid . ' @' . $weekDay;
                                       // echo $weekDay . ' line 438******<br/>';
                                    if(isset($datesEntityArray[$weekDay])) {
                                        //$datesEntityArray[$tourDateString]['data']['field_tour_date_suffix'] = $suffix;
                                        //$datesEntityArray[$tourDateString]['data']['field_tour_date_prefix'] = $prefix;
                                        $datesEntityArray[$weekDay]['data']['title'] = $title;
                                        $nodeId = $nodeId = $this->_createDateNode($datesEntityArray[$weekDay],true);
                                        unset($datesEntityArray[$weekDay]);
                                    } else {
                                        $nodeId = $this->_createDateNode([
                                            $entity => ['title' => $title,
                                                'type' => 'tour_dates',
                                                'field_tour_date' => $weekDay,
                                                'field_tour_date_old_tour_rowid' => $tour_rowid,
                                                'field_tour_date_suffix' => $suffix,
                                                'field_tour_date_prefix' => $prefix,
                                                'field_tour_date_generated_from' => 'String  ' . $dateOfArray->format('l'). ' of ' .$month
                                            ]
                                        ]);
                                    }//var_dump($nodeId);
                                        if ($nodeId) {
                                            $entityArray[$tour_rowid][$nodeId] = 'saved -  ' . $weekDay;
                                        }
                                    }
                                }

                            }
                        }
                    }
                } else {
                    $weekdays = explode(',',$value);//var_dump($weekdays);
                    foreach($weekdays as $wValue) {
                        //var_dump($wValue);
                        for($i=1;$i<13; $i++) {
                            $month = ($i < 10) ? '0'.$i : $i;
                            //var_dump($month);
                            $wValue = ($wValue == 7) ? 0 : $wValue;
                            $dateArrays = $this->getAllDaysInAMonth($year, $month, $this->_weekDays[$wValue]);
                            //var_dump($wValue);exit;
                            if (isset($dateArrays)) {
                                foreach ($dateArrays as $dateOfArray) {
                                    //echo($dateOfArray->format('Y-m-d')) . '<br/>';
                                    $weekDay = $dateOfArray->format('Y-m-d');
                                    $title = $tour_rowid . '-'.$dateOfArray->format('l') . ' '. ' @' . ' ' . $weekDay;
                                    if(isset($datesEntityArray[$weekDay])) {   
                                       $datesEntityArray[$weekDay]['data']['title'] = $title;
                                        $nodeId = $nodeId = $this->_createDateNode($datesEntityArray[$weekDay],true);
                                        unset($datesEntityArray[$weekDay]);
                                    } else {                                    
                                    $nodeId = $this->_createDateNode([
                                        $entity => ['title' => $title,
                                            'type' => 'tour_dates',
                                            'field_tour_date' => $weekDay,
                                            'field_tour_date_old_tour_rowid' => $tour_rowid,
                                            //'field_tour_date_suffix' => $suffix,
                                            //'field_tour_date_prefix' => $prefix,
                                            'field_tour_date_generated_from' => 'Week day   ' . $dateOfArray->format('l')
                                        ]
                                    ]);
                                    }
                                    if ($nodeId) {
                                        $entityArray[$tour_rowid][$nodeId] = 'saved -  ' . $weekDay;
                                    }

                                }
                            }
                        }

                    }
                }
            }
            //var_dump($datesEntityArray);
            if (count($datesEntityArray) > 0) {
                $delete = [];
                foreach($datesEntityArray as $key=>$value) {
                    //$delete[key($value['entity'])] = $value['entity'] ;
                    if(!isset($value->field_tour_date_lock) && true != $value->field_tour_date_lock && isset($value['entity'])) {
                        $this->entityTypeManager()->delete($value['entity']);
                    }
                }
               // var_dump($delete);exit
                 //$this->entityTypeManager()->delete($delete);
            }
        $return = '';
            if (isset($entityArray)) {
                foreach ($entityArray[$tour_rowid] as $key=>$value ) {
                    $return .= '<br/>date=>' .$key . ' ' . $value;
                }

            }
        return $return ;

    }

    /**
     * @param $data
     * @return mixed
     */
    protected function _createDateNode($data,$update = false)
    {
    
        if(!$update) {
            $entity = key($data);
            $node = $this->entityTypeManager()->create($data[$entity]);
            $node->field_tour_date_tour->target_id = $entity;
            $node->save();
        } else {
            $node = $this->entityTypeManager()->load($data['node']);
            foreach($data['data'] as $key=>$value) {
                $node->$key->value = $value; 
            }
            $node->save($data['node']);
        }
        return $node->id();
    }

    /**
     * THIS is DRAFT !!!!!!
     * Update all tables according relationship between them
     *
     * Due The Mysql 5.7 see https://dev.mysql.com/doc/refman/5.7/en/group-by-handling.html
     * @code
     *  SELECT
            t.*,
            dates.*
            FROM tours t
            LEFT JOIN tour_dates dates ON t.tour_rowid = dates.td_tour
            GROUP BY
                t.tour_rowid,
                dates.td_rowid
                HAVING COUNT(dates.td_rowid) > 0
                ORDER BY `t`.`tour_rowid` ASC
     *
     * @endcode
     * @param $id
     */
    protected function _updateAllTables ($id)
    {
        //Database::setActiveConnection('external');
        $db = $this->_setExternalConnection();

        if ($id)  {
            $query = $db->select('tours','t')
                ->fields('t')
                ->condition('tour_rowid',$id, '=');
            //$query->leftJoin('tour_dates', 'dates', 't.tour_rowid = dates.td_tour');
            //$query->fields('dates');
            $query->leftJoin('tour_places', 'places', 't.tour_rowid = places.tp_tour');
            $query->fields('places');
            $query->addExpression('COUNT(places.tp_rowid)', 'count');
            $query->groupBy('t.tour_rowid');
            $query->groupBy('places.tp_rowid');
            $result = $query->execute()->fetchObject(); //fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            $query = $db->select('tours','t')
                ->fields('t');
            //$query->leftJoin('tour_dates', 'dates', 't.tour_rowid = dates.td_tour');
            //$query->fields('dates');
            $query->leftJoin('tour_places', 'places', 't.tour_rowid = places.tp_tour');
            $query->fields('places');
            $query->addExpression('COUNT(places.tp_rowid)', 'count');
            $query->groupBy('t.tour_rowid');
            $query->groupBy('places.tp_rowid');
            print($query);exit;
            $result = $query->execute()->fetchAll(); //Assoc('tour_rowid', \PDO::FETCH_ASSOC); //fetchAll(PDO::FETCH_ASSOC);
        }
        foreach($result as $key=>$value) {
            echo $key . '=>';
            var_dump($value);
            //echo $value->tour_rowid . ' === ';
            //echo $value->tp_rowid ;
            echo '---<br/><br/>---';
        }
        \Drupal\Core\Database\Database::setActiveConnection();
        exit;
        return [
            '#type' => 'markup',
            '#markup' => $this->t('Implement method: updateData')
        ];
        //var_dump($result); exit;
    }

    protected function _updatePlacesTable ( $id = null )
    {
        //\Drupal\Core\Database\Database::setActiveConnection('external');
        $db = $this->_setExternalConnection();
        if ($id)  {
            $data = $db->select('places','t')
                ->fields('t')
                ->condition('place_rowid',$id, '=')
                ->execute();
        }
        else {
            $data = $db->select('places','t')
                ->fields('t')
                ->execute()->fetchAll();
        }
        $result = array();
        // Close external connection
        \Drupal\Core\Database\Database::setActiveConnection();
        $districts_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'districts'
            ]);
        foreach ($districts_ent_ids as $key=>$value) {
            $districts[$value->field_district_old_rowid->value]  = $key;
            //var_dump($key);
            //var_dump($value->field_district_old_rowid->value);
            //echo '<br/>';
        }
        //var_dump($districts);exit;
        foreach ($data as $m=>$tour){

            $entity_ids = $this->entityTypeManager()
                            ->loadByProperties([
                                'type' => 'boarding_places',
                                'field_place_old_rowid' => $tour->place_rowid,
                            ]);

//var_dump($entity_ids);
            //var_dump($districts[$tour->place_district]);


//var_dump($tour);exit;

            if (count($entity_ids) > 0) {
                $node = $this->entityTypeManager()->load(key($entity_ids));
                $node->setTitle(strip_tags($tour->place_name));
                $node->field_place_old_rowid->value =  $tour->place_rowid;
                $node->field_place_name->value= $tour->place_name;
                $node->field_place_active->value = $tour->place_active;
                $node->field_place_long->value = $tour->place_lon;
                $node->field_place_lat->value = $tour->place_lat;
                $node->field_district->target_id = $districts[$tour->place_district];
                $node->save($entity_ids);
            } else {
                $node = $this->entityTypeManager()->create(
                    [
                        'type' => 'boarding_places',
                        'title' => strip_tags($tour->place_name),
                        'field_place_old_rowid' =>  $tour->place_rowid,
                        'field_place_name'=> $tour->place_name,
                        'field_place_active' => $tour->place_active,
                        'field_place_long->value' => $tour->place_lon,
                        'field_place_lat->value' => $tour->place_lat,
                        //'field_district->entity' => $districts[$tour->place_district],
                    ]);
                $node->field_district->target_id = $districts[$tour->place_district];
                $node->save($entity_ids);
            }
            $added =  $node->save();
            $entityArray[$tour->type_rowid] = 'added -  ' . $added;

        }
        return $entityArray;
        return array(
            '#type' => 'markup',
            '#markup' => $this->t( 'Update Types with id ' . implode(' , ',$entityArray)),
        );
    }


    protected function _updateDistrictsTable ( $id = null )
    {
        //\Drupal\Core\Database\Database::setActiveConnection('external');
        $db = $this->_setExternalConnection();
        if ($id)  {
            $data = $db->select('districts','t')
                ->fields('t')
                ->condition('district_rowid',$id, '=')
                ->execute();
        }
        else {
            $data = $db->select('districts','t')
                ->fields('t')
                ->execute()->fetchAll();
        }
        $result = array();
        // Close external connection
        \Drupal\Core\Database\Database::setActiveConnection();

        foreach ($data as $m=>$tour){

            $entity_ids = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'districts',
                    'field_district_old_rowid' => $tour->district_rowid,
                ]);

            if (count($entity_ids) > 0) {
                $node = $this->entityTypeManager()->load(key($entity_ids));
                $node->setTitle(strip_tags($tour->district_name));
                $node->field_district_old_rowid->value =  $tour->district_rowid;
                $node->field_district_name->value= $tour->district_name;
                $node->field_district_active->value = $tour->district_active;

                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->district_name;
            } else {
                $node = $this->entityTypeManager()->create(
                    [
                        'type' => 'districts',
                        'title' => strip_tags($tour->district_name),
                        'field_district_old_rowid' =>  $tour->district_rowid,
                        'field_district_name'=> $tour->district_name,
                        'field_place_active' => $tour->place_active,
                    ]);
                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->district_name;
            }

        }
        return $entityArray;
        return array(
            '#type' => 'markup',
            '#markup' => $this->t( 'Update Types with id '),
        );
    }

    /**
     * Types table. No dependency
     * @param null $id
     * @return array
     */
    protected function _updateTypesTable ( $id = null )
    {

        $db = $this->_setExternalConnection();
        if ($id)  {
            $data = $db->select('types','t')
                ->fields('t')
                ->condition('type_rowid',$id, '=')
                ->execute();
        }
        else {
            $data = $db->select('types','t')
                ->fields('t')
                ->execute()->fetchAll();
        }
        $result = array();
        // Close external connection
        \Drupal\Core\Database\Database::setActiveConnection();

        foreach ($data as $m=>$tour){

            $entity_ids = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_types',
                    'field_tour_type_rowid' => $tour->type_rowid,
                ]);

            if (count($entity_ids) > 0) {
                $node = $this->entityTypeManager()->load(key($entity_ids));
                $node->setTitle(strip_tags($tour->type_name));
                $node->field_tour_type_rowid->value =  $tour->type_rowid;
                $node->field_tour_type_name->value= $tour->type_name;
                $node->field_tour_type_active->value = $tour->type_active;

                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->type_name;
            } else {
                $node = $this->entityTypeManager()->create(
                    [
                        'type' => 'tour_types',
                        'title' => strip_tags($tour->type_name),
                        'field_tour_type_rowid' =>  $tour->type_rowid,
                        'field_tour_type_name'=> $tour->type_name,
                        'field_tour_type_active' => $tour->type_active,
                    ]);
                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->type_name;
            }

        }
        return $entityArray;
        return array(
            '#type' => 'markup',
            '#markup' => $this->t( 'Update Types with id '),
        );
    }

    /**
     * Direction. Tours Depend on it
     * @param null $id
     * @return array
     */
    protected function _updateDirectionsTable ( $id = null )
    {

        $db = $this->_setExternalConnection();
        if ($id)  {
            $data = $db->select('directions','t')
                ->fields('t')
                ->condition('direction_rowid',$id, '=')
                ->execute();
        }
        else {
            $data = $db->select('directions','t')
                ->fields('t')
                ->execute()->fetchAll();
        }
        $result = array();
        // Close external connection
        \Drupal\Core\Database\Database::setActiveConnection();

        foreach ($data as $m=>$tour){

            $entity_ids = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_direction',
                    'field_direction_rowid' => $tour->direction_rowid,
                ]);

            if (count($entity_ids) > 0) {
                $node = $this->entityTypeManager()->load(key($entity_ids));
                $node->setTitle(strip_tags($tour->direction_name));
                $node->field_direction_rowid->value =  $tour->direction_rowid;
                $node->field_direction_name->value= $tour->direction_name;
                $node->field_direction_active->value = $tour->direction_active;

                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->direction_name;
            } else {
                $node = $this->entityTypeManager()->create(
                    [
                        'type' => 'tour_direction',
                        'title' => strip_tags($tour->direction_name),
                        'field_direction_rowid' =>  $tour->direction_rowid,
                        'field_direction_name'=> $tour->direction_name,
                        'field_direction_active' => $tour->direction_active,
                    ]);
                $node->save($entity_ids);
                $entityArray[$node->id()] = $tour->direction_name;
            }

        }
        return $entityArray;

    }

    /**
     *
     * @code
     *
     * Structure
     * field_tour_main_price
    field_tour_old_price
    field_tour_price_3
    field_tour_price_4
    field_tour_price_flight
    field_tour_price_kids
    field_tour_price_prefix
    field_tour_price_promo
    field_tour_price_single
    field_tour_price_suffix
    field_tour_price_teen
    field_tour_price_tour
    field_tour_price_tour_rowid
    field_tour_price_without_flight

     * @endcode
     * @param $entity
     * @param $tour_rowid
     * @param array $ids
     * @param bool $start
     * @param bool $external
     */
    protected function _updatePricesTabel ($tour_rowid = null)
    {
        $db = $this->_setExternalConnection();
         if ($tour_rowid) {
            $data = $db->select('tours', 't')
                    ->fields('t')
                    ->condition('tour_rowid', $tour_rowid, '=')
                    ->execute();

            } else {
                $data = $db->select('tours', 't')
                    ->fields('t')
                    ->execute();
         }
         \Drupal\Core\Database\Database::setActiveConnection();

        // Load Tours Entities
        $tours_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tours'
            ]);
        if (0 == count($tours_ent_ids)){
            return ['Tours  not exists, need insert it first'];
        }
        foreach ($tours_ent_ids as $key=>$value) {
            $tours[$value->field_tour_old_rowid->value]  = $key;
        }
        // Check if single tour_rowid and entity exists
        if ($tour_rowid && !isset($tours[$tour_rowid])) {
            return ['Tour ' .$tour_rowid . ' Not Created Yet'] ;
        }

        //var_dump($tours);exit;
        foreach($data as $m=>$tour) {
            $entityId = $tours[$tour->tour_rowid];
            if(isset($entityId)) {
                $prices_ent_ids = $this->entityTypeManager()
                    ->loadByProperties([
                        'type' => 'tour_prices',
                        'field_tour_price_tour' => $entityId,
                    ]);
                // Suffix, Prefix logic
                $tourPriceSuffix = '';
                $tourPricePrefix = '';
                $remark = explode (',',$tour->tour_price_remark);
                if (isset($remark[1])) {
                    $tourPricePrefix = $remark[0];
                    $tour->tour_price_remark = trim(str_replace("от", "", $tour->tour_price_remark));
                    $tour->tour_price_remark = ltrim($tour->tour_price_remark ,',');
                }
                else {
                    if(strpos($tour->tour_price_remark,'от')!==false) {
                        $tourPricePrefix = 'от';
                        $tour->tour_price_remark = trim(str_replace("от", "", $tour->tour_price_remark));
                        $tour->tour_price_remark = ltrim($tour->tour_price_remark ,',');

                    }
                }

                if ( strpos($tour->tour_price_remark,'*')!==false ) {
                        $tourPriceSuffix .= '*';
                }
                $tourPriceSuffix .= ' '. $tour->tour_price_remark;

                if ( strpos($tour->tour_price_remark,'перелет')!==false){
                        $tourFlight = true;;
                }
                if ( strpos($tour->tour_price_remark,'+ перелет')!==false){
                    $tourPriceWithoutFlight = $tour->tour_price;;
                } else {
                    $tourPriceWithoutFlight = null;
                }

                // End of suffix prefix logic

             if (count($prices_ent_ids) > 0 ) {
                 $nodeKey = key($prices_ent_ids); // this is node Id
                 $node = $prices_ent_ids[$nodeKey];
                 $node->setTitle('Prices for '.strip_tags($tour->tour_name));

                 $node->field_tour_main_price->value = $tour->tour_price;
                 $node->field_tour_old_price->value  =  $tour->tour_old_price;
                 $node->field_tour_price_3->value    = $tour->tour_price_disc_3;
                 $node->field_tour_price_4->value    = $tour->tour_price_disc_4;
                 $node->field_tour_price_flight->value = $tour->tour_price_flight;
                 $node->field_tour_price_without_flight->value = isset($tour->tour_price_without_flight) ? $tour->tour_price_without_flight : $tourPriceWithoutFlight;
                 $node->field_tour_price_kids->value   = $tour->tour_price_kids;
                 $node->field_tour_price_prefix->value = (isset($tour->tour_price_prefix)&& !empty($tour->tour_price_prefix)) ? $tour->tour_price_prefix : trim($tourPricePrefix);
                 $node->field_tour_price_promo->value   = $tour->tour_price_promo;
                 $node->field_tour_price_single->value  = $tour->tour_price_single;
                 $node->field_tour_price_suffix->value  = (isset($tour->tour_price_suffix) && !empty($tour->tour_price_suffix)) ? $tour->tour_price_suffix: trim($tourPriceSuffix);
                 $node->field_tour_price_teen->value   = $tour->tour_price_teen;
                 $node->field_tour_price_lux->value = $tour->tour_price_lux;
                 $node->field_tour_price_tour_rowid->value = $tour->tour_rowid;
                 $node->field_tour_price_tour->target_id = $entityId;
                 $node->field_tour_price_is_flight->value = isset($tourFlight) ? $tourFlight : false;

                 $added =  $node->save($nodeKey);
                 if (2 == $added) {
                     $entityArray[$tour->tour_rowid] = 'edited -  ' . $node->id();
                     if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                 }
             } else {

                 $node = $this->entityTypeManager()->create(
                     ['type' => 'tour_prices',
                        'title'=>'Prices for '.strip_tags($tour->tour_name),
                         'field_tour_main_price' => $tour->tour_price,
                         'field_tour_old_price' => $tour->tour_old_price,
                         'field_tour_price_3' =>   $tour->tour_price_disc_3,
                         'field_tour_price_4' =>   $tour->tour_price_disc_4,
                         'field_tour_price_flight' => $tour->tour_price_flight,
                         'field_tour_price_without_flight' => isset($tour->tour_price_without_flight) ? $tour->tour_price_without_flight : $tourPriceWithoutFlight,
                         'field_tour_price_kids' => $tour->tour_price_kids,
                         'field_tour_price_prefix' => (isset($tour->tour_price_prefix)&& !empty($tour->tour_price_prefix)) ? $tour->tour_price_prefix : trim($tourPricePrefix),
                         'field_tour_price_promo' => $tour->tour_price_promo,
                         'field_tour_price_single' => $tour->tour_price_single,
                         'field_tour_price_suffix' => (isset($tour->tour_price_suffix) && !empty($tour->tour_price_suffix)) ? $tour->tour_price_suffix: trim($tourPriceSuffix), // Need create suffix, according old application logic
                         'field_tour_price_teen' => $tour->tour_price_teen,
                         'field_tour_price_lux' => $tour->tour_price_lux,
                         //'field_tour_price_tour' => $entityId,
                         'field_tour_price_tour_rowid' => $tour->tour_rowid,
                         'field_tour_price_is_flight' => isset($tourFlight) ? $tourFlight : false,
                     ]);
                 $node->field_tour_price_tour->target_id = $entityId;
                 $added = $node->save();
                 if (1 == $added) {
                     $entityArray[$tour->tour_rowid] = 'saved -  ' . $node->id();
                 }
             }

            } else {
                $entityArray[$tour->tour_rowid]  =  'Tour ' .$tour_rowid . ' Not Created Yet' ;
            }
            //var_dump($entityArray);exit;
        }

        return $entityArray;
        var_dump($entityArray);exit;
        return $entityArray;
    }

    /**
     * @param null $tour_rowid
     * Structure
     * @code
     *
     *  field_boarding_time
        field_boarding_time_place
        field_boarding_time_prefix
        field_boarding_time_suffix
        field_boarding_time_tour
        field_boarding_time_tour_rowid

     * @endcode
     */
    protected function _updateBoardingPlacesTime ($tour_rowid = null)
    {
        //$node = $this->entityTypeManager()
        //    ->loadByProperties([
        //        'type' => 'tour_boarding_places_time',]);
        //$this->entityTypeManager()->delete($node);exit;

        // Load boarding Places Entity
        $places_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'boarding_places'
            ]);
        if (0 == count($places_ent_ids)){
            return 'Places  not exists, need insert it first';
        }
        foreach ($places_ent_ids as $key=>$value) {
            $places[$value->field_place_old_rowid->value]  = $key;
        }

        // Load Tours Entities
        $tours_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tours'
            ]);
        if (0 == count($tours_ent_ids)){
            return 'Tours  not exists, need insert it first';
        }
        foreach ($tours_ent_ids as $key=>$value) {
            $tours[$value->field_tour_old_rowid->value]  = $key;
        }

        $db = $this->_setExternalConnection();
        // Load source tour_places
        if ($tour_rowid)  {
            $data = $db->select('tour_places','t')
                ->fields('t')
                ->condition('tp_tour',$tour_rowid, '=')
                ->execute();
        }
        else {
            $data = $db->select('tour_places','t')
                ->fields('t')
                ->execute()->fetchAll();
        }
        \Drupal\Core\Database\Database::setActiveConnection();

        foreach ($data as $m=>$tour) {
            // $entity_ids - is array of nodes, keyed by node Id
            //
            $boarding_ent = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_boarding_places_time',
                    //'field_boarding_time_tour_rowid' => $tour->tp_tour,
                    'field_boarding_time_old_rowid' => $tour->tp_rowid
                ]);
            $nodeKey = key($boarding_ent); // this is node Id
            $node = $boarding_ent[$nodeKey];
             //var_dump(count($boarding_ent));exit;
            if (1 == count($boarding_ent)) {
                echo $tour->tp_time . '==>';
                echo $tours[$tour->tp_tour];
                echo '<br/>';

                $node->setTitle($tour->tp_tour);
                $dt = new \DateTime("1970-01-01 $tour->tp_time", new \DateTimeZone('UTC'));
                $node->field_boarding_time->value = (int)$dt->getTimestamp();
                //$node->field_boarding_time_place->target_id = $places[$tour->tp_place];
                //$node->field_boarding_time_prefix
                $node->field_boarding_time_suffix->value = $tour->tp_remark;
                //$node->field_boarding_time_tour->target_d = $tours[$tour->tp_tour];
                $node->field_boarding_time_tour_rowid->value = $tour->tp_tour;
                $node->field_boarding_time_old_rowid->value = $tour->tp_rowid;
                $node->field_boarding_time_place->target_id = $places[$tour->tp_place];
                $node->field_boarding_time_tour->target_id = $tours[$tour->tp_tour];

                //echo $tour->tp_time . '==>';
                //echo $tours[$tour->tp_tour];
                //echo '<br/>' . $nodeKey . '<br/>';
                $added =  $node->save();
                if (2 == $added) {
                    $entityArray[$tour->tp_rowid] = 'edited -  ' . $node->id();
                    //if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                }
                //
            } else {
                // Duplicates entry is not correct. Need delete
                if (1 < count($node)) {
                    $this->entityTypeManager()->delete($node);
                }
                //echo $tour->tp_time . '==>';
                //echo $tours[$tour->tp_tour];
                //echo '<br/>';
                $dt = new \DateTime("1970-01-01 $tour->tp_time", new \DateTimeZone('UTC'));
                $node = $this->entityTypeManager()->create(
                    [    'type' => 'tour_boarding_places_time',
                        'title'=>$tour->tp_tour,
                        'field_boarding_time'=>(int)$dt->getTimestamp(),
                        'field_boarding_time_suffix'=>$tour->tp_remark,
                        'field_boarding_time_tour_rowid'=>$tour->tp_tour,
                        'field_boarding_time_old_rowid'=>$tour->tp_rowid
                    ]);
                $node->field_boarding_time_place->target_id = $places[$tour->tp_place];
                $node->field_boarding_time_tour->target_id = $tours[$tour->tp_tour];
                $added =  $node->save();
                if (1 == $added) {
                    $entityArray[$tour->tp_rowid] = 'created -  ' . $node->id();
                    }

            }
        }
        return $entityArray;


    }


    protected function _updateHotels ( $hotel_rowid = null)
    {

        // Load Tours Entities before export, due hotel tables related to tours
        $tours_ent_ids = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tours'
            ]);
        if (0 == count($tours_ent_ids)){
            return 'Tours  not exists, need insert it first';
        }
        foreach ($tours_ent_ids as $key=>$value) {
            $tours[$value->field_tour_old_rowid->value]  = $key;
        }

        $db = $this->_setExternalConnection();
        // Load source tour_places
        if ($hotel_rowid)  {
            $data = $db->select('hotels','h')
                ->fields('h')
                ->condition('hotel_rowid',$hotel_rowid, '=')
                ->execute();
        }
        else {
            $data = $db->select('hotels','h')
                ->fields('h')
                ->execute()->fetchAll();
        }
        \Drupal\Core\Database\Database::setActiveConnection();

        foreach ( $data as $m=>$hotel) {

            $hotel_ent = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'hotels',
                    //'field_boarding_time_tour_rowid' => $tour->tp_tour,
                    'field_hotel_old_rowid' =>$hotel->hotel_rowid
                ]);
            $nodeKey = key($hotel_ent); // this is node Id
            $node = $hotel_ent[$nodeKey];

            if (1 == count($hotel_ent)) {

                $node->setTitle($hotel->hotel_name);

                    $node->field_hotel_old_rowid = $hotel->hotel_rowid;
                    $node->field_hotel_name = $hotel->hotel_name;
                    $node->field_hotel_descr= $hotel->hotel_descr;
                    $node->field_hotel_country = 'us';
                    $node->field_hotel_address_address_line1 = $hotel->hotel_address1;
                    $node->field_hotel_address_address_line2 = $hotel->hotel_address2;
                    $node->field_hotel_address_locality= $hotel->hotel_city;
                    $node->field_hotel_address_administrative_area= $hotel->state;
                    $node->field_hotel_address_postal_code= $hotel->zipcode;
                    $node->field_hotel_photo= $hotel->hotel_photo;

                $added =  $node->save();
                if (2 == $added) {
                    $entityArray[$hotel->hotel_rowid] = 'edited -  ' . $node->id();
                    //if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                }
                //
            } else {
                $node = $this->entityTypeManager()->create(
                    ['type' => 'hotels',
                        'title' => (isset($hotel->hotel_name)) ? $hotel->hotel_name : 'no Named',
                        'field_hotel_old_rowid' => $hotel->hotel_rowid,
                        'field_hotel_name' => $hotel->hotel_name,
                        'field_hotel_descr' => $hotel->hotel_descr,
                        'field_hotel_country' => 'us',
                        'field_hotel_address_address_line1' => $hotel->hotel_address1,
                        'field_hotel_address_address_line2' => $hotel->hotel_address2,
                        'field_hotel_address_locality' => $hotel->hotel_city,
                        'field_hotel_address_administrative_area' => $hotel->state,
                        'field_hotel_address_postal_code' => $hotel->zipcode,
                        'field_hotel_photo' => $hotel->hotel_photo,
                    ]);

                $added = $node->save();
                if (1 == $added) {
                    $entityArray[$hotel->hotel_rowid] = 'created -  ' . $node->id();
                }
            }
            $this->_updateHotelRooms ($node->id(),$hotel->hotel_rowid);
        }
        return $entityArray;

    }

    /**
     * @param $hotelNodeId - node id of hotel
     * @param $hotelId - old hotel rowid
     */
    protected function _updateHotelRooms ($hotelNodeId,$hotelId)
    {

        $db = $this->_setExternalConnection();
        // Load source tour_places
        if ($hotelId)  {
            $data = $db->select('hotel_rooms','h')
                ->fields('h')
                ->condition('room_hotel',$hotelId, '=')
                ->execute();
        }
        \Drupal\Core\Database\Database::setActiveConnection();
        foreach ($data as $m=>$room) {

            $room_ent = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'hotel_rooms',
                    //'field_boarding_time_tour_rowid' => $tour->tp_tour,
                    'field_hotel_room_old_rowid' =>$room->room_rowid
                ]);
            $nodeKey = key($room_ent); // this is node Id
            $node = $room_ent[$nodeKey];

            if (1 == count($room_ent)) {

                $node->setTitle($room->room_name);
                $node->field_hotel_room_old_rowid = $room->room_rowid;
                $node->field_hotel_room_name = $room->room_name;
                $node->field_hotel_room_descr= $room->room_descr;
                $node->field_hotel_room_active = $room->room_active;
                $node->field_hotel_photo = $room->room_photo;
                $node->field_hotel_room_hotel->target_id = $hotelNodeId;
                $added =  $node->save();
                if (2 == $added) {
                    $entityArray[$room->room_rowid] = 'edited -  ' . $node->id();
                    //if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                }
                //
            } else {
                $node = $this->entityTypeManager()->create(
                    ['type' => 'hotel_rooms',
                        'title' => (isset($room->room_name)) ? $room->room_name : 'no Named',
                        'field_hotel_room_old_rowid' => $room->room_rowid,
                        'field_hotel_room_name' => $room->room_name,
                        'field_hotel_room_descr' => $room->rooml_descr,
                        'field_hotel_photo' => $room->room_photo,
                        'field_hotel_room_active'=>$room->room_active,
                    ]);
                $node->field_hotel_room_hotel->target_id = $hotelNodeId;
                $added = $node->save();
                if (1 == $added) {
                    $entityArray[$room->room_rowid] = 'created -  ' . $node->id();
                }
            }
            $this->_updateHotelPrices ($node->id(),$hotelNodeId,$room->room_rowid);
        }

    }

    /**
     * @param $hotelNodeId - node id of hotel
     * @param $roomNodeId - node id of room
     * @param $hotelId - old hotel rowid
     */
    protected function _updateHotelPrices ($roomNodeId,$hotelNodeId,$roomId)
    {

        $db = $this->_setExternalConnection();
        // Load source tour_places
        if ($roomId)  {
            $data = $db->select('hotel_prices','h')
                ->fields('h')
                ->condition('hp_room',$roomId, '=')
                ->execute();
        }
        \Drupal\Core\Database\Database::setActiveConnection();
        foreach ($data as $m=>$room) {

            $room_ent = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'hotel_room_prices',
                    //'field_boarding_time_tour_rowid' => $tour->tp_tour,
                    'field_hotel_room_prices_rowid' =>$room->hp_rowid
                ]);
            $nodeKey = key($room_ent); // this is node Id
            $node = $room_ent[$nodeKey];

            if (1 == count($room_ent)) {

                $node->field_hotel_room_price_adult     = $room->hp_adult;
	            $node->field_hotel_room_prices_2_child  = $room->hp_child1;
	            $node->field_hotel_room_prices_3_person = $room->hp_add_adult3;
	            $node->field_hotel_room_prices_4_person = $room->hp_add_adult4;
	            $node->field_hotel_room_prices_bus      = $room->hp_bus;
                $node->field_hotel_room_prices_bus_chil = $room->hp_bus_child;
	            $node->field_hotel_room_prices_hotel->target_id    = $hotelNodeId;
	            $node->field_hotel_room_prices_room->target_id     = $roomNodeId;
	            $node->field_hotel_room_prices_rowid    = $room->hp_rowid;
	            $node->field_hotel_room_prices_single   = $room->single_accomodation;
	            //$node->field_hotel_room_prices_start_en = $room->
	            $node->field_hotel_room_prices_teen     = $room->hp_teen;
	            $node->field_hotel_room_prices_tips     = $room->hp_tip;
                $node->field_hotel_room_prices_nnights = $room->hp_nnights;

                $node->setTitle('Room Price-' . $roomId . '-room-' . $roomNodeId . '-hotel-'.$hotelNodeId . '-' . $room->hp_nnights . ' nights');

                $added =  $node->save();
                if (2 == $added) {
                    $entityArray[$room->room_rowid] = 'edited -  ' . $node->id();
                    //if ($node->id() != $nodeKey) return 'Updated incorrect entity ' . $nodeKey . ' to ' .$node->id();
                }
                //
            } else {
                $node = $this->entityTypeManager()->create(
                    ['type' => 'hotel_room_prices',
                        'title' => 'Room Price-' . $roomId . '-room-' . $roomNodeId . '-hotel-'.$hotelNodeId . '-' . $room->hp_nnights . ' nights',
                        'field_hotel_room_price_adult'     => $room->hp_adult,
                        'field_hotel_room_prices_2_child'  => $room->hp_child1,
                        'field_hotel_room_prices_3_person' => $room->hp_add_adult3,
                        'field_hotel_room_prices_4_person' => $room->hp_add_adult4,
                        'field_hotel_room_prices_bus'      => $room->hp_bus,
                        'field_hotel_room_prices_bus_chil' => $room->hp_bus_child,
                        'field_hotel_room_prices_rowid'    => $room->hp_rowid,
                        'field_hotel_room_prices_single'   => $room->single_accomodation,
                        'field_hotel_room_prices_teen'     => $room->hp_teen,
                        'field_hotel_room_prices_tips'     => $room->hp_tip,
                        'field_hotel_room_prices_nnights'  => $room->hp_nnights,
                    ]);
                $node->field_hotel_room_prices_hotel->target_id    = $hotelNodeId;
                $node->field_hotel_room_prices_room->target_id     = $roomNodeId;
                $added = $node->save();
                if (1 == $added) {
                    $entityArray[$room->room_rowid] = 'created -  ' . $node->id();
                }
            }

        }



    }
    /**
     * Actually main purpose delete tour and all related dates, prices, boarding time etc
     * But can delete single dependency
     * @param $table
     * @param $id - node Id
     */
    public function deleteEntities ($table, $id)
    {
        if (!isset($table) && !isset($d)) {
            return [
                '#type' => 'markup',
                '#markup' => 'table and Id mandatory',
            ];
        }
        if ('tours' == $table) {
            $tourNode = $this->entityTypeManager()->load($id);
            //var_dump(key($tourNode));exit;
            if (isset($tourNode)) {
                $tourNode->delete();
            }

            $dateNode = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_dates',
                    'field_tour_date_tour' => $id,
                ]);
            $dateCount = count($dateNode);
            if ($dateCount > 0) {
                $this->entityTypeManager()->delete($dateNode);
            }


            $priceNode = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_prices',
                    'field_tour_price_tour' => $id,
                ]);
            $priceCount = count($priceNode) ;
            if ($priceCount > 0) {
                $this->entityTypeManager()->delete($priceNode);
            }


            $boardingNode = $this->entityTypeManager()
                ->loadByProperties([
                    'type' => 'tour_boarding_places_time',
                    'field_boarding_time_tour' => $id,
                ]);
            $boardingCount = count($boardingNode) ;
            if ($boardingCount> 0) {
                $this->entityTypeManager()->delete($boardingNode);
            }
            $result = 'Deleted tour =>' .$id . ' Dates=> ' .  $dateCount .' Prices=>' .$priceCount . ' Boarding => ' . $boardingCount;
        } else {
            if (in_array($table, ['tour_dates','tour_prices','tour_boarding_places_time'])) {
                $deleteNodes = $this->entityTypeManager()
                    ->loadByProperties([
                        'type' => $table,
                        $this->_tableMainRefernceFields[$table] => $id,
                    ]);
                $nCount = count($deleteNodes);
                if ($nCount > 0) {
                    $this->entityTypeManager()->delete($deleteNodes);
                }
                $result = $table . ' entities related to tour ' . $id . ' deleted ' . $nCount;
            } else {
                $result = 'Only particular tables can deleted';
            }
        }

        return [
            '#type' => 'markup',
            '#markup' => $result
        ];


    }
    /**
     * @param string $connection
     * @return \Drupal\Core\Database\Connection
     */
    protected function _setExternalConnection ($connection = 'external')
    {
        Database::setActiveConnection($connection);
        return  Database::getConnection();
    }

    /**
     * Get an array of \DateTime objects for each day (specified) in a year and month
     * Got from https://stackoverflow.com/questions/28213048/every-monday-of-the-month-in-php
     * also
     * http://thisinterestsme.com/php-get-first-monday-of-month/
     * @param integer $year
     * @param integer $month
     * @param string $day
     * @param integer $daysError    Number of days into month that requires inclusion of previous Monday
     * @return array|\DateTime[]
     * @throws Exception      If $year, $month and $day don't make a valid strtotime
     */
    public function getAllDaysInAMonth($year, $month, $day = 'Monday', $daysError = 3) {
        $dateString = 'first '.$day.' of '.$year.'-'.$month;

        if (!strtotime($dateString)) {
            throw new \Exception('"'.$dateString.'" is not a valid strtotime');
        }

        $startDay = new \DateTime($dateString);

        // Actually below no need in this case, due it return previous month and in multiple month occurred duplicate dates
        if ($startDay->format('j') > $daysError) {
            //$startDay->modify('- 7 days');
        }

        $days = [];

        while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
            $days[] = clone($startDay);
            $startDay->modify('+ 7 days');
        }

        return $days;
    }

    /**
     * using /source/www/stars/a_source_stars_new_data.php
     * @param $file
     */
    protected function _updateFromStarsFile ($file)
    {
        $sourceRoot = dirname(DRUPAL_ROOT) . '/source/';
        //var_dump($file);exit;
        if(!($file)) {
            include $sourceRoot . 'stars/a_source_stars_new_data.php';
            if(isset($array_groups)) {
                $result = [];
                foreach($array_groups as $key=>$value) {
                    $group = $key;
                    foreach ($value as $subKey => $subValue) {
                        $file = $sourceRoot . 'stars/stars/new_data/' . $subValue;
                        $source = file_get_contents($file);
                        preg_match_all('/\$[A-Za-z0-9-_]+/', $source, $vars);
                        include $file;
                        foreach ($vars[0] as &$variables) {
                            $variables =  substr($variables,1);
                            if(isset($$variables) && isset($tour_rowid)) {
                                if (is_array($$variables)) {
                                    foreach($$variables as $value) {
                                        if(is_array($value)) {
                                            foreach ($value as $subvalue) {
                                                if (!empty($subvalue) && !is_null($subvalue)) {
                                                    $result[$tour_rowid][$variables][][] = mb_convert_encoding($subvalue, "utf-8", "windows-1251");
                                                }
                                            }
                                        } else {
                                            if (!empty($value) && !is_null($value)) {
                                                $result[$tour_rowid][$variables][] = mb_convert_encoding($value, "utf-8", "windows-1251");
                                            }
                                        }

                                    }
                                }
                                else {
                                    if(!empty($$variables) && !is_null($$variables)) {
                                        $result[$tour_rowid][$variables] = mb_convert_encoding($$variables, "utf-8", "windows-1251");
                                    }
                                }
                            }
                            //echo $variables . '<br/>';
                        }
                        $result[$tour_rowid]['group'] = $group;
                        $result[$tour_rowid]['group_weight'] = $subKey;
                        $vars = [];

                    }
                }
            }
        }
        var_dump($result);exit;


        $file = $sourceRoot . 'stars/stars/new_data/description_1.php';
        $source = file_get_contents(dirname(DRUPAL_ROOT) . '/source/stars/stars/new_data/description_1.php');
        preg_match_all('/\$[A-Za-z0-9-_]+/', $source, $vars);
         include $file;
        $result = [];
        foreach ($vars[0] as &$variables) {
            $variables =  substr($variables,1);
            if(isset($$variables) && isset($tour_rowid)) {
                if (is_array($$variables)) {
                    foreach($$variables as $value) {
                        if(is_array($value)) {
                            foreach ($value as $subvalue) {
                                if (!empty($subvalue) && !is_null($subvalue)) {
                                    $result[$tour_rowid][$variables][][] = mb_convert_encoding($subvalue, "utf-8", "windows-1251");
                                }
                            }
                        } else {
                            if (!empty($value) && !is_null($value)) {
                                $result[$tour_rowid][$variables][] = mb_convert_encoding($value, "utf-8", "windows-1251");
                            }
                        }

                    }
                }
                else {
                    if(!empty($$variables) && !is_null($$variables)) {
                        $result[$tour_rowid][$variables] = mb_convert_encoding($$variables, "utf-8", "windows-1251");
                    }
                }
            }
            //echo $variables . '<br/>';
        }

var_dump($result);exit;

    }

    /**
     * @param $data
     */
    protected function _updateDescrTable ($data)
    {

    }

    public function getSqlQuery ( $sql = null)
    {
        $this->resQuery = [];
        //$q="select * from tours where   (tour_rowid in(290,286,287,85,291) and tour_active=1) order by field(tour_rowid,290,85,287,291,286)";
        $q = "SELECT t.td_rowid, t.td_tour, t.td_date, t1.* from tour_dates t  left outer join tours t1 on t.td_tour=t1.tour_rowid where td_date>='2019-07-29' and td_date<='2019-08-10' and tour_active=1  and tour_direction!=36   and tour_display_week in(0)  and tour_startdate <= '2019-01-01'  order by td_date, tour_ndays";
        $parser = new PHPSQLParser($q, true);
        foreach($parser->parsed as $key=>$value) {
            //echo ' ' . $key . ' ';
            //var_dump($value);
            //echo '<br/><br/>';
            $iterator = new \RecursiveArrayIterator($value );
            iterator_apply($iterator, [$this,'_iterateQuery'], [$iterator,$key]);
        }
        //var_dump($this->resQuery);exit;
        $response = (object) $this->resQuery;
        return new JsonResponse($response);


    }

    protected function _iterateQuery (  $iterator,$key)
    {

        while ( $iterator -> valid() ) {

            if ( $iterator -> hasChildren() ) {

                $this->_iterateQuery($iterator -> getChildren(),$key);

            }
            else {
                $this->resQuery[$key][$iterator -> key()][] = $iterator -> current() ;
                //echo $key . ' => '.$iterator -> key() . ' : ' . $iterator -> current() .'<br/>';
            }

            $iterator -> next();
        }
    }
}
