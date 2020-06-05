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
          color: <?php echo $color; ?>
        }
      </style>
    <?php
  }



  clog($color);
?>
<section id="content" class="site-content <?php echo esc_attr($content_class['main_class']); ?>">

  <div class="container service-content">


  <?php
    echo the_content();


  // logos

  // content

  // elegibility

  // related events

  // locations

   ?>
  </div>


 </section><!-- #content -->

 <?php if( $content_class['right_sidebar'] && is_active_sidebar(orgafresh_get_opt('alus_blog_details_right_sidebar'))  ): ?>
  <aside id="right-sidebar" role="complementary" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
    <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ); ?>
  </aside>
  <?php endif; ?>

<?php get_footer();