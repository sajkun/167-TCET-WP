<?php
/**
 * The theme's index.php file.
 *
 */

get_header();

$content_class = orgafresh_get_content_layout( orgafresh_get_opt('alus_blog_layout') );
if( !is_active_sidebar( orgafresh_get_opt('alus_blog_left_sidebar') ) || !is_active_sidebar( orgafresh_get_opt('alus_blog_right_sidebar') )){
  $content_class['main_class'] = 'col-sm-12 col-xs-12';
}

orgafresh_page_heading();
?>
<div class="spacer-h-lg-70"></div>
<div class="container">
  <div class="row">

    <?php if( $content_class['left_sidebar'] && is_active_sidebar( orgafresh_get_opt('alus_blog_left_sidebar') ) ): ?>
      <aside id="left-sidebar" role="complementary" class="<?php echo esc_attr($content_class['left_sidebar_class']); ?>">
        <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_left_sidebar') ); ?>
      </aside>
    <?php endif; ?>

    <section id="content" class="site-content <?php echo esc_attr($content_class['main_class']); ?>">
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php
            switch($post->post_type){
              case 'theme_services':
                $terms = wp_get_post_terms($id, 'services_term', array('fields'=>'ids'));
                $color = false;

                if($terms){
                  $color               = get_term_meta($terms[0], 'events_color', true);
                }

                $args = array(
                  'post'            => $post,
                  'color'           => "style='background-color:$color'",
                  'type'            => 'program',
                );

                print_theme_template_part('search-preview','globals', $args);
                break;

              case 'tribe_events':
                $terms = wp_get_post_terms($id, 'services_term', array('fields'=>'ids'));
                $color = false;

                if($terms){
                  $color               = get_term_meta($terms[0], 'events_color', true);
                }

                $args = array(
                  'post'            => $post,
                  'color'           => "style='background-color:$color'",
                  'type'            => 'event',
                );

                print_theme_template_part('search-preview','globals', $args);
                break;

              case 'page':
                $terms = wp_get_post_terms($id, 'services_term', array('fields'=>'ids'));
                $color = false;

                if($terms){
                  $color               = get_post_meta($post->ID, 'main_color', true);
                }

                $post->post_content = $post->post_excerpt;

                $args = array(
                  'post'            => $post,
                  'color'           => "style='background-color:$color'",
                  'type'            => '',
                );

                print_theme_template_part('search-preview','globals', $args);
                break;
              default:
                // echo $post->post_type;
                break;
            }

           ?>
        <?php endwhile; ?>
        <?php orgafresh_pagination(); ?>
      <?php else : ?>
        <?php echo '<div class="alert alert-error">'.esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'orgafresh').'</div>'; ?>
        <?php get_search_form(); ?>
      <?php endif; ?>
    </section><!-- #content -->

    <?php if( $content_class['right_sidebar'] && is_active_sidebar( orgafresh_get_opt('alus_blog_right_sidebar') ) ): ?>
      <aside id="right-sidebar" role="complementary" class="<?php echo esc_attr($content_class['right_sidebar_class']); ?>">
        <?php dynamic_sidebar( orgafresh_get_opt('alus_blog_right_sidebar') ); ?>
      </aside>
    <?php endif; ?>

  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer();
