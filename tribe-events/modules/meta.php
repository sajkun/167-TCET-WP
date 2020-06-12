<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @version 4.6.10
 *
 * @package TribeEventsCalendar
 */
$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();
$event_id = get_the_ID();
do_action( 'tribe_events_single_meta_before' );
$terms = wp_get_post_terms( $event_id, 'services_term', array( 'field' => 'ids' ) );
// Check for skeleton mode (no outer wrappers per section)
$not_skeleton = ! apply_filters( 'tribe_events_single_event_the_meta_skeleton', false, get_the_ID() );

// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );

$EventOrganizerID = get_post_meta($event_id, '_EventOrganizerID', true );

$email = get_post_meta($EventOrganizerID, '_OrganizerEmail', true);
$phone = get_post_meta($EventOrganizerID, '_OrganizerPhone', true);


?>

<?php if ( $not_skeleton ) : ?>
	<div class="col-12">
		<div class="spacer-h-20"></div>
		<h4 class="single-event-meta-title">
			Details
		</h4>
<?php endif; ?>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_start' );

// Always include the main event details in this first section
tribe_get_template_part( 'modules/meta/details' );
 if ($terms): ?>

<p class="event-meta-text service">
	<span class="marker"></span>
	<?php echo $terms[0]->name ; ?>
</p>
<?php endif;

// Include venue meta if appropriate.
if ( tribe_get_venue_id() ) {
	// If we have no map to embed and no need to keep the venue separate...
	if ( ! $set_venue_apart && ! tribe_embed_google_map() ) {
		tribe_get_template_part( 'modules/meta/venue' );
	} elseif ( ! $set_venue_apart && ! tribe_has_organizer() && tribe_embed_google_map() ) {
		// If we have no organizer, no need to separate the venue but we have a map to embed...
		tribe_get_template_part( 'modules/meta/venue' );

		echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
		tribe_get_template_part( 'modules/meta/map' );
		echo '</div>';
	} else {
		// If the venue meta has not already been displayed then it will be printed separately by default
		$set_venue_apart = true;
	}
}
	?>
		<div class="events-line"></div>
		<div class="single-event-meta-title">
			Contact
		</div>
		<div class="spacer-h-20"></div>
		<?php if ($phone): ?>
		<div class="event-meta-text">
			<i class="icon-label">
				<img src="<?php echo THEME_URL?>/assets/images/icons/phone.svg" alt="">
			</i>
			<span><a><?php echo $phone; ?></a></span>
		</div>
		<div class="spacer-h-10"></div>
		<?php endif ?>
		<?php if ($email): ?>
		<div class="event-meta-text">
			<i class="icon-label">
				<img src="<?php echo THEME_URL?>/assets/images/icons/email.svg" alt="">
			</i>
			<span><a><?php echo $email; ?></a></span>
		</div>
		<?php endif ?>

		<div class="spacer-h-30"></div>
	<?php

	$reg_mode = get_post_meta($event_id, 'register_mode', true);

	switch ($reg_mode) {
		case 'message':
			echo get_post_meta($event_id, 'message_for_registration', true);
			break;
		case 'email':
		$p = get_post($event_id);
			printf('<a href="mailto:%1$s?subject=%3$s" class="register-event-button">%2$s</a>',get_post_meta($event_id, 'email_for_registration', true), __('Register Now','theme-translations'), 'Register for event : '. $p->post_title);
			break;
	}

// Include organizer meta if appropriate
if ( tribe_has_organizer() ) {
	// tribe_get_template_part( 'modules/meta/organizer' );
}

do_action( 'tribe_events_single_event_meta_primary_section_end' );
?>

<div class="spacer-h-30"></div>

<?php if ( $not_skeleton ) : ?>
	</div>
<?php endif;


do_action( 'tribe_events_single_meta_after' );
