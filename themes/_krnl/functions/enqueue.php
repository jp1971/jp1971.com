<?php
//Print admin styles in header
add_action( 'admin_print_styles', 'krnl_enqueue_admin_styles' );
function krnl_enqueue_admin_styles() {
	wp_enqueue_style(
	   'krnl_admin_styles', //$handle
	   get_template_directory_uri() . '/css/krnl_admin_styles.css', //$src
	   false, //$deps (dependencies)
	   '1.0', //$ver
	   'screen' //$media
	);
}

// Print site scripts in header and footer
add_action('wp_enqueue_scripts', 'krnl_enqueue_scripts');
function krnl_enqueue_scripts() {

	wp_enqueue_script(
		'krnl_bootstrap',//$handle
		get_template_directory_uri() . "/js/krnl/bootstrap.js", //$src
    	array( 'jquery' ), //$deps (dependencies)
		'0.1', //$ver
		false //$in_footer
	);
}

add_action( 'admin_enqueue_scripts', 'krnl_enqueue_admin_scripts' );
function krnl_enqueue_admin_scripts() {
	wp_enqueue_script(
		'krnl_bootstrap',//$handle
		get_template_directory_uri() . "/js/krnl/bootstrap.js", //$src
    	array( 'jquery' ), //$deps (dependencies)
		'0.1', //$ver
		false //$in_footer
	);
}

// Print site scripts in footer
add_action( 'admin_footer', 'krnl_acf_gallery_override' );
function krnl_acf_gallery_override() {
	wp_deregister_script( 'acf-input-gallery' );

    wp_enqueue_script(
		'krnl_acf_gallery_override',//$handle
		get_template_directory_uri() . "/js/krnl/acf_gallery_input.js", //$src
    	array( 'jquery' ), //$deps (dependencies)
		'0.1', //$ver
		false //$in_footer
	);
}