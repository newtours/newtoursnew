<?php
namespace Drupal\tours_calendar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;
use  Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class CalendarController.
 *
 * @package Drupal\tours\Controller
 */
class CalendarController extends ControllerBase { 

    /**
     * HebCal Json url
     * @var type 
     */
    protected $_hebCalUrl = 'http://www.hebcal.com/hebcal/?v=1&cfg=json';
    
    /**
     *
     * @var type 
     */
    protected $_hebCalMajorUrl = 'https://www.hebcal.com/hebcal/?cfg=fc&v=1&i=off';
    
    /**
     * 
     */
    protected $_hebCalVar = [
        
        'year'=> 'now',  //– “now” for current year, or 4-digit YYYY such as 2003
        'month'=>'x',   //– “x” for entire Gregorian year, or use a numeric month (1=January, 6=June, etc.)
        'maj'=>'on',   //– Major holidays
        'min'=>'on',   //– Minor holidays (Tu BiShvat, Lag B’Omer, …)
        'nx'=>'on',    //– Rosh Chodesh
        'mf'=>'on',    //– Minor fasts (Ta’anit Esther, Tzom Gedaliah, …)
        'ss'=>'on',    //– Special Shabbatot (Shabbat Shekalim, Zachor, …)
        'mod'=>'on',   //– Modern holidays (Yom HaShoah, Yom HaAtzma’ut, …)
        's'=>'on',     //– Parashat ha-Shavuah on Saturday
        'c'=>'on',     //– Candle lighting times. See also candle-lighting options below.
        'm'=>50,
        'b'=>18,
        'm'=>'50',     //– Havdalah 50 minutes after sundown. Set to m=0 (zero) to disable Havdalah times
        'b'=>'18',     //– Candle-lighting time minutes before sunset
        'D'=>'on',     //– Hebrew date for dates with some event
        'd'=>'on',     //– Hebrew date for entire date range
        'o'=>'on',     //– Days of the Omer
        'geo'=>'zip',
        'zip'=>'11223'
    ];
    
    /**
     *
     * @var type 
     */
    protected $_hebCalConvert = [
        'url'=>'http://www.hebcal.com/converter/?',
        'tohebrew'=>
            'gy=%s&' .     //– Gregorian year
            'gm=%s&' . //– Gregorian month (1=January, 12=December)
            'gd=%s&' . //– Gregorian day of month
            'g2h=1&' . //– Convert from Gregorian to Hebrew date
            'gs=%s&' . //– default 'on' After sunset on Gregorian date
            'cfg=json', //– output format is JSON (cfg=json) or XML (cfg=xml)                    
        'togreg'=>
            'hy=%s&' . //– Hebrew year
            'hm=%s&' . //– Hebrew month (Nisan, Iyyar, Sivan, Tamuz, Av, Elul, Tishrei, Cheshvan, Kislev, Tevet, Shvat, Adar1, Adar2)
            'hd=%s&' . //– Hebrew day of month
            'h2g=1&' . //– Convert from Hebrew to Gregorian date
            'cfg=json' //– output format is JSON (cfg=json) or XML (cfg=xml)  
        ];
    
   /**
    * Main calendar output
   * https://www.hebcal.com/home/1223/display-a-jewish-calendar-on-your-website-with-hebcal-fullcalendar-io
   * @return type
   */  
  public function hebCalendar($view = null ) {

                $defaultView = [
                    'week'=>'basicWeek',
                    'month'=> 'month',
                    'today'=> 'basicDay',
                    //'time-month'=>'timelineMonth'
                   ];
 
      $nodeEvents = [
             "title"=>"ל״ג בעומר",
                    "url"=>"http://www.hebcal.com/holidays/lag-baomer",
                    "className"=>"holiday",
                    "hebrew"=>"ל״ג בעומר",
                    "description"=>"33rd day of counting the Omer",
                    "start"=>"2019-03-13",
                    "allDay"=>true
      ];
 
    return array(
      '#theme' => 'tours_calendar',
      //'#test_var' => $this->t('Test Value'),
      '#attached' => [
            'library' => [
                'tours_calendar/fullcalendar',
                'tours_calendar/tooltip',
                    ],
                
            'drupalSettings'=>[
                'nodeEvents'=>json_encode($nodeEvents),
                'defaultView'=>isset($defaultView[$view]) ? $defaultView[$view] : 'month',
                'nodeTest'=>'test'
            ]
          ],
    );
 
  }

