<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
* Theme helper functions
*
* @package theme/helpers
*/


if(!function_exists('clog')){

  /**
 * prints an inline script with output in console
 *
 * @param mixed $content - obj|array|string
 */
  function clog($content, $color = false){
    // if(!$content) return;

    global $clog_data;
    $clog_data = (!$clog_data)? array() : $clog_data;

    $color = (is_object($content) || is_array($content))? false : $color;

    $clog_data[] = array(
       'content' => $content,
       'color'   => $color,
       'type'    => 'regular'
    );
  }
}

if(!function_exists('exec_clog')){
  function exec_clog(){
    global $clog_data;

    if(!$clog_data) return;

    foreach ($clog_data as $key => $data) {
      switch ($data['color']){
         case 'red':
            $script_open =  '<script> console.log("\x1b[0m\x1b[31m %s \x1b[0m",';
          break;
         case 'green':
            $script_open =  '<script> console.log("\x1b[0m\x1b[32m %s \x1b[0m",';
          break;
         case 'blue':
            $script_open =  '<script> console.log("\x1b[0m\x1b[34m %s \x1b[0m",';
          break;
         case 'purple':
            $script_open =  '<script> console.log("\x1b[0m\x1b[35m %s \x1b[0m",';
          break;
         case 'cyan':
            $script_open =  '<script> console.log("\x1b[0m\x1b[36m %s \x1b[0m",';
          break;
         case 'grey':
            $script_open =  '<script> console.log("\x1b[0m\x1b[37m %s \x1b[0m",';
          break;
        default:
            $script_open = '<script> console.log(';
          break;
      }

      switch ($data['type']) {
        case 'end':
          echo '<script> console.groupEnd()</script>';
          break;
        case 'start':
          printf( '<script> console.groupCollapsed("%s")</script>', $data['content']);
          break;
        case 'start:expanded':
          printf( '<script> console.group("%s")</script>', $data['content']);
          break;

        default:
          echo $script_open;
          echo json_encode($data['content']);
          echo ')</script>';
          break;
      }
    }
}

if(!function_exists('glog')){
  /**
 * prints an inline script with output in console
 *
 * @param mixed $content - obj|array|string
 */
  function glog($content = 'group log', $expand = false){
      global $clog_data;
      $clog_data = (!$clog_data)? array() : $clog_data;
      if ($content) {

            $clog_data[] = array(
               'content' => $content,
               'color'   => false,
               'type'    => (!$expand)?'start' : 'start:expanded'
            );

      }
      else{
        $clog_data[] = array(
           'content' => $content,
           'color'   => false,
           'type'    => 'end'
        );

      }
    }
  }
}

// deprecated, left for backward compatibility
function dlog(){}

if(!function_exists('my_upload_dir')){

  /**
  * modifies upload url and path
  *
  * @param $upload - array
  */
  function my_upload_dir($upload) {

    $upload['subdir'] = '/documents' . $upload['subdir'];

    $upload['path']   = $upload['basedir'] . $upload['subdir'];

    $upload['url']    = $upload['baseurl'] . $upload['subdir'];

    return $upload;
  }
}


if(!function_exists('add_svg_sprite')){
  function add_svg_sprite($slug = '', $url = THEME_URL.'/assets/sprite_svg/symbol_sprite.html'){
    $name_symbol = 'inlineSVGrev_'.$slug;
    $name_data = 'inlineSVGdata_'.$slug;
    echo "<script> ( function( window, document ) {var file = '".$url."', revision = 1; if( !document.createElementNS || !document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ).createSVGRect ){return true; }; var isLocalStorage = 'localStorage' in window && window[ 'localStorage' ] !== null, request, data, insertIT = function() {document.body.insertAdjacentHTML( 'afterbegin', data ); }, insert = function() {if( document.body ) insertIT(); else document.addEventListener( 'DOMContentLoaded', insertIT )}; if( isLocalStorage && localStorage.getItem( '".$name_symbol."' ) == revision ) {data = localStorage.getItem( '".$name_data."' ); if( data ) {insert(); return true; } }; try {request = new XMLHttpRequest(); request.open( 'GET', file, true ); request.onload = function(){if( request.status >= 200 && request.status < 400 ) {data = request.responseText; insert(); if( isLocalStorage ) {localStorage.setItem( '".$name_data."',  data ); localStorage.setItem( '".$name_symbol."', revision ); } } }; request.send(); }catch( e ){}; }( window, document ) ); </script>";
  }
}


