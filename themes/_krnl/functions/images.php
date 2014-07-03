<?php

// Image Settings

if ( get_option( 'krnl_use_krnl_image_settings' ) == '1' ) {

	// Set default link type to none
	update_option( 'image_default_link_type', 'none' );

	// Disable thumbnails thereby only allowing full sized images
	function krnl_filter_image_sizes( $sizes ) {
	 
		unset( $sizes['thumbnail']);
		unset( $sizes['medium']);
		unset( $sizes['large']);
	 
		return $sizes;
	}
	add_filter( 'intermediate_image_sizes_advanced', 'krnl_filter_image_sizes' );

	// Update default thumbnail options
	update_option( 'thumbnail_crop', 0);
	update_option( 'thumbnail_size_h', 0 );
	update_option( 'thumbnail_size_w', 0 );
	update_option( 'medium_size_h', 0 );
	update_option( 'medium_size_w', 0 );
	update_option( 'large_size_h', 0 );
	update_option( 'large_size_w', 0 );
}