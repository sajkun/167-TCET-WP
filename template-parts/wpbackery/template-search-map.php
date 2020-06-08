<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<div class="search-map" id="search-map"></div>

<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.init.map.search', ['search-map', '<?php echo $lat; ?>', '<?php echo $lng; ?>', '<?php echo $zoom; ?>'])
  })
</script>

<?php foreach ($venues_formatted as $key => $venue): ?>
<script>
  jQuery(document).ready(function(){
    jQuery(document.body).trigger('theme.add.map.search.marker', ['<?php echo $venue['lat']; ?>', '<?php echo $venue['lng']; ?>', '<?php echo $venue['marker']; ?>'])
  })
</script>
<?php endforeach ?>
