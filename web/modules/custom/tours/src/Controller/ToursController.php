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

                $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_rowid', $tour->tour_rowid);
                $entity_ids = $query->execute();
                if (count($entity_ids) > 0 ) {
                    $node = \Drupal::entityTypeManager()->getStorage('node')->load(key($entity_ids));
                     $node->title = strip_tags($tour->tour_name);
                     $node->field_tour_name = $tour->tour_name;                   
                     $node->field_tour_active = $tour->tour_active;
                     $node->field_tour_base_link = $tour->tour_link;
                     $node->field_tour_base_picture = $tour->tour_picture;
                     $node->field_tour_days = $tour-tour_ndays;
                     $node->field_tour_days_remark = $tour->tour_ndays_rem;
                     $node->field_tour_direction = $tour->tour_direction;
                     $node->field_tour_type = $tour->tour_type;
                     $node->field_tour_counry = $tour->tour_country;
                     $node->field_tour_nights = $tour->tour_nnights;
                     $node->field_tour_nights_remark = $tour->tour_nnights_rem;
                     $node->field_tour_old_rowid = $tour->tour_rowid;
                     $node->field_tour_price = $tour->tour_price;
                     $node->field_tour_descr = $tour->tour_descr;
                     $node->field_tour_startdate=$tour->tour_startdate;
                     $node->field_tour_date_01=$tour->tour_m01_days;
                     $node->field_tour_date_02=$tour->tour_m02_days;
                     $node->field_tour_date_03=$tour->tour_m03_days;
                     $node->field_tour_date_04=$tour->tour_m04_days;
                     $node->field_tour_date_05=$tour->tour_m05_days;
                     $node->field_tour_date_06=$tour->tour_m06_days;
                     $node->field_tour_date_07=$tour->tour_m07_days;
                     $node->field_tour_date_08=$tour->tour_m08_days;
                     $node->field_tour_date_09=$tour->tour_m09_days;
                     $node->field_tour_date_10=$tour->tour_m10_days;
                     $node->field_tour_date_11=$tour->tour_m11_days;
                     $node->field_tour_date_12=$tour->tour_m12_days;   
                     $node->field_tour_week_days=$tour->tour_week_days;
                    //$node->ield_tour_type'=>$tour->tour_type;
                     $node->field_tour_date_remark=$tour->tour_date_remark;                       
                                 
                } 
                else {
                $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                    array('type' => 'tours',
                     'title' => strip_tags($tour->tour_name),
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
                     'field_tour_date_01'=>$tour->tour_m01_days,
                     'field_tour_date_02'=>$tour->tour_m02_days,
                     'field_tour_date_03'=>$tour->tour_m03_days,
                     'field_tour_date_04'=>$tour->tour_m04_days,
                     'field_tour_date_05'=>$tour->tour_m05_days,
                     'field_tour_date_06'=>$tour->tour_m06_days,
                     'field_tour_date_07'=>$tour->tour_m07_days,
                     'field_tour_date_08'=>$tour->tour_m08_days,
                     'field_tour_date_09'=>$tour->tour_m09_days,
                     'field_tour_date_10'=>$tour->tour_m10_days,
                     'field_tour_date_11'=>$tour->tour_m11_days,
                     'field_tour_date_12'=>$tour->tour_m12_days,   
                     'field_tour_week_days'=>$tour->tour_week_days,
                    // 'field_tour_type'=>$tour->tour_type,
                     'field_tour_date_remark'=>$tour->tour_date_remark,                     
                     ));                                        
                }
                $node->save(); 
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
            case 'tours':
                return $this->updateToursTable($id);
                break;
            case 'dates':
                return $this->updateDatesTable ( $id );
                break;
            case 'directions':
                return $this->updateDiectionsTable ( $id );
                break;
            case 'types':
                return $this->updatetypeTable ( $id );
                break; 
            case 'countries':
                        $list = (\Drupal\Core\Locale\CountryManager::getStandardList());
                exit;
            default:
                return 'Nothing did';
            }            
    }

    protected function updateTypeTable ( $id = null )
    {
          \Drupal\Core\Database\Database::setActiveConnection('external');
          $db = \Drupal\Core\Database\Database::getConnection();
          if (isset($id) && 'null' != $id)  {
          $data = $db->select('types','t')
                                ->fields('t')
                                ->condition('type_rowid',$id, '=')
                                ->execute();
          }
          else {
          $data = $db->select('types','t')
                                 ->fields('t')
                                 ->execute();              
          }
            $result = array();
            // Close external connection
            \Drupal\Core\Database\Database::setActiveConnection();         
            foreach ($data as $m=>$tour){    

                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_types_rowid', $tour->directiom_rowid);
                  $entity_ids = $query->execute();
                  if (count($entity_ids) > 0) {                       
                     $node = \Drupal::entityTypeManager()->getStorage('node')->load(key($entity_ids));
                            $node->setTitle($tour->type_name);
                            $node->field_tour_type_rowid->value =  $tour->type_rowid;
                            $node->field_tour_type_name->value= $tour->type_name;
                            $node->field_tour_type_active->value = $tour->type_active;                                                                            
                  } else {            
                    $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                            array(
                            'type' => 'tour_types',
                            'title' => strip_tags($tour->type_name),
                            'field_tour_type_rowid' =>  $tour->type_rowid,
                            'field_tour_type_name'=> $tour->type_name,
                            'field_tour_type_name' => $tour->type_active,                                  
                    
                     ));
                  }
                    $added =  $node->save(); 
                    $entityArray[$tour->type_rowid] = 'added -  ' . $added;
            }
        return array(
             '#type' => 'markup',
                '#markup' => $this->t( 'Update Types with id ' . implode(' , ',$entityArray)),
            );
    }    
    
    protected function updateDiectionsTable ( $id = null )
    {
        //DElete multiple
        /*
        $result = \Drupal::entityQuery('node')
            ->condition('type', 'tour_direction')
            ->execute();      
            entity_delete_multiple('node', $result);exit;
        */    

          \Drupal\Core\Database\Database::setActiveConnection('external');
          $db = \Drupal\Core\Database\Database::getConnection();
          if (isset($id) && 'null' != $id)  {
          $data = $db->select('directions','t')
                                ->fields('t')
                                ->condition('direction_rowid',$id, '=')
                                ->execute();
          }
          else {
          $data = $db->select('directions','t')
                                 ->fields('t')
                                 ->execute();              
          }
            $result = array();
            // Close external connection
            \Drupal\Core\Database\Database::setActiveConnection();         
            foreach ($data as $m=>$tour){    
/*
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_direction_rowid', $tour->direction_rowid);
                  $entity_ids = $query->execute();
 * */
                // Look https://www.drupal.org/node/2849874        
                $entity_ids = \Drupal::entityTypeManager()
                    ->getListBuilder('node')
                    ->getStorage()
                    ->loadByProperties([
                    'type' => 'tour_direction',
                    'field_direction_rowid' => $tour->direction_rowid,
                 ]);
                
                
                
var_dump($entity_ids);
echo '<br/>';
                  if (count($entity_ids) > 0) {    
                      echo '<br/>Updated' . $tour->direction_rowid . '<br/>';
                     $node = \Drupal::entityTypeManager()->getStorage('node')->load(key($entity_ids));
                            $node->setTitle($tour->direction_name);
                            $node->field_direction_rowid->value =  $tour->direction_rowid;
                            $node->field_direction_name->value= $tour->direction_name;
                            $node->field_direction_active->value = $tour->direction_active; 
                            $added = $node->save($entity_ids);
                            
                  } else {
             echo '<br/>Created' . $tour->direction_rowid . '<br/>';
                    $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                            array(
                            'type' => 'tour_direction',
                            'title' => strip_tags($tour->direction_name),
                            'field_direction_rowid' =>  $tour->direction_rowid,
                            'field_direction_name'=> $tour->direction_name,
                            'field_direction_active' => $tour->direction_active,                                                     
                            ));
                    $added = $node->save();
                  }
                    //$added =  (count($entity_ids) > 0) ? $node->save($entity_ids) : $node->save(); 
                    $entityArray[$tour->direction_rowid] = 'added -  ' . $added;
            }
            exit;
        return array(
             '#type' => 'markup',
                '#markup' => $this->t( 'Update Diections with id ' . implode(' , ',$entityArray)),
            );
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
    //var_dump($tour);        
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_rowid', $tour->tour_rowid);
                  $entity_ids = $query->execute();
                  //var_dump($tour->tour_rowid);
                 // var_dump($entity_ids);
                  
                  if ($entity_ids) { 
                      
                      $node = \Drupal::entityTypeManager()->getStorage('node')->load(key($entity_ids));
  
                                 //$node->setTitle($tour->tour_name);
                                 $node->field_tour_name->value =  $tour->tour_name;
                                 $node->field_tour_active->value= $tour->tour_active;
                                 $node->field_tour_price->value = $tour->tour_price;
                                 $node->field_tour_descr->value = $tour->tour_descr ;                                 
                                  $node->field_tour_base_link->value = $tour->tour_link;
                                  $node->field_tour_base_picture->value = $tour->tour_picture;
                                   $node->field_tour_days->value   =$tour->tour_ndays;
                                    $node->field_tour_days_old_remarks->value=$tour->tour_ndays_rem;
                                   $node->field_tour_direction->value=$tour->tour_direction;
                                   $node->field_tour_nights->value=$tour->tour_nnights;
                                   $node->field_tour_nights_old_remark->value=$tour->tour_nnights_rem;
                                   //$node->field_tour_old_rowid->value =$tour->tour_rowid; // No need refresh

                                   $node->field_tour_short_description->value = $tour->tour_descr;
                                    // 'field_tour_type'=>$tour->tour_type,
                                   $node->field_tour_date_remark->value = $tour->tour_date_remark;
                                  
                                   $entityArray[$tour->tour_rowid] = 'edited -  ' . implode(' , - ',$entity_ids);
                       
                      
                  } else {
             
                    $node = \Drupal::entityTypeManager()->getStorage('node')->create(
                            array('type' => 'tours',
                                    'title' => $tour->tour_name,
                                    'field_tour_name' => $tour->tour_name,
                                    'field_tour_price->value' => $tour->tour_price,                   
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
            //var_dump($data);exit;
            // Close external connection
            \Drupal\Core\Database\Database::setActiveConnection();      
            foreach ($data as $m=>$tour){
                // var_dump($tour);exit;
                $tour->new_tour_id = NULL;
                $TourDateTime = NULL;
                $newTourDateString = NULL;
                
            // Check for nid in main tours content
                  $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_rowid', $tour->td_tour);
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
    exit;              
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
