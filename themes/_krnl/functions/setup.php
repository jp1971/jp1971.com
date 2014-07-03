<?php

// Add Menu Function
add_action( 'init', 'krnl_register_menu' );
function krnl_register_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}

// Initialize JavaScript module pattern in admin footer
add_action( 'admin_footer', 'krnl_bootstrap_admin_init');
function krnl_bootstrap_admin_init() {
	echo '
	<script>
		krnl.bootstrap.init();
	</script>		
	';
}

// Create KRNL object level menu
add_action( 'admin_menu', 'krnl_add_object_page' );
function krnl_add_object_page() {
	add_object_page( 
		'KRNL', 
		'KRNL', 
		'publish_posts', 
		'krnl'
	);
}