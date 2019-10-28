<?php
/**
 * @file
 * Classes and general Room Reservations helper functions.
 */

/**
 * Create an array of all the reserve categories.
 *
 * @param $ebundle
 *
 * @return array
 *    if $ebundle = null: An array representing all the categories.
 *    else categories for this bundle
 */
function reserve_categories($ebundle = null) {
  $categories = array();

  // if ebundle is set we don't need to query db as we can get info from field settings
  if ($ebundle) {
    $entity_type = ebundle_split($ebundle, 'type');
    $bundle = ebundle_split($ebundle, 'bundle');
    $field = reserve_category_fields($ebundle);
    $fconfig = \Drupal\field\Entity\FieldConfig::loadByName($entity_type, $bundle, $field)->getSettings();
    $ids = array_filter($fconfig['categories']);
  }
  else {
    $ids = Drupal::service('entity.query')
      ->get('reserve_category')
      ->condition('status', TRUE)
      //->sort('reserve_display_order', 'ASC')
      ->execute();
  }

  $cats = \Drupal::entityTypeManager()->getStorage('reserve_category')->loadMultiple($ids);
  foreach ($cats as $cat) {
    $categories[$cat->id()] = array(
      'id' => $cat->id(),
      'title' => $cat->label(),
      'prebuffer' => $cat->reserve_setup_buffer->getString() ? $cat->reserve_setup_buffer->getString() : 0,
      'postbuffer' => $cat->reserve_takedown_buffer->getString() ? $cat->reserve_takedown_buffer->getString() : 0,
      'minadvstd' => $cat->reserve_minadv_std->getString() ? $cat->reserve_minadv_std->getString() : 0,
      'minadvext' => $cat->reserve_minadv_ext->getString() ? $cat->reserve_minadv_ext->getString() : 0,
      'maxadvstd' => $cat->reserve_maxadv_std->getString() ? $cat->reserve_maxadv_std->getString() : 14,
      'maxadvext' => $cat->reserve_maxadv_ext->getString() ? $cat->reserve_maxadv_ext->getString() : 180,
    );
  }

  return $categories;
}

/**
 * Retrieve all the reservable entities from the database of a certain bundle.
 *
 *
 * @return array
 *   An array with each element representing a reservable entity.
 */
function reserve_entities($ebundle) {
  $entity_type = ebundle_split($ebundle, 'type');
  $bundle = ebundle_split($ebundle, 'bundle');
  $query = Drupal::service('entity.query')
    ->get($entity_type)
    ->condition('status', TRUE);

  if ($entity_type != $bundle) {
    $query->condition('type', $bundle);
  }

    //->sort('reservations_display_order', 'ASC')
  $ids = $query->execute();

  $entities = \Drupal::entityTypeManager()->getStorage($entity_type)->loadMultiple($ids);

  return $entities;
}

/**
 * Determine the list of next 12 months.
 *
 * @return array
 *   Each element represents a month.
 *
 */
