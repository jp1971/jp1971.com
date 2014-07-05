<?php

// The enqueue functions file for the JP1971 theme.

//Print theme styles in header
add_action( 'wp_enqueue_scripts', 'jp1971_enqueue_styles' );
function jp1971_enqueue_styles() {

   wp_enqueue_style(
      'reset'//$handle
      ,get_stylesheet_directory_uri() . "/css/jp1971.css" //$src
      ,false //$deps (dependencies)
      ,'1.0' //$ver
      ,'screen' //$media
   );
}