if(!function_exists('print_inline_style')){
  /**
  *  prints an inline javascript.
  *  script adds styles to local storage
  *
  * @param $url - url of script
  * @param $script name - name of a script
  */
  function print_inline_style($url, $script_name){
    $script_name = str_replace('-', '_', $script_name);
    $script = sprintf(' (function(){function add_inline_%1$s() {var style = document.createElement(\'style\'); style.rel = \'stylesheet\'; document.head.appendChild(style); style.textContent = localStorage.%1$s; };
      var image_url = "%3$s"; var exp  = new RegExp("..\/images", "gi"); try {if (localStorage.%1$s) {add_inline_%1$s(); } else {var request = new XMLHttpRequest(); request.open(\'GET\', \'%2$s\', true); request.onload = function() {if (request.status >= 200 && request.status < 400) {var text =  request.responseText; text = text.replace(exp, image_url); localStorage.%1$s = text; add_inline_%1$s(); } }; request.send(); } } catch(ex) {} }());', $script_name, $url, THEME_URL.'/images/');

    printf('<script>%s</script>',$script);
  }
}


if(!function_exists('print_theme_template_part')){
  /**
  *  prints an inline javascript.
  *  script adds styles to local storage
  *
  * @param $url - url of script
  * @param $script name - name of a script
  */
  function print_theme_template_part($template_name,  $template_path, $args = array()){

    if(!empty($template_name) && ($template_path) ){
      extract($args);
      include(THEME_PATH.'/template-parts/'. $template_path . '/'.'template-'. $template_name .'.php');
    }
  }
}


if(!function_exists('include_php_from_dir')){

  /**
  * Includes all php files from specified directory
  *
  * @param $path - string
  */
  function include_php_from_dir($path){
    if(is_dir($path)){
      foreach (glob($path.'/*') as $child_name){
        if(is_dir($child_name)){
          include_php_from_dir($child_name);
        }else{
         if(file_exists( $child_name )){
           $ext = pathinfo($child_name, PATHINFO_EXTENSION);
           if($ext === 'php'){
             include_once($child_name);
           }
         }
        }
      }
    }else{
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if($ext === 'php'){
        include_once($path);
      }
    }
  }
}


if(!function_exists('test_filter')){
  function test_filter($data){
    print_r($data);
    return $data;
  }
}


if(!function_exists('print_theme_log')){
  /**
   * prints passed data to a file
   *
   * @param $log - mixed string|bool|integer|object
   */
  function print_theme_log($log){
    $log = print_r($log, true);
    file_put_contents(THEME_PATH.'/logs/post_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
  }
}

if(!function_exists('print_events_header')){
  function print_events_header(){
    $events_page_id = (int)get_option('theme_page_events');
    if ($events_page_id) {
      $page = get_post($events_page_id);
      echo apply_filters('the_content', $page->post_content);
    }
  }
}


if(!function_exists('get_styles_for_gmap_static')){
  function get_styles_for_gmap_static(){

    return array(
      'style=feature:poi|visibility:off',
      'style=element:geometry|color:0xf5f5f5',
      'style=element:labels.text.fill|color:0x616161',
      'style=element:labels.text.stroke|color:0xf5f5f5',
      'style=feature:administrative.land_parcel|element:labels.text.fill|color:0xbdbdbd',
      'style=feature:poi|element:geometry|color:0xeeeeee',
      'style=feature:poi|element:labels.text.fill|color:0x757575',
      'style=feature:poi.park|element:geometry|color:0xe5e5e5',
      'style=feature:poi.park|element:labels.text.fill|color:0x9e9e9e',
      'style=feature:road|element:geometry|color:0xffffff',
      'style=feature:road.arterial|element:labels.text.fill|color:e7e7e7',
      'style=feature:road.highway|element:geometry|color:0xdadada',
      'style=feature:road.highway|element:labels.text.fill|color:0x616161',
      'style=feature:road.local|element:labels.text.fill|color:0xffffff',
      'style=feature:transit.line|element:geometry|color:0xe5e5e5',
      'style=feature:transit.station|element:geometry|color:0xeeeeee',
      'style=feature:water|element:geometry|color:0xc9c9c9',
      'style=feature:water|element:labels.text.fill|color:0x9e9e9e',
      'style=feature:landscape|element:geometry.fill|color:0xf2f2f2',
    );
  }
}


function get_address_for_gmap($venue_id = null){
   $address = '';

  if(function_exists('tribe_get_full_address')){
    $forbidden_symbols = array(',', ':', '\'', '.', '#', PHP_EOL, '\\n', '&');
    $address = strip_tags(tribe_get_full_address($venue_id));
    $address = str_replace($forbidden_symbols, ' ', trim(strip_tags($address)));
    $address = preg_replace('/\s{1,}/', ' ', $address );

    $address = str_replace(' ', '+', $address );
  }

  return $address;
}


function print_venu_filter($grid_date = false, $display = 'month'){
  $date = new DateTime();
  $year  = $date->format('Y');
  $month = $grid_date? explode('-',$grid_date)[1] : $date->format('m');

  $months = array(
    'January'   => "01",
    'February'  => "02",
    'March'     => "03",
    'April'     => "04",
    'May'       => "05",
    'June'      => "06",
    'July'      => "07",
    'August'    => "08",
    'September' => "09",
    'October'   => "10",
    'November'  => "11",
    'December'  => "12",
  );

    $terms = get_terms( 'services_term', [
      'hide_empty' => false,
    ] );

  $locations = get_posts(array(
    'posts_per_page' => -1,
    'post_type' => 'tribe_venue',

    // 'meta_query' => array(
    //   'relation' => 'OR',
    //   array(
    //     'key'     => 'hide_the_filter',
    //     'compare_key' => 'LIKE',
    //     'compare' => 'NOT EXISTS',
    //   ),
    //   array(
    //     'key'     => 'hide_the_filter',
    //     'value'   => '0',
    //     'compare' => '!=',
    //   ),
    // ),
  ));


  $locations_grouped = array();

  foreach ($locations as $l) {
    $hide = get_post_meta($l->ID, 'hide_the_filter', true);
    $name = (trim(get_post_meta($l->ID,'display_name',true)))? trim(get_post_meta($l->ID,'display_name',true)) :$l->post_title;
    if($hide){
      continue;
    }

    if(!isset($locations_grouped[$name])){
      $locations_grouped[$name] = array(
        'name' => $name,
        'value' => array(),
      );
    }

    array_push($locations_grouped[$name]['value'], $l->ID);
  }

  usort($locations_grouped, 'compare_names');


  ?>
  <form action="javascript:void(0)" method="POST">
    <input type="hidden" value="<?php echo $display; ?>">
    <div class="events-filters">
      <div class="row " <?php echo "style='width: 100%'"?>>
        <div class="col-12 col-md-4">

          <label for="eventDate">Month</label>

          <select name="eventDate" id="eventDate" onchange='reloadDate(this, event)'>
            <?php foreach ($months as $mos => $num):
              printf('<option value="%1$s" %2$s>%3$s</option>',
                       "$year-$num",
                        $num  == $month? 'selected = "selected"' : '',
                        $mos
                    );
             endforeach; ?>
          </select> <div class="spacer-h-10 spacer-h-md-0"></div>
        </div>
        <div class="col-12 col-md-4 ">
          <label for="locations_filter">Locations</label>

          <select name="locations_filter" id="locations_filter" onchange='reloadDate(this, event)'>
            <option value="-1">Any location</option>
            <?php foreach ($locations_grouped as $name => $data):
              if(!$data['name']){continue;}
              printf('<option value="%1$s">%2$s</option>',
                        implode(',',$data['value']),
                        $data['name']
                    );
             endforeach; ?>
          </select> <div class="spacer-h-10 spacer-h-md-0"></div>
        </div>
        <div class="col-12 col-md-4">
          <label for="services_term">Service</label>

          <select name="services_term" id="services_term1" onchange='reloadDate(this, event)'>
             <option value="none">Any service</option>
            <?php foreach ($terms as $t):
              printf('<option value="%1$s" %2$s>%3$s</option>',
                        $t->slug,
                        $t  == $month? 'selected = "selected"' : '',
                        $t->name
                    );
             endforeach; ?>
          </select> <div class="spacer-h-30 spacer-h-md-0"></div>

        </div>
      </div>
  </div>
  </form>
  <?php
}

function compare_names($a, $b){
  if($a['name'] == $b['name']) return 0;

  return ($a['name'] < $b['name'])? -1: 1;

}

