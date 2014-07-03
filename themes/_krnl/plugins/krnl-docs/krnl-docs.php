<?php
/*
Plugin Name: KRNL Docs
Plugin URI: http://jp1971.com/
Description: Write and display site documentation directly in WordPress.
Version: 1.0
Author: JP1971
Author URI: http://jp1971.com/
License: GPL2
*/

/*  Copyright 2014 JP1971 (jameson@jp1971.com)

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

class KRNLDocs {

	private static $instance = false;

	public static function get_instance() {
	  if ( ! self::$instance ) {
	    self::$instance = new self();
	  }
	  return self::$instance;
	}

	private function __construct() {
		//Define plugin specific variables

		// add_options_page variables
		$this->options_page_title = 'Docs';
		$this->options_page_menu_title = 'Docs Settings';
		$this->options_page_menu_slug ='docs';

		// add_settings_section variables
		$this->section_id = 'docs_section';
		$this->section_title = '';
		$this->section_callback = array( $this, 'docs_section_callback' );

		// register_setting/register_settings_fields variables
		$this->option_group = 'docs';

		// Create a sample doc so that archive and single pages display properly
		add_action( 'wp_loaded', array( $this, 'create_placeholder_doc' ) );

		// Add actions
		add_action( 'admin_menu', array( $this, 'add_plugin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );
		add_action( 'init', array( $this, 'create_doc_taxonomy' ) );
		add_action( 'init', array( $this, 'create_doc_post_type' ) );
		add_action( 'wp_head', array( $this, 'no_index_no_follow') );
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_node' ), 999 );
		// Add filters
		add_filter( 'archive_template', array( $this, 'get_custom_post_type_archive_template' ) );
		add_filter( 'single_template', array( $this, 'get_custom_post_type_single_template' ) );

		// Add ajax for doc order
		add_action( 'init', array( $this, 'load_krnl_doc_scripts' ) );
		add_action( 'wp_ajax_krnl_doc_order', array( $this, 'krnl_doc_order' ) );
		add_action( 'wp_ajax_nopriv_krnl_doc_order', array( $this, 'krnl_doc_order' ) );

		// Register uninstall hook
		register_uninstall_hook( __FILE__, 'uninstall' );
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/**
	 * Settings API functions
	 */
	function add_plugin_menu() {
		// See if docs_create option is set. If not, use default.
		$caps = get_option( 'docs_create' );
		if( $caps == null ) {
			// Default role for reading docs is Admin.
			$caps = 'manage_options';
		}
		// Add options page
		// http://codex.wordpress.org/Function_Reference/add_options_page
		add_options_page(
			$this->options_page_title,
			$this->options_page_menu_title,
			'manage_options',
			$this->options_page_menu_slug,
			array( $this, 'render_options_page' )
		);
	}

	function register_plugin_settings() {
		// Add settings section(s)
		// http://codex.wordpress.org/Function_Reference/add_settings_section
		add_settings_section(
			$this->section_id,
			$this->section_title,
			$this->section_callback,
			$this->options_page_menu_slug
		);

		// Add settings field(s)
		// e.g. add_settings_field( $id, $title, $callback, $page, $section, $args );
		// http://codex.wordpress.org/Function_Reference/add_settings_field
		add_settings_field(
			'docs_create',
			'Create Docs',
			array( $this, 'docs_create_callback' ),
			$this->options_page_menu_slug,
			$this->section_id
		);

		add_settings_field(
			'docs_read',
			'Read Docs',
			array( $this, 'docs_read_callback' ),
			$this->options_page_menu_slug,
			$this->section_id
		);

		add_settings_field(
			'docs_link',
			'Docs Link',
			array( $this, 'docs_link_callback' ),
			$this->options_page_menu_slug,
			$this->section_id
		);

		// Register plugin settings
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// http://codex.wordpress.org/Function_Reference/register_setting
		register_setting ( $this->option_group, 'docs_create' );
		register_setting ( $this->option_group, 'docs_read' );
		register_setting ( $this->option_group, 'docs_link' );
	}

	function docs_section_callback() {
		echo '1. <strong>Create Docs</strong> sets which users can create docs. Default is Admin.';
		echo '<br />';
		echo '2. <strong>Read Docs</strong> sets which users can read docs. Default is Editor and above.';
		echo '<br />';
		echo '3. <strong>Docs Link</strong> determines whether or not Docs link will appear in the site menu in the WordPress toolbar.';
		echo '<br />';
	}

	function docs_create_callback() {
		$caps = get_option( 'docs_create' );
		if( $caps == null ) {
			// Default role for reading docs is Admin.
			$caps = 'manage_options';
		}
	?>
		<select name="docs_create">
			<option value="manage_options" <?php selected( $caps, 'manage_options' ); ?>>Admin</option>
			<option value="edit_others_posts" <?php selected( $caps, 'edit_others_posts' ); ?>>Editor</option>
			<option value="edit_published_posts" <?php selected( $caps, 'edit_published_posts' ); ?>>Author</option>
			<option value="edit_posts" <?php selected( $caps, 'edit_posts' ); ?>>Contributor</option>
		</select>
	<?php
	}

	function docs_read_callback() {
		$caps = get_option( 'docs_read' );
		if( $caps == null ) {
			// Default role for reading docs is Editor.
			$caps = 'edit_others_posts';
		}
	?>
		<select name="docs_read">
			<option value="manage_options" <?php selected( $caps, 'manage_options' ); ?>>Admin</option>
			<option value="edit_others_posts" <?php selected( $caps, 'edit_others_posts' ); ?>>Editor</option>
			<option value="edit_published_posts" <?php selected( $caps, 'edit_published_posts' ); ?>>Author</option>
			<option value="edit_posts" <?php selected( $caps, 'edit_posts' ); ?>>Contributor</option>
		</select>
	<?php
	}

	function docs_link_callback() {
		$link = esc_attr( get_option( 'docs_link' ) );
	?>
		<input type="checkbox" name="docs_link" value="1" <?php checked( $link, 1 ); ?> />
	<?php
	}

	function render_options_page() {
	?>
		<div class="wrap">
			<h2><?php echo $this->options_page_menu_title; ?></h2>
			<form action="options.php" method="POST">
				<?php settings_fields( $this->option_group ); ?>
				<?php do_settings_sections( $this->options_page_menu_slug ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/**
	 * Custom taxonomy and post type functions
	 */
	function create_doc_taxonomy() {
		$labels = array(
			'name'					=> _x( 'Categories', 'Taxonomy plural name', 'text-domain' ),
			'singular_name'			=> _x( 'Category', 'Taxonomy singular name', 'text-domain' ),
			'search_items'			=> __( 'Search Categories', 'text-domain' ),
			'popular_items'			=> __( 'Popular Categories', 'text-domain' ),
			'all_items'				=> __( 'All Categories', 'text-domain' ),
			'parent_item'			=> __( 'Parent Category', 'text-domain' ),
			'parent_item_colon'		=> __( 'Parent Category', 'text-domain' ),
			'edit_item'				=> __( 'Edit Category', 'text-domain' ),
			'update_item'			=> __( 'Update Category', 'text-domain' ),
			'add_new_item'			=> __( 'Add New Category', 'text-domain' ),
			'new_item_name'			=> __( 'New Category Name', 'text-domain' ),
			'add_or_remove_items'	=> __( 'Add or remove Categories', 'text-domain' ),
			'choose_from_most_used'	=> __( 'Choose from most used text-domain', 'text-domain' ),
			'menu_name'				=> __( 'Category', 'text-domain' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => false,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
			// 'capabilities'      => array(),
		);

		register_taxonomy( 'krnl_doc_tags', 'docs', $args );
	}

	function create_doc_post_type() {
		register_post_type( 'docs',
			array(
				'labels' => array(
					'name' => 'Docs',
					'singular_name' => 'Doc',
					'add_new_item' => 'Add New Doc',
					'edit_item'=> 'Edit Doc',
					'new_item' => 'New Doc',
					'view_item' => 'View Doc',
					'search_items' => 'Search Docs',
					'not_found' => 'No Docs found',
					'not_found_in_trash' => 'No Docs found in Trash'
				),
				'capabilities' => array( 'delete_others_posts' ),
				'exclude_from_search' => true,
				'has_archive' => true,
				'map_meta_cap' => true,
				'public' => true,
				'taxonomies' => array( 'krnl_doc_tags' ),
				'show_in_menu' => 'krnl',
				'show_in_admin_bar' => true,
				'supports' => array(
					'title', 'editor', 'revisions'
				)
			)
		);
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/**
	 * Template request functions
	 */
	function no_index_no_follow() {
		// Add meta to docs archive and single pages
		if( is_post_type_archive( 'docs' ) || get_post_type() == 'docs' ) {
			echo "<meta name='robots' content='noindex, nofollow' />\n";
		}
	}

	function get_custom_post_type_archive_template( $archive_template ) {
		global $post;
	    if ( get_post_type() == 'docs' ) {
			$archive_template = locate_template( 'archive-docs.php' );
	     	if ( $archive_template != '' ) {
	        	// Do nothing - locate_template() has already specified the location of  archive-docs.php
			} else {
				$archive_template = dirname( __FILE__ ) . '/templates/archive-docs.php';
			}
	     }
	     return $archive_template;
	}

	function get_custom_post_type_single_template( $single_template ) {
		global $post;
		if ( get_post_type() == 'docs' ) {
			$single_template = locate_template( 'single-docs.php' );
			if ( $single_template != '' ) {
	        	// Do nothing - locate_template() has already specified the location of  archive-docs.php
			} else {
	    		$single_template = dirname( __FILE__ ) . '/templates/single-docs.php';
	    	}
	    }
	    return $single_template;
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/**
	 * Functions that are used to order the document TOC when the dropdown value is changed
	 */
	function load_krnl_doc_scripts() {

		wp_enqueue_script(
			'krnl_doc_ajax',
			get_template_directory_uri() . '/plugins/krnl-docs/assets/js/krnl_doc_ajax.js',
			array( 'jquery' ),
			'1',
			true
		);

		wp_localize_script(
			'krnl_doc_ajax',
			'krnl_doc_ajax',
			array(
				'url' => home_url( 'wp-admin/admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'krnl_doc_ajax_nonce' )
			)
		);

	}

	function krnl_doc_order() {

		$value = sanitize_text_field( $_GET['value'] );
		$nonce = sanitize_text_field( $_GET['nonce'] );

		$tax_query = false;

		if ( $value === 'name' ) {

			$orderby = $value;
			$order = 'ASC';

		} elseif ( substr( $value, 0, 4) === 'tag-' ) {

			$tax_query = true;
			$orderby = 'name';
			$order = 'ASC';
			$value = substr( $value, 4 );

		} else {

			$orderby = 'date';
			$order = $value;

		}

		if ( wp_verify_nonce( $nonce, 'krnl_doc_ajax_nonce' ) ) :
			$args = array(
				'post_type'       => 'docs',
				'post_status'     => 'publish',
				'posts_per_page'  => -1,
				'orderby'         => $orderby,
				'order'           => $order
			);

			if ( $tax_query ) {
				$args = array_merge( array( 'krnl_doc_tags' => $value ), $args );
			}

			$docs = new WP_Query( $args );
			while ( $docs->have_posts() ) : $docs->the_post(); ?>

				<li>
					<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
				</li>

				<?php
			endwhile;
			wp_reset_postdata();
			die;
		endif;
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	/**
	 * Set up / tear down functions
	 */

	function create_placeholder_doc() {
		// Only create placeholder if there are no other docs
		if ( count( get_posts( array( 'post_type' => 'docs', 'posts_per_page' => 1) ) ) == 0 ) {
			// Create post object
			$placeholder_doc = array(
				'post_type'		=> 'docs',
				'post_title'    => 'Placeholder Doc',
				'post_content'  => 'This is a placeholder doc. Please edit or create a new doc before deleting',
				'post_status'   => 'publish',
				'tax_input'     => array(
					'krnl_doc_tags' => array(
						'Assets',
						'Content',
						'Hosting',
						'Settings',
						'Shortcodes',
						'Social',
						'WordPress'
					),
				),
				'post_author'   => 1,
			);

			// Insert the post into the database
			wp_insert_post( $placeholder_doc );
		}
	}

	function add_admin_bar_node( $wp_admin_bar ) {
		if( 1 == get_option( 'docs_link' ) ) {
		    $docs_args = array(
		    	'id' => 'docs',
		    	'title' => 'Docs',
		    	'parent' => 'site-name',
		    	'href' => home_url( 'docs' )
		    );
		    $wp_admin_bar->add_node( $docs_args );
		}
	}

	function uninstall() {
		// If uninstall not called from WordPress, exit
		if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		    exit();
		}

		// Single site
		if ( !is_multisite() )
		{
		    // delete_option( $option_name );
		    $docs = get_posts( array( 'post_type' => 'docs', 'number' => -1 ) );
			foreach( $docs as $doc ) {
				wp_delete_post( $doc->ID, true );
			}
		}
		// Multisite
		else
		{
		    global $wpdb;
		    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		    $original_blog_id = get_current_blog_id();
		    foreach ( $blog_ids as $blog_id )
		    {
		        switch_to_blog( $blog_id );
	            $docs = get_posts( array( 'post_type' => 'docs', 'number' => -1 ) );
	        	foreach( $docs as $doc ) {
	        		wp_delete_post( $doc->ID, true );
	        	}
		    }
		    switch_to_blog( $original_blog_id );
		}
	}

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

}
$krnl_docs = KRNLDocs::get_instance();