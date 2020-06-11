<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
class WPBakeryShortCode_member_of_team extends WPBakeryShortCode {
   protected function content( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'term_ids' => false,
    ), $atts ) );

    $ids = explode(',', $term_ids);

    $args =  array(
      'posts_per_page' => -1,
      'post_type'      => 'team_member',
      'field' => 'ids',

    );

    if($ids){
      $args['tax_query'] = array(array(
            'taxonomy' => 'team_term',
            'field' => 'id',
            'terms' => $ids // Where term_id of Term 1 is "1".
          ) );
    }

    $members = get_posts($args);

    if(! $members) return;
    ob_start();
    ?><div class="row"><?php

    foreach ($members as $key => $m) {
      $img_id = get_post_thumbnail_id($m->ID);
      $args_team = array(
        'image_url' => wp_get_attachment_image_url($img_id, 'photo_team') ?:THEME_URL.'/assets/images/girl.svg',
        'name'      => get_post_meta( $m->ID, 'name', true),
        'certificationcertification'      => get_post_meta( $m->ID, 'certificationcertification', true),
        'title'      => get_post_meta( $m->ID, 'title', true),
        'certifications'      => get_post_meta( $m->ID, 'certifications', true),
        'summary'      => strip_tags(strip_shortcodes($m->post_content)),
        'email'      => get_post_meta( $m->ID, 'email', true),
      );

    ?> <div class="col-12 col-md-6 col-lg-4" style="order: <?php echo get_post_meta( $m->ID, 'order', true); ?>"> <?php

      print_theme_template_part('team-member','wpbackery', $args_team);

   ?>
      </div>
    <?php
    }
    ?>
      </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
  }
}


add_action('vc_before_init', 'map_member_of_team');

function map_member_of_team(){
  $args = array(
  );

  $terms = get_terms('team_term', array('hide_empty' => false));

  $values = array();
  foreach ($terms as $t) {
    $values[$t->name] = $t->term_id;
  }


  vc_map( array(
      'base' => 'member_of_team',
      'name' => __( 'Team Member show', 'theme-translation' ),
      'class' => '',
      'category' => __( 'Theme Shortcodes' ),
      'icon' => THEME_URL.'/assets/images/girl.svg',
      'description' => __('Shows a list of team members', 'theme-translation'),
      'show_settings_on_create' => true,
      'params' => array(
          array(
            'type' => 'dropdown_multi',
            "heading" => __('Categories', 'theme-translation'),
            'param_name' => 'term_ids',
            'description' => __('Multiple selection possible', 'theme-translation'),
            'value' => $values,
          ),
      ),
  ));


}