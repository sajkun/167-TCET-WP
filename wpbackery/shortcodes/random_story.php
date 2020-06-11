<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
class WPBakeryShortCode_theme_random_story extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'term_ids' => false,
    ), $atts ) );

    $ids = explode(',', $term_ids);

    $args =  array(
      'posts_per_page' => -1,
      'post_type'      => 'theme_success_story',
      'field' => 'ids',

    );

    if($ids){
      $args['tax_query'] = array(array(
            'taxonomy' => 'services_term',
            'field' => 'id',
            'terms' => $ids // Where term_id of Term 1 is "1".
          ) );
    }

    $stories = get_posts($args);

<<<<<<< HEAD
    if(! $stories) return;

=======
>>>>>>> 035391a8d273cfe41e2d744e4c7bd6b03f53f2c8
    $end = count( $stories ) - 1;

    $index = random_int(0,  $end);

    $img_id = get_post_thumbnail_id($stories[$index]->ID);

    $terms = wp_get_post_terms($stories[$index]->ID, 'services_term', array('fields'=>'ids'));

    $color = false;

    if($terms){
      $color     = get_term_meta($terms[0], 'events_color', true);
    }

    $args_story = array(
      'text' => $stories[$index]->post_title,
      'location' => get_field('location', $stories[$index]->ID),
      'name'     => get_field('name', $stories[$index]->ID),
      'image'    => wp_get_attachment_image_url( $img_id, 'medium', false ),
      'url'      => get_permalink(get_option('theme_page_success_stories')),
      'color'    => $color,
    );


    ob_start();
    print_theme_template_part('theme-story','wpbackery', $args_story);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }
}


add_action('vc_before_init', 'map_theme_random_story');

function map_theme_random_story(){
  $args = array(
  );

  $terms = get_terms('services_term', array('hide_empty' => false));

  $values = array();
  foreach ($terms as $t) {
    $values[$t->name] = $t->term_id;
  }


  vc_map( array(
      'base' => 'theme_random_story',
      'name' => __( 'Random story', 'theme-translation' ),
      'class' => '',
      'category' => __( 'Theme Shortcodes' ),
      'icon' => THEME_URL.'/assets/images/icons/story.png',

      'description' => __('Shows a random success story from selected categories', 'theme-translation'),

      'show_settings_on_create' => true,

      'params' => array(
          array(
            'type' => 'dropdown_multi',
            "heading" => __('Categories', 'theme-translation'),
            'param_name' => 'term_ids',
            'description' => __('Multiple selection possible', 'theme-translation'),
            'value' => $values,
          ),
      ),
  ));


}