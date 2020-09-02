<?php

add_action('add_meta_boxes', 'event_image_selection');


function event_image_selection(){
  add_meta_box( 'event_custom_image', 'Featured Image Selection', 'event_image_selection_cb', 'tribe_events', 'side',  'high' );
}


function event_image_selection_cb($post){
  $terms     = wp_get_post_terms( $post->ID, 'services_term' );

  if(!$terms){
    echo '<b> you need to select a related program to chose images. </b> <br>';
    echo '<b>Select it and save post please</b>';
  }else{



    $o     = get_option('events_images');

    $attachment_id = get_post_thumbnail_id();

    $published = array();

    echo '<div class="img-cont">';
    foreach ($terms as $term) {
      $images = $o[$term->slug];

      if(!isset($o[$term->slug]['items'])){
        echo "no images set for category ". $o[$term->slug]['name'];
         printf('<input type="hidden" name="_custom_attachment" value="%s">',  -1);
      }else{
        foreach ($o[$term->slug]['items'] as $image_id) {

          if(in_array($image_id, $published)){
            continue;
          }

          $published[] = $image_id;
          $checked = $image_id ==   $attachment_id? 'checked="checked"' : '';
          $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail', false );

          echo '<label>';
           printf('<input type="radio" name="_custom_attachment" %2$s value="%1$s">',  $image_id, $checked);
          echo '<div class="mark-img">';
           printf('<img src="%s" alt="" >',  $image_url);
          echo '</div>';
          echo '</label>';
        }
      }
    }
   echo '</div>';


    ?>
    <br>
       <label>
         <input type="radio" name="_custom_attachment" value="-1" class="hidden">
         <span class="button">Remove Featured Image</span>
       </label>

       <input name="save" type="submit" class="button button-primary button-large" value="Update">
      <style>
        .postbox-container #postimagediv{
          display: none!important;
        }
      </style>

    <?php

  }
}



add_action('admin_menu', 'event_image_settings');


function event_image_settings(){
  add_submenu_page( 'edit.php?post_type=tribe_events', __('Image Settings For Events'), __('Image Settings For Events'), 'manage_options', 'edit-image-events-settings', 'event_image_settings_cb', 200);
}

function event_image_settings_cb(){
  wp_enqueue_media();

  if (isset($_POST['do_save']) && 'yes' == $_POST['do_save']) {
     update_option('events_images', $_POST['events_images']);
  }
  $terms = get_terms(array('taxonomy' => 'services_term', 'hide_empty' => false,));
  $o     = get_option('events_images');

  clog($o);
  ?>
    <h1>Image Settings For Events</h1>
    <br>
    <br>
    <br>

    <form action="<?php echo admin_url('edit.php?post_type=tribe_events&page=edit-image-events-settings') ?>" method="POST">
      <?php foreach ($terms as $key => $t): clog($t);
        $counter = 0;
       ?>
        <div class="term-img-block">
          <h3><?php echo $t->name ?>:</h3>

          <input type="hidden" name="events_images[<?php echo $t->slug ?>]['name']" value="<?php echo $t->name; ?>">

          <div class="term-block <?php echo $t->slug ?>">
          <?php if (isset($o[$t->slug]['items']) ): ?>
            <?php foreach ($o[$t->slug]['items'] as $image_id):
              if(!$image_id) continue;
              $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail', false );
              ?>
                <div class="image-settings">
                  <img src="<?php echo $image_url ?>" alt="">
                  <input type="hidden" class="image_id" name="events_images[<?php echo $t->slug; ?>][items][<?php echo $counter; ?>]"  value="<?php echo $image_id; ?>">
                  <a href="javascript:void(0)" class="remove" onclick="remove_image_setting(this)">Remove</a>
               </div>
            <?php
             $counter++;
             endforeach ?>
          <?php else: ?>
            <b class="no-images">No images configured for this service</b>
          <?php endif ?>
          </div>
          <br>
          <br>

          <input type="hidden" class="counter_<?php echo $t->slug ?>" value="<?php echo $counter; ?>">

        <button class="button button-primary" type="submit"> Save</button>
          <a href="javascript:void(0)" class="button" onclick="add_image_block('<?php echo $t->slug ?>')">Add Image</a>

      </div>
      <?php endforeach ?>
      <input type="hidden" value="yes" name="do_save">
    </form>
  <?php
}