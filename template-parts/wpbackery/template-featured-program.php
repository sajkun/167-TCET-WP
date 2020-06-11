<div class="featured-program">
  <div class="container">

    <div class="spacer-h-30 spacer-h-lg-50"></div>
    <?php if ($title): ?>
    <h4 class="featured-program__title">
      <?php echo $title ?>
    </h4>
    <?php endif ?>

    <?php if ($text): ?>
    <p class="featured-program__text">
      <?php echo $text ?>
    </p>
    <?php endif ?>

    <?php if ($button_url): ?>
    <a href="<?php echo $button_url; ?>" target="_blank" class="featured-program__more"><?php echo $button_text ?></a>
    <?php endif ?>
    <div class="spacer-h-30 spacer-h-lg-70"></div>

  </div>
</div>

