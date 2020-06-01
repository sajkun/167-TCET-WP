<?php

add_filter('body_class', 'check_header');

function check_header($classes){
  $classes[] = orgafresh_get_opt('alus_header_top_bar')? 'has-top-bar'  : 'no-top-bar';
  return $classes;
}