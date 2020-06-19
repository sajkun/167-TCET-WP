<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}


class WPBakeryShortCode_theme_large_map extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'lat'  => false,
      'lng'  => false,
      'zoom' => 12,
      'title' => '',
    ), $atts ) );

    if(!$lat || !$lng){
      return;
    }

    $args = array(
      'lat'   => $lat,
      'lng'   => $lng,
      'zoom'  => $zoom,
      'title' => $title,
    );

    ob_start();
    print_theme_template_part('large-map','wpbackery', $args);
    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}


add_action('vc_before_init', 'vc_before_init_theme_large_map');

function vc_before_init_theme_large_map(){
  vc_map( array(
      'base' => 'theme_large_map',
      'name' => __( 'Large Map', 'theme-translation' ),
      'class' => '',
      'category' => __( 'Theme Shortcodes' ),
      'icon' => THEME_URL.'/assets/images/icons/map.png',

      'description' => __('Map that will dispalay 1 location for welcome screen', 'theme-translation'),

      'show_settings_on_create' => true,

      'params' => array(
        array(
          'type' => 'textfield',
          "heading" => __('Latitude', 'theme-translation'),
          'param_name' => 'lat',
        ),
        array(
          'type' => 'textfield',
          "heading" => __('Longitude', 'theme-translation'),
          'param_name' => 'lng',
        ),
        array(
          'type' => 'textfield',
          "heading" => __('Title', 'theme-translation'),
          'param_name' => 'title',
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