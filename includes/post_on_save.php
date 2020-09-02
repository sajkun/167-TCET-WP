<?php
add_action('save_post', 'push_custom_save');


function push_custom_save( $post_id ){

  if(isset($_POST['_custom_attachment'])){
    $thumbnail_id = (int)$_POST['_custom_attachment'];
    if($thumbnail_id >=0 ){
      set_post_thumbnail( $post_id, $thumbnail_id);
    }else{
      delete_post_thumbnail( $post_id);
    }
  }


  // saves terms on event save if related program assigned
  if(isset($_POST['acf'])){
    $field = get_field_object('related_programm');
    $key = $field['key'];

    if(isset($_POST['acf'][$key])){
       $terms     = wp_get_post_terms( $_POST['acf'][$key], 'services_term' );
       $terms_old = wp_get_post_terms(  $post_id, 'services_term' );
       if( $terms != $terms_old ){
         foreach ($terms_old as  $term_old) {
           wp_remove_object_terms( $post_id, $term_old->term_id, 'services_term' );
         }
         foreach ($terms as $term) {
           wp_set_post_terms( $post_id, array($term->term_id),  'services_term', true);
         }
       }
    }
  }
}
