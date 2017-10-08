<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://radford.online/
 * @since      1.0.2
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/admin
 * @author     Will Radford <radford.will@gmail.com>
 */
class Kiip_For_Wordpress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public

	function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public

	function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kiip_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kiip_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kiip-for-wordpress-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public

	function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kiip_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kiip_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kiip-for-wordpress-admin.js', array( 'jquery' ), $this->version, false );

	}

	public

	function kiip_admin_menu() {
		// admin menu slug links
		add_menu_page( 'Kiip for WP Settings', 'Kiip-for-WP', 'manage_options', plugin_dir_path( __FILE__ ) . 'partials/kiip-for-wordpress-admin-display.php', '', plugins_url( 'kiip-for-wp' ) . '/assets/images/kiip-round-logo-white16.png', 99 );

	}

	/**
	 * Save initial data for the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    Adds meta data for the plugin options. (need to add this to installer)
	 */
	public

	function register_settings() {
		//registering settings
		register_setting( 'kiip-settings-group', 'public_key' );
		register_setting( 'kiip-settings-group', 'is_test_mode' );
		register_setting( 'kiip-settings-group', 'test_mode_email' );
		register_setting( 'kiip-settings-group', 'test_mode_userid' );
		register_setting( 'kiip-settings-group', 'test_mode_post_moment' );
		register_setting( 'kiip-settings-group', 'test_mode_set_click' );
		register_setting( 'kiip-settings-group', 'test_mode_set_container' );
		register_setting( 'kiip-settings-group', 'test_mode_onscroll' );
	}



}