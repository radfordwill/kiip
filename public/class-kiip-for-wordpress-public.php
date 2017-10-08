<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://radford.online/
 * @since      1.0.2
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/public
 * @author     Will Radford <radford.will@gmail.com>
 */
class Kiip_For_Wordpress_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kiip-for-wordpress-public.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_enqueue_script( 'kiip-ex', '//d3aq14vri881or.cloudfront.net/kiip.js', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kiip-for-wordpress-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'php_vars', $this->kiip_options_array() );
	}	
	
	/**
	 * Retrieve the meta data in an array for the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    Returns meta data for the plugin options in array.
	 */
	
	public function kiip_options_array() {
		$kiip_publicKey = sanitize_text_field( get_option( 'public_key' ) );
		$kiip_testmode = sanitize_html_class( get_option( 'is_test_mode' ), 'off' );
		$kiip_postmoment = sanitize_text_field( get_option( 'test_mode_post_moment' ) );
		$kiip_email = sanitize_email( get_option( 'test_mode_email' ) );
		$kiip_userId = sanitize_text_field( get_option( 'test_mode_userid' ) );
		$kiip_setClick = sanitize_html_class( get_option( 'test_mode_set_click' ) );
		$kiip_setContainer = sanitize_html_class( get_option( 'test_mode_set_container' ) );
		$kiip_onScroll = sanitize_text_field( get_option( 'test_mode_onscroll' ) );
		// add data to pass in js
		$dataToBePassed = array(
			'kiipsetPublickey' => $kiip_publicKey,
			'kiipsetTestMode' => $kiip_testmode,
			'kiipsetpostMoment' => $kiip_postmoment,
			'kiipsetEmail' => $kiip_email,
			'kiipsetUserId' => $kiip_userId,
			'kiipsetClick' => $kiip_setClick,
			'kiipsetContainer' => $kiip_setContainer,
			'kiiponScroll' => $kiip_onScroll );
		
		    return $dataToBePassed;
	}
	
		
	
}


;

