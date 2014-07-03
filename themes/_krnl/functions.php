<?php

//The main functions file for the krnl theme.
require_once( __DIR__ . '/functions/admin.php' );

require_once( __DIR__ . '/functions/settings.php' );

require_once( __DIR__ . '/functions/enqueue.php' );

require_once( __DIR__ . '/functions/excerpt.php' );

require_once( __DIR__ . '/functions/images.php' );

require_once( __DIR__ . '/functions/privacy.php' );

require_once( __DIR__ . '/functions/setup.php' );

require_once( __DIR__ . '/functions/shortcodes.php' );

add_action( 'wp_loaded', function() { require_once( __DIR__ . '/functions/timber.php' ); }, 11 );

require_once( __DIR__ . '/functions/utilities.php' );

if ( defined( 'KRNL_DEV' ) && KRNL_DEV ) {
	require_once( __DIR__ . '/functions/flush-permalinks.php');
}

//Third Party Plugins
require_once( __DIR__ . '/plugins/timber-library/timber.php' );

if ( get_option( 'krnl_acf_plugin' ) == 1 ) {

	require_once( __DIR__ . '/plugins/advanced-custom-fields/acf.php' );

	require_once( __DIR__ . '/plugins/acf-gallery/acf-gallery.php' );

	require_once( __DIR__ . '/plugins/acf-options-page/acf-options-page.php' );

	require_once( __DIR__ . '/plugins/acf-repeater/acf-repeater.php' );

	require_once( __DIR__ . '/plugins/acf-wp-wysiwyg/acf-wp_wysiwyg.php' );
}

//Native KRNL Plugins
if ( get_option( 'krnl_cpss_plugin' ) == 1 ) {
	require_once( __DIR__ . '/plugins/krnl-compatible-post-sharing-system/krnl-compatible-post-sharing-system.php' );
}

if ( get_option( 'krnl_docs_plugin' ) == 1 ) {
	require_once( __DIR__ . '/plugins/krnl-docs/krnl-docs.php' );
}

if ( get_option( 'krnl_gallery_plugin' ) == 1 ) {
	require_once( __DIR__ . '/plugins/krnl-gallery/krnl-gallery.php' );
}

//Unused
// if ( get_option( 'krnl_jrnl_plugin' ) == 1 ) {
// 	require_once( __DIR__ . '/plugins/krnl-notes/krnl-notes.php' );
// }
// require_once( __DIR__ . '/functions/rating.php' );