<?php
class theme_content_output{
  public function __construct(){
    add_action('wp_footer', array($this, 'print_up_button'));
  }

  public static function print_up_button(){
    echo '
    <div class="go-up-container container container-xxl">
      <div class="go-up-button"><span class="go-up-button__inner"></span></div>
    </div>
    ';
  }
}

new theme_content_output();