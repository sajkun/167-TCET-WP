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
      'post_type'      => 'tribe_venue',
      'fileds'         => 'ids',
    );

    $venues = get_posts($args_venues );

     foreach ($venues as $key => $venue_id){
       $venues_formatted[] = array(
          'lat'  => get_field('latitude', $venue_id),
          'lng' => get_field('longitude', $venue_id),
          'marker'    => get_field('marker_google_map_venue', $venue_id),
        );
     }

    $args = array(
      'lat'  => $lat,
      'lng'  => $lng,
      'zoom' => $zoom,
      'venues_formatted' => $venues_formatted,
    );

    ob_start();
    print_theme_template_part('search-map','wpbackery', $args);
    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}



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
        'description' => __('this number should be between 1 and 14'),
        'value' => 12,
      ),
    ),
));