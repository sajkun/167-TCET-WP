<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<div class="location-item" data-lat="<?php echo $lat;?>" data-lng="<?php echo $lng;?>" data-category="<?php echo $category;?>" data-title="<?php echo $title;?>" data-search="<?php echo $search;?>">
  <div class="location-item__image" title="click to show on map">
    <img src="<?php echo $image_url;?>" alt="" class="map">
    <div class="location-item__marker">
    </div>
    <img src="<?php echo $marker_url; ?>" class="marker" alt="">
  </div><!-- location-item__image -->
  <div class="location-item__info">
    <h4 class="location-item__title"><?php echo $title; ?></h4>

    <?php if ($address): ?>
    <p class="location-item__info"><?php echo $address; ?></p>
    <?php endif ?>

    <?php if ($city_province): ?>
    <p class="location-item__info"><?php echo $city_province; ?></p>
    <?php endif ?>

    <?php if ($phone): ?>
    <p class="location-item__info"><?php echo $phone; ?></p>
    <?php endif; ?>

    <?php if ($phone_lng): ?>
    <p class="location-item__info">
      <?php _e('For long distance calls','theme-translations');?>: <br>
      <?php echo $phone_lng; ?></p>
    <?php endif; ?>

    <?php if ($hours): ?>
    <p class="location-item__info pre"><?php _e('Hours of Operation','theme-translations');?> <br><?php echo $hours; ?> </p>
    <?php endif; ?>
  </div>
</div>
