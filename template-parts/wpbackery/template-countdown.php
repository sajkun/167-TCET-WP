<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>
<div class="countdown">
  <div class="row">
    <div class="col-12 col-lg-4 text-center text-left-lg">
      <p class="countdown__organizer-venue">
        <?php if ($organizer):
          echo $organizer .' | ';
        endif;
        if ($venue):
          echo $venue;
        endif; ?>
      </p>
      <a href="<?php echo $url ?>" class="countdown__event-title">
        <?php echo $title; ?>
      </a>

      <div class="spacer-h-40 spacer-h-lg-0"></div>
    </div>
    <div class="col-12 col-md-12 col-lg-6">
      <div class="row justify-content-between fullheight">
        <div class="col-4 col-md-3 valign-center">
          <div class="countdown__item">
            <span class="value days" data-value="<?php echo $diff->days ?>"><?php echo $diff->days ?></span>
            <span class="label" data-single="<?php _e('day', 'theme-translation')?>" data-multiple="<?php _e('days', 'theme-translation')?>"><?php echo _n('day', 'days', $diff->days); ?></span>
          </div>
        </div>
        <div class="col-4 col-md-3 valign-center">
          <div class="countdown__item">
            <span class="value hours" data-value="<?php echo $diff->h ?>"><?php echo $diff->h ?></span>
            <span class="label" data-single="<?php _e('hr', 'theme-translation')?>" data-multiple="<?php _e('hrs', 'theme-translation')?>"><?php echo _n('hr', 'hrs', $diff->h); ?></span>
          </div>
        </div>
        <div class="col-4 col-md-3 valign-center">
          <div class="countdown__item">
            <span class="value minutes" data-value="<?php echo $diff->i ?>"><?php echo $diff->i ?></span>
            <span class="label" data-single="<?php _e('min', 'theme-translation')?>" data-multiple="<?php _e('mins', 'theme-translation')?>"><?php echo _n('min', 'mins', $diff->i); ?></span>
          </div>
        </div>
        <div class="col-md-3 hide-mobile valign-center">
          <div class="countdown__item">
            <span class="value seconds" data-value="<?php echo $diff->s ?>"><?php echo $diff->s ?></span>
            <span class="label" data-single="<?php _e('sec', 'theme-translation')?>" data-multiple="<?php _e('sec', 'theme-translation')?>"><?php echo _n('sec', 'sec', $diff->s); ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-2 text-center text-right-lg valign-center">
      <div class="spacer-h-40 spacer-h-lg-0"></div>
      <a href="<?php echo $url; ?>" class="countdown__button">LEARN MORE</a>
      <a href="<?php echo $url_events; ?>" class="countdown__button v2 show-tablet">View All Events</a>
    </div>
  </div>

  <div class="hide-mobile hide-tablet text-center">
    <div class="spacer-h-40"></div>
    <a href="<?php echo $url_events; ?>" class="countdown__button  v2">View All Events</a>
  </div>
</div>