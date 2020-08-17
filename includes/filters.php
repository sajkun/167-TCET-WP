<?php

add_filter('body_class', 'check_header');

function check_header($classes){
  $classes[] = orgafresh_get_opt('alus_header_top_bar')? 'has-top-bar'  : 'no-top-bar';
  return $classes;
}



function entex_fn_remove_post_type_from_search_results($query){

    /* check is front end main loop content */
    if(is_admin() || !$query->is_main_query()) return;

    /* check is search result query */
    if($query->is_search()){

        $post_type_to_show = array('theme_services', 'tribe_events');
        /* get all searchable post types */
        $searchable_post_types = get_post_types(array('exclude_from_search' => false));

        foreach($searchable_post_types as $post_type){
          if(is_array($searchable_post_types) && !in_array($post_type, $post_type_to_show)){
              unset( $searchable_post_types[ $post_type ] );
          }
        }
        $query->set('post_type', $searchable_post_types);
    }
}

add_action('pre_get_posts', 'entex_fn_remove_post_type_from_search_results');


add_action('pre_get_posts', 'request_mod_events');

function request_mod_events($query){

    // print_theme_log($query);

    if($_REQUEST && isset($_REQUEST['search_service_term']) && $_REQUEST['search_service_term'] !== 'none' && $query->query_vars['post_type'] === 'tribe_events'){
      $taxquery = array( array(
        'taxonomy' => "services_term",
        'field' => 'slug',
        'terms' => $_REQUEST['search_service_term']
      ) );

      $query->set( 'tax_query', $taxquery );
    }


    if($_REQUEST && isset($_REQUEST['venue_id']) && $_REQUEST['venue_id'] != '-1' && $query->query_vars['post_type'] === 'tribe_events'){
        $meta_query = (array)$query->get('meta_query');

        $ids = explode(',', $_REQUEST['venue_id']);

          $meta_query[] = array(
                  'key'     => '_EventVenueID',
                  'value'   => $ids,
                  'compare' => 'IN',
          );

        $query->set('meta_query',$meta_query);
    }

}


add_filter('tribe_get_option', 'test_tribe_get_option', 10, 3);

function test_tribe_get_option($option, $optionname, $default){

  if(wp_is_mobile() && $optionname == 'viewOption'){
    return 'list';
  }

  return $option;
}



add_filter('tribe_events_ical_single_event_links', 'tribe_events_ical_single_event_links_filter', 1000, 1);

function tribe_events_ical_single_event_links_filter($links){

  $html = '<a href="javascript:print_pdf(' . get_queried_object_id() . ')" id="exec-print-pdf" class="button tribe-events-button">Download PDF</a>';


  $links = str_replace('</div>', $html.'</div>', $links);
  return $links;
}



add_filter('the_title', 'filter_event_related_title', 10 , 2);

function filter_event_related_title($title, $post_id){


  $meta = get_post_meta($post_id, 'related_programm', true);

  if($meta){
    $program = get_post($meta);
    return $program->post_title;
  }

  return $title;
}


add_filter('tribe_get_event', 'filter_event_related_content', 100 ,3);


function filter_event_related_content($post, $output,$filter){


  $programm_id = get_post_meta($post->ID, 'related_programm', true);

  if($programm_id){
    $programm = get_post($programm_id);

    if($programm){
      $limit = 320;
      $post->post_content = $programm->post_content;
      $text  = strip_tags(strip_shortcodes($programm->post_content));
      $after = strlen($text) > $limit ? '...' : '';
      $post->excerpt = ($programm->excerpt)? $programm->excerpt : '<p>'. substr($text, 0 , $limit) . $after . '</p>';
    }
  }
  return $post;
}


add_action('wp_head', 'filter_tribe_events_content');

function filter_tribe_events_content(){
  global $post;

  if($post->post_type === 'tribe_events' && is_single()){
    $programm_id = get_post_meta($post->ID, 'related_programm', true);
    $programm = get_post($programm_id);

    if($programm){
      $post->post_content = strip_shortcodes($programm->post_content);
    }
  }
}