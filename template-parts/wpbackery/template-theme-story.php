.<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<style>
  .template-story__readmore{
    background-color: <?php echo $color; ?>;
  }
</style>

<div class="template-story">
  <div class="template-story__image">
    <?php if ($image): ?>
    <img src="<?php echo $image?>" alt="">
    <?php endif ?>
  </div>
  <div class="spacer-h-30"></div>

  <?php if ($text): ?>
  <p class="template-story__text">
    "<?php echo $text;  ?>"
  </p>
  <?php endif ?>

  <p class="template-story__text">
    <?php if ($name): ?>
      <strong><?php echo $name;  ?></strong>,
    <?php endif ?>
    <?php if ($location): ?>
      <?php echo $location;  ?>
    <?php endif ?>
  </p>

  <a href="<?php echo $url;  ?>" class="template-story__readmore"><?php _e('Read More','theme-translations');?></a>



  <div class="spacer-h-50"></div>
</div>