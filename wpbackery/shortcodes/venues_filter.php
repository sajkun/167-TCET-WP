<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}


class WPBakeryShortCode_theme_venues_filter extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {


    $args_venues = array(
      'posts_per_page' => -1,
      'post_type'      => 'tribe_venue',
    );

    $venues = get_posts($args_venues );

     foreach ($venues as $key => $venue){

      $term_id = get_field('service', $venue->ID);
      $term    = get_term($term_id, "tribe_events_cat");

      $venues_formatted[] = array(
        'title'     => $venue->post_title,
        'category'  => $term->name,
       );
     }

     $categories = array();
     $names      = array();

     foreach ($venues_formatted as $key => $v) {
       $categories[] = $v['category'];
       $names[] = $v['title'];
     }

     array_unique($categories);

    $args = array(
      'names' => $names,
      'categories' => $categories,
    );


    ob_start();
    print_theme_template_part('venues-filter','wpbackery', $args);
    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}



vc_map( array(
    'base' => 'theme_venues_filter',
    'name' => __( 'Venues Filter', 'theme-translation' ),
    'class' => '',
    'category' => __( 'Theme Shortcodes' ),
    'icon' => THEME_URL.'/assets/images/icons/filter.png',

    'description' => __('Locations map', 'theme-translation'),

    'show_settings_on_create' => false,

    'params' => array(
    ),
));