<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<div class="container clearfix no-paddings">
  <div class="search-map" id="large-map" data-zoom="<?php echo $zoom ?>"></div>
</div>

<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.init.largemap', ['large-map', '<?php echo $lat; ?>', '<?php echo $lng; ?>', '<?php echo $zoom; ?>', '<?php echo $title; ?>'])
  })
</script>

