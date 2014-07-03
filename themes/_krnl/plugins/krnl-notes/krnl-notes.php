<?php
/*
Plugin Name: 
Plugin URI: 
Description: 
Version: 
Author: 
Author URI: 
License: GPL2
*/

/*  Copyright 20xx [name/orgainzation] ([email address])

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 U`SA
*/

class KRNLNotes {

	private static $instance = false;

	public static function get_instance() {
	  if ( ! self::$instance ) {
	    self::$instance = new self();
	  }
	  return self::$instance;
	}

	private function __construct() {
		// Add actions
		add_action( 'init', array( $this, 'create_notes_post_type' ), 20 );
		add_action( 'wp_head', array( $this, 'no_index_no_follow') );
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_node' ), 999 );
		// Add filters
		add_filter( 'archive_template', array( $this, 'get_custom_post_type_archive_template' ) );
		add_filter( 'single_template', array( $this, 'get_custom_post_type_single_template' ) );
	}

	function no_index_no_follow() {
		if( is_post_type_archive( 'notes' ) || get_post_type() == 'notes' ) {
			echo '<meta name="robots" content="noindex, nofollow" />';
		} 
	}
	
	function create_notes_post_type() {
		register_post_type( 'notes',
			array(
				'labels' => array( 
					'name' => 'Notes',
					'singular_name' => 'Note',
					'add_new_item' => 'Add New Note',
					'edit_item'=> 'Edit Note',
					'new_item' => 'New Note',
					'view_item' => 'View Note',
					'search_items' => 'Search Notes',
					'not_found' => 'No Notes found',
					'not_found_in_trash' => 'No Notes found in Trash'
				),
				'has_archive' => true,
				'public' => true,
				'capabilities' => array( 'delete_others_posts' ),
				'map_meta_cap' => true,
				'show_in_menu' => 'krnl',
				'supports' => array(
					'title', 'editor', 'revisions'
				)
			)
		);
	}

	function get_custom_post_type_archive_template( $notes_template ) {
	     if ( get_post_type() == 'notes' ) {
	          $notes_template = dirname( __FILE__ ) . '/templates/archive-notes.php';
	     }
	     return $notes_template;
	}

	function get_custom_post_type_single_template( $notes_template ) {
		if ( get_post_type() == 'notes' ) {
	          $notes_template = dirname( __FILE__ ) . '/templates/single-notes.php';
	     }
	     return $notes_template;
	}

	function add_admin_bar_node( $wp_admin_bar ) {
	    $notes_args = array(
	    	'id' => 'notes',
	    	'title' => 'Notes',
	    	'parent' => 'site-name',
	    	'href' => home_url( 'notes' )
	    );
	    $wp_admin_bar->add_node( $notes_args );
	}
}
$krnl_notes = KRNLNotes::get_instance();