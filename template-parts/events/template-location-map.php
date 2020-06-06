<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>

<div class="google-map-preview" id="<?php echo $block_id; ?>"></div>
<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.init.map', ['<?php echo $block_id; ?>', '<?php echo $latitude; ?>', '<?php echo $longitude; ?>'])
  })
</script>