    /**
     * @param $tour
     */
   public function tourCalendar($id,$params)
   {

       // Load directions
       $dates_ent_ids = $this->entityTypeManager
           ->loadByProperties([
               'type' => 'tour_dates',
               'field_tour_date_tour' => $id,
           ]);
       if (0 == count($dates_ent_ids)){
           return 'Dates not exist';
       }
       foreach ($dates_ent_ids as $key=>$value) {
           $dates[$value->field_tour_date->value]  = $key;
       }
       var_dump($dates);exit;

   }
  /**
   * Get request from calendar
   * /calendar-data?start=2018-04-29&end=2018-06-03&_=1525575676992
   * 
   * request to hebcal
   * http://zircon/calendar-data?start=2018-04-29&end=2018-06-03&_=1525575676992
   * https://www.hebcal.com/hebcal/?start=2018-04-29&end=2018-06-03&cfg=fc&v=1&i=off&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&lg=s&s=on&&c=on&geo=zip&zip=11223&city=&geonameid=&b=18&m=50&o=on
   * @param type $events
   */
    public function hebCalendarData($events = null)
    {
        $all = \Drupal::request()->query->all();
        
       if(isset($all['end']) && isset($all['start']) ) {
           $start = $all['start'];
           $end = $all['end'];
                
        } else {
            $date = new \DateTime();
            $start = $date->format('Y-m-d');
            $date->add(new \DateInterval('P1M'));
            $end = $date->format('Y-m-d');
            
        }
        
        if (!isset($events)) {
            $requestDate = 'start='. $start . '&end='  . $end;
            $hebCalUrl = 'https://www.hebcal.com/hebcal/?cfg=fc&v=1&i=off';
                           
            $hebCalUrlParameters = '&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&lg=s&s=on&&c=on&geo=zip&zip=11223&city=&geonameid=&b=18&m=50&o=on';
            $hebCalUrl =     $hebCalUrl . '&' . $requestDate . $hebCalUrlParameters; 
        //var_dump($hebCalUrl);exit;
            $hebCal = file_get_contents($hebCalUrl);
   
        //$hebCal = file_get_contents ('https://www.hebcal.com/hebcal/?start=2018-04-29&end=2018-06-03&cfg=fc&v=1&i=off&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&lg=s&s=on&&c=on&geo=zip&zip=11223&city=&geonameid=&b=18&m=50&o=on');

            return new JsonResponse(json_decode($hebCal, TRUE));
        } else {
            return new JsonResponse($this->_getCustomEvents($start,$end));
        }
        //var_dump($hebCal);
        //exit;
    }
    
    /**
     * 
     * @param type $all
     */
    protected function _getCustomEvents($start = null,$end=null)
    {
              $nodeEvents[] = [
             "title"=>"ל״ג בעומר",
                    "url"=>"http://www.hebcal.com/holidays/lag-baomer",
                    //"className"=>"holiday",
                    "hebrew"=>"ל״ג בעומר",
                    "description"=>"33rd day of counting the Omer",
                    "start"=>"2018-05-08",
                    "allDay"=>true,
                  //'color'=>'#000099',
                  'textColor'=>'#990000',
                  'backgroundColor'=>'#fff',
                  'borderColor'=>'#cecece'
            ];
              return $nodeEvents;
        
    }
    
