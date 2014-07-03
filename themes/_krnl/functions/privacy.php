<?php

// Remove the WordPress generator tag
remove_action( 'wp_head', 'wp_generator' );

// Disable opens sans
if ( get_option( 'krnl_disable_open_sans' ) == '1' ) {
	add_action( 'admin_enqueue_scripts', 'krnl_disable_open_sans' );
}
function krnl_disable_open_sans() {
	wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
}

// Require login
if ( get_option( 'krnl_require_login' ) == '1' ) {
    add_action( 'wp_head', 'krnl_require_login' );
}

function krnl_require_login() {
    if ( !is_user_logged_in() ) {
        auth_redirect();
    }
}