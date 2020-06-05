<?php
// remove this file in production
if(!THEME_DEBUG){
  return;
}

add_action('wp_enqueue_scripts', 'check_scripts');

function check_scripts(){
  global $wp_scripts;

  glog('scripts', true);

  clog($wp_scripts);

  glog(false);

  wp_dequeue_script('gmap-api');
}

