<?php
namespace Drupal\tours\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;
use \Drupal\node\Entity\Node;
use  \Drupal\Core\Datetime\DrupalDateTime;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax;
use Drupal\Core\Ajax\OpenModalDialogCommand;

//use Drupal\Core\Database\Database;

/**
 * Class ToursController.
 *
 * @package Drupal\tours\Controller
 */
class ToursController extends ControllerBase {



    /**
     * Constructs a new ToursDataController object.
     */
    public function __construct( EntityTypeManagerInterface $entity_type_manager) {

        $this->entityTypeManager = $entity_type_manager->getListBuilder('node')
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

  public function indexPage()
  {
      return [
          //'#type' => 'markup',
          '#theme' => 'index_list',
          '#title'=>'',
          '#tours_data'=> isset($tours) ? $tours : NULL,
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
          //'#markup' => '',
      ];
  }
  
  public function bootsrapPage ($template = null) {
            return [
                //'#type' => 'markup',
                '#theme' => 'index_list',
                '#title'=>'',
                '#tours_data'=> isset($tours) ? $tours : NULL,
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
          //'#markup' => '',
      ];
  }
  public function showTourList( $result = null )
  {
      $toursEntity = $this->entityTypeManager()
          ->loadByProperties([
              'type' => 'tours'
          ]);
      if (0 == count($toursEntity)){
          $markDataEmpty = 'Tours Table is empty';
      }
      foreach ($toursEntity as $key=>$value) {

          $tours[$key] = [
              'tour_rowid'=>$value->field_tour_old_rowid->value,
              'tour_name'=>$value->field_tour_name->value,
              'tour_link'=> $value->field_tour_base_link->value,
              'tour_image'=> $value->field_tour_base_picture->value,
              'tour_days'=> $value->field_tour_days->value,
              //'tour_dates'=> $value->field_tour_days->value,
              //'tour_prices'=> $value->field_tour_days->value,
          ];
      }


      return [
          //'#type' => 'markup',
          '#theme' => 'tours_list',
          '#tours_data'=> isset($tours) ? $tours : NULL,
          '#attached' => [
              'library' => [
                  'tours/respTable',
                  //'tours/wishlist-carousel',
                  //'core/drupal.dialog.ajax'
                ],
              'drupalSettings' => [
                  'tourData' => 'test',
                ]
              ],
          //'#markup' => '',
      ];
  }


    /**
     * Return json of dates for particular range
     * @param $start
     * @param $end
     * @return JsonResponse
     */
    protected function showExistingDates ($start, $end)
    {
        $query = $this->entityTypeManager->getQuery();
        $query->condition('type', 'tour_dates')
            ->condition('field_tour_date', $start, '>=')
            ->condition('field_tour_date', $end, '<=')
            ->sort('field_tour_date', 'DESC');
        $nids = $query->execute();
        $datesEntity = $this->entityTypeManager->loadMultiple($nids);

  //      $datesEntity = $this->entityTypeManager
  //          ->loadByProperties([
  //              'type' => 'tour_dates',
  //          ]);
        $nDates = 0;
        $dates = [];
        foreach ($datesEntity as $value) {
            $key = $value->field_tour_date->value;
            if (isset($result[$key])) {
                $result[$key]['counter'] = $result[$key]['counter'] + 1 ;
                //var_dump( $result[$key]) ;
                $dates[$nDates]['title'] = 'title ' .  $result[$key]['counter'] ;
                continue;
            }
            $result[$key] = [
                'date'=>$key,
                'title'=>1,
                'counter'=> 1,
                ];

            $dates[$nDates] = $result[$key];
            $nDates ++;

        }

        /**
         *  Sort no need here
         */
        /**
        usort($dates, function($a,$b){
             $t1 = strtotime($a['date']) ;
             $t2 = strtotime($b['date']) ;
            if ($t1 == $t2) return 0;
            return ($t1 < $t2) ? -1 : 1;

        });
         */
        return new JsonResponse($dates);

    }

    /** Output Tours List  for particular date (dates) date
     * @param $date
     * @param null $tours
     * @param null $json - return json or markup
     * @return array|JsonResponse
     */
   public function showTourByDate ($date,$tours = null,$json = null)
   {
       $datesEntity = $this->entityTypeManager
           ->loadByProperties([
               'type' => 'tour_dates',
               'field_tour_date' => $date,
               //'field_tour_date_tour' => $list,
           ]);

       if (count($datesEntity) > 0) {
           foreach ($datesEntity as $key=>$value) {
               $dates[$value->field_tour_date_tour->target_id] = [
                   'dates_tour'=>$value->field_tour_date_tour->target_id,
                   'date_date'=>$value->field_tour_date->value,
                   'date_suffix'=>$value->field_tour_date_suffix->value,
                   'date_prefix'=>$value->field_tour_date_prefix->value,
                   'dates_tour_rowid'=>$value->field_tour_date_old_tour_rowid->value,
                   'date_remark'=>$value->field_tour_date_remark->value,
                   'date_generated'=>$value->field_tour_date_generated_from->value,
               ];
               $tournid[] =  $value->field_tour_date_tour->target_id;
           }
//var_dump($tournid);
           $toursEntity = $this->entityTypeManager->loadMultiple($tournid);
           foreach ($toursEntity as $key=>$value) {
               $toursData[$key] = [
                    'tour_name' => $value->field_tour_name->value,
                    'tour_ndays' => $value->field_tour_days->value,
                    'tour_link'=>$value->field_tour_base_link->value,
                    'tour_image'=>$value->field_tour_base_picture->value,
                    'tour_days_prefix'=>$value->field_tour_days_prefix->value,
                     'tour_days_suffix'=>$value->field_tour_days_suffix->value,
                    'tour_old_rowid' =>$value->field_tour_old_rowid->value,
                    'tour_short_description' => $value->field_tour_descr->value
                   ];
            }
           }
       //echo $date . '<br/>';
       //echo count($toursEntity) . '<br/>';exit;
//var_dump($toursData);exit;
       if (isset($json)) {
           return new JsonResponse($dates);
       }
       $return =  [
           //'#type' => 'markup',
           '#theme' => 'tours_calendar_content',
           '#dates_data'=> isset($dates) ? $dates : [],
           '#tours_data'=> isset($toursData) ? $toursData : [],
           //'#table_title'=>['name'=>$tourName, 'days'=>$tourDays],
           '#attached' => [
               'library' => [
                   'tours/respTable',
                   //'tours/wishlist-carousel',
                   //'core/drupal.dialog.ajax'
               ],
               'drupalSettings' => [
                   'tourData' => 'test',
               ]
           ],
           //'#markup' => '',
       ];
       //var_dump($return);exit;
       return new \Symfony\Component\HttpFoundation\Response(render($return));

   }
    /**
     * @param null $list - array of tour ids
     * @param null $date - particular date
     * @param null $output
     * @return array|JsonResponse
     */
   public function showTourDates ($list = null,$date = NULL,$output = null)
   {

       $all = \Drupal::request()->query->all();

       if(isset($all['end']) && isset($all['start']) ) {
           $start = $all['start'];
           $end = $all['end'];

       } else {
           $dateNow = new \DateTime();
           $start = $dateNow->format('Y-m-d');
           $dateNow->add(new \DateInterval('P1M'));
           $end = $dateNow->format('Y-m-d');

       }

       if (!isset($list) && !isset($date)) {
           return $this->showExistingDates($start,$end);
       }

       if ('tours-list' == $list && isset($date)) {
           return $this->showTourByDate($date);
       }


       $datesEntity = $this->entityTypeManager
           ->loadByProperties([
               'type' => 'tour_dates',
               'field_tour_date' => $date,
               //'field_tour_date_tour' => $list,
           ]);
       if (0 == count($datesEntity)){
           $markDataEmpty = 'Date Table is empty';
       }
       $tour = $this->entityTypeManager->load($list);
       $tourName = $tour->field_tour_name->value;
       $tourDays = $tour->field_tour_days->value;
       foreach ($datesEntity as $key=>$value) {
           $dates[$key] = [
           'dates_tour'=>$value->field_tour_date_tour->target_id,
               'date_date'=>$value->field_tour_date->value,
               'date_suffix'=>$value->field_tour_date_suffix->value,
               'date_prefix'=>$value->field_tour_date_prefix->value,
               'dates_tour_rowid'=>$value->field_tour_date_old_tour_rowid->value,
               'date_remark'=>$value->field_tour_date_remark->value,
               'date_generated'=>$value->field_tour_date_generated_from->value,

               ];
       }
        if(isset($output) ) {
            $response = (object) $dates;
            return new JsonResponse($response);
        }

       return [
           //'#type' => 'markup',
           '#theme' => 'tours_list',
           '#dates_data'=> isset($dates) ? $dates : NULL,
           '#table_title'=>['name'=>$tourName, 'days'=>$tourDays],
           '#attached' => [
               'library' => [
                   'tours/respTable',
                   //'tours/wishlist-carousel',
                   //'core/drupal.dialog.ajax'
               ],
               'drupalSettings' => [
                   'tourData' => 'test',
               ]
           ],
           //'#markup' => '',
       ];
   }





    public function showFullTourData ( $list = null)
    {
        $toursEntity = $this->entityTypeManager()
            ->loadByProperties([
                'type' => 'tours',
                //'field_tour_old_rowid'=> $list
            ]);
        if (0 == count($toursEntity)){
            $tours = [];
        }
        foreach ($toursEntity as $key=>$value) {

            $dates = $this->showTourDates($key,null,'array');

            $tours[$key] = [
                'tour_rowid'=>$value->field_tour_old_rowid->value,
                'tour_name'=>$value->field_tour_name->value,
                'tour_link'=> $value->field_tour_base_link->value,
                'tour_image'=> $value->field_tour_base_picture->value,
                'tour_days'=> $value->field_tour_days->value,
                'dates'=>$dates
                //'tour_dates'=> $value->field_tour_days->value,
                //'tour_prices'=> $value->field_tour_days->value,
            ];
        }
var_dump($tours);exit;
    }


    public function createProduct ($tour = null)
    {


    }




     
     public function showCarousel($type = NUll)
     {
         
            return [
          //'#type' => 'markup',
          '#theme' => 'carousels_list',
          '#tours_data'=> isset($tours) ? $tours : NULL,
          '#attached' => [
              'library' => [
                  //'tours/respTable',
                  'tours/slick-carousel',
                  //'core/drupal.dialog.ajax'
              ],
              'drupalSettings' => [
                  'tourData' => 'test',
              ]
          ],
          //'#markup' => '',
      ];   
         
         
       $markUp =   '   <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bitter" rel="stylesheet" type="text/css">
<div class="container">
  <div class="row header-row">
    <div class="col-md-offset-2 col-md-8 title">
      
      <h1>Bootstrap 3 Show Many Slide One Carousel</h1>
          <p>Find out more about <a href="https://github.com/rtpHarry/Bootstrap3-ShowManySlideOneCarousel">this code sample</a>.</p>
    </div>    
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="carousel carousel-showmanymoveone slide" id="carousel123">
        <div class="carousel-inner">
          <div class="item active">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=1" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=2" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/d6d6d6/333&amp;text=3" class="img-responsive"></a></div>
          </div>          
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002040/eeeeee&amp;text=4" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=5" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=6" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=7" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/40a1ff/002040&amp;text=8" class="img-responsive"></a></div>
          </div>
        </div>
        <a class="left carousel-control" href="#carousel123" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
        <a class="right carousel-control" href="#carousel123" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <h2>Second carousel test</h2>
    </div>
  </div>  
  <div class="row">
    <div class="col-md-12">
      <div class="carousel carousel-showmanymoveone slide" id="carouselABC">
        <div class="carousel-inner">
          <div class="item active">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=A" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=B" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/d6d6d6/333&amp;text=C" class="img-responsive"></a></div>
          </div>          
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002040/eeeeee&amp;text=D" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=E" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=F" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=G" class="img-responsive"></a></div>
          </div>
          <div class="item">
            <div class="col-xs-12 col-sm-6 col-md-3"><a href="#"><img src="http://placehold.it/500/40a1ff/002040&amp;text=H" class="img-responsive"></a></div>
          </div>
        </div>
        <a class="left carousel-control" href="#carouselABC" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
        <a class="right carousel-control" href="#carouselABC" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
    </div>
  </div>  
</div>';
       
       $markUp2 = '
           
<div class="container">
   

    <p>Bootstrap 3 Carousel Multiple Items Increment by 1</p>

     
   
<!--  <a href="https://github.com/rtpHarry/Bootstrap3-ShowManySlideOneCarousel">this code sample</a>   -->
<div class="row">
   <div class="col-md-12">
      <div class="carousel carousel-showmanymoveone slide" id="carousel-tilenav" data-interval="false">
         <div class="carousel-inner">
            <div class="item active">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=1" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=2" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/d6d6d6/333&amp;text=3" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/002040/eeeeee&amp;text=4" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/0054A6/fff/&amp;text=5" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/002d5a/fff/&amp;text=6" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/eeeeee&amp;text=7" class="img-responsive"></a>
               </div>
            </div>
            <div class="item">
               <div class="col-xs-12 col-sm-6 col-md-2">
                  <a href="#"><img src="http://placehold.it/500/40a1ff/002040&amp;text=8" class="img-responsive"></a>
               </div>
            </div>
         </div>
         <a class="left carousel-control" href="#carousel-tilenav" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
         <a class="right carousel-control" href="#carousel-tilenav" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
      </div>
   </div>
</div>

   
</div>


';
       
             return [
     // '#theme' => 'wishlist_carousel',
    '#type' => 'markup',
    '#markup' => $markUp,
      //'#someVariable' => $some_variable,
      '#attached' => array(
        'library' => array(
          'tours/wishlist-carousel',
        ),

      ),
    ];
     }
}
