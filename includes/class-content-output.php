<?php
class theme_content_output{
  public function __construct(){
    add_action('wp_footer', array($this, 'print_up_button'));
    add_action('wp_footer', array($this, 'add_page_color_styles'));
    add_action('tribe_events_single_event_after_the_content', array($this, 'tribe_events_single_event_after_the_content'));
  }

  public static function tribe_events_single_event_after_the_content(){
    $object = get_queried_object();
    ?>
        <script>
          function open_window(href, title){
           var w = 640, h = 480,
              left = Number((screen.width/2)-(w/2)), tops = Number((screen.height/2)-(h/2));

          popupWindow = window.open(href, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=1, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left);
          popupWindow.focus(); return false;
          }
        </script>

      <div class="spacer-h-30"></div>
      <div class="social-share">
        <span class="social-share__title"><?php _e('Share This Event','theme-translations');?> !</span>

        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink( $object->ID); ?>"
          onclick="open_window(this.href, this.title); return false"  title="<?php _e('Share in Facebook'); ?>"
          target="_parent"
          class="social-share__link employment">
          <img src="<?php echo THEME_URL ?>/assets/images/icons/fb.svg" alt="">
        </a>

        <?php
          $limit = 140;
          $product_name = $object->post_title;
          $short_description = strip_tags(strip_shortcodes($object->post_content));
          $after = (mb_strlen($product_name .'. '. strip_tags($short_description))>$limit)?'...': '' ;
          $text = mb_substr(esc_attr($product_name .'. '. strip_tags($short_description)), 0, $limit-3).$after;
          $url = get_permalink($object);
        ?>

        <a href="http://twitter.com/share?text=<?php echo $text ?>&url=<?php echo esc_url( $url ) ?>" title="<?php _e('Share in Twitter'); ?>" onclick="open_window(this.href, this.title); return false" target="_parent" class="social-share__link youth">
          <img src="<?php echo THEME_URL ?>/assets/images/icons/twitter.svg" alt="">
        </a>
      </div>
    <?php
  }


  public static function print_up_button(){
    echo '
    <div class="go-up-container container container-xxl">
      <div class="go-up-button"><span class="go-up-button__inner"></span></div>
    </div>
    ';
  }


  public static function add_page_color_styles(){
    $obj = get_queried_object();

    if($obj->post_type=="page"){
      $primary_color   = get_field('primary_color',$obj->ID);
      $secondary_color = get_field('secondary_color',$obj->ID);
      ?>
        <style>

          <?php if ($secondary_color): ?>
        .theme-accordeon__head,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta.vc_tta-tabs-position-left .vc_tta-panel-heading,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta.theme-tour .vc_tta-panel-heading,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta .vc_tta-panel-heading,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tab,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left.theme-tour .vc_tta-tab{
            background-color: <?php echo $secondary_color; ?>;
          }
          <?php endif ?>

          <?php if ($primary_color): ?>

          .wpb_text_column ul    li{
            position: relative;
            list-style-type: none;
          }

           .wpb_text_column ul    li:before{
              content: '•';
              display: block;
              position: absolute;
              left: -20px;
              top: 0px;
              color: <?php echo $primary_color; ?>;
            }

          .wpb_text_column ul{
            padding-left: 20px;

          }

          .vc_btn3-container a,
          .vc_btn3-container  button{
            color: #fff !important;
            border: 0 !important;
            padding: 0 25px !important;
            height: 32px!important;
            line-height: 32px!important;
            font-size: 20px!important;
            background-image: none !important;
          }

          .vc_btn3-container  button:hover{
            opacity: .8;
          }
            .theme-accordeon__head .marker:after, .theme-accordeon__head .marker:before,
          .expanded .theme-accordeon__head{
             background-color: <?php echo $primary_color; ?>;
          }

          .vc_btn3-container a{
            color: #fff !important;
          }

           .vc_btn3-container a:hover{
            opacity: .8;
           }

          .vc_btn3-container a,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta.theme-tour .vc_active .vc_tta-panel-heading,
          body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta .vc_active .vc_tta-panel-heading,
          .vc_btn3-container  button,
           body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left.theme-tour .vc_tta-tab.vc_active,
           body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tab.vc_active,
           body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left .vc_tta-tab:hover,
           body.wpb-js-composer .vc_general.vc_tta-tabs.vc_tta-tabs-position-left.theme-tour .vc_tta-tab:hover{
            background-color: <?php echo $primary_color; ?>!important;
          }
          <?php endif ?>
        </style>

      <?php
    }
  }
}

new theme_content_output();