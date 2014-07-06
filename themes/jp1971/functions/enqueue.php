<?php

// The enqueue functions file for the JP1971 theme.

//Print theme styles in header
add_action( 'wp_enqueue_scripts', 'jp1971_enqueue_styles' );
function jp1971_enqueue_styles() {

   wp_enqueue_style(
      'jp1971', //$handle
      get_stylesheet_directory_uri() . "/css/jp1971.css", //$src
      false, //$deps (dependencies)
      '1.0', //$ver
      'screen' //$media
   );
}

// Print scripts in header and footer
add_action( 'wp_enqueue_scripts', 'jp1971_enqueue_scripts' );
function jp1971_enqueue_scripts() {
	wp_enqueue_script(
		'jp1971-comments', // $handle
		get_stylesheet_directory_uri() . "/js/jp1971/comments.js", // $src
		array( 'jquery' ), // $deps (dependencies)
		'1.0', // $ver
		true // $in_footer
	);
}