<?php
namespace Drupal\reserve\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\reserve\Entity\ReserveReservation;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides route responses for the Example module.
 */
class CalendarController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * Param: $ebundle, e.g. node.room
   *
   * @return array
   *   A simple renderable array.
   */
  public function calendar($ebundle, $selected_month = null, $selected_day = null) {
    $ebundles = reserve_get_reserve_bundles();
    if(!in_array($ebundle, $ebundles)) {
      throw new NotFoundHttpException();
    }
    else {
      return $this->getBundleCalendar($ebundle, $selected_month, $selected_day);
    }
  }

  public function calendarTitle($ebundle) {
    $bundle = ebundle_split($ebundle, 'bundle');
    return t('@bundle Calendar', array('@bundle' => ucwords($bundle)));
  }

  private function getBundleCalendar($ebundle, $selected_month = null, $selected_day = null) {
    $config = \Drupal::config('reserve.settings');
    // likely no need for this as not used anywhere else; but maybe for external modules
    global $yyyy_mmdd;

    //$entity_type = ebundle_split($ebundle, 'type');
    //$bundle = ebundle_split($ebundle, 'bundle');
    $category_field = reserve_category_fields($ebundle);

    // dates are now keyed by Cat ID; but we only need one of these to build calendar but make sure its the one which starts earliest
    $datesbycat = reserve_dates($ebundle, $selected_month, $selected_day);
    $categories = reserve_categories($ebundle);

    // allow other modules to alter the categories
    \Drupal::moduleHandler()->alter('reserve_categories', $categories);

    // if no Categories left; we should not bother with the rest of this
    if (!count($categories)) {
      drupal_set_message(t('There are no configured Reserve Categories. Please contact the System Administrator'), 'warning');
      return '';
    }

    $earliest = $this->reserve_earliest_category($categories);
    $dates = $datesbycat[$earliest];

    // Determine which day has been selected by the user. If the user has entered a url that specifies a day outside of the
    // allowable reservation window, then set the current day as the selected day.
    $yyyy_mmdd = $dates[0]['yyyymmdd'];
    foreach ($dates as $day) {
      if ($day['selected']) {
        $yyyy_mmdd = $day['yyyymmdd'];
      }
    }
    if ($yyyy_mmdd == $dates[0]['yyyymmdd']) {
      $dates[0]['selected'] = TRUE;
      $dates[0]['today'] = TRUE;
    }

    // a bit hacky; but we need to store what the calendar is using for its date so we can use this in theme functions later
    //$_SESSION['reservations_current_day'] = $yyyy_mmdd;

    // If the day being displayed is today, only display time slots that are later than the current time minus two hours.
    $today_displayed = FALSE;
    foreach ($dates as $day) {
      if (($day['selected']) && $day['today']) {
        $today_displayed = TRUE;
      }
    }
    if ($today_displayed) {
      $hours = reserve_hours('limited');
    }
    else {
      $hours = reserve_hours();
    }

    // Determine the open hours (display version) for the date selected by the user.
    $building_hours_day = reserve_facility_hours($yyyy_mmdd);
    $building_hours_display = $building_hours_day['display'];

    // For each time slot, determine if the rooms are open or closed.
    $int_first_shift_open = intval($building_hours_day['first_shift_open']);
    $int_first_shift_close = intval($building_hours_day['first_shift_close']);
    $int_second_shift_open = intval($building_hours_day['second_shift_open']);
    $int_second_shift_close = intval($building_hours_day['second_shift_close']);
    $open_24 = $building_hours_day['open_24_hours'];
    $x = 0;
    $buffer = $config->get('show_before_after_hours') * 100;
    foreach ($hours as $time_slot) {
      $int_time_slot_time = intval($time_slot['time']);
      if ($building_hours_day['open_24_hours']) {
        $time_slot['open'] = TRUE;
      }
      elseif ((($int_time_slot_time >= $int_first_shift_open) && ($int_time_slot_time < $int_first_shift_close)) ||
        (($int_time_slot_time >= $int_second_shift_open) && ($int_time_slot_time < $int_second_shift_close))) {
        $time_slot['open'] = TRUE;
      }
      else {
        $time_slot['open'] = FALSE;
      }

      // if not open ALL day let's limit display to start just before first open shift (or 2nd if only one used)
      // this assume you must have 1st shift defined and possible 2nd (i.e. can't define only 2nd shift)
      if (!$open_24 && $buffer != 300) {
        if ($int_first_shift_open < 9999 && ($hours[$x]['time'] < $int_first_shift_open - $buffer)) {
          unset($hours[$x]);
        }
        else {
          $hours[$x] = $time_slot;
        }
        // and do the same for closing
        if (isset($hours[$x])) {
          if ($int_second_shift_close < 9999) {
            if ($hours[$x]['time'] >= $int_second_shift_close + $buffer) {
              unset($hours[$x]);
            }
          }
          elseif ($int_first_shift_close < 9999) {
            if ($hours[$x]['time'] >= $int_first_shift_close + $buffer) {
              unset($hours[$x]);
            }
          }
        }
      }
      else {
        $hours[$x] = $time_slot;
      }
      $x++;
    }
    $times = reserve_times();
    $entities = reserve_entities($ebundle);

    // Initialize the $reservations array.
    $reservations = array();
    foreach ($entities as $entity) {
      $entity_name = $entity->label();
      foreach ($hours as $time_slot) {
        $time = $time_slot['time'];
        $reservations[$entity->id()][$time] = array(
          'time' => $time,
          'display' => $time_slot['display'],
          'class' => $time_slot['class'],
          'id' => '',
          'booked' => FALSE,
          'start' => FALSE,
          'end' => FALSE,
          'user' => '',
          'name' => '',
        );
      }
    }

    $results = array();
    $ids = \Drupal::service('entity.query')
      ->get('reserve_reservation')
      ->condition('status', TRUE)
      ->condition('reservation_date', $yyyy_mmdd . '%', 'like')
      ->condition('reservation_ebundle', $ebundle)
      //->sort('reservation_time', 'DESC')
      //->sort('reservations_display_order', 'ASC');
      ->accessCheck(FALSE)
      ->execute();

    $results = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->loadMultiple($ids);

    foreach ($results as $data) {
      $id = $data->id();
      $time = $data->reservation_time->getString();
      $rid = $data->reservable_id->getString();
      $name = $data->label();
      $user = $data->getOwner();
      $reservations[$rid][$time]['booked'] = TRUE;
      $reservations[$rid][$time]['class'] .= ' booked';
      $reservations[$rid][$time]['name'] = $name;
      $reservations[$rid][$time]['user_name'] = $user->getDisplayName();
      $reservations[$rid][$time]['id'] = $id;
      $reservations[$rid][$time]['series_id'] = $data->reservation_series_id->getString() ? $data->reservation_series_id->getString() : '';
      $reservations[$rid][$time]['user'] = $user->id();
      $reservations[$rid][$time]['blocked'] = $data->reservation_private->getString() ? $data->reservation_private->getString() : FALSE;

      // add rest of slots as booked for the length of this reservation
      $length = $data->reservation_length->getString();;
      $time_slots = $length / 30;
      $reservations[$rid][$time]['slots'] = $time_slots;
      $remainder = $length % 30;
      if ($remainder > 1) {
        $time_slots++;
      }
      $key = array_search($time, $times);
      $x = 2;
      while ($x <= $time_slots) {
        $key++;
        $next_time = $times[$key];
        $reservations[$rid][$next_time]['booked'] = TRUE;
        $reservations[$rid][$next_time]['class'] .= ' booked';
        $x++;
        // reservation time slots can't go passed midnight; i.e. slot 47
        if ($key == 47) {
          break;
        }
      }

      // add in pre/post buffer for setup/takedown (rev 7.x-1.3+)
      //  - if the slot is part of buffer we add "setup" to class
      //  - if we don't have admin rights; we also mark it as booked so no one can book in these slots
      $category = $categories[$entities[$rid]->$category_field->getString()];
      $preslots = $category['prebuffer'] / 30;
      $postslots = $category['postbuffer'] / 30;
      $startkey = array_search($reservations[$rid][$time]['time'], $times);
      $endkey = $startkey + $time_slots;
      $k = $startkey - $preslots;
      $bookover = \Drupal::currentUser()->hasPermission('book over reservation buffer');
      while ($k < $startkey) {
        if (!$reservations[$rid][$times[$k]]['booked']) {
          $reservations[$rid][$times[$k]]['class'] .= ' setup';
        }
        $reservations[$rid][$times[$k]]['booked'] = $bookover ? $reservations[$rid][$times[$k]]['booked'] : true;
        $k++;
      }
      $k = $endkey;
      while ($k < $endkey + $postslots) {
        if (!$reservations[$rid][$times[$k]]['booked']) {
          $reservations[$rid][$times[$k]]['class'] .= ' setup';
        }
        $reservations[$rid][$times[$k]]['booked'] = $bookover ? $reservations[$rid][$times[$k]]['booked'] : true;
        $k++;
      }
    }

    $vars = array(
      'ebundle' => $ebundle,
      'dates' => $dates,
      'categories' => $categories,
      'reservations' => $reservations,
      'hours' => $hours,
      'rooms' => $entities,
      'user_reservations' => reserve_user_reservations(),
    );

    // @todo: should do something here with render array and tpl file
    $variables = $this->calenderPage($vars);
    $variables['#theme'] = 'calendar_template';
    $variables['#attached']['library'] = 'reserve/reserve';
    $variables['#building_hours_display'] = $building_hours_display;

    return $variables;
  }

   /**
   * Theme the reservation calendar page.
   *
   * @global object $user
   *   Drupal user object.
   * @global type $base_url
   *   Application base url.
   *
   * @param array $dates
   *   An array containing information about all the possible days for which a
   *   reservtion can be made.
   * @param array $categories
   *   An array of all the room categories.
   * @param array $reservations
   *   An array representing all the reservations that have been made for the
   *   day that is being displayed on the calendar.
   * @param array $hours
   *   An array representing every half hour time slot in a single day.
   * @param string $building_hours_display
   *   A user friendly string of the open hours for the day being displayed
   *   on the calendar.
   * @param array $rooms
   *   An array representing all of the ENTITIES that can be reserved.
   * @param array $user_reservations
   *   An array representing the current user's reservations for the allowable
   *   reservation period.
   *
   * @return string
   *   The html for displaying the page.
   */
  private function calenderPage($vars) {
    /**
     * @var $ebundle
     * @var $dates
     * @var $categories
     * @var $reservations
     * @var $hours
     * @var $building_hours_display
     * @var $rooms
     * @var $user_reservations
     */
    extract($vars);

    if (!count($rooms)) {
      $this->messenger()->addError(t('You will need to first add entities which can be reserved.'));
      throw new NotFoundHttpException();
    }

    global $base_url;
    $user = \Drupal::currentUser();
    $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
    $config = \Drupal::config('reserve.settings');
    $category_field = reserve_category_fields($ebundle);
    $clearimg = '<img src="' . base_path() . drupal_get_path('module', 'reserve') . '/images/clear.png" />';
    $modal = ['attributes' => [
      'class' => ['use-ajax'],
      'data-dialog-type' => 'modal',
      'data-dialog-options' => json_encode(['width' => 700])
    ]];

    $entity_type = ebundle_split($ebundle, 'type');
    $bundle = ebundle_split($ebundle, 'bundle');

    // to support minimum adv booking per category; let's get available dates per cat
    $datespercat = reserve_dates($ebundle,null, null, true);

    // pass some variables to JS
    $format = strtolower($config->get('date_format') ? $config->get('date_format') : 'y/m/d');
    $variables['#attached']['drupalSettings']['reserve']['dateFormat'] = $format;
    $variables['#attached']['drupalSettings']['reserve']['ebundle'] = $ebundle;
    $max_length = $extended ?
      ($config->get('reservation_max_length_admin') ? $config->get('reservation_max_length_admin') : 120) :
      ($config->get('reservation_max_length_standard') ? $config->get('reservation_max_length_standard') : 120);
    $variables['#attached']['drupalSettings']['reserve']['maxLength'] = $max_length;

    // Determine which date has been selected by the user.
    foreach ($dates as $day) {
      if ($day['selected'] == TRUE) {
        $day_of_week = $day['day-of-week'];
        $month_number = $day['month-number'];
        $month = $day['month'];
        $xday = $day['day'];
        $year = $day['year'];
        $yyyymmdd = $day['yyyymmdd'];
      }
    }

    $variables['#calendar-text'] = $config->get('calendar_text');
    $variables['#reserve_room_instructions_text'] = $config->get('reserve_instructions') ? $config->get('reserve_instructions') :
      t('To make a reservation, click on the desired time/day in the calendar below. You will be asked to login.');
    $variables['#arrow'] = base_path() . drupal_get_path('module', 'reserve') . '/images/arrow-icon.png';
    $variables['#date'] = format_date(strtotime($month . ' ' . $xday . ', ' . $year), 'custom', 'l, F d, Y');
    $variables['#date_picker'] = \Drupal::formBuilder()->getForm('Drupal\reserve\Form\CalendarDatePicker');

    $field = reserve_category_fields($ebundle);
    $fconfig = \Drupal\field\Entity\FieldConfig::loadByName($entity_type, $bundle, $field)->getSettings();
    $variables['#calendar_header'] = $fconfig['calendar_header'];
    $variables['#reservation_instructions'] = $fconfig['reservation_instructions'];

    // Bundle name (or Entity Type name if no bundles)
    $bundle_info = \Drupal::service("entity_type.bundle.info")->getAllBundleInfo();
    $bundle = $bundle_info[current($rooms)->getEntityTypeId()][current($rooms)->bundle()]['label'];

    // Reservation calendar grid:
    //
    // Each block on the grid is assigned one (or more) of the following classes:
    //
    // closed - the building is closed;
    // booked - the building is open and the time slot has been reserved;
    // open - the building is open, the time slot has not been reserved, but the user must login to reserve the time slot;
    // reservable - the building is open, the time slot has not been reserved and the user is able to reserve the time slot.
    // setup - buffer zones added before/after bookings to allow for setup/takedown (per category)
    //

    // Panel container.

    // If the user is logged in, the class for each unbooked time slot is 'reservable'.  If the user is not logged in, the class is 'open'.
    // Only logged in users can click a block of time to open the reservation form.
    $unbooked_class = ($user->id()) ? 'reservable' : 'open';

    // Create a tab for each room category.  Each tab contains a grid of time slots and rooms.
    $i = 0;
    foreach ($categories as $index => $category) {
      $table = array();

      // Category TABS
      $categories[$index]['active'] = ($i == 0) ? 'active' : '';
      $categories[$index]['tag'] = strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $category['title']));

      // Show the first tab and hide all others.
      //// @todo: use JS to set active based on anchor
      $categories[$index]['show'] = ($i == 0) ? 'show' : 'hide';

      $i++;
      $r = 0; $c = 0;

      // Date and building hours.
      $flipped = $config->get('calendar_flipped');
      $orientclass = $flipped ? 'orient-horiz' : 'orient-vert';

      $table[$r][$c] = '<li class="room-info">' . $bundle . '</li>' . "\n";
      $r++;

      // Available hours column.
      foreach ($hours as $time_slot) {
        $time_display = ($time_slot['class'] == 'odd') ? t($time_slot['display']) : "";
        $table[$r][$c] = '<li class="' . $time_slot['class'] . ' timeslot" time="' . $time_slot['time'] . '">' . $time_display . '</li>' . "\n";
        $r++;
      }
      $table[$r][$c] = '<li class="room-info room-info-footer">' . $bundle . '</li>' . "\n";
      $r++;

      // Column for each room in the category.
      $rooms_per_category = 0;
      foreach ($rooms as $room) {
        $rid = $room->id();
        // Count the number of rooms in the selected category.
        if ($room->$category_field->getString() == $category['id']) {
          $rooms_per_category++;
        }
        $room_name = $room->label();
        $room_link = Link::fromTextAndUrl($room_name, Url::fromUri('internal:/' . $entity_type . '/' . $rid))->toString();

        // use qtip if we have it
        if (\Drupal::moduleHandler()->moduleExists('qtip')) {
          $variables['#room_desc'] = $room->body->getString();
          $room_info = '<span class="qtip-link"><span class="qtip-tooltip">' . $room_desc .  '</span>' . $room_link . '</span>';
        }
        else {
          $room_info = $room_link;
        }

        if ($room->$category_field->getString() == $category['id']) {
          $c++; $r = 0;

          // Room name
          $cell = '<li class="room-info">' . $room_info . '</li>';
          $r++;

          // Populate each time slot.
          foreach ($hours as $time_slot) {
            $r++;
            $time = $time_slot['time'];
            $open = $time_slot['open'];

            // lets use slot class from reservation if it is set
            $slotclass = isset($reservations[$rid][$time_slot['time']]['class']) ? $reservations[$rid][$time_slot['time']]['class'] : $time_slot['class'];

            // to support min adv booking per cat; let's simply mark all slots as closed for dates not available to this user for this cat
            if (!isset($datespercat[$category['id']][$yyyymmdd])) {
              $open = false;
            }

            // Determine if the building is open or closed for this time slot.
            if ($open) {
              $booked_class = ($reservations[$rid][$time]['booked']) ? '' : $unbooked_class;
            }
            else {
              $booked_class = 'closed';
            }
            // The time slot can be reserved by the current user.
            $viewable_class = '';
            $widthclass = '';
            if ($booked_class == 'reservable' && $user->hasPermission('add reservations')) {
              $link = Link::fromTextAndUrl(
                Markup::create($clearimg),
                Url::fromUri('internal:/reserve_reservation/add/' .
                  $month_number . '/' . $xday . '/' . $time_slot['time'] . '/' . $rid . '/' . $ebundle, $modal))
                ->toString();
            }
            // The time slot can be reserved, but the user must login first.
            elseif ($booked_class == 'open') {
              $link = Link::fromTextAndUrl(
                Markup::create($clearimg),
                Url::fromUri('internal:/user/login?destination=/reserve_reservation/add/' .
                  $month_number . '/' . $xday . '/' . $time_slot['time'] . '/' . $rid . '/' . $ebundle, $modal))
                ->toString();
            }
            elseif ($booked_class == 'closed') {
              $link = '';
            }
            else {
              // if the slot has no ID this means it is the latter slots of the booking
              $viewable_class = '';
              $link = '';

              // The time slot has a reservation that can be edited by the current user.
              if ($id = $reservations[$rid][$time]['id']) {
                $reservation = entity_load('reserve_reservation', $id);
                $viewable_class = $reservation->access('update') ? 'viewable' : '';
                if ($viewable_class == 'viewable') {
                  $options = array_merge_recursive($modal, array(
                    'attributes' => array(
                      'title' => $reservations[$rid][$time]['name'],
                      'class' => 'booking-span'),
                    'absolute' => TRUE,
                  ));
                  $link = Link::fromTextAndUrl(
                    $reservations[$rid][$time]['name'],
                    Url::fromUri('internal:/reserve_reservation/' . $id . '/edit', $options))
                    ->toString();
                }

                // The time slot has a reservation that cannot be viewed by the current user. and we are NOT allowed to see the Title
                else if (isset($reservations[$rid][$time]['blocked']) && $reservations[$rid][$time]['blocked']) {
                  $link = t('Booked');
                }

                // The time slot has a reservation that cannot be edited by the current user. but we are allowed to see the Title
                else {
                  $link = $reservations[$rid][$time]['name'];
                }
              }

              $slots = isset($reservations[$rid][$time]['slots']) ? $reservations[$rid][$time]['slots'] : '';
              $widthclass = $slots ? 'colspan' . $reservations[$rid][$time]['slots'] : '';
            }

            // allow other modules to modify the $link
            \Drupal::moduleHandler()->alter('reserve_reservations_link', $link, $reservations[$rid][$time]);

            // allow other modules to add a custom class to slots
            $custom_class = '';
            \Drupal::moduleHandler()->alter('reserve_reservations_custom_class', $custom_class, $reservations[$rid][$time]);

            // add div wrapper to display better
            $link = $link ? '<div class="booking-span">' . $link . '</div>' : '';

            // we used book class to determine if linked or not; which we needed for pre/post slots as well as actual reservation slots
            // but we don't want to show booked class now for the slots which are just buffer slots
            if (stristr($slotclass, 'setup')) {
              $booked_class = '';
            }

            if ($reservations[$rid][$time]['id']) {
              $ingroup = true;
              $numslots = $reservations[$rid][$time]['slots'];
              if ($reservations[$rid][$time]['series_id']) {
                $cell .= '<div class="reserve-group reserve-series">';
              }
              else {
                $cell .= '<div class="reserve-group">';
              }
              $numslots--;
            }

            $cell .= '<li class="' . $slotclass . ' ' . $booked_class . ' ' . $custom_class . ' ' .
              $viewable_class .  ' ' . $widthclass . '">' . $link . '</li>' . "\n";

            if (isset($ingroup) && $ingroup) {
              if ($numslots) {
                $numslots--;
              }
              else {
                $cell .= '</div>';
                $ingroup = false;
              }
            }
          }

          $table[$r][$c] = $cell;

          // Room name and capacity.
          $r++;
          $table[$r][$c] = '<li class="room-info">' . $room_info . '</li>' . "\n";

        }
      }

      // remove extra table labels based on admin setting
      $compressed = false;
      if ($config->get('calendar_compressed_labels')) {
        $compressed = true;
      }

      // dump our table contents in std or flipped orientation
      if ($flipped) {
        $table = $this->reserve_transpose($table);
        $m = $r;
        $n = $c;
      }
      else {
        $m = $c;
        $n = $r;
      }

      // @todo: this should be done as variables passed to twig
      $table_markup = '';
      for ($x = 0; $x <= $m; $x++){
        if ($flipped && $compressed && ($x == 1 || $x == $m || $x == $m - 1)) continue;
        $table_markup .= '<div class="grid-column hours-column">
          <ul>
         ';
        for ($y = 0; $y <= $n; $y++) {
          if (!$flipped && $compressed && ($y == 1 || $y == $n || $y == $n - 1)) continue;
          if (isset($table[$y][$x])) {
            $table_markup .= $table[$y][$x];
          }
        }
        $table_markup .= '</ul>
          </div>
         ';
      }

      if ($rooms_per_category) {
        $categories[$index]['table'] = Markup::create($table_markup);
      }
      else {
        $nothing_to_book = t('There are no %bundles to book in this category. You will need to assign this Reserve Category to at least 1 %bundle.',
          ['%bundles' => $bundle . 's', '%bundle' => $bundle]);
        $categories[$index]['table'] = Markup::create('<strong>' . $nothing_to_book . '</strong>' . $table_markup);
      }
    }

    $variables['#categories'] = $categories;

    // if we have no bookable entities, lets put out helpful message
    // @todo - possibly this could be done much earlier and then skip alot of the code above; but just processing empty arrays so likely not a big deal

    return $variables;
  }

  private function reserve_transpose($array) {
    array_unshift($array, null);
    return call_user_func_array('array_map', $array);
  }

  private function reserve_earliest_category($categories) {
    $earliest = 1000;
    $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
    $catmin = $extended ? 'minadvext' : 'minadvstd';
    foreach ($categories as $cat) {
      if ($cat[$catmin] < $earliest) {
        $earliest = $cat[$catmin];
        $result = $cat['id'];
      }
    }
    return $result;
  }

  public function reservationAddModalCallback() {
    $response = new jsonResponse();

    $entity = ReserveReservation::create();
    $editForm = \Drupal::service('entity.form_builder')->getForm($entity, 'default');
    $form = \Drupal::service('renderer')->renderPlain($editForm);

    $response->setData($form);

    return $response;
  }

  public function accessCalendarPage(AccountInterface $account, $ebundle) {
    return AccessResult::allowedIf($account->hasPermission('access calendar for ' . $ebundle));
  }

}
