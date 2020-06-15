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