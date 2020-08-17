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

<?php if ($meta && isset($meta->rules) && count($meta->rules) > 0 ):
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
      $text = array();
  ?>
  <div class="event-meta-text">

  <?php foreach ($meta['rules'] as $key => $rule): ?>

    <?php
    $only_custom = true;
       switch ($rule['custom']['type']) {
         case 'Daily':
         $only_custom = false;
           if($rule['custom']['interval'] == 1){
              $text[] = 'This event occurs every day';
           }else{

              $text[] = 'This event occurs every '. $rule['custom']['interval'] .' days <br>';
           }

             $text[] = ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;

             $text[] = ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

           if((int)$rule['custom']['end-day'] > 0){
               $text[] = '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
           }

           break;
         case 'Weekly':
         $only_custom = false;

           if($rule['custom']['interval'] == 1){
              $text[] = 'This event occurs every week ';
           }else{
              $text[] = 'This event occurs every '. $rule['custom']['interval'] .' weeks <br>';
           }

            if( $rule['custom']['week']['day'] && count($rule['custom']['week']['day']) < 12 ){

                $text[] = 'on ';

              $days_ = array();

               foreach ($rule['custom']['week']['day'] as $key => $day) {
                 $days_[] = $days[$day];
               }

                 $text[] = implode(', ',$days_) . '<br>';

            }else if($rule['custom']['week']['day'] && count($rule['custom']['week']['day']) == 7){
                $text[] = ' every month <br>';
            }

              $text[] = ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;

             $text[] = ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

           if((int)$rule['custom']['end-day'] > 0){
               $text[] = '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
           }
          break;

         case "Monthly":
         $only_custom = false;
             if($rule['custom']['interval'] == 1){
                $text[] = 'This event occurs every month ';
             }else{
                $text[] = 'This event occurs every '. $rule['custom']['interval'] .' months <br>';
             }


             if(count($rule['custom']['month']) > 0){

                $text[] = (isset($rule['custom']['month']['day']))? 'every ' . $rule['custom']['month']['number'] .' ' : 'every '. (int) $rule['custom']['month']['number']. 'th day  of month <br>';

                $text[] = (isset($rule['custom']['month']['day']))? $days[$rule['custom']['month']['day']] .' <br>' : '';


             }else{
                $text[] = 'every '. (int)tribe_get_start_date( null, false, ' d' ) . 'th day <br>';
             }


               $text[] = ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;
               $text[] = ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

             if((int)$rule['custom']['end-day'] > 0){
                 $text[] = '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
             }
           break;

         case "Yearly":
         $only_custom = false;
             if($rule['custom']['interval'] == 1){
                $text[] = 'This event occurs every year';
             }else{
                $text[] = 'This event occurs every '. $rule['custom']['interval'] .' years <br>';
             }


             if(count($rule['custom']['year']) > 0){
              $year = array();
              foreach ($rule['custom']['year']['month'] as $key => $ind) {
                $year[] =$months[$ind];
              }

                $text[] = 'on '. implode(', ', $year) .'<br>';


             }else{
                $text[] = 'every month <br>';
             }

             if($rule['custom']['year']['same-day'] === 'yes'){
                 $text[] = 'every '. (int)tribe_get_start_date( null, false, ' d' ) . 'th day of month<br>';
             }else{
                $text[] = (isset($rule['custom']['year']['day']))? 'every ' . $rule['custom']['year']['number'] .' ' : 'every '. (int) $rule['custom']['year']['number']. 'th day  of year <br>';

                $text[] = (isset($rule['custom']['year']['day']))? $days[$rule['custom']['year']['day']] .' <br>' : '';
             }


               $text[] = ( $rule['custom']['start-time'] )? 'begins: ' . $rule['custom']['start-time']  . ' <br> ' : 'begins: ' . $start_time  . ' <br> ' ;
               $text[] = ($rule['custom']['end-time'])? 'ends: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-time']  : '';

             if((int)$rule['custom']['end-day'] > 0){
                 $text[] = '<br>lasts: &nbsp;&nbsp;&nbsp;' . $rule['custom']['end-day'] . ' ' ._n('day','days', $rule['custom']['end-day']  );
             }

           break;


          case 'Date':
             $date = new DateTime( $rule['custom']['date']['date']);
               $text[] = $date->format('F d');
               $text[] = ($rule['custom']['same-time'] === 'no')? ' - '. $rule['custom']['start-time']  : ' - '. $start_time;
               $text[] = ($rule['custom']['same-time'] === 'no' && $rule['custom']['end-time'])? '-'. $rule['custom']['end-time'] . '<br>' : '<br>';
             break;

         default:
           # code...
           break;
       }

     ?>


  <?php endforeach;
   if($only_custom ){
    echo 'Daily start/end times <br>';
   }

   echo implode('', $text);
    echo'<div class="events-line"></div>';
   ?>

   </div>


<?php endif ?>
