<?php
/*
Plugin Name: KRNL Gallery
Plugin URI: 
Description: A Gallery post type shortcode to produce an array of image IDs
Version: 1.0.0
Author: Athletics
Author URI: http://athleticsnyc.com
License: GPL2
*/

/*  Copyright 2014 Athletics ([email address])

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

class KRNLGallery {

	private static $instance = false;

	public static function get_instance() {
	  if ( ! self::$instance ) {
	    self::$instance = new self();
	  }
	  return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'krnl_gallery_post_type' ), 10 );
		add_action( 'init', array( $this, 'krnl_gallery_acf' ) );
		add_shortcode( 'gallery', array( $this, 'krnl_gallery_shortcode' ) );
		add_shortcode( 'popup_gallery', array( $this, 'krnl_popup_gallery_shortcode' ) );
	}

	public function krnl_gallery_post_type() {
	    register_post_type( 'gallery',
	    	array(
	    		'labels' => array( 
	    			'name' => 'Gallery',
	    			'singular_name' => 'Gallery',
	    			'add_new_item' => 'Add New Gallery',
	    			'edit_item'=> 'Edit Gallery',
	    			'new_item' => 'New Gallery',
	    			'view_item' => 'View Gallery',
	    			'search_items' => 'Search Gallery',
	    			'not_found' => 'No gallery found',
	    			'not_found_in_trash' => 'No gallery found in Trash'
	    		),
	    		'public' => true,
	    		'has_archive' => true,
	    		'hierarchical' => true,
	    		'show_in_menu' => 'krnl',
	    		'supports' => array(
	    			'title', 'editor', 'thumbnail'
	    		)
	    	)
	    );
	}

	public function krnl_gallery_acf() {
		if ( function_exists( "register_field_group" ) ) {
			register_field_group( array (
				'id' => 'acf_gallery',
				'title' => 'Gallery',
				'fields' => array (
					array (
						'key' => 'field_52f2980f386a2',
						'label' => 'Slideshow Gallery',
						'name' => 'slideshow-gallery',
						'type' => 'gallery',
						'required' => 1,
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'gallery',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'no_box',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}
	}

	public function krnl_gallery_shortcode( $atts ) {
		extract( shortcode_atts( 
			array(
				'id' => null
			), 
		$atts ) );

		if ( $id === null ) {
			return;
		}

		$images = get_field( 'slideshow-gallery', $id );
		$image_id_array = array();

		foreach ( $images as $image ) {
			$image_id_array[] = $image['id'];
		}

		return $image_id_array;


	}

	public function krnl_popup_gallery_shortcode( $atts ) {
		extract( shortcode_atts( 
			array(
				'id' => null
			), 
		$atts ) );

		if ( $id === null ) {
			return;
		}

		$images = get_field( 'slideshow-gallery', $id );

		ob_start();
		?>

		<div class="popup-gallery clearfix">
		<?php foreach( $images as $image ): ?>
        <figure>
        	<a href="<?php echo $image['url']; ?>">
            	<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />  
            </a>              
        </figure>
    	<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
$krnl_gallery = KRNLGallery::get_instance();