function reserve_current_months() {
  $advance_days = 365;
  $found = false;
  for ($x = 0; $x < $advance_days; $x++) {
    if (date('m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y"))) != $found) {
      $months[date('Y-m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")))]['m'] = date('n', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")));
      $months[date('Y-m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")))]['mm'] = date('m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")));
      $months[date('Y-m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")))]['y'] = date('Y', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")));
      $found = date('m', mktime(0, 0, 0, date("m"), date("d") + $x, date("Y")));
    }
  }

  // Note:  Month names are translated when they are displayed.
  $names = array(
    'Unused',
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  );

  foreach ($months as $month) {
    $item['display'] = $names[$month['m']] . ' ' . $month['y'];
    $item['year'] = $month['y'];
    $item['month'] = $month['m'];
    $item['MM'] = $month['mm'];
    $item['YYYY_MM'] = $month['y'] . '_' . $month['mm'];
    $results[] = $item;
  }
  return $results;
}

/**
 * Returns default daily open hours for the month.
 *
 * @param int $year
 *   The year of the month being represented.
 * @param int $month
 *   The year and month of the month being represented in format YYYY_MM.
 *
 * @return object
 *   An array detailing the DEFAULT open slots for each day of a given month
 */
function reserve_default_monthly_hours($year, $month) {
  $mo_hours = array();

  // Days in the month.
  $days = date('t', mktime(0, 0, 0, $month, 1, $year));

  $default_hours = \Drupal::config('reserve.default_hours')->get('data');
  if (!$default_hours) {
    for ($x = 0; $x < $days; $x++) {
      $mo_hours[] = 'D';
      $mo_hours[] = '9999';
      $mo_hours[] = '9999';
      $mo_hours[] = '9999';
      $mo_hours[] = '9999';
    }
  }
  else {
    for ($x = 0; $x < $days; $x++) {
      // Day of week.
      $dow = date('w', mktime(0, 0, 0, $month, $x + 1, $year));
      $mo_hours[] = 'D';
      $mo_hours[] = $default_hours[$dow * 4];
      $mo_hours[] = $default_hours[($dow * 4) + 1];
      $mo_hours[] = $default_hours[($dow * 4) + 2];
      $mo_hours[] = $default_hours[($dow * 4) + 3];
    }
  }

  return $mo_hours;
}

/**
 * Create reservations dates array.
 *
 * Create an array containing pertinent information about all the
 * possible days for which a reservation can be made.
 *
 * 7.x-1.3 REV:
 *  - start of adding features on a per Category basis
 *  - for now let's just key this date's array by Cat ID
 *
 * @param int $selected_month
 *   The month of the day currently selected by the user
 * @param int $selected_day
 *   The day of the month of the day currently selected by the user.
 *
 * @return array
 *   Information about each day for which a reservation can be made, including
 *   display name, day of the week, month name and number, day of the month,
 *   date in the format YYYY-MM-DD, whether the day is currently selected by
 *   the user, and whether the day is today.
 */
function reserve_dates($ebundle = null, $selected_month = NULL, $selected_day = NULL, $keyed = false) {
  $config = \Drupal::config('reserve.settings');
  // Determine date information (month, day, year, etc.) for each of these days.
  $categories = reserve_categories($ebundle);
  $dates = array();
  foreach ($categories as $cat) {
    $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
    $advancedaysmax = $extended ? $cat['maxadvext'] : $cat['maxadvstd'];
    $advancedaysmin = $extended ? $cat['minadvext'] : $cat['minadvstd'];
    for ($j = $advancedaysmin; $j < $advancedaysmax; $j++) {
      $day = array();
      $day['display'] = date("l, n/j", strtotime("now + " . $j . " days"));
      $day['day-of-week'] = date("l", strtotime("now + " . $j . " days"));
      $day['month'] = date("F", strtotime("now + " . $j . " days"));
      $month_number = date("n", strtotime("now + " . $j . " days"));
      $day['month-number'] = $month_number;
      $sday = date("j", strtotime("now + " . $j . " days"));
      $day['day'] = $sday;
      $year = date("Y", strtotime("now + " . $j . " days"));
      $day['year'] = $year;
      // Determine the date selected by the user.  If none selected, default to the first day.
      if (($j == 0) && (!$selected_month) && (!$selected_day)) {
        $day['selected'] = TRUE;
      }
      elseif (($selected_month == $month_number) && ($selected_day == $sday)) {
        $day['selected'] = TRUE;
      }
      else {
        $day['selected'] = FALSE;
      }
      // The date in YYYY-MM-DD format.
      if ($month_number < 10) {
        $month_number = str_pad($month_number, 2, '0', STR_PAD_LEFT);
      }
      if ($sday < 10) {
        $sday = str_pad($sday, 2, '0', STR_PAD_LEFT);
      }
      $day['yyyymmdd'] = $year . "-" . $month_number . "-" . $sday;
      $day['today'] = (($day['month-number'] == date('m')) &&
        ($day['day'] == date('j'))) ? TRUE : FALSE;
      if ($keyed) {
        $dates[$cat['id']][$day['yyyymmdd']] = $day;
      }
      else {
        $dates[$cat['id']][] = $day;
      }
    }
  }
  return $dates;
}

/**
 * Create an array representing every half hour time slot in a single day.
 *
 * @param string $option
 *   If set to 'limited', only include time slots in the array that are
 *   later in the day than the current time minus the longest possible
 *   reservation length.
 *
 * @return array
 *   An array representing reservable time slots in a single day.
 */
function reserve_hours($option = NULL) {
  $config = \Drupal::config('reserve.settings');
  $hours = array();
  $x = 0;
  $y = 0;
  while ($x <= 23) {
    $hours_entry = array();
    $hour = ($x < 10) ? '0' . $x : $x;
    if ($x == 0) {
      $display_hour = 12;
    }
    elseif ($x <= 12) {
      $display_hour = $x;
    }
    else {
      $display_hour = $x - 12;
    }
    $minutes = ($y % 2) ? '30' : '00';
    $time = $hour . $minutes;
    $ampm = ($y < 24) ? t('AM') : t('PM');
    if ($y == 0) {
      // these shouldn't be wrapped in t() since we are just about to do a date() with them anyway
      $display = 'Midnight';
    }
    elseif ($y == 24) {
      $display = 'Noon';
    }
    else {
      $display = $display_hour . ':' . $minutes . ' ' . $ampm;
    }

    // convert display to 24:00 format if required
    if ($config->get('reserve_hour_format')) {
      $display = date('H:i', strtotime($display));
    }

    $class = ($y % 2) ? 'even' : 'odd';
    $hours_node_time = $display_hour . ':' . $minutes . $ampm;
    $hours_entry['time'] = $time;
    $hours_entry['display'] = $display;
    $hours_entry['hours node time'] = $hours_node_time;
    $hours_entry['class'] = $class;
    $hours_entry['open'] = TRUE;
    $hours[] = $hours_entry;
    if ($y % 2) {
      $x++;
    }
    $y++;
  }

  // Only return time slots that are greater than the current time minus the maximum reservation length.
  $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
  if ($option == 'limited') {
    $max_length = $extended ? $config->get('reservation_max_length_extended') : $config->get('reservation_max_length_standard');
    $margin_time = ($max_length / 60) * 100;
    if ($max_length % 60) {
      $margin_time += 30;
    }
    $str_current_time = date('H') . date('i');
    $int_current_time = intval($str_current_time);
    $cutoff_time = $int_current_time - $margin_time;
    $cutoff_time = ($cutoff_time < 0) ? 0 : $cutoff_time;
    $limited_hours = array();
    foreach ($hours as $time_slot) {
      $time_slot_time = intval($time_slot['time']);
      if ($time_slot_time > $cutoff_time) {
        $limited_hours[] = $time_slot;
      }
    }
    return $limited_hours;
  }
  else {
    return $hours;
  }
}

/**
 * Create open hours array.
 *
 * Create an array of open hours information for the day in question.

 *
 * D8 - add passing DATE parameter as is is used in functions like reserve_valid_lengths and only needs for the day
 * D8 - actually, i don't see anywhere that full date range is required; so let's remove all the code for that
 *
 * @todo: this needs to be cached
 *
 * @return array
 *   An array representing information about the facility's open hours for that day, such
 *   as whether the facility is open that day, the number of open shifts,
 *   open and close hours, and a string that can be used to display the hours
 *   in a user friendly way.
 */
function reserve_facility_hours($date, $reset = FALSE) {
  $monthly_hours = \Drupal::config('reserve.monthly_hours');
  static $building_hours;
  if (!isset($building_hours[$date]) || $reset) {
    $building_hours = array();

    $month = date('Y_m', strtotime($date));
    $day = date('j', strtotime($date));
    $mo_hours = $monthly_hours->get($month);

    if (!$mo_hours) {
      $m = intval(substr($month, 5));
      $year = substr($month, 0, 4);
      $mo_hours = reserve_default_monthly_hours($year, $m);
    }
    
    $start = ($day - 1) * 5; 
    $first_shift_open = $mo_hours[$start + 1];
    $first_shift_close = $mo_hours[$start + 2];
    $second_shift_open = $mo_hours[$start + 3];
    $second_shift_close = $mo_hours[$start + 4];
    if (($first_shift_open == '9999') && ($first_shift_close == '9999') && ($second_shift_open == '9999') && ($second_shift_close == '9999')) {
      $open = FALSE;
    }
    else {
      $open = TRUE;
    }
    if (($open) && ($first_shift_open == '0000') && ($first_shift_close == '2400')) {
      $open_24_hours = TRUE;
    }
    else {
      $open_24_hours = FALSE;
    }
    if (!$open) {
      $shifts = 0;
    }
    elseif ($open_24_hours) {
      $shifts = 1;
    }
    elseif (($open) && ($second_shift_open == '9999') && ($second_shift_close == '9999')) {
      $shifts = 1;
    }
    else {
      $shifts = 2;
    }
    $day_hours = array(
      $first_shift_open,
      $first_shift_close,
      $second_shift_open,
      $second_shift_close,
    );
    $display = reserve_hours_display($day_hours);
    $hours_data = array(
      'open' => $open,
      'open_24_hours' => $open_24_hours,
      'shifts' => $shifts,
      'first_shift_open' => $first_shift_open,
      'first_shift_close' => $first_shift_close,
      'second_shift_open' => $second_shift_open,
      'second_shift_close' => $second_shift_close,
      'display' => $display,
    );
    $building_hours[$date] = $hours_data;
  }

  return $building_hours[$date];
}


/**
 * Creates a string for displaying the open hours for a single day.
 *
 * @param array $day_hours
 *   An array that represents the openning and closing hours for two
 *   separate shifts in a single day
 *
 * @return string
 *   A string that can be used to display the hours for a single day, such as
 *   'Open 24 Hours' or 'Noon - 6:00 PM'.
 */
function reserve_hours_display($day_hours) {
  $first_shift_open = $day_hours[0];
  $first_shift_close = $day_hours[1];
  $second_shift_open = $day_hours[2];
  $second_shift_close = $day_hours[3];
  // Closed.
  if (($first_shift_open == '9999') &&
    ($first_shift_close == '9999') &&
    ($second_shift_open == '9999') &&
    ($second_shift_close == '9999')) {
    return 'Closed';
  }
  // Open 24 hours.
  if (($first_shift_open == '0000') &&
    ($first_shift_close == '2400')) {
    return 'Open 24 Hours';
  }
  // One shift.
  if (($second_shift_open == '9999') &&
    ($second_shift_close == '9999')) {
    $first_shift_open_display
      = reserve_display_time($first_shift_open);
    $first_shift_close_display
      = reserve_display_time($first_shift_close);
    return $first_shift_open_display . ' - ' .
      $first_shift_close_display;
  }
  // Two shifts.
  $first_shift_open_display
    = reserve_display_time($first_shift_open);
  $first_shift_close_display
    = reserve_display_time($first_shift_close);
  $second_shift_open_display
    = reserve_display_time($second_shift_open);
  $second_shift_close_display
    = reserve_display_time($second_shift_close);
  return $first_shift_open_display . ' - ' .
    $first_shift_close_display . ' and ' .
    $second_shift_open_display . ' - ' .
    $second_shift_close_display;
}

/**
 * Create time slot array.
 *
 * Create an array with each element representing one of the 48 half hour time
 * slots that make up a day.
 *
 * @return array
 *   An array with each element representing a half hour time slot.
 */
function reserve_times() {
  $times = array();
  $hours = reserve_hours();
  foreach ($hours as $hour) {
    $times[] = $hour['time'];
  }
  return $times;
}

/**
 * Return time in display format.
 *
 * This function returns the time in display format (Midnight, 12:30 AM,
 * 1:00 AM, etc.)  for any time slot of the day given in military time
 * format (0000, 0030, 0100, etc.).
 *
 * @param string $military_time
 *   Time of day represented in four digit military time.
 *
 * @return string
 *   Time of day represented as HH:MM AM.
 */
function reserve_display_time($military_time) {
  $hours = reserve_hours();
  $hours[] = array(
    'time' => '2400',
    'display' => 'Midnight',
  );
  foreach ($hours as $hour) {
    $time = $hour['time'];
    if ($time == $military_time) {
      return $hour['display'];
    }
  }
  return '';
}

/**
 * Determine closing times.
 *
 * Determines which half hour time slots represent the last ones before the
 * building closes.
 *
 * @param string $yyyy_mmdd
 *   The date for which close times are being determine, in the format
 *   YYYY-MM-DD.
 *
 * @return array
 *   An array representing the time slots just before closing.  The array can
 *   contain 0, 1, or 2 items.
 */
function reserve_close_times($yyyy_mmdd) {
  $closing_times = array();
  $reserve_building_hours = reserve_facility_hours($yyyy_mmdd);
  $building_hours_day = $reserve_building_hours;
  // 24 hours.
  if ($building_hours_day['open_24_hours']) {
    $next_day = date('Y-m-d', strtotime("$yyyy_mmdd +1 days"));
    $next_day_first_time_slot_open
      = reserve_first_slot_open($next_day);
    if (!$next_day_first_time_slot_open) {
      $closing_times[] = '2330';
    }
    return $closing_times;
  }
  // First shift ends at midnight.
  if ($building_hours_day['first_shift_close'] === '2400') {
    $next_day = date('Y-m-d', strtotime("$yyyy_mmdd +1 days"));
    $next_day_first_time_slot_open
      = reserve_first_slot_open($next_day);
    if (!$next_day_first_time_slot_open) {
      $closing_times[] = '2330';
    }
    return $closing_times;
  }
  // First shift does not end at midnight.
  $time = $building_hours_day['first_shift_close'];
  $hours = reserve_hours();
  $time_found = FALSE;
  while (!$time_found) {
    $time_slot = array_pop($hours);
    if ($time_slot['time'] == $time) {
      $time_found = TRUE;
    }
  }
  $time_slot = array_pop($hours);
  $int_second_shift_close = intval($building_hours_day['second_shift_close']);
  $closing_times[] = $time_slot['time'];
  // Second shift ends at midnight.
  if (($building_hours_day['shifts'] == 2) &&
    ($int_second_shift_close == 2400)) {
    $next_day = date('Y-m-d', strtotime("$yyyy_mmdd +1 days"));
    $next_day_first_time_slot_open
      = reserve_first_slot_open($next_day);
    if (!$next_day_first_time_slot_open) {
      $closing_times[] = '2330';
    }
  }
  // Second shift does not end at midnight.
  if (($building_hours_day['shifts'] == 2) &&
    ($int_second_shift_close < 2400)) {
    $time = $building_hours_day['second_shift_close'];
    $hours = reserve_hours();
    $time_found = FALSE;
    while (!$time_found) {
      $time_slot = array_pop($hours);
      if ($time_slot['time'] == $time) {
        $time_found = TRUE;
      }
    }
    $time_slot = array_pop($hours);
    $closing_times[] = $time_slot['time'];
  }
  return $closing_times;
}

/**
 * Determine if facility is open from midnight to 12:30 AM.
 *
 * Determines if the facility is open during the first half hour of the day,
 * from midnight to 12:30 AM.  This information is needed when determining if
 * any particular half hour time slot is the last one before the building
 * closes.
 *
 * @param string $yyyy_mmdd
 *   The date being examined, in the format YYYY-MM-DD.
 *
 * @return bool
 *   TRUE - The facility is open during the first half hour of the day.
 *   FALSE - The facility is not open during the first half hour of the day.
 */
function reserve_first_slot_open($yyyy_mmdd) {
  $reserve_building_hours = reserve_facility_hours($yyyy_mmdd);
  $building_hours_day = $reserve_building_hours;
  if (!$building_hours_day['open']) {
    return FALSE;
  }
  if ($building_hours_day['open_24_hours']) {
    return TRUE;
  }
  if ($building_hours_day['first_shift_open'] == '0000') {
    return TRUE;
  }
  return FALSE;
}

/**
 *
 * NOTE  - not currently used in D8 port
 *
 * Determine reservation start conflicts.
 *
 * Determines if a new reservation room, date and start time conflicts with a
 * previously existing reservation.
 *
 * @param string $room
 *   The room that is being reserved.
 * @param string $yyyy_mmdd
 *   The date of the start time for the reservation, in the format 'yyyy-mm-dd'.
 * @param string $time
 *   The start time for the reservation, in military time.  9:00 AM is
 *   represented as '0900', and 9:00 PM is represented as '2100'.
 *
 * @return bool
 *   TRUE - A scheduling conflict was found.
 *   FALSE - A scheduling conflict was not found.
 */
function reserve_start_conflicts($room, $yyyy_mmdd, $time) {
  $config = \Drupal::config('reserve.settings');

  // Previous and next days.
  $previous_day = date('Y-m-d', strtotime("$yyyy_mmdd -1 days"));
  // Start times of other reservations that could conflict with this one.
  $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
  $max_length = $extended ? $config->get('reservation_max_length_extended') : $config->get('reservation_max_length_standard');
  $max_slots = $max_length / 30;
  $search_items = array();
  for ($x = 0; $x < 8; $x++) {
    $search_items = array(
      'date' => '1999-01-01',
      'start_time' => '9999',
      'length' => 999,
    );
  }
  $day = $yyyy_mmdd;
  $hours = reserve_hours();
  $time_found = FALSE;
  $time_slot = NULL;
  while (!$time_found) {
    $time_slot = array_pop($hours);
    if ($time_slot['time'] == $time) {
      $time_found = TRUE;
    }
  }
  for ($x = 0; $x < $max_slots; $x++) {
    if ($time_slot == NULL) {
      $day = $previous_day;
      $hours = reserve_hours();
      $time_slot = array_pop($hours);
    }
    $search_item['date'] = $day;
    $search_item['start_time'] = $time_slot['time'];
    $search_item['length'] = 30 * $x;
    $search_items[] = $search_item;
    $time_slot = array_pop($hours);
  }
  $sql = "
    SELECT id FROM {room_reservations}
    WHERE (
    (deleted = 'N' AND room = :room AND date = :date0 AND	time = :time0 AND length > :length0)
    OR
    (deleted = 'N' AND room = :room AND date = :date1 AND	time = :time1 AND length > :length1)
    OR
    (deleted = 'N' AND room = :room AND date = :date2 AND	time = :time2 AND length > :length2)
    OR
    (deleted = 'N' AND room = :room AND date = :date3 AND	time = :time3 AND length > :length3)
    OR
    (deleted = 'N' AND room = :room AND date = :date4 AND	time = :time4 AND length > :length4)
    OR
    (deleted = 'N' AND room = :room AND date = :date5 AND	time = :time5 AND length > :length5)
    OR
    (deleted = 'N' AND room = :room AND date = :date6 AND	time = :time6 AND length > :length6)
    OR
    (deleted = 'N' AND room = :room AND date = :date7 AND	time = :time7 AND length > :length7)
    )
  ";
  $conflicts_found = FALSE;
  $conflicts_found = db_query($sql, array(
      ':room' => $room,
      ':date0' => $search_items[0]['date'], ':time0' => $search_items[0]['start_time'], ':length0' => $search_items[0]['length'],
      ':date1' => $search_items[1]['date'], ':time1' => $search_items[1]['start_time'], ':length1' => $search_items[1]['length'],
      ':date2' => $search_items[2]['date'], ':time2' => $search_items[2]['start_time'], ':length2' => $search_items[2]['length'],
      ':date3' => $search_items[3]['date'], ':time3' => $search_items[3]['start_time'], ':length3' => $search_items[3]['length'],
      ':date4' => $search_items[4]['date'], ':time4' => $search_items[4]['start_time'], ':length4' => $search_items[4]['length'],
      ':date5' => $search_items[5]['date'], ':time5' => $search_items[5]['start_time'], ':length5' => $search_items[5]['length'],
      ':date6' => $search_items[6]['date'], ':time6' => $search_items[6]['start_time'], ':length6' => $search_items[6]['length'],
      ':date7' => $search_items[7]['date'], ':time7' => $search_items[7]['start_time'], ':length7' => $search_items[7]['length'])
  )->rowCount();
  return $conflicts_found;
}

/**
 * Determine valid reservation lengths of time.
 *
 * Determines which lengths of time are valid for a reservation for a particular
 * room starting at particular time.  Valid lengths are limited by the
 * following:
 * (1)  Previously scheduled reservations.
 * (2)  Building close times.
 * (3)  Last time slot of the day.  Reservations possibly end 15 minutes before
 * the building closes.
 *
 * @param string $room
 *   The room that is being reserved.
 * @param string $yyyy_mmdd
 *   The date of the start time for the reservation, in the format 'yyyy-mm-dd'.
 * @param string $time
 *   The start time for the reservation, in military time.
 *   9:00 AM is represented as '0900', and 9:00 PM is represented as '2100'.
 * @param int $id
 *   The id of the reservation being made.
 * @param int $all
 *   By default we do not check the first time slot since it should be true or we wouldn't have been able to pick it on calendar
 *    but, for repeating reserverations we need to check all slots.
 *
 * @return array
 *   An array with an element for each possible reservation length of time,
 *   and an indicator showing whether that particular length is valid for the
 *   reservation being made.
 */
function reserve_valid_lengths($rid, $ebundle, $yyyy_mmdd, $time, $id = NULL, $all = FALSE) {
  $config = \Drupal::config('reserve.settings');

  // @todo: should make a small file with replacements for simple D7 functions like l, arg, etc
  $current_path = \Drupal::service('path.current')->getPath();
  $path_args = explode('/', $current_path);

  // let's first ensure this is a valid RID
  $rooms = reserve_entities($ebundle);
  if (!isset($rooms[$rid])) {
    return null;
  }

  $extended = \Drupal::currentUser()->hasPermission('add reservations extended');
  $max_length = $extended ?
    ($config->get('reservation_max_length_extended') ? $config->get('reservation_max_length_extended') : 120) :
    ($config->get('reservation_max_length_standard') ? $config->get('reservation_max_length_standard') : 120);
  $max_slots = $max_length / 30;
  $valid_lengths = array();
  for ($x = 30; $x <= $max_length; $x += 30) {
    $valid_lengths[] = array(
      'length' => $x,
      'is_valid' => TRUE,
    );
  }
  // Divide the maximum reservation length into 30 minute time slots and determine the start date and time of each of these slots.
  $search_items = array();
  // Time slots for the first day.
  $day = $yyyy_mmdd;
  $hours = reserve_hours();
  $x = 0;
  $include = FALSE;
  foreach ($hours as $time_slot) {
    if ($time_slot['time'] == $time) {
      $include = TRUE;
    }
    if ($include) {
      $search_item['date'] = $day;
      $search_item['start_time'] = $time_slot['time'];
      $search_items[] = $search_item;
      $x++;
    }
    if ($x == $max_slots) {
      $include = FALSE;
      break;
    }
  }

  // Determine if the reservation at each possible length would conflict with another reservation.  If so, set is_valid for that length to FALSE.
  // The first time slot has already been validated and does not need to be checked again.
  if ($all) {
    $start = 0;
  }
  else {
    $start = 1;
  }
  for ($x = $start; $x < $max_slots; $x++) {
    $valid_length = $valid_lengths[$x];
    if ($valid_length['is_valid']) {
      $search_item = $search_items[$x];
      $date = $search_item['date'];
      $start_time = $search_item['start_time'];

      $conflicts_found = false;

      $query = Drupal::service('entity.query')
        ->get('reserve_reservation')
        ->condition('reservation_date', $date . '%', 'LIKE')
        ->condition('reservation_time', $start_time)
        ->condition('reservable_id', $rid)
        ->accessCheck(FALSE);
        //->sort('reserve_display_order', 'ASC');

      // if editing a reservation (series) we need to not include any of the reservations in current series
      $group = NULL;
      if ($path_args[3] == 'edit') {
        $eid = $path_args[2];
        $res = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->load($eid);

        if ($sid = $res->reservation_series_id->getString()) {
          $group = $query->orConditionGroup()
            ->notExists('reservation_series_id')
            ->condition('reservation_series_id', $sid, '<>');
        }
      }

      if ($group) {
        $ids = $query->condition($group)->execute();
      }
      else {
        $ids = $query->execute();
      }
      $reservations = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->loadMultiple($ids);
      if (count($reservations)) {
        $conflicts_found = true;
        for ($y = $x; $y < $max_slots; $y++) {
          $valid_lengths[$y]['is_valid'] = FALSE;
        }
      }
    }
  }
  // need to limit these valid lengths by a prebuffer if it exists for the category this room is in
  // but only if not permissions to do this
  if (!\Drupal::currentUser()->hasPermission('book over buffer')) {
    $categories = reserve_categories();
    $rooms = reserve_entities($ebundle);
    $categoryField = reserve_get_ebundle_category_field($ebundle);
    $category = $categories[$rooms[$rid]->get($categoryField)->getString()];
    $preslots = $category['prebuffer'] / 30;
    if ($preslots) {
      foreach ($valid_lengths as $index => $length) {
        if ($length['is_valid'] == false) {
          $last = $index;
          break;
        }
      }
      if (isset($last)) {
        for ($x = $last - $preslots; $x <= $last; $x++) {
          $valid_lengths[$x]['is_valid'] = false;
        }
      }
    }
  }

  // Determine if the reservation at each possible length would conflict with the hours that the building
  // is closed.  If so, set is_valid for that length to FALSE.  The first time slot has already been
  // validated and does not need to be checked again.
  $building_hours_day = reserve_facility_hours($day);
  for ($x = 0; $x < $max_slots; $x++) {
    $valid_length = $valid_lengths[$x];
    if ($valid_length['is_valid']) {
      $conflicts_found = FALSE;
      $search_item = $search_items[$x];
      $date = $search_item['date'];
      $start_time = $search_item['start_time'];
      // If building is closed, set conflict flag.
      if (!$building_hours_day['open']) {
        $conflicts_found = TRUE;
      }
      $int_start_time = intval($start_time);
      $int_first_shift_open = intval($building_hours_day['first_shift_open']);
      $int_first_shift_close = intval($building_hours_day['first_shift_close']);
      // One shift.
      if ((!$building_hours_day['open_24_hours']) && ($building_hours_day['shifts'] == 1) &&
        (($int_start_time < $int_first_shift_open) || ($int_start_time >= $int_first_shift_close))) {
        $conflicts_found = TRUE;
      }
      // Two shifts.
      $int_second_shift_open = intval($building_hours_day['second_shift_open']);
      $int_second_shift_close = intval($building_hours_day['second_shift_close']);
      if ((!$building_hours_day['open_24_hours']) &&
        ($building_hours_day['shifts'] == 2) &&
        (($int_start_time < $int_first_shift_open) ||
          (($int_start_time >= $int_first_shift_close) &&
            ($int_start_time < $int_second_shift_open)) ||
          ($int_start_time >= $int_second_shift_close))
      ) {
        $conflicts_found = TRUE;
      }
      if ($conflicts_found) {
        for ($y = $x; $y < $max_slots; $y++) {
          $valid_lengths[$y]['is_valid'] = FALSE;
        }
      }
    }
  }

  return $valid_lengths;
}

/**
 * Determine if the user has exceeded the maximum reservations per day.
 *
 * @global object $user
 *   Drupal user object.
 *
 * @param string $yyyy_mmdd
 *   The date for which maximum allowable reservations are being checked, in
 *   the format YYYY-MM-DD.
 *
 * @return bool
 *   TRUE - the maximum has been exceeded.
 *   FALSE - the maximum has not been exceeded.
 */
function reserve_daily_max_exceeded($yyyy_mmdd) {
  global $user;
  $config = \Drupal::config('reserve.settings');

  $max = $config->get('reservations_per_day');
  if (!$max) {
    return FALSE;
  }

  $record_count = 0;
  if ($user->uid) {
    $ids = \Drupal::service('entity.query')
      ->get('reserve_reservation')
      ->condition('user_id', $user->id)
      ->condition('reservation_date', 'value', $yyyy_mmdd . '%', 'like')
      ->execute();
    $record_count = count($ids);
  }

  if ($record_count < $max) {
    return FALSE;
  }
  else {
    return TRUE;
  }
}


/**
 * Find the current user's reservations for the next 14 days.
 *
 * @global object $user
 *   A Drupal user object.
 *
 * @return array
 *   An array with each element representing one reservation that the user has
 *   made.
 */
function reserve_user_reservations() {
  $user_reservations = array();
  $all_hours = reserve_hours();
  $user = \Drupal::currentUser();
  if ($user->id()) {
    $earliest_date = date('Y-m-d', strtotime(date('Y-m-d')));
    $latest_date = date('Y-m-d', strtotime("now +13 days"));

    $ids = \Drupal::service('entity.query')
      ->get('reserve_reservation')
      ->condition('user_id', $user->id())
      ->condition('reservation_date', $earliest_date, '>=')
      ->condition('reservation_date', $latest_date, '<=')
      ->sort('reservation_date', 'DESC')
      ->sort('reservation_time', 'DESC')
      ->execute();
    $results = \Drupal::entityTypeManager()->getStorage('reserve_reservation')->loadMultiple($ids);

    foreach ($results as $data) {
      $reservation = array();
      $reservation['id'] = $data->id();
      $unix_timestamp = strtotime($data->reservation_date->getString());
      $reservation['date'] = date("l, n/j", $unix_timestamp);
      $reservation['time'] = '';
      foreach ($all_hours as $time_slot) {
        if ($time_slot['time'] == $data->reservation_time->getString()) {
          $reservation['time'] = $time_slot['display'];
          break;
        }
      }
      $user_reservations[] = $reservation;
    }
  }
  return $user_reservations;
}

/*
 * return TRUE/FALSE if a slot of the selected length is available to be booked
 */
function reserve_is_slot_free($rid, $ebundle, $yyyy_mmdd, $time, $length) {
  $slots = reserve_valid_lengths($rid, $ebundle, $yyyy_mmdd, $time, NULL, true);
  foreach ($slots as $slot) {
    if ($slot['length'] == $length && $slot['is_valid']) {
      return true;
    }
  }
  return false;
}

function reserve_yyyymmdd($month, $day) {
  // determine if this year or next year
  $yearnow = date('Y');
  $absdaynow = date('z');
  $absdaydefault = date('z', mktime(0, 0, 0, $month, $day, $yearnow));
  if ($absdaynow > $absdaydefault) {
    $year = $yearnow + 1;
  }
  else {
    $year = $yearnow;
  }
  return date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
}

/*
 * List of bundles with Reserve Category field attached - i.e. reservable bundles
 *
 */
function reserve_get_reserve_bundles() {
  $bundles = array();
  $fieldmap = \Drupal::entityManager()->getFieldMap();
  foreach ($fieldmap as $entity_type => $typedef) {
    foreach ($typedef as $field) {
      if ($field['type'] == 'reserve_category') {
        foreach ($field['bundles'] as $bundle) {
          $bundles[] = $entity_type . '.' . $bundle;
        }
      }
    }
  }
  return $bundles;
}

/*
 * returns list of field names used as category fields in different bundles
 * OR specific field name if $ebundle is provided (e.g. node.room)
 */
function reserve_category_fields($ebundle = NULL) {
  $fieldmap = \Drupal::entityManager()->getFieldMap();
  $fields = [];
  foreach ($fieldmap as $entity_type => $typedef) {
    foreach ($typedef as $name => $field) {
      if ($field['type'] == 'reserve_category') {
        foreach ($field['bundles'] as $bundle) {
          $fields[$entity_type . '.' . $bundle] = $name;
        }
      }
    }
  }
  if ($ebundle) {
    return $fields[$ebundle];
  }
  else {
    return $fields;
  }
}

function ebundle_split($ebundle, $part) {
  $ebits = explode('.', $ebundle);
  if ($part == 'type') return $ebits[0];
  if ($part == 'bundle') return $ebits[1];
}

/*
 * return array of formatted eBundles
 *  e.g.: Room (node)
 */
function ebundles_formatted() {
  $result = array();
  $info = \Drupal::service("entity_type.bundle.info")->getAllBundleInfo();
  $ebundles = reserve_get_reserve_bundles();
  if (count($ebundles)) {
    foreach ($ebundles as $ebundle) {
      $type = ebundle_split($ebundle, 'type');
      $bundle = ebundle_split($ebundle, 'bundle');
      $result[$ebundle] = $info[$type][$bundle]['label'] . " ($type)";
    }
  }
  return $result;
}

function reserve_which_year($month, $day) {
  // determine if this year or next year
  $yearnow = date('Y');
  $absdaynow = date('z');
  $absdaydefault = date('z', mktime(0, 0, 0, $month, $day, $yearnow));
  if ($absdaynow > $absdaydefault) {
    $year = $yearnow + 1;
  }
  else {
    $year = $yearnow;
  }

  return $year;
}

/*
 * used for Allowed Values for Reservation.reservable_content_type field
 */
function reserve_site_entity_types() {
  $types = \Drupal::entityManager()->getEntityTypeLabels(TRUE);
  return $types['Content'];
}

/*
 * get Category field used on ebundle
 */
function reserve_get_ebundle_category_field($ebundle) {
  $type = ebundle_split($ebundle, 'type');
  $bundle = ebundle_split($ebundle, 'bundle');
  $fields = \Drupal::service('entity_field.manager')->getFieldMapByFieldType('reserve_category');
  $fieldsType = $fields[$type];
  foreach ($fieldsType as $field => $fieldInfo) {
    if (in_array($bundle, $fieldInfo['bundles'])) {
      return $field;
    }
  }
}