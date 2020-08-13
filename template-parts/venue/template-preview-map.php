<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>

<?php if ( $static_url): ?>

  <a href="<?php echo $search_url; ?>" class="location-preview__map" traget="_blank">
    <img src="<?php echo $static_url; ?>" alt="">
  </a>
<?php endif ?>
<?php /*
<div class="google-map-preview location-preview__map" id="<?php echo $block_id; ?>" data-lng="<?php echo $longitude; ?>" data-lat="<?php echo $latitude; ?>" data-marker="<?php echo $marker; ?>">
</div>
<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.init.map', ['<?php echo $block_id; ?>', '<?php echo $latitude; ?>', '<?php echo $longitude; ?>', '<?php echo $marker; ?>'])
  })
</script> */ ?>