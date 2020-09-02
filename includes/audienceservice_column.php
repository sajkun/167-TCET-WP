<?php
add_filter( 'manage_tribe_events_posts_columns', 'set_audience_to_event', 10 );

add_action( 'manage_tribe_events_posts_custom_column' , 'custom_audience_category', 3, 2 );

function set_audience_to_event($columns) {
    $columns['audience'] = __( 'Audience', 'theme-translations' );
    return $columns;
}

function custom_audience_category( $column, $post_id ) {
    switch ( $column ) {

        case 'audience' :

          $terms = wp_get_post_terms($post_id, 'audience_category');
          $data = array();

          if ($terms) {

            foreach ($terms as $key => $term) {
              $data[] = $term->name;
            }
          }else{
            echo '—';
          }

          echo implode(', ',$data) ;

          break;
    }
}

function sortable_custom_columns( $columns ) {
    $columns['audience'] = __( 'Audience', 'theme-translations' );
    return $columns;
}
add_filter( 'manage_edit-tribe_events_sortable_columns', 'sortable_custom_columns' );