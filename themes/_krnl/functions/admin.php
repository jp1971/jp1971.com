<?php

/*
 * Remove Options if KRNL DEV isn't defined as true
 */

if ( !defined( 'KRNL_DEV' ) ||
	( defined( 'KRNL_DEV' ) && KRNL_DEV !== true ) ) {

	add_action( 'admin_menu', 'remove_menus', 999 );

	function remove_menus(){
		remove_submenu_page( 'options-general.php', 'krnl_settings' );
		remove_menu_page( 'edit.php?post_type=acf' );
	}
}