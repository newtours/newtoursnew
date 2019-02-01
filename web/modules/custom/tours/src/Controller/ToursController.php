<?php
namespace Drupal\tours\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;
use \Drupal\node\Entity\Node;
use  \Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class ToursController.
 *
 * @package Drupal\tours\Controller
 */
class ToursController extends ControllerBase {

  /**
   * Generate.
   *
   * @return string
   *   Return Hello string.
   */
  public function generate() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: generate')
    ];
  }
  
    public function showList( $id ) {
 
    return array(
      '#theme' => 'tours_list',
      '#test_var' => $this->t('Test Value'),
    );
 
  }
  
  public function connectToNewtours() {

      //$node = \Drupal::entityTypeManager()->getStorage('node')->create(array('type' => 'tours', 'title' => 'Another node'));
      //$node->save();
      //var_dump($node);
  \Drupal\Core\Database\Database::setActiveConnection('external');
  $db = \Drupal\Core\Database\Database::getConnection();
  
  $data = $db->select('tours','t')->fields('t')->execute();
   $result = array();
   //var_dump($data);exit;
//$categories_vocabulary = 'tour_directions';
   
  foreach ($data as $m=>$tour){
      /*
      var_dump(mb_detect_encoding($tour->tour_name));
      header('Content-Type: text/html; charset=cp1251');
      echo $tour->tour_name;exit;
      echo iconv('cp1251', 'UTF-8/IGNORE', $tour->tour_name);exit;
      //var_dump($tour->tour_name);exit;
      $string = $tour->tour_name;
      //$string = str_replace('=', '%', $string);
      //$string = rawurldecode($string);var_dump($string);
      //$string = echo iconv('Windows-1251', 'UTF-8/IGNORE', $string);
      echo $string;exit;

      //setlocale(LC_CTYPE, 'POSIX');
      //var_dump(iconv("cp1251_general_ci", "UTF-8/IGNORE", $tour->tour_name));exit;
           var_dump(\Drupal\Component\Utility\Unicode::convertToUtf8($tour->tour_name,'Windows-1251'));  exit;
       * */
       
      $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                 array('type' => 'tours',
                     'title' => $tour->tour_name,
                     'field_tour_name' => $tour->tour_name,
                   
                     'field_tour_active'=>$tour->tour_active,
                     'field_tour_base_link'=>$tour->tour_link,
                     'field_tour_base_picture'=>$tour->tour_picture,
                     'field_tour_days'=>$tour->tour_ndays,
                     'field_tour_days_remark'=>$tour->tour_ndays_rem,
                     'field_tour_direction'=>$tour->tour_direction,
                     'field_tour_nights'=>$tour->tour_nnights,
                     'field_tour_nights_remark'=>$tour->tour_nnights_rem,
                     'field_tour_old_rowid'=>$tour->tour_rowid,
                     'field_tour_price'=>$tour->tour_price,
                     'field_tour_descr'=>$tour->tour_descr,
                     'field_tour_startdate'=>$tour->tour_startdate,
                    // 'field_tour_type'=>$tour->tour_type,
                     'field_tour_date_remark'=>$tour->tour_date_remark,
                     
                     ));
       
      
               $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_rowid', $tour->tour_rowid);
                $entity_ids = $query->execute();
                if (count($entity_ids) > 0 ) {
                    var_dump(count($entity_ids));
                    $node->save($entity_ids);               
                } 
                else {
                    echo 'New';
                    $node->save(); 
                    
                }
                $entityArray[] = $entity_ids;
            exit;   
               
     foreach ($tour as $key=>$value) {
         $result[$m][$key] =$value;

     }
  }
  //var_dump($node); exit;
