<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}



class WPBakeryShortCode_event_count_down extends WPBakeryShortCode {
  protected function content( $atts, $content = null ) {
    if(!in_array("the-events-calendar/the-events-calendar.php", get_option('active_plugins'))){
      return;
    }

    extract( shortcode_atts( array(
      'event_id' => -1,
    ), $atts ) );

    $event = get_post($event_id);

    if(!$event || $event->post_status !== 'publish'){
      return;
    }

    $now = new DateTime('now');
    $meta = get_post_meta($event_id);
    $organizer_id = (int)get_post_meta($event_id, '_EventOrganizerID', true);
    $venue_id     = (int)get_post_meta($event_id, '_EventVenueID', true);
    $date         = get_post_meta($event_id, '_EventStartDate', true);
    $timezone     = get_post_meta($event_id, '_EventTimezone', true);
    $timezone_obj = Tribe__Timezones::get_timezone($timezone);
    $now->setTimezone( $timezone_obj );
    $date_obj = new DateTime( $date , $timezone_obj);

    $organizer = get_post($organizer_id);
    $venue     = get_post($venue_id);
    $diff = date_diff($now, $date_obj);

    if( $diff->invert === 1){
      return;
    }

    $events_archive_base = tribe_get_option( 'eventsSlug', 'events' );
    $url_events = home_url( '/' . $events_archive_base . '/' );

    $args = array(
      'diff' => $diff,
      'organizer' => $organizer->post_title,
      'title' => $event->post_title,
      'venue' => $venue->post_title,
      'url'   => get_permalink($event),
      'url_events'   => $url_events,
    );

    ob_start();

    echo print_theme_template_part('countdown', 'wpbackery', $args);

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
  }
}

add_action('vc_before_init', 'vc_before_init_event_count_down');


function vc_before_init_event_count_down(){
  if (in_array("the-events-calendar/the-events-calendar.php", get_option('active_plugins'))){


    $events = tribe_get_events( [
       'posts_per_page' => -1,
       'start_date'     => 'now',
    ]);

    $values = array();

    foreach ($events as $event) {
      $values[$event->post_title] = $event->ID;
    }


    vc_map( array(
        'base' => 'event_count_down',
        'name' => __( 'Event Count Down', 'theme-translation' ),
        'class' => '',
        'category' => __( 'Theme Shortcodes' ),
        'icon' => THEME_URL.'/assets/images/icons/countdown.png',
        'description' => __('Display a countdown to a specified event. Will be hidded if event starting day passed','theme-translation'),
        'show_settings_on_create' => true,
        'custom_markup' => '<h4 class="wpb_element_title"> <i class="vc_general vc_element-icon"></i>Event Count Down</h4> <span class="vc_admin_label admin_label_event_id" style="display: inline;"><label> Event </label></span>',
        'params' => array(
          array(
            'type' => 'dropdown',
            "heading" => __( "Event", "theme-translation" ),
            'param_name' => 'event_id',
            'description' => __('Select an event for a countdown', 'theme-translation'),
            'value' => $values,
          ),
        ),
    ));
  }
}