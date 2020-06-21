<?php
/**
 * Component: After Events
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/after.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 4.9.11
 *
 * @var string $after_events HTML stored on the Advanced settings to be printed after the Events.
 */

if ( empty( $after_events ) ) {
	return;
}

$months = array(
     'Jan' => 'January',
     'Feb' => 'February',
     'Mar' => 'March',
     'Apr' => 'April',
     'May' => 'May',
     'Jun' => 'June',
     'Jul' => 'July',
     'Aug' => 'August',
     'Sep' => 'September',
     'Oct' => 'October',
     'Nov' => 'November',
     'Dec' => 'December',
);
?>
<?php /* if (!wp_is_mobile()): ?>
  <div class="spacer-h-30"></div>
  <div class="row navigate-events">
    <div class="col-6">
      <?php if ($prev_url): ?>
      <a href="<?php echo  $prev_url; ?>" class="navigate-events__link"
            aria-label="<?php esc_attr_e( 'Previous month', 'the-events-calendar' ); ?>"
    title="<?php esc_attr_e( 'Previous month', 'the-events-calendar' ); ?>"
    data-js="tribe-events-view-link"
        >
        <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 8 14"><defs></defs><g><g><title>Path 27</title><path d="M7.2959,12.88477v0l-5.67006,-5.78957v0l5.67006,-5.99818v0" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#5cb8b2" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
        <span class="navigate-events__month"><?php echo $months[$prev_label]; ?></span>
      </a>
     <?php endif ?>
    </div>
    <div class="col-6 text-right">
      <?php if ($next_url): ?>
      <a href="<?php echo  $next_url; ?>"
          class="navigate-events__link"
          aria-label="<?php esc_attr_e( 'Next month', 'the-events-calendar' ); ?>"
          title="<?php esc_attr_e( 'Next month', 'the-events-calendar' ); ?>"
          data-js="tribe-events-view-link"
      >
        <span class="navigate-events__month"><?php echo $months[$next_label]; ?></span>
        <svg  width="9" height="14" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 9 14"><defs></defs><g><g><title>Path 28</title><path d="M1.20801,13.26435v0l5.67024,-5.78956v0l-5.67024,-5.99823v0" fill-opacity="0" fill="#ffffff" stroke-dashoffset="0" stroke-linejoin="miter" stroke-linecap="butt" stroke-opacity="1" stroke="#5cb8b2" stroke-miterlimit="20" stroke-width="2"></path></g></g></svg>
      </a>
      <?php endif ?>
    </div>
  </div>
<?php endif */?>
<div class="tribe-events-after-html">
	<?php echo $after_events; ?>
</div>


