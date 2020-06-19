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
    $color               = get_term_meta($terms[0], 'events_color', true);
    $secondary_color     = get_term_meta($terms[0], 'secondary_color', true);
    $marker_id           = get_term_meta($terms[0], 'marker_google_map_term', true);

    global $marker_url_term;
    $marker_url_term = wp_get_attachment_image_url($marker_id, 'full');
  }


   // stylings depending on category
  if($secondary_color){
    ?>
      <style>
     .featured-program{
       background-color: <?php echo $secondary_color; ?>;
      }

      </style>
    <?php
  }
  if($color){
    ?>
      <style>

        .venue-preview__contacts li:before{
          background-color: <?php echo $color; ?>;
        }

        .service-content ul li:before{
          color: <?php echo $color; ?>;
        }
        .fullwidth-title{
          background-color: <?php echo $color; ?>;
        }

        .service-content a{
          color: <?php echo $color; ?>;
        }
        .service-content a[download]{
          color: #fff;
        }
        .service-content a[download],
        .event-data__more,
        .event-data__icon,
        .featured-program__more,
        .event-data__decoration,
        .load-more-venues,
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

  <div class="spacer-h-30 spacer-h-lg-60"></div>

  <?php

  $limit = 6;

  for($i = 1; $i <= $limit; $i++){

    $data = get_field('program_'.$i);

    if(!$data['show'] || (!$data['title'] && !$data['text'])){
      continue;
    }

    $args = array(
      'title' => $data['title'],
      'text' => $data['text'],
      'button_text' => $data['button_text']? $data['button_text'] : __('Read More', 'theme-translations'),
      'button_url' => $data['button_url'],
    );


    print_theme_template_part('featured-program', 'wpbackery', $args);

    if($i!== $limit){

      echo '<div class="spacer-h-50"></div>';
    }
  }

  ?>

  <?php

    $future_events_category = get_field('future_events_category');

    $args = array(
       'posts_per_page' => 3,
       'start_date'     => new DateTime('today'),
       'fields' => 'ids',
    );

    if($future_events_category && !is_a('WP_Error', $future_events_category)){
       $args['tax_query'] = array( array(
          'taxonomy' => "tribe_events_cat",
          'field' => 'id',
          'terms' =>  $future_events_category->term_id
        ) );
    }
    $future_events = tribe_get_events($args);

     glog('event', true);
     clog($future_events);
     glog(false);

    if ($future_events) {
      ?><div class="spacer-h-40"></div><div class="container no-paddings">
        <?php
      printf("<h2>%s</h2>",__('Upcoming Events & Workshops', 'theme-translations'));

      ?><div class="spacer-h-40"></div>
        <?php
      foreach ($future_events as $event_id) {
        $event = get_post($event_id);
        $image_id = get_post_thumbnail_id($event_id);
        $start  = get_post_meta($event_id, '_EventStartDate', true);
        $start   = new DateTime($start);
        $end    = get_post_meta($event_id, '_EventEndDate', true);
        $end    = new DateTime($end);

        $venue_id = (int)get_post_meta($event_id, '_EventVenueID',true);

        $address = array(
          get_post_meta($venue_id,'_VenueZip', true),
          get_post_meta($venue_id,'_VenueCity', true),
          get_post_meta($venue_id,'_VenueProvince', true),
          get_post_meta($venue_id,'_VenueAddress', true),
        );
        $address_formatted = array();
        foreach ($address as $key => $a) {
          if($a){
            array_push($address_formatted, $a);
          }
          # code...
        }

        $args = array(
          'title' => $event->post_title,
          'image_url'   => wp_get_attachment_image_url( $image_id, 'event_data', false ),
          'permalink'   => get_permalink($event),
          'date_start'  =>  $start->format('l, F d, Y'),
          'time_start'  =>  $start->format('h:i a'),
          'time_end'    =>  $end->format('h:i a'),
          'address' => implode(', ', $address_formatted),
          'topics' => get_field('event_topic', $event_id),
        );

        print_theme_template_part('preview', 'events', $args);

      }

       ?></div><?php
    }
  ?>

  <div class="spacer-h-20"></div>
  <div class="spacer-h-20"></div>

   <?php
   /**
   * prints venues for event
   */


  // get stored venues
  $venues = get_field('locations');
    if ($venues):
      ?>
        <section class="fullwidth-title">
          <div class="container">
            <?php _e('Locations','theme-translations');?>
          </div>
        </section>
        <div class="spacer-h-50"></div>

        <div class="row-xs">

      <?php
      /**
      * @see includes/venue_list.php
      */
      show_venu_list($venues);
        ?> </div> <?php

    endif; ?>



 </section><!-- #content -->

 <?php if( $content_class['right_sidebar'] && is_active_sidebar(orgafresh_get_opt('alus_blog_details_right_sidebar'))  ): ?>
  <aside id="right-sidebar" role="complementary" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
    <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ); ?>
  </aside>
  <?php endif; ?>

<?php get_footer();