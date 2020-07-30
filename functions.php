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
    define('US_SERVICE_COLOR', true);
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
    add_action( 'wp_enqueue_scripts', array($this,'orgafresh_child_enqueue_scripts'), PHP_INT_MAX );

    add_action( 'wp_enqueue_scripts', array($this,'unregister_styles'), PHP_INT_MAX );

    add_action('wp_head', function(){
      if(orgafresh_get_opt('alus_header_layout') === 'layout_tcet'){
        remove_action( 'orgafresh_after_body_open', 'orgafresh_header_mobile_navigation', 10 );
      }
    });


     if(THEME_DEBUG){
        add_action('wp_footer', 'exec_clog', PHP_INT_MAX);
        add_action('admin_footer', 'exec_clog', PHP_INT_MAX);
     }

    add_action('admin_init', array($this,'add_reading_settings'));

    add_action('admin_menu', array($this,'add_option_pages'));

    add_action('tribe_before_content', 'print_events_header');

    add_action( 'admin_menu', array($this,'register_my_import_page' ));
  }

  public function import_services_cb(){
    echo 'blocked';
    return;

    if(isset($_FILES['csv'])){
      $content = file_get_contents($_FILES['csv']["tmp_name"]);
      $data    = str_getcsv ( $content, PHP_EOL, '"');

      $keys = str_getcsv ( $data[0], ',');

      $tax_service_group = 'services_term';
      $tax_session_type   = 'session_type';


     // clog($data);
      foreach ($data as $key => $value) {
         if($key > 0){
            $row = str_getcsv ( $value, ',', '"');

            // clog($row);

            $term_service_group = get_term_by( 'name', $row[1], 'services_term');
            if(!$term_service_group  && isset($row[1])){
              $term_service_group = wp_insert_term($row[1], 'services_term');
            }
            // clog( $term_service_group->term_id  );

            $term_session_type = get_term_by( 'name', $row[2], 'session_type');

            if(!$term_session_type && isset($row[2])){
              $term_session_type = wp_insert_term($row[2], 'session_type');
            }

            $post_data = array(
              'post_title'    => $row[0],
              'post_content'  =>  $row[3],
              'post_status'   => 'publish',
              'post_type'     => 'theme_services',
            );

            $post_id = wp_insert_post( $post_data );

            if ($term_service_group) {
              wp_set_post_terms( $post_id, array($term_service_group->term_id), 'services_term');
            }

            if ($term_session_type) {
              wp_set_post_terms( $post_id, array($term_session_type->term_id), 'session_type');
            }


            add_post_meta( $post_id, 'eligibility', $row[4]);
        }
      }
    }

    ?>
      <form action="<?php echo admin_url('admin.php?page=import_services'); ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv">
        <input type="submit" value ="upload">
      </form>
    <?php
  }
  public function register_my_import_page(){
    add_menu_page( 'Import Services', 'Import Services', 'manage_options', 'import_services', array($this, 'import_services_cb' ));
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

  }

  public static function orgafresh_child_enqueue_scripts() {

    wp_enqueue_script('owl-carousel-script', THEME_URL.'/assets/owlcarousel/js/owl.carousel.min.js', array('jquery'), '1.0', true);

    // wp_enqueue_script('velesh-theme-html2canvas', THEME_URL.'/assets/script/html2canvas.js', array('jquery'), '1.0', true);

    wp_enqueue_script('velesh-theme-pdf-print', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js', array('jquery'), '1.0', true);

    wp_enqueue_script('velesh-theme-script', THEME_URL.'/assets/script/main.js', array('jquery'), '1.0', true);


    if(function_exists('tribe_get_option')){
      wp_enqueue_script('velesh-theme-google-map-api', sprintf('https://maps.googleapis.com/maps/api/js?key=%s', tribe_get_option('google_maps_js_api_key')), array(), '1.0', false);
    }

    if (THEME_DEBUG) {
      wp_localize_script( 'velesh-theme-script', 'THEME_DEBUG' , 'yes' );
    }

    if(isset($_GET['service'])){
      wp_localize_script( 'velesh-theme-script', 'link_passed_service' , $_GET['service'] );
    }
      wp_localize_script( 'velesh-theme-script', 'HOME_URL' , HOME_URL );



    $obj = get_queried_object();

    if(isset($obj->post_type) &&  $obj->post_type=="tribe_events"){
      wp_localize_script( 'velesh-theme-script','tribe_event_title' , trim($obj->post_name) );
    }

    $wp_urls = array(
      'theme_url' =>THEME_URL,
      'ajax_url'  => admin_url('admin-ajax.php'),
    );

     wp_localize_script( 'velesh-theme-script','WP_URLS' , $wp_urls );
  }


  /**
  * remove Bootstrap 3
  */
  public static function unregister_styles(){
    global $wp_styles;
    wp_dequeue_style('orgafresh-default');
    wp_deregister_style('orgafresh-default');
    wp_dequeue_script('gmap-api');
    wp_deregister_style('grw_css');
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



