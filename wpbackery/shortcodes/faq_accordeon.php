<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}


class WPBakeryShortCode_faq_accorderon extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'faq_ids' => -1,
    ), $atts ) );


    $args = array(
     'posts_per_page' => -1,
     'post_type'    => 'faq_post',
     'include'  => explode(',', $faq_ids),
   );

    $faqs = get_posts($args);

    unset($args);

    ob_start();

    foreach ($faqs as $key => $f) {
      $args = array(
        'question' => $f->post_title,
        'answer' => $f->post_content,
      );
      echo print_theme_template_part('faq-item', 'wpbackery', $args);
    }

    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}


add_action('vc_before_init', 'vc_before_init_faq_post');


function vc_before_init_faq_post(){


  $faq = get_posts( array(
     'posts_per_page' => -1,
     'post_type'    => 'faq_post',
   ));

  $values = array();

  foreach ($faq as $event) {
    $values[$event->post_title] = $event->ID;
  }


  vc_map( array(
      'base' => 'faq_accorderon',
      'name' => __( 'F.A.Q. accorderon', 'theme-translation' ),
      'class' => '',
      'category' => __( 'Theme Shortcodes' ),
      'icon' => THEME_URL.'/assets/images/icons/faq.png',

      'description' => __('Displays a list of F.A.Q.', 'theme-translation'),

      'show_settings_on_create' => true,

      'custom_markup' => '<h4 class="wpb_element_title"> <i class="vc_general vc_element-icon"></i>'.__( 'F.A.Q. accorderon', 'theme-translation' ).'</h4> <span class="vc_admin_label admin_label_faq_ids" style="display: inline;"><label> Faq ids: </label></span>',

      'params' => array(
        array(
          'type' => 'dropdown_multi',
          "heading" => __('Select F.A.Q', 'theme-translation'),
          'param_name' => 'faq_ids',
          'description' => __('Multiple selection possible', 'theme-translation'),
          'value' => $values,
        ),
      ),
  ));
}