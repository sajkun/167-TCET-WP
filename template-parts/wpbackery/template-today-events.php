<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

?>
  <a href="<?php echo $url; ?>" class="event-preview" id="layer-<?php echo $key; ?>-1">
    <span class="event-preview__title"><?php echo $title ?></span>
    <span class="event-preview__date"><?php echo $date ?></span>
    <span class="event-preview__time"><?php echo $time ?></span>
    <span class="event-preview__color-mark <?php echo $slug ?>" style="background-color: <?php echo $color ?>;"></span>
  </a>
