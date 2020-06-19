<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}


class WPBakeryShortCode_theme_search_map extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'lat'  => false,
      'lng'  => false,
      'zoom' => 12,
    ), $atts ) );


    $args_venues = array(
      'posts_per_page' => -1,
      'post_type'      => LOCATIONS_POST,
      // 'fields'         => 'ids',

       'meta_query' => array(
           array(
               'key' => 'show_in_locations',
               'value' => 'yes',
               'compare' => '=',
           )
       )
    );

    $venues = get_posts( $args_venues );


    $args = array(
      'lat'  => $lat,
      'lng'  => $lng,
      'zoom' => $zoom,
      // 'venues_formatted' => $venues_formatted,
    );


     $venues_formatted = array();

    if($venues){
     foreach ($venues as $key => $venue){
      $venue_id = $venue->ID;

       $venues_formatted[] = array(
          'title' => $venue->post_title,
          'lat'   => get_field('latitude', $venue_id),
          'lng'   => get_field('longitude', $venue_id),
          'marker'    => get_field('marker_google_map_venue', $venue_id),
        );
     }
      $args['venues_formatted'] = $venues_formatted;
    }

    ob_start();
    print_theme_template_part('search-map','wpbackery', $args);
    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}

add_action('vc_before_init', 'vc_before_init_theme_search_map');

function vc_before_init_theme_search_map(){

  vc_map( array(
      'base' => 'theme_search_map',
      'name' => __( 'Locations map', 'theme-translation' ),
      'class' => '',
      'category' => __( 'Theme Shortcodes' ),
      'icon' => THEME_URL.'/assets/images/icons/map.png',

      'description' => __('Locations map', 'theme-translation'),

      'show_settings_on_create' => true,

      'params' => array(
        array(
          'type' => 'textfield',
          "heading" => __('Latitude of map center', 'theme-translation'),
          'param_name' => 'lat',
        ),
        array(
          'type' => 'textfield',
          "heading" => __('Longitude of map center', 'theme-translation'),
          'param_name' => 'lng',
        ),
        array(
          'type' => 'textfield',
          "heading" => __('Initial zoom', 'theme-translation'),
          'param_name' => 'zoom',
          'description' => __('this number should be between 1 and 16'),
          'value' => 12,
        ),
      ),
  ));
}