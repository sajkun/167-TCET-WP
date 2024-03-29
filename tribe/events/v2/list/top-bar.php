<?php
/**
 * View: Top Bar
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/top-bar.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @version 5.0.1
 *
 */
?>
<div class="tribe-events-c-top-bar tribe-events-header__top-bar">

	<?php // $this->template( 'list/top-bar/nav' ); ?>

	<?php // $this->template( 'components/top-bar/today' ); ?>

	<?php // $this->template( 'list/top-bar/datepicker' ); ?>
  <?php print_venu_filter(false, 'list'); ?>

	<?php $this->template( 'components/top-bar/actions' ); ?>

</div>
<div class="datepicker-month">
  <div class="inner">
    <div class="before"></div>
    <?php $this->template( 'list/top-bar/datepicker' ); ?>
  </div>

  <div class="spacer-h-30 spacer-h-lg-70"></div>
</div>