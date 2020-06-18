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

          $address = '';

          if(function_exists('tribe_get_full_address')){
            $address = strip_tags(tribe_get_full_address($venue_id));
            $address = str_replace(array(',', ':', PHP_EOL, '\\n'), ' ', trim(strip_tags($address)));
            $address = preg_replace('/\s{1,}/', ' ', $address );

            $address = str_replace(' ', '+', $address );
          }

          $styles = array(
            'style=element:geometry|color:0xf5f5f5',
            'style=element:labels.icon|visibility:off',
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


         $venues_formatted[] = array(
            'latitude'  => get_field('latitude', $venue_id),
            'longitude' => get_field('longitude', $venue_id),
            'block_id'  => 'theme_map_holder_'.$key,

            'marker'    => ($marker_url_term && function_exists('get_field')) ? $marker_url_term : get_field('marker_google_map_venue', $venue_id),
            'title'     => $venu->post_title,
            'address'   => (function_exists('tribe_get_full_address'))? strip_tags(tribe_get_full_address($venue_id) ): '',
            'phone'     => get_post_meta($venue_id, '_VenuePhone', true),
            'email'     => get_post_meta($venue_id, '_VenueEmail', true),
            'static_url'     => $google_map_static_url ,
            'search_url'     => "http://www.google.com/maps/place/?q=$address",
          );
       }

       $venues_show = $venues_formatted;

       foreach ($venues_show as $id =>  $venue):
        $hide_class = ($id > $limit && !isset($_GET['show']))? 'hidden' : '';
        ?>
        <div class="col-md-6 ">
          <div class="venue-preview <?php echo $hide_class ?>">
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