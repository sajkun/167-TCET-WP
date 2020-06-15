<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();
$terms = wp_get_post_terms( $event_id, 'services_term', array( 'field' => 'ids' ) );
$main_color= false;
$secondary_color= false;

if($terms){
	$main_color = count($terms) > 0 ?  get_term_meta($terms[0]->term_id, 'events_color', true) : '#eee';
	$secondary_color = count($terms) > 0 ?  get_term_meta($terms[0]->term_id, 'secondary_color', true) : '#fff';
}


$elegibility = get_post_meta( $event_id,'eligibility', true );
$is_invitation_only = get_post_meta( $event_id,'is_invitation_only', true );
$invitation_only_text = get_post_meta( $event_id,'invitation_only_text', true );

?>

<style>
	.event-meta-text .marker{
		background-color: <?php echo $main_color ?>;
	}
</style>
<?php if (US_SERVICE_COLOR): ?>

<style>
	<?php if ($main_color): ?>
		  .sinle-event__sideinfo,
		.tribe-events-single-event-title{
			background-color: <?php echo $secondary_color ?>;
		}
	<?php endif ?>
	<?php if ($main_color): ?>

	.icon-label,
	.eligibility-title{
		background-color: <?php echo $main_color ?>;
	}

	.tribe-events-schedule a,
	.single-event-content a{
		color: <?php echo $main_color ?>!important;
	}

  .single-event-content li:before,
  .single-event-content ul li:before{
    color: <?php echo $main_color; ?>;
  }
	<?php endif ?>
</style>
<?php endif ?>
<div class="spacer-h-30"></div>
<div id="tribe-events-content" class="tribe-events-single container container-xxl">
	<?php tribe_the_notices() ?>

	<div class="row no-gutters">
		<div class="col-lg-8">
			<h1 class="tribe-events-single-event-title">
			<?php the_title( '<span>', '</span>' ); ?> <br>
				<?php if ($is_invitation_only ):
          _e('INIVTATION ONLY', 'theme-translations');
				 endif ?>

			</h1>
			<div class="tribe-events-schedule tribe-clearfix ">
				<?php //echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
				<?php if ( tribe_get_cost() ) : ?>
					<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
				<?php endif; ?>

				<?php while ( have_posts() ) :  the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('single-event-content'); ?>>
						<!-- Event featured image, but exclude link -->
						<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

						<!-- Event content -->
						<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
						<div class="tribe-events-single-event-description tribe-events-content">
							<?php the_content(); ?>
						</div>
						<!-- .tribe-events-single-event-description -->

						<!-- Event meta -->
					</div> <!-- #post-x -->
				<?php endwhile; ?>

				<?php if ($is_invitation_only ):
          echo '<p>'. $invitation_only_text .'</p>';
				 endif ?>
			</div>
		</div>
		<div class="col-lg-4 sinle-event__sideinfo clearfix">
				<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
				<?php tribe_get_template_part( 'modules/meta' ); ?>
				<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div>
	</div>


	<div class="spacer-h-30 spacer-h-lg-70"></div>

	<?php if ($elegibility): ?>
		<div class="row">
			<div class="col-12">
				<div class="eligibility-title">
					<span><?php _e('Eligibility','theme-translations');?></span>
				</div>
			</div>
			<div class="col-12 single-event-content">
					<?php echo apply_filters('the_content', $elegibility); ?>
			</div>
		</div>
	<?php endif ?>

<?php do_action( 'tribe_events_single_event_after_the_content' );?>

	<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>

	<!-- Notices -->

<?php /*

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

	*/ ?>

</div><!-- #tribe-events-content -->