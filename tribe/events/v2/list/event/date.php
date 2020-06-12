<?php
/**
 * View: List View - Single Event Date
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/date.php
 *
 * See more documentation about our views templating system.
 *
 * @link {INSERT_ARTCILE_LINK_HERE}
 *
 * @since 4.9.9
 * @since 5.1.1 Move icons into separate templates.
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 *
 * @version 5.1.1
 */
use Tribe__Date_Utils as Dates;

$event_date_attr = $event->dates->start->format( Dates::DBDATEFORMAT );
?>

<?php if ($event->dates->start->format('d-m-y')  === $event->dates->end->format('d-m-y')): ?>

   <time class="event-list__date">
     <?php echo $event->dates->start->format('F d, Y') ?>
   </time>
   <time class="event-list__time">
     <?php echo $event->dates->start->format('H:ia') ?> -
     <?php echo $event->dates->end->format('H:ia') ?>
   </time>

  <?php else: ?>
   <time class="event-list__date">
     <?php echo $event->dates->start->format('F d, Y') ?>  <span class="event-list__time">  <?php echo $event->dates->start->format('H:ia') ?> - </span><br>
     <?php echo $event->dates->end->format('F d, Y') ?> <span class="event-list__time">  <?php echo $event->dates->end->format('H:ia') ?></span>&nbsp;&nbsp;
   </time>
<?php endif ?>


