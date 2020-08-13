<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
$time_zone_label      = Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false, 'F d, Y' );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date     = tribe_get_display_end_date( null, false,  'F d, Y' );
$end_time     = tribe_get_end_date( null, false, $time_format );
$end_ts       = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );


/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();

$meta = get_post_meta($event_id, '_EventRecurrence', true );

clog($meta);


?>


<p class="event-meta-text"><?php _e('Start','theme-translations');?>:</p>
<p class="event-meta-text">
  <?php echo $start_date; ?>
</p>
<p class="event-meta-text">
  <?php echo $start_time; ?>
</p>

<div class="events-line"></div>

<p class="event-meta-text"><?php _e('End','theme-translations');?>:</p>
<p class="event-meta-text">
  <?php echo $end_date; ?>
</p>
<p class="event-meta-text">
  <?php echo $end_time; ?>
</p>

<div class="events-line"></div>

<?php if ($meta):
$days = array(
  'none',
  'Monday',
  'Tuesday',
  'Wednesday',
  'Thursday',
  'Friday',
  'Saturday',
  'Sunday',
);

$months = array(
  'none',
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
  ?>

  <?php foreach ($meta['rules'] as $key => $rule): ?>

  <div class="event-meta-text">
    <?php
       switch ($rule['custom']['type']) {
         case 'Daily':
           if($rule['custom']['interval'] == 1){
            echo 'An event repeating every day';
           }else{

            echo 'An event repeating every '. $rule['custom']['interval'] .' days <br>';
           }

           echo ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;

           echo ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

           if((int)$rule['custom']['end-day'] > 0){
             echo '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
           }
           echo'<div class="events-line"></div>';
           break;
         case 'Weekly':

           if($rule['custom']['interval'] == 1){
            echo 'An event repeating every week';
           }else{
            echo 'An event repeating every '. $rule['custom']['interval'] .' weeks <br>';
           }

            if( $rule['custom']['week']['day'] && count($rule['custom']['week']['day']) < 12 ){

              echo 'on ';

              $days_ = array();

               foreach ($rule['custom']['week']['day'] as $key => $day) {
                 $days_[] = $days[$day];
               }

               echo implode(', ',$days_) . '<br>';

            }else if($rule['custom']['week']['day'] && count($rule['custom']['week']['day']) == 7){
              echo ' every month <br>';
            }


            echo ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;

           echo ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

           if((int)$rule['custom']['end-day'] > 0){
             echo '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
           }
           echo'<div class="events-line"></div>';
          break;

         case "Monthly":
             if($rule['custom']['interval'] == 1){
              echo 'An event repeating every month';
             }else{
              echo 'An event repeating every '. $rule['custom']['interval'] .' months <br>';
             }


             if(count($rule['custom']['month']) > 0){

              echo (isset($rule['custom']['month']['day']))? 'every ' . $rule['custom']['month']['number'] .' ' : 'every '. (int) $rule['custom']['month']['number']. 'th day  of month <br>';

              echo (isset($rule['custom']['month']['day']))? $days[$rule['custom']['month']['day']] .' <br>' : '';


             }else{
              echo 'every '. (int)tribe_get_start_date( null, false, ' d' ) . 'th day <br>';
             }


             echo ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;
             echo ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

             if((int)$rule['custom']['end-day'] > 0){
               echo '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
             }
             echo'<div class="events-line"></div>';
           break;

         case "Yearly":
             if($rule['custom']['interval'] == 1){
              echo 'An event repeating every year';
             }else{
              echo 'An event repeating every '. $rule['custom']['interval'] .' years <br>';
             }


             if(count($rule['custom']['year']) > 0){
              $year = array();
              foreach ($rule['custom']['year']['month'] as $key => $ind) {
                $year[] =$months[$ind];
              }

              echo 'on '. implode(', ', $year) .'<br>';


             }else{
              echo 'every month <br>';
             }

             if($rule['custom']['year']['same-day'] === 'yes'){
               echo 'every '. (int)tribe_get_start_date( null, false, ' d' ) . 'th day of month<br>';
             }else{
              echo (isset($rule['custom']['year']['day']))? 'every ' . $rule['custom']['year']['number'] .' ' : 'every '. (int) $rule['custom']['year']['number']. 'th day  of year <br>';

              echo (isset($rule['custom']['year']['day']))? $days[$rule['custom']['year']['day']] .' <br>' : '';
             }


             echo ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;
             echo ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

             if((int)$rule['custom']['end-day'] > 0){
               echo '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
             }

             echo'<div class="events-line"></div>';
           break;

         default:
           # code...
           break;
       }
     ?>

    </div>

  <?php endforeach ?>



<?php endif ?>
