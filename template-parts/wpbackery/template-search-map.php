<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<div class="container clearfix no-paddings">
  <div class="search-map" id="search-map" data-zoom="<?php echo $zoom ?>"></div>
</div>

<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.init.search', ['search-map', '<?php echo $lat; ?>', '<?php echo $lng; ?>', '<?php echo $zoom; ?>'])
  })
</script>

<?php if (isset($venues_formatted)): ?>
  <?php foreach ($venues_formatted as $key => $venue): ?>
  <script>
    jQuery(document).ready(function(){
      jQuery(document.body).trigger('theme.add.map.search.marker', ['<?php echo $venue['lat']; ?>', '<?php echo $venue['lng']; ?>', '<?php echo $venue['marker']; ?>', '<?php echo $venue['title']; ?>'])
    })
  </script>
  <?php endforeach ?>
<?php endif ?>
