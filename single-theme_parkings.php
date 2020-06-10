<?php
global $post;
get_header();
$content_class = orgafresh_get_content_layout(orgafresh_get_opt('alus_blog_details_layout'));
if( !is_active_sidebar( orgafresh_get_opt('alus_blog_details_left_sidebar') ) || !is_active_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ) ){
  $content_class['main_class'] = 'col-sm-12 col-xs-12';
}

  orgafresh_page_heading(); ?>

<section id="content" class="site-content <?php echo esc_attr($content_class['main_class']); ?>">

  <div class="container service-content">
  <?php
    echo the_content();
   ?>
  </div>

 </section><!-- #content -->

 <?php if( $content_class['right_sidebar'] && is_active_sidebar(orgafresh_get_opt('alus_blog_details_right_sidebar'))  ): ?>
  <aside id="right-sidebar" role="complementary" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
    <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_details_right_sidebar') ); ?>
  </aside>
  <?php endif; ?>

<?php get_footer();