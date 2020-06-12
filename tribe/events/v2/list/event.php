<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
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

clog($event);

$container_classes = ['event-list', $event->post_name];
$container_classes['tribe-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class( [ 'tribe-events-calendar-list__event', 'tribe-common-g-row', 'tribe-common-g-row--gutters' ], $event->ID );



// get service group taxonomies and detect color if exists
$terms = wp_get_post_terms( $event->ID, 'services_term', array( 'field' => 'ids' ) );
$color= false;
if($terms){
	$color = count($terms) > 0 ?  get_term_meta($terms[0]->term_id, 'events_color', true) : '#eee';
}

?>

<?php if ($color): ?>
	<style>
		.<?php echo  $event->post_name; ?> .event-list__service-marker{
			background-color: <?php echo $color; ?>;
		}
	</style>

<?php endif ?>

<div <?php tribe_classes( $container_classes ); ?>>
	<div class="row">
		<div class="col-12 col-md-6">
			<?php $this->template( 'list/event/title', [ 'event' => $event ] ); ?>
		</div>
		<div class="col-12 col-md-6 text-right-md">
			<?php $this->template( 'list/event/date', [ 'event' => $event ] ); ?>
		</div>
	</div>

	<div class="event-list__service-marker"></div>

	<div class="clearfix">
 	<?php $this->template( 'list/event/venue', [ 'event' => $event ] ); ?>
	</div>

	<article  class="clearfix">
		<?php $this->template( 'list/event/description', [ 'event' => $event ] ); ?>
		<div class="spacer-h-30"></div>

		<a href="<?php echo esc_url( $event->permalink ); ?>" class="event-list__more"><?php _e('Learn More','theme-translations'); ?></a>
	</article>
</div>
