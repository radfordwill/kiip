<?php

/**
 * Plugin Name: Kiip For Wordpress
 *
 * Description: Kiip.me plugin for Wordpress. Make ad revenue. Create rewards and user retention.
 *
 * Plugin URI: http://radford.online
 * Version: 1.0.3
 *
 * Author: Will Radford
 * Author URI: http:/radford.online
 * License: GPLv2
 * @package kiip-for-wordpress
 *
 * This plugin used the Object-Oriented Plugin Template Solution as a skeleton
 *
 */

/**
 * The instantiated version of this plugin's class
 */
$GLOBALS[ 'kiip_for_wordpress' ] = new kiip_for_wordpress;

/**
 *
 * attributions
 * This plugin used the Object-Oriented Plugin Template Solution as a skeleton
 *
 * since 1.0.3
 *
 */
class kiip_for_wordpress {
    /**
     * This plugin's identifier
     */
    const ID = 'kiip-for-wordpress';
    //define("ID", "kiip-for-wordpress", true);

    /**
     * This plugin's name
     */
    const NAME = 'Kiip for Wordpress';
    //define("NAME", "Kiip for Wordpress", true);

    /**
     * This plugin's version
     */
    const VERSION = '1.0.3';
    //define("VERSION", "1.0.3", true);

    /**
     * This plugin's location
     */
    const FOLDERNAME = 'kiip-for-wp';
    //define("VERSION", "1.0.3", true);

    /**
     * This plugin's table name prefix
     * @var string
     */
    protected $prefix = 'kiip_for_wordpress';


    /**
     * Has the internationalization text domain been loaded?
     * @var bool
     */
    protected $loaded_textdomain = false;

    /**
     * This plugin's options
     *
     * Options from the database are merged on top of the default options.
     *
     * @see kiip_for_wordpress::set_options()  to obtain the saved
     *      settings
     * @var array
     */
    protected $options = array();

    /**
     * This plugin's default options
     * @var array
     */
    protected $options_default = array(
        'deactivate_deletes_data' => 1,
    );

    /**
     * Our option name for storing the plugin's settings
     * @var string
     */
    protected $option_name;

    /**
     * Name, with $table_prefix, of the table tracking login failures
     * @var string
     */
    protected $table_login;

    /**
     * Our usermeta key for tracking when a user logged in
     * @var string
     */
    protected $umk_login_time;

    /**
     * Declares the WordPress action and filter callbacks
     *
     * @return void
     * @uses kiip_for_wordpress::initialize()  to set the object's
     *       properties
     */
    public

    function __construct() {
        $this->initialize();
        if ( is_admin() ) {
            $this->load_plugin_textdomain();

            // load admin files
            $this->enqueue_styles_admin();
            $this->enqueue_scripts_admin();

            // add settings to db from settings api
            $this->register_settings();

            if ( is_multisite() ) {
                $admin_menu = 'network_admin_menu';
            } else {
                $admin_menu = 'admin_menu';
            }

            register_activation_hook( __FILE__, array( & $this, 'activate' ) );
            if ( $this->options[ 'deactivate_deletes_data' ] ) {
                register_deactivation_hook( __FILE__, array( & $this, 'deactivate' ) );
            }
            add_action( $admin_menu, array( & $this, 'kiip_admin_menu' ) );
            // add_action( 'admin_init', 'kiip_admin_menu' );
        } else {
            // load public files
            $this->enqueue_styles_public();
            //$this->enqueue_scripts_public();
            // add shortcodes
            add_shortcode( 'kiip_ad_shortcode', array( $this, 'kiip_ad_shortcodes' ) );
        }

    }

    /**
     * Sets the object's properties and options
     *
     * This is separated out from the constructor to avoid undesirable
     * recursion.  The constructor sometimes instantiates the admin class,
     * which is a child of this class.  So this method permits both the
     * parent and child classes access to the settings and properties.
     *
     * @return void
     *
     * @uses kiip_for_wordpress::set_options()  to replace the default
     *       options with those stored in the database
     */
    protected

    function initialize() {
        global $wpdb;

    }

    /*
     * ===== ACTION & FILTER CALLBACK METHODS =====
     */

    /**
     * A centralized way to load the plugin's textdomain for
     * internationalization
     * @return void
     */
    protected

    function load_plugin_textdomain() {
        if ( !$this->loaded_textdomain ) {
            load_plugin_textdomain( self::ID, false, self::ID . '/languages' );
            $this->loaded_textdomain = true;
        }
    }

