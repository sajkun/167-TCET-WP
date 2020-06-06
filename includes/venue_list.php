<?php
function show_venu_list($venues, $link_id = "venues", $limit = 6){

   $limit =  $limit - 1;
?>
  <div class="container no-paddings">
    <div class="venues-preview">
      <a id="<?php echo $link_id ?>"></a>
      <div class="row">
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

          $address = array(
            get_post_meta($venue_id,'_VenueZip', true),
            get_post_meta($venue_id,'_VenueCity', true),
            get_post_meta($venue_id,'_VenueProvince', true),
            get_post_meta($venue_id,'_VenueAddress', true),
          );

         $venues_formatted[] = array(
            'latitude'  => get_field('latitude', $venue_id),
            'longitude' => get_field('longitude', $venue_id),
            'block_id'  => 'theme_map_holder_'.$key,

            'marker'    => ($marker_url_term) ? $marker_url_term : get_field('marker_google_map_venue', $venue_id),
            'title'     => $venu->post_title,
            'address'   => implode(' ', $address),
            'phone'     => get_post_meta($venue_id, '_VenuePhone', true),
            'email'     => get_post_meta($venue_id, '_VenueEmail', true),
          );
       }

       $venues_show = $venues_formatted;

       foreach ($venues_show as $id =>  $venue):
        $hide_class = ($id > $limit && !isset($_GET['show']))? 'hidden' : '';
        ?>
        <div class="col-md-6 venue-preview <?php echo $hide_class ?>">
        <?php

          //MAP
          // get data for google maps call
          $args_map = array(
            'latitude'  => $venue['latitude'],
            'longitude' => $venue['longitude'],
            'block_id'  => $venue['block_id'],
            'marker'    => $venue['marker'],
          );

          // print map
          echo  print_theme_template_part('preview-map', 'venue', $args_map);

          // VEBUE DETAILS

          // get details about location
          $args_info = array(
            'phone'   => $venue['phone'],
            'email'   => $venue['email'],
            'title'   => $venue['title'],
            'address' => $venue['address'],
          );

          // print details of location
          echo  print_theme_template_part('preview-info', 'venue', $args_info);
        ?>
        </div> <?php // end venue-preview ?>
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