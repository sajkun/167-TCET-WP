<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}


class WPBakeryShortCode_theme_venues_filter extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {


    $args_venues = array(
      'posts_per_page' => -1,
      'post_type'      => LOCATIONS_POST,
       'meta_query' => array(
           array(
               'key' => 'show_in_locations',
               'value' => 'yes',
               'compare' => '=',
           )
       )
    );

    $venues = get_posts($args_venues );

    if(!$venues){
      return;
    }


     foreach ($venues as $key => $venue){

      $term_id = get_field('service', $venue->ID);
      $term    = get_term($term_id, "services_term");


     $venues_formatted[] = array(
        'title'     => get_post_meta($venue->ID, '_VenueCity', true),
        'category'  => ($term && !is_a($term, "WP_Error"))? $term->name : '',
       );
     }

     $categories = array();
     $names      = array();

     foreach ($venues_formatted as $key => $v) {
       $categories[] = $v['category'];
       $names[]      = $v['title'];
     }

     $categories = array_unique($categories);
     $names      = array_unique($names);

    sort($names);

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

add_action('vc_before_init', 'vc_before_init_theme_venues_filter');


function vc_before_init_theme_venues_filter(){

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
}