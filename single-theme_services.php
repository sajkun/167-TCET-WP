<?php
global $post;
get_header();
$content_class = orgafresh_get_content_layout(orgafresh_get_opt('alus_blog_details_layout'));
if( !is_active_sidebar( orgafresh_get_opt('alus_blog_details_left_sidebar') ) || !is_active_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ) ){
  $content_class['main_class'] = 'col-sm-12 col-xs-12';
}

  orgafresh_page_heading();
  // get page welcome screen

  // get categorie,s title to style content
  $id = get_queried_object_id();
  $terms = wp_get_post_terms($id, 'services_term', array('fields'=>'ids'));

  $color = false;

  if($terms){
    $color = get_term_meta($terms[0], 'events_color', true);
  }

  if($color){
    ?>
      <style>
        .service-content ul li:before{
          color: <?php echo $color; ?>;
        }
        .fullwidth-title{
          background-color: <?php echo $color; ?>;
        }
        .event-data__more,
        .event-data__icon,
        .event-data__decoration,
        .event-data__overlay{
          background-color: <?php echo $color; ?>;
        }
      </style>
    <?php
  }
?>
<section id="content" class="site-content <?php echo esc_attr($content_class['main_class']); ?>">

  <div class="container service-content">
  <?php
    echo the_content();
   ?>
  </div>

  <div class="spacer-h-20"></div>

  <?php // print eligibility content ?>
  <?php
    $eligibility = get_field('eligibility');

    if ($eligibility) {
      ?>
      <section class="fullwidth-title">
        <div class="container">
          <?php _e('Eligibility','theme-translations');?>
        </div>
      </section>
    <div class="spacer-h-20"></div>
    <div class="container service-content">
      <?php echo apply_filters( 'the_content', $eligibility ); ?>
    </div>

    <?php
    }
  ?>

  <div class="spacer-h-20"></div>

  <?php
    $related_events = get_field('related_events');

    if ($related_events) {
      ?><div class="container">
        <?php
      printf("<h2>%s</h2>",__('Upcoming Events & Workshops', 'theme-translations'));

      ?><div class="spacer-h-40"></div>
        <?php
      foreach ($related_events as $event_id) {
        $event = get_post($event_id);
        $image_id = get_post_thumbnail_id($event_id);
        $start  = get_post_meta($event_id, '_EventStartDate', true);
        $start  = get_post_meta($event_id, '_EventEndDate', true);
        $start   = new DateTime($start);
        $end   = new DateTime($end);

        $venue_id = (int)get_post_meta($event_id, '_EventVenueID',true);

        $address = array(
          get_post_meta($venue_id,'_VenueZip', true),
          get_post_meta($venue_id,'_VenueCity', true),
          get_post_meta($venue_id,'_VenueProvince', true),
          get_post_meta($venue_id,'_VenueAddress', true),
        );

        $args = array(
          'title' => $event->post_title,
          'image_url'   => wp_get_attachment_image_url( $image_id, 'event_data', false ),
          'permalink'   => get_permalink($event),
          'date_start'  =>  $start->format('l, F d, Y'),
          'time_start'  =>  $start->format('h:i a'),
          'time_end'    =>  $end->format('h:i a'),
          'address' => implode(', ', $address),
          'topics' => get_field('event_topic', $event_id),
        );

        print_theme_template_part('preview', 'events', $args);

      }

       ?></div><?php
    }
  ?>

  <div class="spacer-h-20"></div>
  <div class="spacer-h-20"></div>

  <?php  $locations = get_field('locations');
    if ($locations):
     ?>
      <section class="fullwidth-title">
        <div class="container">
          <?php _e('Locations','theme-translations');?>
        </div>
      </section>
      <div class="spacer-h-50"></div>

      <div class="container">


        <div class="row">

      <?php
         foreach ($locations as $key => $location_id) {
          ?>
          <div class="col-md-6">
          <?php
            $args = array(
              'latitude' => get_field('latitude', $location_id),
              'longitude' => get_field('longitude', $location_id),
              'block_id' => 'theme_map_holder_'.$key,
            );

            echo  print_theme_template_part('location-map', 'events', $args);
          ?>
          </div>
         <?php  }; ?>
        </div>
        </div>
        <div class="spacer-h-50"></div>

    <?php endif; ?>



 </section><!-- #content -->

 <?php if( $content_class['right_sidebar'] && is_active_sidebar(orgafresh_get_opt('alus_blog_details_right_sidebar'))  ): ?>
  <aside id="right-sidebar" role="complementary" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
    <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ); ?>
  </aside>
  <?php endif; ?>

<?php get_footer();