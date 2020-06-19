<?php
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_collapse_on_mobile extends WPBakeryShortCodesContainer {

    protected function content( $atts, $content = null ) {

      extract( shortcode_atts( array(
        'title' => false,
        'anchor' => false,
      ), $atts ) );

      ob_start();
      ?>
        <div class="theme-accordeon-mob">
          <h4 class="theme-accordeon-mob__head">
            <?php if ($anchor): ?>
              <a id="<?php echo $anchor; ?>"></a>
            <?php endif ?>
            <div class="container container-xxl no-paddings">
              <span class="marker"></span>
              <span class="title"><?php echo $title ?></span>
            </div>
          </h4>
          <div class="theme-accordeon-mob__body">
            <div class="container container-xxl no-paddings">
             <?php echo do_shortcode($content); ?>
            </div>
          </div>
        </div>
      <?php
      $output = ob_get_contents();
      ob_end_clean();
      return $output;
    }
  }
}
add_action('vc_before_init', 'vc_before_init_collapse_on_mobile');

function vc_before_init_collapse_on_mobile(){
  vc_map( array(
      'base' => 'collapse_on_mobile',
      'name' => __( 'Collapse On mobile', 'theme-translation' ),
      "content_element" => true,
      "show_settings_on_create" => true,
      "is_container" => true,
      'category' => __( 'Theme Shortcodes' ),
      'description' =>__("content collapsed on mobiles", "theme-translations"),
      'icon' => THEME_URL.'/assets/images/icons/accordeon.png',
      "js_view" => 'VcSectionView',
      'params' => array(
        array(
          'type' => 'textfield',
          "heading" => __('Title', 'theme-translation'),
          'param_name' => 'title',
        ),

        array(
          'type' => 'textfield',
          "heading" => __('Anchor for links', 'theme-translation'),
          'param_name' => 'anchor',
        ),
      ),
  ));
}