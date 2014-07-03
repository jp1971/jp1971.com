<?php

/**
 * Function for creating a button that flushes the permalinks
 */


// Add button to the admin bar
add_action( 'admin_bar_menu', function( $wp_admin_bar ) {

	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}

	$flusher = array(
		'href' => 'javascript:void(0);',
		'id' => 'krnl-permalinks',
		'title' => '¬ Flush Permalinks'
	);

	$wp_admin_bar->add_menu( $flusher );

}, 9999 );

// Enqueue the JS for AJAX to front and backend
add_action( 'admin_enqueue_scripts', 'krnl_flush_permalinks_scripts' );
add_action( 'wp_enqueue_scripts', 'krnl_flush_permalinks_scripts' );
function krnl_flush_permalinks_scripts() {
	wp_enqueue_script(
		'flusher',
		get_template_directory_uri() . '/js/krnl/flush_permalinks.js',
		array( 'jquery' ),
		'1',
		true
	);

	wp_localize_script(
		'flusher',
		'KFP',
		array(
			'action_id'   => 'flush_permalinks',
			'button_id'   => '#wp-admin-bar-krnl-permalinks a',
			'nonce'       => wp_create_nonce( 'krnl_permalinks_nonce' ),
			'success_msg' => 'Permalinks have been flushed',
			'error_msg'   => 'There was an error flushing the permalinks',
		)
	);
}

// Create ajaxurl variable if on the front end
if ( ! is_admin() ) {
	add_action( 'wp_head', function() {
		echo '<script type="text/javascript">var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"</script>';
	});
}

// Action that gets called by the AJAX
add_action( 'wp_ajax_flush_permalinks', function() {
	if( check_ajax_referer( 'krnl_permalinks_nonce', 'nonce' ) ) {
		flush_rewrite_rules();
		die( '1' ); // Success!
	} else {
		die( '0' ); // Error.
	}
});
