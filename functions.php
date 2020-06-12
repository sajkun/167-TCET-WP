<?php
class velesh_orgafresh_child{

  /**
  * default init function
  */
  public function __construct(){
    $this->define_constants();
    $this->include();
    $this->add_actions();
    $this->add_filters();
    $this->define_image_sizes();
  }


  /**
  * defines global constants
  */
  public function define_constants(){
    define('THEME_PATH', get_stylesheet_directory());
    define('THEME_URL', get_stylesheet_directory_uri());
    define('HOME_URL', get_home_url());
    define('THEME_DEBUG', false);
    define('SERVICE_POST_NAME', 'theme_services');
    define('FAQ_POST_NAME', 'faq_post');
    define('LOCATIONS_POST', 'tribe_venue');
  }

  public function define_image_sizes(){
    add_image_size('event_data', 560, 250, true);
    add_image_size('photo_team', 384, 454, true);
  }


  /**
  * includes .php files
  */
  public function include(){
   include_once(THEME_PATH.'/includes/helpers.php');
   include_php_from_dir(THEME_PATH.'/includes/');
   include_php_from_dir(THEME_PATH.'/wpbackery/');
  }


  /**
  * add actions
  */
  public function add_actions(){
    global $wp_styles;

    add_action( 'wp_enqueue_scripts', array($this,'orgafresh_child_enqueue_styles'), 10 );

    add_action( 'wp_enqueue_scripts', array($this,'unregister_styles'), PHP_INT_MAX );

    add_action('wp_head', function(){
      if(orgafresh_get_opt('alus_header_layout') === 'layout_tcet'){
        remove_action( 'orgafresh_after_body_open', 'orgafresh_header_mobile_navigation', 10 );
      }
    });


     if(THEME_DEBUG){
        add_action('wp_footer', 'exec_clog', PHP_INT_MAX);
     }

    add_action('admin_init', array($this,'add_reading_settings'));

    add_action('admin_menu', array($this,'add_option_pages'));
  }

  /**
  * add filters
  */
  public function add_filters(){
    add_filter('upload_mimes', array($this, 'cc_mime_types'), PHP_INT_MAX);
  }


  /**
  * enques styles and scripts for theme
  */
  public static function orgafresh_child_enqueue_styles() {
    wp_enqueue_style( 'orgafresh-style', get_template_directory_uri() . '/style.css', array('font-awesome') );

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('font-awesome') );

    wp_enqueue_style( 'velesh-theme-style', THEME_URL . '/assets/css/main.min.css', array());

    wp_enqueue_style( 'owl-carousel-style', THEME_URL . '/assets/owlcarousel/css/owl.carousel.min.css', array());

    wp_enqueue_script('owl-carousel-script', THEME_URL.'/assets/owlcarousel/js/owl.carousel.min.js', array('jquery'), '1.0', true);

    wp_enqueue_script('velesh-theme-script', THEME_URL.'/assets/script/main.js', array('jquery'), '1.0', true);


    if(function_exists('tribe_get_option')){
      wp_enqueue_script('velesh-theme-google-map-api', sprintf('https://maps.googleapis.com/maps/api/js?key=%s', tribe_get_option('google_maps_js_api_key')), array(), '1.0', false);
    }

    if (THEME_DEBUG) {
      wp_localize_script( 'velesh-theme-script', 'THEME_DEBUG' , 'yes' );
    }
  }


  /**
  * remove Bootstrap 3
  */
  public static function unregister_styles(){
    global $wp_styles;
    wp_dequeue_style('orgafresh-default');
    wp_deregister_style('orgafresh-default');
    wp_dequeue_script('gmap-api');
  }


  /**
   * adds additional mime types for attachments
   *
   * @hookedto - upload_mimes 10
   */
  public static function cc_mime_types($mimes) {
    $mimes['mp4'] = 'video/mp4';
    $mimes['avi'] = 'video/avi';
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
  }


  /**
  * adds additional settings section
  */
  public function add_reading_settings(){
    add_settings_section('theme-pages-section', __('Custom page settings', 'theme-translations '), array($this, 'add_additional_page_settings'), 'reading');
  }


  /**
  * callback for settings section
  *
  * @data - array;
  *
  * @see $this->add_reading_settings()
  */
  public function add_additional_page_settings($data){
  }

  /**
  * adds options to reading sections
  * allow admin to define special pages
  */
  public function add_option_pages(){
    $options = array(
      'success_stories'        => __('Success Stories', 'theme-translations'),
      'team'                   => __('Team Page', 'theme-translations'),
      'events'                 => __('Events Page', 'theme-translations'),
    );

    foreach ($options as $key => $name) {
      $option_name = 'theme_page_'.$key;

      register_setting( 'reading', $option_name );

      add_settings_field(
       'theme_setting_'.$key,
        $name,

        array(__CLASS__, 'page_select_callback'),

        'reading',
        'theme-pages-section',

        array(
          'id' => 'theme_setting_'.$key,
          'option_name' => $option_name,
        )
      );
    }
  }

  /**
   * callback to display a select option for page select
   *
   * @param $val - arrray
   *
   * @see $this->add_reading_settings()
   */
  public static function page_select_callback( $val ){
    $id = $val['id'];
    $option_name = $val['option_name'];
    $args = array(
      'posts_per_page' => -1,
      'limit'          => -1,
    );
    $pages = get_pages($args);
    echo ' <select name="'.$option_name .'">';
    echo '<option value="-1">— Select —</option>';

    foreach ($pages  as $id => $page) {
      $selected = (esc_attr( get_option($option_name) ) == $page->ID )? 'selected = "selected"' : '';
      ?>
        <option <?php echo $selected; ?> value="<?php echo $page->ID ?>"> <?php echo $page->post_title; ?></option>
      <?php
    }
    echo '</select>';
  }

  public static function add_cors_http_header(){
    // header("Access-Control-Allow-Origin: *");
  }
}


new velesh_orgafresh_child();
