<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}




class WPBakeryShortCode_theme_todays_events extends WPBakeryShortCode {
    protected function content( $atts, $content = null ) {
        if(!in_array("the-events-calendar/the-events-calendar.php", get_option('active_plugins'))){
          return;
        }

        extract( shortcode_atts( array(
          'show_future_events' => false,
          'start_type' => 'today',
        ), $atts ) );


        $output = '';

        $today = new DateTime( $start_type );

        $events = tribe_get_events( [
           'posts_per_page' => -1,
           'start_date'     => $start_type,
        ]);

         $events_formatted = array();

         foreach ($events as $key => $event) {
          $date          = get_post_meta($event->ID, '_EventStartDate', true);
          $timezone     = get_post_meta($event->ID, '_EventTimezone', true);
          $timezone_obj = Tribe__Timezones::get_timezone($timezone);
          $event->date_obj     = new DateTime( $date, $timezone_obj );

          if(!$show_future_events && $event->date_obj->format('d') != $today->format('d')){
            continue;
          }

          $terms        =  wp_get_post_terms($event->ID, 'services_term');

          $event->color = count($terms) > 0 ?  get_term_meta($terms[0]->term_id, 'events_color', true) : '#eee';

          $events_formatted[] = $event;
         }


        ob_start();

        if(count($events_formatted) <= 0){
         printf('<p class="text-center">%s</p>', __('No events scheduled for today', 'theme-translation'));
        }else{


        ?>
        <div class="upcomming-events-wrapper">
        <div class="upcomming-events <?php echo count($events_formatted) > 3? 'owl-carousel' : '' ;?>">
        <?php

        foreach ($events_formatted as $key => $event) {
          $args = array(
            'title' => $event->post_title,
            'slug'  => $event->post_slug,
            'date'  => $event->date_obj->format('M d, Y'),
            'time'  => $event->date_obj->format('h:i A'),
            'key' => $key,
            'color' => $event->color,
            'url'   => get_permalink($event),
          );

          echo print_theme_template_part('today-events', 'wpbackery', $args);
        }
        ?>
          </div>
          <?php if (count($events_formatted) > 3): ?>
          <div class="carousel-ctrl">
            <span class="next"></span>
            <span class="prev"></span>
          </div>
          <?php endif ?>
        </div>
  <?php
        }
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
  }
}

add_action('vc_before_init', 'vc_before_init_theme_todays_events');

function vc_before_init_theme_todays_events(){
  if (in_array("the-events-calendar/the-events-calendar.php", get_option('active_plugins'))){

    vc_map( array(
        'base' => 'theme_todays_events',
        'name' => __( 'Today Events', 'theme-translation' ),
        'class' => '',
        'category' => __( 'Theme Shortcodes' ),
        'icon' => THEME_URL.'/assets/images/icons/today.jpg',
        'description' => __('Display a carousel with latest events. Uses tribe_events post type','theme-translation'),
        'show_settings_on_create' => false,
        'params' => array(
          array(
            'type' => 'dropdown',
            "heading" => __( "Start Date Type", "theme-translation" ),
            'param_name' => 'start_type',
            'description' => __('Defines starting date for events', 'theme-translation'),
            'value' => array(
                __( 'Today',  "theme-translation"  ) => 'today',
                __( 'Now',  "theme-translation"  ) => 'now',
              ),
          ),
          array(
            "type" => "checkbox",
            "heading" => __( "Show future events", "theme-translation" ),
            "param_name" => "show_future_events",
            "value" => 'yes',
            "description" => __( "Check this if you want to show events that will start later than today.", "theme-translation" )
          ),
        ),
    ));
  }
}