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
