<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
?>

<div class="venue-preview__info">
  <?php if ($title): ?>
  <h4 class="venue-preview__title">
    <?php echo $title ?>
  </h4>
  <?php endif ?>

  <?php if ($address): ?>
    <p class="venue-preview__address">
      <?php echo $address; ?>
    </p>
  <?php endif ?>

  <ul class="venue-preview__contacts">
    <?php if ($responsible_person): ?>
    <li>
      <?php
        echo $responsible_person;
       ?>
    </li>
    <?php endif ?>
    <?php if ($phone): ?>
    <li>
      <?php
      $phone_ = preg_replace('/\\D+/', '', $phone)  ;
      printf('<a href="tel:+%s" class="venue-preview__phone">%s</a>',$phone_,$phone);
       ?>
    </li>
    <?php endif ?>

    <?php if ($email): ?>
      <li>
        <?php
         printf('<a href="mailto:+%1$s" class="venue-preview__email">%1$s</a>',$email); ?>
      </li>
    <?php endif ?>
  </ul>
</div>
