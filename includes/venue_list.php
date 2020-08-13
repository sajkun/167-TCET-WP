<?php
function show_venu_list($venues, $link_id = "venues", $limit = 6){

   $limit =  $limit - 1;
?>
  <div class="container no-paddings">
    <div class="venues-preview">
      <a id="<?php echo $link_id ?>"></a>
      <div class="row gutters-12">
       <?php

       $venues_formatted = array();

       // prepare formatted data for venues
       global $marker_url_term;
       foreach ($venues as $key => $venue_id){

          if(is_object($venue_id)){
            $venu = $venu_id;
          }else{
            $venu    = get_post($venue_id);
          }

           // get

          /**
          * @see includes/helpers.php
          */
          $address = get_address_for_gmap($venue_id);

          clog($address);

          /**
          * @see includes/helpers.php
          */
          $styles = get_styles_for_gmap_static();

          if($address){

          $google_map_static_url = sprintf('https://maps.googleapis.com/maps/api/staticmap?center=%1$s&zoom=%2$s&size=%3$s&key=%4$s&%8$s&markers=icon:%5$s|%6$s,%7$s',
            $address,
            15,
            '558x300',
            tribe_get_option('google_maps_js_api_key'),
            ($marker_url_term && function_exists('get_field')) ? $marker_url_term : get_field('marker_google_map_venue', $venue_id),
            get_field('latitude', $venue_id),
            get_field('longitude', $venue_id),
            implode('&', $styles)
          );
          }else{
            $google_map_static_url = false;
          }

          $multiple_contacts = get_field('multiple_contacts', $venue_id);


         $venues_formatted[] = array(
            'latitude'           => get_field('latitude', $venue_id),
            'multiple_contacts'  => $multiple_contacts? explode(PHP_EOL, $multiple_contacts) : false,
            'longitude'          => get_field('longitude', $venue_id),
            'responsible_person' => get_field('responsible_person', $venue_id),
            'block_id'           => 'theme_map_holder_'.$key,
            'marker'             => ($marker_url_term && function_exists('get_field')) ? $marker_url_term : get_field('marker_google_map_venue', $venue_id),
            'title'              => get_field('display_name', $venue_id)?:$venu->post_title,
            'address'            => (function_exists('tribe_get_full_address'))? strip_tags(tribe_get_full_address($venue_id) ): '',
            'phone'              => get_post_meta($venue_id, '_VenuePhone', true),
            'email'              => get_post_meta($venue_id, '_VenueEmail', true),
            'static_url'         => $google_map_static_url ,
            'search_url'         => "http://www.google.com/maps/place/?q=$address",
          );
       }

       $venues_show = $venues_formatted;

       foreach ($venues_show as $id =>  $venue):
        $hide_class = ($id > $limit && !isset($_GET['show']))? 'hidden' : '';
        ?>
        <div class="col-md-6 js-show-venue <?php echo $hide_class ?>">
          <div class="venue-preview">
        <?php

          //MAP
          // get data for google maps call
          $args_map = array(
            'latitude'  => $venue['latitude'],
            'longitude' => $venue['longitude'],
            'block_id'  => $venue['block_id'],
            'marker'    => $venue['marker'],
            'static_url'    => $venue['static_url'],
            'search_url'    => $venue['search_url'],
          );

          // print map
          echo  print_theme_template_part('preview-map', 'venue', $args_map);

          // VEBUE DETAILS

          // get details about location
          $args_info = array(
            'responsible_person' => $venue['responsible_person'],
            'phone'              => $venue['phone'],
            'email'              => $venue['email'],
            'title'              => $venue['title'],
            'address'            => $venue['address'],
            'multiple_contacts'  => $venue['multiple_contacts'],
          );

          // print details of location
          echo  print_theme_template_part('preview-info', 'venue', $args_info);
        ?>
          </div> <?php // end venue-preview ?>
          <div class="spacer-h-20"></div>
        </div>
       <?php  endforeach; ?>
      </div><!-- row -->
    </div><!-- venues-preview -->
   <?php if (count($venues_formatted) > $limit && !isset($_GET['show'])): ?>
    <div class="spacer-h-50"></div>
    <div class="text-center">
      <a href="<?php echo get_permalink(get_queried_object_id())?>/?show=yes#<?php echo $link_id ?>" class="load-more-venues"><?php _e('Show More Locations', 'theme-translations')?></a>
    </div>
   <?php endif ?>
  </div><!-- container -->

  <div class="spacer-h-50"></div>
  <?php
}