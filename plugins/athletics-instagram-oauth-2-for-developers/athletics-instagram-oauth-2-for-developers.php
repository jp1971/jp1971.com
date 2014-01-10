<?php
/*
Plugin Name: Instagram OAuth 2.0
Plugin URI: 
Description: 
Version: 1.0.0
Author: Athletics
Author URI: http://athleticsnyc.com
License: GPL2
*/

/*  Copyright 2014 Athletics (dev@athleticsnyc.com)

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

class AthleticsInstagramOAuth {

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
		$this->options_page_title = 'Instagram OAuth 2.0';
		$this->options_page_menu_title = 'Instagram OAuth 2.0';
		$this->options_page_menu_slug = 'instagram_oauth_2_0';

		// add_settings_section variables
		$this->section_id = 'instagram_oauth_2_0_section';
		$this->section_title = '';
		$this->section_callback = array( $this, 'instagram_oauth_2_0_section_callback' );

		// register_setting/register_settings_fields variables
		$this->option_group = 'instagram_oauth_2_0';

		// set the redirect uri on activation
		add_option( 'redirect_uri', home_url( 'wp-admin/options-general.php?page=instagram_oauth_2_0') );
		error_log(home_url( 'wp-admin/options-general.php?page=instagram_oauth_2_0') );

		// Add action hooks
		add_action( 'admin_menu', array( $this, 'add_plugin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );
	}

	public function add_plugin_menu() {
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

	public function register_plugin_settings() {
		// Add settings section(s)
		// http://codex.wordpress.org/Function_Reference/add_settings_section
		add_settings_section(
			$this->section_id,
			$this->section_title,
			$this->section_callback,
			$this->options_page_menu_slug
		);

		// Add settings field(s)
		// http://codex.wordpress.org/Function_Reference/add_settings_field
		// e.g. add_settings_field( $id, $title, $callback, $page, $section, $args );
		add_settings_field( 
			'client_id', 
			'Client ID', 
			array( $this, 'client_id_callback'), 
			$this->options_page_menu_slug,
			$this->section_id
		);

		add_settings_field( 
			'client_secret', 
			'Client Secret', 
			array( $this, 'client_secret_callback'), 
			$this->options_page_menu_slug,
			$this->section_id
		);

		add_settings_field( 
			'redirect_uri', 
			'Redirect URI', 
			array( $this, 'redirect_uri_callback'), 
			$this->options_page_menu_slug,
			$this->section_id
		);

		// Register plugin settings
		// http://codex.wordpress.org/Function_Reference/register_setting
		// e.g. register_setting( $option_group, $option_name, $sanitize_callback );
		register_setting( $this->option_group, 'client_id' );
		register_setting( $this->option_group, 'client_secret' );
		register_setting( $this->option_group, 'redirect_uri' );
	}

	public function instagram_oauth_2_0_section_callback() {
		echo 'Please enter your Instagram Client ID and Secret.';
	}

	public function client_id_callback() {
    	$client_id = esc_attr( get_option( 'client_id' ) );
    	echo "<input type='text' size='60' name='client_id' value='$client_id' />";
	}	

	public function client_secret_callback() {
    	$client_secret = esc_attr( get_option( 'client_secret' ) );
    	echo "<input type='text' size='60' name='client_secret' value='$client_secret' />";
	}	

	public function redirect_uri_callback() {
    	$redirect_uri = esc_attr( get_option( 'redirect_uri' ) );
    	echo "<input type='text' size='60' name='redirect_uri' value='$redirect_uri' />";
	}	

	public function render_options_page() {
	?>
		<div class="wrap">
		    <h2>Instagram OAuth 2.0</h2>
		    <form action="options.php" method="POST">
		        <?php settings_fields( $this->option_group ); ?>
		        <?php do_settings_sections( $this->options_page_menu_slug ); ?>
		        <?php submit_button(); ?>
		    </form>
		</div>
	<?php
	}
}
$athletics_instagram_oauth = AthleticsInstagramOAuth::get_instance();