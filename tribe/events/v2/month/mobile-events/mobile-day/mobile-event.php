<?php
/**
 * View: Month View Mobile Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/month/mobile-events/mobile-day/mobile-event.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
$classes = tribe_get_post_class( [ 'tribe-events-calendar-month-mobile-events__mobile-event' ], $event->ID );
$classes['tribe-events-calendar-month-mobile-events__mobile-event--featured'] = $event->featured;

$terms = wp_get_post_terms( $event->ID, 'services_term', array( 'field' => 'ids' ) );
$color= false;
if($terms){
  $color = count($terms) > 0 ?  get_term_meta($terms[0]->term_id, 'events_color', true) : '#eee';
}
$style = "style='background-color:$color'";
?>

<article <?php tribe_classes( $classes ); ?>>

	<?php $this->template( 'month/mobile-events/mobile-day/mobile-event/featured-image', [ 'event' => $event ] ); ?>

	<div class="tribe-events-calendar-month-mobile-events__mobile-event-details">

    <div class="row">
      <div class="col-6 col-xs-6">
  		<?php $this->template( 'month/mobile-events/mobile-day/mobile-event/title', [ 'event' => $event ] ); ?>
      </div>
      <div class="col-6 col-xs-6 text-right">
    		<?php $this->template( 'month/mobile-events/mobile-day/mobile-event/date', [ 'event' => $event ] ); ?>
    		<?php $this->template( 'month/mobile-events/mobile-day/mobile-event/cost', [ 'event' => $event ] ); ?>
      </div>

      <div class="col-12">
        <div class="spacer-h-10"></div>
        <div class="color-separator-mobile" <?php echo $style ?>></div>
        <div class="spacer-h-20"></div>
        <p class="event-mobile__descr"><?php echo (string) $event->excerpt; ?> </p>
        <div class="spacer-h-20"></div>
        <a href="<?php echo esc_url($event->permalink) ?>" class="event-list__more">Learn More</a>
      </div>


    </div>


	</div>
</article>


