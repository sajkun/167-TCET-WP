<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if ( ! tribe_get_venue_id() ) {
	return;
}
$address = str_replace(' ', '+', strip_tags(tribe_get_full_address()));
?>

<div class="spacer-h-20"></div>


<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<h2 class="single-event-meta-title"> <?php esc_html_e( tribe_get_venue_label_singular(), 'the-events-calendar' ) ?> </h2>
	<dl>
		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>
		<dd class="tribe-venue"> <?php echo tribe_get_venue() ?> </dd>
		<?php if ( tribe_address_exists() ) : ?>
			<dd class="tribe-venue-location">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if ( tribe_show_google_map_link() ) : ?>
						<?php //echo tribe_get_map_link_html(); ?>
					<?php endif; ?>

					<div class="spacer-h-10"></div>
						<div class="event-meta-text">
							<i class="icon-label">
								<img src="<?php echo THEME_URL?>/assets/images/icons/geo.svg" alt="">
							</i>
							<a href="http://www.google.com/maps/place/?q=<?php echo $address ?>" target="_blank">Directions</a>
						</div>
				</address>
			</dd>
		<?php endif; ?>
		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
	</dl>
</div>