  /**
   * Generate.
   * @param $date like 2018-04-06
   * @return string
   *   Return Hello string.
   */
  public function generateCurrentDate( $date = null, $resultArray = false) {
      date_default_timezone_set('America/New_York');

      if(isset($date)) {
          $date = new \DateTime($date); 
      } else {
          $date = new \DateTime();
      }
    //var_dump($date);exit;   
     $curDate = $date->format('Y-m-d');
  
     $curDateArray = explode('-',$curDate);
     $year = $curDateArray[0];
     $month = $curDateArray[1];
     $day = $curDateArray[2];
    $hebCalCall = $this->_hebCalUrl;
    $this->_hebCalVar['year'] = $year;
    $this->_hebCalVar['month'] = $month;
    $this->_hebCalVar['day'] = $day;
    $hebCalVars = '';
    foreach($this->_hebCalVar as $key=>$value) {
        $hebCalVars .= '&' . $key . '='.$value;
    }
    $hebCalCall = $hebCalCall . $hebCalVars;
    //var_dump($hebCalCall);exit;
    $dateData =  file_get_contents($hebCalCall,true);
    $output = json_decode($dateData); 
    $result = [];
    foreach($output->items as $key=>$value) {
        //foreach($value as $k=>$v) {
        //var_dump($key);
        //echo '<br/>';
        //var_dump($curDate);
        //var_dump($value->date);
        //var_dump($value);
        if ($value->date==$curDate or false!==strpos($value->date,$curDate)) {
               if($value->category == 'candles') {
                   $result[$curDate]['candles'] = [$value->title];
               } elseif($value->category == 'parashat'){
                   
                   $result[$curDate]['parashat'] = [
                       'hebrew'=>$value->hebrew,
                       'title'=>$value->title,
                       'torah'=>$value->leyning->torah,
                       'haftarah'=>$value->leyning->haftarah,
                   ];
               }elseif($value->category == 'holiday'){
                   $result[$curDate]['holiday'] = [
                       'hebrew'=>$value->hebrew,
                       'title'=>$value->title,
                        'yomtov'=>isset($value->yomtov) ?  $value->yomtov : false                     
                   ];
               }elseif($value->category == 'havdalah'){
                   $result[$curDate]['havdalah'] = [
                   'title'=>$value->title,
                       ];
               }elseif($value->category == 'omer'){
                   $result[$curDate]['omer'] = [
                   'title'=>$value->title,
                   'hebrew'=>$value->hebrew,
                       ];
               }
               elseif($value->category == 'hebdate'){
                   $result[$curDate]['hebdate'] = [
                   'title'=>$value->title,
                   'hebrew'=>$value->hebrew,
                       ];
               }
          //var_dump($value);
        //echo '<br/>';          
        }

        //}
        
        
    }//exit;

    return $resultArray ? $result : new JsonResponse(json_encode($result));
    //var_dump($dd);exit;
    
    
    
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: generate')
    ];
  }
  
  /**
   * 
   * https://www.hebcal.com/home/219/hebrew-date-converter-rest-api
   * https://www.hebcal.com/home/197/shabbat-times-rest-api
   * @param type $date
   */
  public function candleLight ( $date, $direction = null ) 
  {
      
      
  }
  
  /**
   * http://www.hebcal.com/converter/?cfg=json&gy=2011&gm=6&gd=2&g2h=1
   * http://www.hebcal.com/converter/?cfg=json&hy=5749&hm=Kislev&hd=25&h2g=1
   * 
   * @param string $sun 'on' or '' 
   */
  public function dateConverter ( $type = 'tohebrew',$date = NULL, $sun = ''  )
  {
     if(!isset($date)) {
          $curDate = new \DateTime(); 
          $date = $curDate->format('Y-m-d');
      } 
    //var_dump($date);exit;
      
      $dateArray = explode('-',$date);
      $year  = trim($dateArray[0],0);
      $month = trim($dateArray[1],0);
      $day   = trim($dateArray[2],0);
      
      $hebCalCall = $this->_hebCalConvert['url'];
      $reqString = sprintf($this->_hebCalConvert[$type],$year,$month,$day,$sun);
      $hebCalCall = $hebCalCall . $reqString;
      //var_dump($hebCalCall);exit;
      $dateData =  file_get_contents($hebCalCall,true);
      $output = json_decode($dateData);
      return new JsonResponse($output);
     
     
  }

    /**
     * Call sefaria to get tetxs
     * @param $title - can be Parsha like Numbers.1.1-4.20, Haftarah  like Isaiah 61:10 - 63:9 - Isaiah.61.10-63.9
     * @param string $subject
     */
  protected function _callSefaria ( $title, $subject = 'texts')
  {
      $parshaData =  file_get_contents('https://www.sefaria.org/api/'. $subject . '/'.$title,true);
      return $parshaData = json_decode($parshaData);
  }

    /**
     * @param $title
     * links
     * http://www.sefaria.org/api/links/Exodus.1.12?with_text=0 or 1
     * http://www.sefaria.org/api/index/titles
     * http://www.sefaria.org/api/index
     * http://www.sefaria.org/api/index/bereishit
     */
    protected function _callSefariaIndex ($title)
    {
        $indexSefariaData = file_get_contents('http://www.sefaria.org/api/index/titles',true);
        //svar_dump($indexSefariaData);
        foreach(json_decode($indexSefariaData) as $key=>$value) {
            echo '1 ' .$key . '<br/>';
            if (is_array($value) || is_object($value)) {
                foreach ($value as $subkey=>$subvalue){
                    if (is_array($subvalue) || is_object($subvalue)) {
                        foreach($subvalue as $sskey=>$ssvalue) {
                            echo '3 ' .$sskey . '<br/>';
                            var_dump($ssvalue);
                        }
                    } else {
                        echo '2 ' .$subkey . '<br/>';
                        var_dump($subvalue);
                    }
                }
            } else var_dump($value);
            echo '<br/>';
        }
        exit;
    }
  /**
   *  Use
   *  Project https://github.com/Sefaria/Sefaria-Project
   *
   * Descriptions here
   * https://github.com/Sefaria/Sefaria-Project/wiki/API-Documentation#index-api
   * https://www.sefaria.org/api/texts/Deuteronomy.29.9-11
   * 
   *  All source texts here https://github.com/Sefaria/Sefaria-Export
   * Torah sources here https://github.com/Sefaria/Sefaria-Export/tree/master/json/Tanakh/Torah
   *  Look also at https://halakhah.com/
   * 
   * Tehillim Psalms - https://github.com/Sefaria/Sefaria-Export/tree/master/json/Tanakh/Writings/Psalms
   * https://www.sefaria.org/Psalms?lang=bi
   *
   * Numbers.1.1-4.20
   * Isaiah 61:10 - 63:9 - Isaiah.61.10-63.9
   * @param type $parsha
   */
  public function weeklyParsha($parsha)
  {
        //$this->_createCityList();
       //$parsha = 'Numbers.1.1-4.20';
       $parshaData = $this->_callSefaria ( $parsha, 'texts');
        //$parshaData = $this->_callSefariaIndex ('');
        //var_dump($parshaData);exit;
      //$parshaData =  file_get_contents('https://www.sefaria.org/api/texts/'.$parsha,true);
      // $parshaData = json_decode($parshaData);
      $firstAvailableSectionRef = $parshaData->firstAvailableSectionRef;
      $indexTitle = $parshaData->indexTitle;
      $heIndexTitle = $parshaData->heIndexTitle;
      $heRef =   $parshaData->heRef;
      //var_dump($parshaData);exit;

      return [
          '#theme' => 'weekly_parsha',
          //'#test_var' => $this->t('Test Value'),
          '#title'=> 'Test performace API QBPL ', //.  $indexTitle . ' '  . $heIndexTitle . ' ' . $firstAvailableSectionRef . ' '. $heRef,
          '#attached' => [
              'library' => [
                  'young_calendar/tooltip',
                  'young_calendar/parsha',
              ],

              'drupalSettings'=>[
                  'parsha'=>$parshaData,
              ]
          ],
      ];


      //$output = json_decode($dateData);
      //return new JsonResponse($output);
  }

  public function todayParsha ($date)
  {
        $dayDataFromCalendar = $this->generateCurrentDate($date, true);

      if (isset($dayDataFromCalendar[$date]['parashat'])) {
          $torah = explode(' ',$dayDataFromCalendar[$date]['parashat']['torah']);
          foreach($torah as $key=>&$value) {
              if(0 == $key) $value = $value . '.';
              $value = str_replace(':','.',trim($value));
          }
          $torah = implode('',$torah);
          // Haftara
          $hafTarah = explode(' ',$dayDataFromCalendar[$date]['parashat']['haftarah']);
          // Haftara logic more comlicated, can occur symbols like II before name
          foreach($hafTarah as $key=>&$value) {
              if(0 == $key && 5 == count($hafTarah) ) {
                  $value =  $value . '_';
              }elseif(1 == $key && 5 == count($hafTarah)) {
                  $value = $value . '.';
              } elseif(0 == $key) {
                  $value = $value . '.';
              }
              $value = str_replace(':','.',trim($value));
          }
          $hafTarah = implode('',$hafTarah);

          $parshaData = $this->_callSefaria ( $torah, 'texts');
          $hafTarahData = $this->_callSefaria ( $hafTarah, 'texts');
          $torahResult = [];
          $hafTorahResult = [];
          if (isset($parshaData) && isset($parshaData->he)) {
              foreach ($parshaData->he as $key => $value) {
                  if (is_array($value)) {
                      foreach ($value as $subKey => $subValue) {
                          $torahResult['data'][] = [
                              'heb' => $subValue,
                              'eng' => $parshaData->text[$key][$subKey]
                          ];
                      }
                  } else {
                      $torahResult['data'][] = [
                          'heb' => $value,
                          'eng' => $parshaData->text[$key]
                      ];
                  }
              }
              $torahResult['titles'] = [
                  'titleEng'=>$parshaData->indexTitle,
                  'chapterEng'=>$parshaData->firstAvailableSectionRef,
                  'titleHe'=>$parshaData->heIndexTitle,
                  'chapterHe'=>$parshaData->heRef

              ];
          }
          if (isset($hafTarahData) && isset($hafTarahData->he)) {
              foreach ($hafTarahData->he as $key => $value) {
                  if (is_array($value)) {
                      foreach ($value as $subKey => $subValue) {
                          $hafTorahResult['data'][] = [
                              'heb' => $subValue,
                              'eng' => $hafTarah->text[$key][$subKey]
                          ];
                      }
                  } else {
                      $hafTorahResult['data'][] = [
                          'heb' => $value,
                          'eng' => $hafTarahData->text[$key]
                      ];
                  }

              }
              $hafTorahResult['titles'] = [
                  'titleEng'=>$hafTarahData->indexTitle,
                  'chapterEng'=>$hafTarahData->firstAvailableSectionRef,
                  'titleHe'=>$hafTarahData->heIndexTitle,
                  'chapterHe'=>$hafTarahData->heRef
              ];
          }

          //var_dump($hafTorahResult);
          //;exit;
          //return $this->weeklyParsha($torah);
          //var_dump($torah);
          //var_dump($dayDataFromCalendar[$date]['parashat']);
          //exit;
      }
      return [
          '#theme' => 'young_parsha',
          //'#test_var' => $this->t('Test Value'),
          '#parsha_data'=>$torahResult,
          '#haftarah_data' => $hafTorahResult,
          '#cache' => ['max-age' => 0,],
          '#title'=> 'Test performace API QBPL ', //.  $indexTitle . ' '  . $heIndexTitle . ' ' . $firstAvailableSectionRef . ' '. $heRef,
          '#attached' => [
              'library' => [
                  'young_calendar/tooltip',
                  //'young_calendar/parsha',
              ],
              'drupalSettings'=>[
                  'parsha'=>$torahResult,
              ]
          ],
      ];
      //var_dump($dayDataFromCalendar[$date]);exit;


  }
  
  /**
   * php function to calculate on php
   * Look at http://www.david-greve.de/luach-code/jewish-php.html
   * 
   */
  public function jewishDate ()
  {
      
      
  }
  
  
  /**
   * Creates Db records from files like cities5000.txt
   * Look at http://download.geonames.org/export/dump/
   * File cities5000.txt has 48378 records on April 6, 2018
   * 
   *  https://www.hebcal.com/home/197/shabbat-times-rest-api
   * https://www.hebcal.com/hebcal/?v=0&maj=on&min=on&nx=on&mf=on&ss=on&mod=on&i=off&year=2018&month=x&yt=G&lg=a&c=on&geo=geoname&geonameid=5128581&b=18&m=50
   * 
   * 
   */
  protected function _createCityList()
  {
      /**
       * To delete
       * count is 48378
       */
      
      /*
      echo 'start';
      $result = \Drupal::entityQuery('node')
      ->condition('type', 'cities')
      ->execute();
      //entity_delete_multiple('node', $result);exit;
      
      //$result = end($result);
      foreach($result as $key=>$value){
          entity_delete_multiple('node', [$key=>$value]);
          var_dump($value);
      }
      exit;
      */
      
      /**
       * count is 48378
       * Need to split to avoid memory errors
       */
      $txt_file = file_get_contents('cities5000.txt',true);    
      $rows        = explode("\n", $txt_file);
      //array_shift($rows);
      var_dump(count($rows));//exit;
      foreach ($rows as $row=>$data) {
           //$row_data = explode(' ', $data);
          if($row > 60000) {
           $row_data = preg_split("/[\t]/", $data);
           //var_dump($comp);exit;
                $info[$row]['type']        = 'cities';   
                $info[$row]['title']        = $row_data[1]; 
                $info[$row]['field_city_geonameid']           = $row_data[0];
                $info[$row]['field_city_name']                = $row_data[1];
                $info[$row]['field_city_alternatenames']      = $row_data[3];
                $info[$row]['field_city_latitude']            = (float) $row_data[4];
                $info[$row]['field_city_longitude']           = (float) $row_data[5];
                $info[$row]['field_city_country_code']        = $row_data[8];
                $info[$row]['field_city_elevation']           = $row_data[15];
                $info[$row]['field_city_timezone']            = $row_data[17];
                
                $node = Node::create($info[$row]);
                echo $row . ' ';
                echo ($info[$row]['title']); 
                echo '<br/>';
                $node->save();
          }    
          if ($row== 80000) exit;
                     
      //if ($row == 5 ) exit; 
      }     
      exit;
  }
  
  /**
   * http://www.hebcal.com/hebcal/?v=1&cfg=json&maj=on&min=on&mod=on&nx=on&year=now&month=x&ss=on&mf=on&c=on&geo=geoname&geonameid=3448439&m=50&s=on
   * 
   * Brooklyn 5110302
   */
  public function getCalendarData( $city = 5110302 )
  {
      
      $hebCalUrl = 'http://www.hebcal.com/hebcal/?v=1&cfg=json';
      
  }



  public function connectToNewtours() {

      //$node = \Drupal::entityTypeManager()->getStorage('node')->create(array('type' => 'tours', 'title' => 'Another node'));
      //$node->save();
      //var_dump($node);
  \Drupal\Core\Database\Database::setActiveConnection('external');
  $db = \Drupal\Core\Database\Database::getConnection();
  
  $data = $db->select('tours','t')->fields('t')->execute();
   $result = array();
   
//$categories_vocabulary = 'tour_directions';
   
  foreach ($data as $m=>$tour){
             
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
       
      
               $query = \Drupal::service('entity.query')
                                    ->get('node')
                                    ->condition('field_tour_old_id', $tour->tour_rowid);
                $entity_ids = $query->execute();
                if ($entity_ids) $node->save($entity_ids); 
                else $node->save(); 
                $entityArray[] = $entity_ids;
               
               
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
         
         return [
                '#theme'=>'young_draft_carousel',
                '#attached' => [
                    'library' => [
                        'young/wishlist-carousel',
                    ],
                ]
         ];
         
         
     } 
       
}