    /**
     * Save initial data for the plugin.
     *
     * @since     1.0.0
     * @return    string    Adds meta data for the plugin options. (need to add this to installer)
     */
    public

    function register_settings() {
        $checkbox_defaults = array(
            'default' => 'off'
        );
        //registering settings
        register_setting( 'kiip-settings-group', 'public_key' );
        register_setting( 'kiip-settings-group', 'is_test_mode', $checkbox_defaults );
        register_setting( 'kiip-settings-group', 'test_mode_email' );
        register_setting( 'kiip-settings-group', 'test_mode_userid' );
        register_setting( 'kiip-settings-group', 'test_mode_post_moment' );
        register_setting( 'kiip-settings-group', 'test_mode_set_click', $checkbox_defaults );
        register_setting( 'kiip-settings-group', 'test_mode_set_container' );
        register_setting( 'kiip-settings-group', 'test_mode_onscroll', $checkbox_defaults );
        register_setting( 'kiip-settings-group', 'test_mode_all_pages', $checkbox_defaults );
        register_setting( 'kiip-settings-group', 'test_mode_all_posts', $checkbox_defaults );
        register_setting( 'kiip-settings-group', 'test_mode_popups', $checkbox_defaults );
    }


    // Admin Menu Main page.
    public

    function kiip_admin_menu() {
        // admin menu slug links
        add_menu_page( 'Kiip for WP Settings',
            'Kiip-for-WP',
            'manage_options',
            self::FOLDERNAME . '/admin/partials/kiip-for-wordpress-admin-display.php',
            '',
            plugins_url( self::FOLDERNAME ) . '/assets/images/kiip-round-logo-white16.png', 99 );
    }


    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public

    function enqueue_styles_public( $file_name = '' ) {
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
        wp_enqueue_style( self::NAME, plugin_dir_url( __FILE__ ) . 'public/css/kiip-for-wordpress-public.css', array(), self::VERSION, 'all' );
    }

    public

    function enqueue_scripts_public( $file_name ) {

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
        if ( $file_name != '' ) {
            wp_enqueue_script( 'kiip-for-wp-public', plugin_dir_url( __FILE__ ) . 'public/js/' . $file_name . '.js', array( 'jquery' ), self::VERSION );
            wp_localize_script( 'kiip-for-wp-public', 'php_vars', $this->kiip_options_array() );
        }

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public

    function enqueue_styles_admin() {
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
        wp_enqueue_style( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/css/kiip-for-wordpress-admin.css', array(), self::VERSION, 'all' );
        wp_enqueue_style( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/css/prettify/themes/vibrant-ink.min.css', array(), self::VERSION, 'all' );  wp_enqueue_style('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public

    function enqueue_scripts_admin() {
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
        wp_enqueue_script( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/js/kiip-for-wordpress-admin.js', array( 'jquery' ), self::VERSION, false );
        
        wp_enqueue_script( self::NAME, plugins_url( 'kiip-for-wp' ). 'admin/js/run_prettify.js?skin=Sons-Of-Obsidian', array( 'jquery' ), self::VERSION, false );
        ;
        
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */


    /**
     * Retrieve the meta data in an array for the plugin.
     *
     * @since     1.0.0
     * @return    string    Returns meta data for the plugin options in array.
     */
    public

    function kiip_options_array() {
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

    /**
     * Get version from class file public
     *
     * @since    1.0.2
     * 
     */
    public

    function get_plugin_data() {

        $plugin_data = get_plugin_data( plugin_dir_path( __FILE__ ) . 'kiip-for-wordpress.php', $markup = true, $translate = true );

        return $plugin_data;
    }

    // [kiip_ad_shortcode fullscreen]	[kiip_ad_shortcode]
    public

    function kiip_ad_shortcodes( $atts, $content ) {

        // $atts = $this->normalize_attributes($atts);
        // Attributes
        $atts = shortcode_atts(
            array(
                'type' => 'fullscreen',
            ),
            $atts,
            'kiip_ad_shortcode'
        );
        if ( $atts[ 'type' ] == true ) {
            $name = $atts[ 'type' ];
        } else {
            $name = 'fullscreen';
        }
        $file_name = 'kiip-for-wordpress-public-' . $name;
        $this->enqueue_scripts_public( $file_name );
        //return $file_name;
    }

    public

    function normalize_attributes( $atts ) {
        foreach ( $atts as $key => $value ) {
            if ( is_int( $key ) ) {
                $atts[ $value ] = true;
                unset( $atts[ $key ] );
            }
        }

        return $atts;
    }
}