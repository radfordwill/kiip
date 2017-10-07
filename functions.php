<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}
if ( is_admin() ) {
	// admin menu entry
	add_action( 'admin_menu', 'kiip_admin_menu' );

	function kiip_admin_menu() {
		add_menu_page( 'Kiip for WP Settings', 'Kiip-for-WP', 'manage_options', 'kiip-for-wp/admin/admin.php', '', plugins_url( 'kiip-for-wp' ) . '/assets/images/kiip-round-logo-white16.png', 99 );
		//call register settings function
		add_action( 'admin_init', 'kiip_reg_settings' );
	};
	// meta data for the plugin options
	function kiip_reg_settings() {
		//registering settings
		register_setting( 'kiip-settings-group', 'public_key' );
		register_setting( 'kiip-settings-group', 'is_test_mode' );
		register_setting( 'kiip-settings-group', 'test_mode_email' );
		register_setting( 'kiip-settings-group', 'test_mode_userid' );
		register_setting( 'kiip-settings-group', 'test_mode_post_moment' );
		register_setting( 'kiip-settings-group', 'test_mode_set_click' );
		register_setting( 'kiip-settings-group', 'test_mode_set_container' );
		register_setting( 'kiip-settings-group', 'test_mode_onscroll' );
		// add setcontainer
		// add to admin only
	}
} else {
	// styles and js
	wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
	wp_enqueue_style( 'kiip-css', plugin_dir_url( __FILE__ ) . 'css/kiip-for-wp-public.css', 'all' );
	wp_enqueue_script( 'kiip-ex', '//d3aq14vri881or.cloudfront.net/kiip.js', false );
	wp_enqueue_script( 'kiip-for-wp-strict', plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), false );
	wp_enqueue_script( 'kiip-for-wp-public', plugins_url( 'kiip-for-wp' ) . '/js/kiip-for-wp-public.js', array( 'jquery' ), false );
	//options passed to js	
	/**/
	function kiip_op_data() {
		$kiip_testmode = sanitize_html_class( get_option( 'is_test_mode' ), 'off' );
		$kiip_postmoment = sanitize_text_field( get_option( 'test_mode_post_moment' ) );
		$kiip_email = sanitize_email( get_option( 'test_mode_email' ) );
		$kiip_userId = sanitize_text_field( get_option( 'test_mode_userid' ) );
		$kiip_setClick = sanitize_html_class( get_option( 'test_mode_set_click' ) );
		$kiip_setContainer = sanitize_html_class( get_option( 'test_mode_set_container' ) );
		$kiip_onScroll = sanitize_text_field( get_option( 'test_mode_onscroll' ) );
		// add data to pass in js
		$dataToBePassed = array(
			'kiipsetTestMode' => $kiip_testmode,
			'kiipsetpostMoment' => $kiip_postmoment,
			'kiipsetEmail' => $kiip_email,
			'kiipsetUserId' => $kiip_userId,
			'kiipsetClick' => $kiip_setClick,
			'kiipsetContainer' => $kiip_setContainer,
			'kiiponScroll' => $kiip_onScroll );
		
		    return $dataToBePassed;
	}
	$kiip_op_data = kiip_op_data();
	wp_localize_script( 'kiip-for-wp-public', 'php_vars', $kiip_op_data );
}