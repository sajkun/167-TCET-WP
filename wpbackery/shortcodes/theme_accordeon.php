<?php

function vc_before_init_theme_accordeon(){
  vc_map( array(
    "name" => __("Theme Accordeon", "theme_translations"),
    "base" => "theme_accordeon",
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    'category' => __( 'Theme Shortcodes' ),
    'description' =>__("An Accordeon", "theme-translations"),
    'icon' => THEME_URL.'/assets/images/icons/accordeon.png',
    "params" => array(
    // add params same as with any other content element
        array(
          "type" => "textfield",
          "heading" => __("Title", "theme-translations"),
          "param_name" => "title",
         ),
      ),
      "js_view" => 'VcSectionView',
    ) );

  $settings = array(
    'allowed_container_element' => array('vc_row', 'theme_accordeon'),
  );

  vc_map_update('vc_tta_section', $settings);
}

add_action('vc_before_init', 'vc_before_init_theme_accordeon', 999);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_theme_accordeon extends WPBakeryShortCodesContainer {

    protected function content( $atts, $content = null ) {

      extract( shortcode_atts( array(
        'title' => false,
      ), $atts ) );

      ob_start();
      ?>
        <div class="theme-accordeon">
          <h4 class="theme-accordeon__head">
            <span class="marker"></span>
            <span class="title"><?php echo $title ?></span>
          </h4>
          <div class="theme-accordeon__body">
             <?php echo do_shortcode($content); ?>
          </div>
        </div>



      <?php
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }
  }
}