//$params = json_encode($result, TRUE);
  //$mm = new JsonResponse($params);
   var_dump($entityArray); exit;
 \Drupal\Core\Database\Database::setActiveConnection();
    //return new JsonResponse($params);

}


    public function updateFromSource ($table,$id='all')
    {
             
        if ('all' == $id) $id = FALSE;
                switch ($table) {
            case 'tours':
                return $this->updateToursTable($id);
                break;
            case 'dates':
                
                return $this->updateDatesTable ( $id );
                break;
            case 2:
                echo "i=2";
                break;
            default:
                return 'Nothing did';
            }            
    }
    
    protected function updateToursTable ( $id )
    {
        
// Delete multiple entities at once.
//\Drupal::entityTypeManager()->getStorage($entity_type)->delete(array($id1 => $entity1, $id2 => $entity2));
        
 
          \Drupal\Core\Database\Database::setActiveConnection('external');
          $db = \Drupal\Core\Database\Database::getConnection();
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
        foreach ($data as $m=>$tour){
            
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_id', $tour->tour_rowid);
                  $entity_ids = $query->execute();
                 // var_dump($tour->tour_rowid);
                  //var_dump($entity_ids);
                  
                  if ($entity_ids) {
                      
                      $node = \Drupal::entityTypeManager()->getStorage('node')->load(key($entity_ids));
                      
                                 //$node->setTitle($tour->tour_name);
                                 $node->field_tour_name->value = $tour->tour_name;
                  
                                  $node->field_tour_active->value=$tour->tour_active;
                                  $node->field_tour_base_link->value = $tour->tour_link;
                                  $node->field_tour_base_picture->value = $tour->tour_picture;
                                   $node->field_tour_days->value   =$tour->tour_ndays;
                                    $node->field_tour_days_remark->value=$tour->tour_ndays_rem;
                                   $node->field_tour_direction->value=$tour->tour_direction;
                                   $node->field_tour_nights->value=$tour->tour_nnights;
                                   $node->field_tour_nights_remark->value=$tour->tour_nnights_rem;
                                   $node->field_tour_old_id->value =$tour->tour_rowid;
                                   $node->field_tour_price_base->value =$tour->tour_price;
                                   $node->field_tour_short_description->value = $tour->tour_descr;
                                    // 'field_tour_type'=>$tour->tour_type,
                                   $node->field_tour_date_remark->value = $tour->tour_date_remark;
                                  
                                   $entityArray[$tour->tour_rowid] = 'edited -  ' . implode(' , - ',$entity_ids);
                       
                      
                  } else {
             
                    $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                            array('type' => 'tours',
                                    'title' => $tour->tour_name,
                                    'field_tour_name' => $tour->tour_name,
                   
                                    'field_tour_active'=>$tour->tour_active,
                                    'field_tour_base_link'=>$tour->tour_link,
                                    'field_tour_base_picture'=>$tour->tour_picture,
                                    'field_tour_days'=>$tour->tour_ndays,
                                    'field_tour_days_remark'=>$tour->tour_ndays_rem,
                                    'field_tour_direction'=>$tour->tour_direction,
                                    'field_tour_nights'=>$tour->tour_nnights,
                                    'field_tour_nights_remark'=>$tour->tour_nnights_rem,
                                    'field_tour_old_id'=>$tour->tour_rowid,
                                    'field_tour_price_base'=>$tour->tour_price,
                                    'field_tour_short_description'=>$tour->tour_descr,
                                    // 'field_tour_type'=>$tour->tour_type,
                                    'field_tour_date_remark'=>$tour->tour_date_remark,                    
                     ));
                  }
                  
                    $added =  $node->save(); 
                    $entityArray[$tour->tour_rowid] = 'added -  ' . $added;
   

            }
    
              //  \Drupal\Core\Database\Database::setActiveConnection();
          //var_dump($entityArray);exit  ;
        return array(
             '#type' => 'markup',
                '#markup' => $this->t( 'Update tours with id ' . implode(' , ',$entityArray)),
            );

    }
    
     protected function updateDatesTable ( $id ) 
     {
               //$result = \Drupal::entityQuery('node')
                //->condition('type', 'tour_dates')
                //->execute();
               // entity_delete_multiple('node', $result);exit;          
         \Drupal\Core\Database\Database::setActiveConnection('external');
                    $db = \Drupal\Core\Database\Database::getConnection();
                    if ($id)  {
                    $data = $db->select('tour_dates','t')
                                 ->fields('t')
                                ->condition('td_tour',$id, '=')
                                ->execute();
                }
                else {
                    $data = $db->select('tour_dates','t')
                                 ->fields('t')
                                 ->execute();              
          }
            $result = array();
            
                        // Close external connection
                 \Drupal\Core\Database\Database::setActiveConnection();      
            foreach ($data as $m=>$tour){
                $tour->new_tour_id = NULL;
                $TourDateTime = NULL;
                $newTourDateString = NULL;
                
            // Check for nid in main tours content
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_id', $tour->td_tour);
                  $entity_ids = $query->execute();
                  
                  if(!$entity_ids) return  array(
                                '#type' => 'markup',
                                '#markup' => $this->t( 'Tour row id is absence for  tour '  . $tour->td_tour . 'Insert tour before'),
                        );
                  
                  $tour->new_tour_id = key( $entity_ids );
                  $TourDateTime = \DateTime::createFromFormat('Y-m-d h:i:s', $tour->td_date . ' 00:00:00');
                  $newTourDateString = $TourDateTime->format('Y-m-d\TH:i:s');
                    // Check if record alredy exist 
                  var_dump($newTourDateString);
                  
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_date_old_tour_rowid', $tour->td_tour)  
                                    ->condition('field_tour_date', $newTourDateString);
                  $dateEntityId  = $query->execute(); 
                  var_dump($dateEntityId);
                  //if($dateEntityId ) continue;  // exit from current loop if record exists in system 
                  if($dateEntityId ) {
                            //\Drupal::entityTypeManager()->getStorage('tour_dates')->delete( $dateEntityId );
                      entity_delete_multiple('node', $dateEntityId);
                        }
                  //var_dump($dateEntityId);exit;
                 
                        //$TourDateTime = \DateTime::createFromFormat('Y-m-d', $tour->td_date);
                        //var_dump($myDateTime);exit;
                        //$newDateString = $myDateTime->format('Y-m-d\TH:i:s');
                        //var_dump($newDateString);
                    $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                            array('type' => 'tour_dates',
                                    'title'=> 'Tour id: ' .  $tour->new_tour_id . '   - ' . $tour->td_tour . ' date : '  .$tour->td_date,
                                    'field_tour_date' => $newTourDateString,
                                    'field_tour_date_tour' => $tour->new_tour_id,
                                    'field_tour_date_old_rowid'=>$tour->td_rowid,
                                    'field_tour_date_remark'=>'',
                                    'field_tour_date_old_tour_rowid'=>$tour->td_tour,
                 
                     ));
                  //var_dump( $dateEntityId );
                  
                    $added =  $node->save(); 
                    $entityArray[$tour->tour_rowid] = 'added -  ' . $tour->td_date;
   

            }
            
                    return array(
                                '#type' => 'markup',
                                '#markup' => $this->t( 'Update tours with id ' . implode(' , ',$entityArray)),
                        );
                 
         
     }
     
     public function showCarousel()
     {
         
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
