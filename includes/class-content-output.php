<?php
class theme_content_output{
  public function __construct(){
    add_action('wp_footer', array($this, 'print_up_button'));
    add_action('wp_footer', array($this, 'add_page_color_styles'));
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

          .vc_btn3-container  button{
            color: #fff !important;
            border: 0 !important;
            padding: 0 25px !important;
            height: 32px;
            line-height: 32px;
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