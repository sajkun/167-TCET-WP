<?php
  $text =  strip_tags(strip_shortcodes($post->post_content));
  $text = (strlen($text) > 240)? substr($text, 0, 240).'...' : $text;
?>

<div class="event-list">
  <div class="row">
    <div class="col-12">
     <i><?php echo $type ?></i>

    </div>
    <div class="col-12">
      <h3 class="event-list__title">
         <a href="<?php echo get_permalink($post); ?>" title="<?php echo esc_attr($post->post_title) ?>" rel="bookmark" class="tribe-events-calendar-list__event-title-link tribe-common-anchor-thin"> <?php echo esc_attr($post->post_title); ?></a>
      </h3>
    </div>
  </div>

  <div class="event-list__service-marker" <?php echo $color ?>></div>

  <article class="clearfix">
    <div class="event-filter__text">
      <p><?php echo $text; ?></p>
    </div>
    <div class="spacer-h-30"></div>

    <a href="<?php echo get_permalink($post); ?>" class="event-list__more">Learn More</a>
  </article>
</div>