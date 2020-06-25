<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>
<div class="team-member">
  <div class="team-member__photo"><img src="<?php echo $image_url; ?>" alt=""></div>
  <?php if ($name): ?>
    <h3 class="team-member__name">
      <?php echo $name; ?>
    </h3>
  <?php endif ?>
  <?php if ($certifications): ?>
    <p class="team-member__text">
      <?php echo $certifications; ?>
    </p>
  <?php endif ?>
  <?php if ($title): ?>
    <p class="team-member__text">
      <?php echo $title; ?>
    </p>
  <?php endif ?>
  <?php if ($summary): ?>
    <div class="spacer-h-20"></div>
    <p class="team-member__text">
      <?php echo $summary; ?>
    </p>
    <div class="spacer-h-20"></div>
  <?php endif ?>
  <?php if ($email): ?>
    <div class="spacer-h-50"></div>
      <a class="icon-label pos-bottom-abs" href="mailto:<?php echo $email; ?>">
        <img src="<?php echo THEME_URL?>/assets/images/icons/email.svg" alt="">
      </a>
  <?php endif ?>
    <div class="spacer-h-20"></div>
</div>