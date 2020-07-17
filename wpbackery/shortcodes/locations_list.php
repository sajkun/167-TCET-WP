<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

class WPBakeryShortCode_theme_locations_list extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
    ), $atts ) );


    $args_venues = array(
      'posts_per_page' => -1,
      'post_type'      => LOCATIONS_POST,
      'order' => 'asc',
      'order_by' => 'date',
       'meta_query' => array(
           array(
               'key' => 'show_in_locations',
               'value' => 'yes',
               'compare' => '=',
           )
       )
    );

    $venues = get_posts($args_venues );

    if(!$venues){
      return;
    }
    ob_start();
    ?>
      <div class="row">
        <div class="col-lg-8">
          <form action="javascript:void(0)" method="POST" id="search-locations-form">
            <div class="search-locations-wrapper row no-gutters">

              <div class="col-10">
                <input type="search" class="field" placeholder="<?php _e('Search','theme-translations');?>">
              </div>

              <div class="col-2 text-right">
                <button type="submit">
                  <svg width="20" height="18" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 20 18"><defs><clipPath id="ClipPath1021"><path d="M-0.00024,8.49994c0,-4.69442 4.02944,-8.5 9,-8.5c4.97056,0 9,3.80558 9,8.5c0,4.69442 -4.02944,8.5 -9,8.5c-4.97056,0 -9,-3.80558 -9,-8.5z" fill="#ffffff"></path></clipPath><clipPath id="ClipPath1030"><path d="M-0.00024,8.49994c0,-4.69442 4.02944,-8.5 9,-8.5c4.97056,0 9,3.80558 9,8.5c0,4.69442 -4.02944,8.5 -9,8.5c-4.97056,0 -9,-3.80558 -9,-8.5z" fill="#ffffff"></path></clipPath></defs><desc>Generated with Avocode.</desc><g><g><title>Line 17</title><path d="M15.01497,13.34563l4.52332,3.28969" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#776e64" stroke-miterlimit="20" stroke-width="2"></path></g><g><title>Ellipse 10</title><path d="M-0.00024,8.49994c0,-4.69442 4.02944,-8.5 9,-8.5c4.97056,0 9,3.80558 9,8.5c0,4.69442 -4.02944,8.5 -9,8.5c-4.97056,0 -9,-3.80558 -9,-8.5z" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#776e64" stroke-miterlimit="20" stroke-width="4" clip-path="url(&quot;#ClipPath1021&quot;)"></path></g><g><title>Group 530</title><g><title>Ellipse 10</title><path d="M-0.00024,8.49994c0,-4.69442 4.02944,-8.5 9,-8.5c4.97056,0 9,3.80558 9,8.5c0,4.69442 -4.02944,8.5 -9,8.5c-4.97056,0 -9,-3.80558 -9,-8.5z" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#776e64" stroke-miterlimit="20" stroke-width="4" clip-path="url(&quot;#ClipPath1030&quot;)"></path></g><g><title>Line 17</title><path d="M15.01497,13.34563l4.52332,3.28969" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#776e64" stroke-miterlimit="20" stroke-width="2"></path></g></g></g></svg>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
     <div class="row location-items no-gutters-cols">
    <?php

    foreach ($venues as $key => $venue){

      $city_province = array(
        get_post_meta( $venue->ID, '_VenueCity', true ),
        get_post_meta( $venue->ID, '_VenueProvince', true ),
        get_post_meta( $venue->ID, '_VenueZip', true ),
      );

      $city_province_ = array();

      foreach ($city_province as $value) {
        if($value){
          $city_province_[] = $value;
        }
      }

      $terms_id = get_field('service', $venue->ID);
      // $term    = get_term( $term_id, "services_term" );

      $terms = array();

      $search = array(
         $venue->post_title,
         get_post_meta( $venue->ID, '_VenueAddress', true ),
         implode(', ', $city_province_ ),

      );

      $terms_name = array();

      foreach ($terms_id as $key => $term_id) {
        $terms[] = $term = get_term($term_id, "services_term");

        if($term && !is_a($term, "WP_Error")){
          array_push($search, $term->name);
          array_push($terms_name, $term->name);
        }
      }

     /**
      * @see includes/helpers.php
      */
      $address = get_address_for_gmap($venue->ID);


      /**
      * @see includes/helpers.php
      */
      $styles = get_styles_for_gmap_static();

      $google_map_static_url = sprintf('https://maps.googleapis.com/maps/api/staticmap?center=%1$s&zoom=%2$s&size=%3$s&key=%4$s&%5$s',
        $address,
        15,
        '243x211',
        tribe_get_option('google_maps_js_api_key'),
        implode('&', $styles)
      );

      $args = array(
          'title'            => get_field('display_name', $venue->ID)?:$venue->post_title,
          'title_data'       =>get_post_meta($venue->ID, '_VenueCity', true),
          'category'         => implode(',', $terms_name),
          'image_url'        => $google_map_static_url ,
          'show_parkings'    => get_field('show_parkings', $venue->ID),
          'parking_url'      => get_field('parking_url', $venue->ID),
          'marker_url'       => get_field('marker_google_map_venue', $venue->ID),
          'meta'             => get_post_meta( $venue->ID ),
          'address'          => get_post_meta( $venue->ID, '_VenueAddress', true ),
          'city_province'    => implode(', ', $city_province_ ),
          'search'           => implode(', ', $search ),
          'email'            => get_post_meta( $venue->ID, '_VenuePhone', true ),
          'phone'            => get_post_meta( $venue->ID, '_VenuePhone', true ),
          'phone_lng'        => get_post_meta( $venue->ID, 'phone_lng', true ),
          'hours'            => get_post_meta( $venue->ID, 'hours_of_operation', true ),
          'lat'              => get_post_meta( $venue->ID, 'latitude', true ),
          'lng'              => get_post_meta( $venue->ID, 'longitude', true ),
      );


      ?> <div class="col-12 col-xs-6 col-sm-6 col-lg-4 js-parent"> <?php

        print_theme_template_part('location-item','wpbackery', $args);

      ?>
      <div class="spacer-h-30"></div>
      </div> <?php
    }
    ?> </div> <?php
    $output = ob_get_contents();
    ob_end_clean();
     return $output;
   }
}

add_action('vc_before_init', 'vc_before_init_theme_locations_list');

function vc_before_init_theme_locations_list(){
  vc_map( array(
    'base' => 'theme_locations_list',
    'name' => __( 'Locations list', 'theme-translation' ),
    'class' => '',
    'category' => __( 'Theme Shortcodes' ),
    'icon' => THEME_URL.'/assets/images/icons/locations.png',

    'description' => __('Locations list with markers', 'theme-translation'),

    'show_settings_on_create' => false,

    'params' => array(

    ),
  ));
}