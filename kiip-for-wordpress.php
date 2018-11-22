<?php
/**
 * Plugin Name: Kiip For Wordpress
 *
 * Description: Kiip.me plugin for Wordpress. Simple to use with shortcodes, widgets and editor buttons. Kiip is a marketing and monetization platform unique in style and user reward platforms. Reward your users and monetize your website today! Make ad revenue. Create rewards and user retention.
 *
 * Plugin URI: https://github.com/radfordwill/kiip
 * Version: 3.1.8
 * Author: Will Radford
 * Author URI: https://github.com/radfordwill/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * @package kiip
 * Text Domain: kiip
 * Domain Path: /languages
 *
 *
 */
if ( ! class_exists( 'kiip_for_wordpress' ) ) {
class kiip_for_wordpress {
	/**
	 * This plugin's identifier
	 */

	const ID = 'kiip-for-wordpress';

	/**
	 * This plugin's name
	 */

	const NAME = 'Kiip for Wordpress';

	/**
	 * This plugin's version
	 */

	const VERSION = '3.1.8';

	/**
	 * This plugin's folder name and location, text domain (also slug name for wordpress.org)
	 */

	const FOLDERNAME = 'kiip';


	/**
	 * This plugin's folder name and location, text domain (also slug name for wordpress.org)
	 */

	const TEXTDOMAIN = 'kiip';

	/**
	 * This plugin's table name prefix
	 * @var string
	 * Future use
	 */

	protected $prefix = 'kiip_for_wordpress';

	/**
	 * Has the internationalization text domain been loaded?
	 * @var bool
	 */

	protected $loaded_textdomain = false;

	/**
	 * @var instance
	 *
	 */

	public static $instance;

	/**
	 * Set up __construct function for this class
	 *
	 * @return void
	 *
	 */

	public

	function __construct() {
		$this->initialize();
		global $admin_menu_link;
		if ( is_admin() ) {
			$this->load_plugin_textdomain();
			// load admin files
			add_action( 'admin_enqueue_scripts', array( $this,  'enqueue_styles_admin' ) );
			add_action( 'admin_enqueue_scripts', array( $this,  'enqueue_scripts_admin' ) );
			// add settings to db from settings api
			//$this->register_settings();
			add_action('admin_init', array(& $this, 'register_settings'));
			if ( is_multisite() ) {
				$admin_menu = 'network_admin_menu';
				$this->admin_menu_link = self::FOLDERNAME . '/admin/partials/kiip-for-wordpress-admin-display.php';
			} else {
				$admin_menu = 'admin_menu';
				$this->admin_menu_link = self::FOLDERNAME . '/admin/partials/kiip-for-wordpress-admin-display.php';
			}
			add_action( $admin_menu, array( & $this, 'kiip_admin_menu' ) );
			// add shortcode buttons to the text editor
			add_action( 'admin_print_footer_scripts', array( & $this, 'kiip_shortcode_button_script' ) );
			// add params to admin js vars for rich editor shortcode button
			add_action( 'admin_head', array( & $this, 'add_kiip_params_admin' ) );
			// add custom links to this plugin's page entry
			add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( & $this, 'kiip_plugin_action_link' ) );
			// add shortcode button to rich editor
			add_action( 'admin_head', array( & $this, 'kiip_add_mce_button' ) );
		} else if (!is_admin()) {
			// load public files
			add_action( 'wp_enqueue_scripts', array( $this,  'enqueue_styles_public' ) );
			add_action( 'wp_enqueue_scripts', array( $this,  'enqueue_scripts_public' ) );
			// add shortcodes
			add_shortcode( 'kiip_ad_shortcode', array( $this, 'kiip_ad_shortcodes' ) );
		}
	}

	/**
	 * Sets the object's properties and options
	 *
	 * This is separated out from the constructor to avoid undesirable
	 * recursion.
	 *
	 * @return void
	 *
	 */

	protected

	function initialize() {
		//dummy
		global $wpdb;
		//global $wp_query;
		//global $pagenow;
	}

	/**
	 * Singleton
	 *
	 * Assume one instance only runs.
	 * @since 3.16
	 *
	 */

	public

	static

	function init() {
		if ( is_null( self::$instance ) )
			self::$instance = new kiip_for_wordpress();
		return self::$instance;
	}

	/**
	 * A centralized way to load the plugin's textdomain for
	 * internationalization
	 * @return void
	 */

	protected

	function load_plugin_textdomain() {
		if ( !$this->loaded_textdomain ) {
			load_plugin_textdomain( self::TEXTDOMAIN, false, self::TEXTDOMAIN . '/languages' );
			$this->loaded_textdomain = true;
		}
	}

	/**
	 * Save initial data for the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    Adds meta data for the plugin options. (TODO need to add this to install function instead)
	 */

	public

	function register_settings() {
		global $wp_version;
		$checkbox_defaults = array(
			'default' => 'off'
		);
		// wp 4.6 or greater uses third option to pass a default value
    if ( version_compare( $wp_version, '4.6', '>=' ) ) {
    register_setting( 'kiip-settings-group', 'is_test_mode', $checkbox_defaults );
		register_setting( 'kiip-settings-group', 'test_mode_set_click', 'kiip-adclick' );
		}
		else {
    register_setting( 'kiip-settings-group', 'is_test_mode' );
		register_setting( 'kiip-settings-group', 'test_mode_set_click' );
		}
		//registering settings
		register_setting( 'kiip-settings-group', 'public_key' );
		register_setting( 'kiip-settings-group', 'test_mode_email' );
		register_setting( 'kiip-settings-group', 'test_mode_userid' );
		register_setting( 'kiip-settings-group', 'test_mode_post_moment' );
	}

	/**
	 * Add menu link with icon in admin
	 *
	 * @since    1.0.0
	 *
	 */

	// Admin Menu Main page.
	public

	function kiip_admin_menu() {
		// admin menu slug links
		add_menu_page( __( 'Kiip for WP Settings', self::FOLDERNAME ),
			'Kiip-for-WP',
			'manage_options',
			$this->admin_menu_link,
			'',
			plugins_url( self::FOLDERNAME ) . '/assets/images/kiip-round-logo-white16.png', 99 );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */

	public

	function enqueue_styles_public() {
		wp_enqueue_style( self::NAME, plugin_dir_url( __FILE__ ) . 'public/css/kiip-for-wordpress-public.css', array(), self::VERSION, 'all' );
	}

	/**
	 * Register the javascript for the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */

	public

	function enqueue_scripts_public( $file_name = '' ) {
		// Call kiip.me web api to load ads. Admin settings contain required api key(s) and pertinent data.
		// Data is returned in a function in this class'
		wp_enqueue_script( 'kiip-ex', '//d3aq14vri881or.cloudfront.net/kiip.js', false );
		if ( $file_name != '' ) {
			wp_enqueue_script( 'kiip-for-wp-public', plugin_dir_url( __FILE__ ) . 'public/js/' . $file_name . '.js', array( 'jquery' ), self::VERSION );
			wp_localize_script( 'kiip-for-wp-public', 'php_vars', $this->kiip_options_array() );
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.2
	 */

	public

	function enqueue_styles_admin() {
		wp_enqueue_style( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/css/kiip-for-wordpress-admin.css', array(), self::VERSION, 'all' );
		// Load only on plugin id orour settings page, id for $current_screen does not get called soon enough to load in header??
		if ( ( 'kiip/admin/partials/kiip-for-wordpress-admin-display' != kiip_admin_get_current_screen() ) ) {
			return;
		}
		// bootstrap 3 affects other admin pages when loaded without conditions to exclude it from the rest of the admin.
		wp_enqueue_style( 'bootstrap.v3', plugin_dir_url( __FILE__ ) . 'admin/css/bootstrap/bootstrap.min.css', array(), '3.3.7' );
		// change to codemirror for shortcode display in settings
		wp_enqueue_style( 'codemirror', plugin_dir_url( __FILE__ ) . 'admin/css/codemirror/codemirror.css', array(), '5.3.2' );
		// one-dark codemirror theme by aerobird98
		wp_enqueue_style( 'one-dark-code-editor', plugin_dir_url( __FILE__ ) . 'admin/css/default.css', array(), self::VERSION );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.2
	 */

	public

	function enqueue_scripts_admin() {
		// get page id  or page name and load js only on this plugins settings page
		if ( 'kiip/admin/partials/kiip-for-wordpress-admin-display' != kiip_admin_get_current_screen() ) {
			return;
		}
		// admin js
		wp_enqueue_script( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/js/kiip-for-wordpress-admin.js', array( 'jquery' ), self::VERSION, false );
		// codemirror v5.3.2
		wp_enqueue_script( 'codemirror', plugin_dir_url( __FILE__ ) . 'admin/js/codemirror/codemirror.js', array( 'jquery' ), '5.3.2', false );
		wp_enqueue_script( 'codemirror-js', plugin_dir_url( __FILE__ ) . 'admin/js/codemirror/mode/javascript/javascript.js', array( 'jquery' ), '5.3.2', false );
		wp_enqueue_script( 'codemirror-js-active', plugin_dir_url( __FILE__ ) . 'admin/js/codemirror/selection/active-line.js', array( 'jquery' ), '5.3.2', false );
	}

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
		// add data to pass in js
		$dataToBePassed = array(
			'kiipsetPublickey' => $kiip_publicKey,
			'kiipsetTestMode' => $kiip_testmode,
			'kiipsetpostMoment' => $kiip_postmoment,
			'kiipsetEmail' => $kiip_email,
			'kiipsetUserId' => $kiip_userId,
			'kiipsetClick' => $kiip_setClick );
		return $dataToBePassed;
	}

	/**
	 * Get version from public class file
	 *
	 * @since    1.0.2
	 *
	 */

	public

	function get_plugin_data() {
		$plugin_data = get_plugin_data( plugin_dir_path( __FILE__ ) . 'kiip-for-wordpress.php', $markup = true, $translate = true );
		return $plugin_data;
	}

	/**
	 * Add shortcode support to the front end pages and html widgets
	 *
	 * @since    1.0.3
	 *
	 */

	public

	function kiip_ad_shortcodes( $atts, $content ) {
		// [kiip_ad_shortcode "fullscreen"]	[kiip_ad_shortcode "moment_type"]
		$atts = $this->we_normalize_attributes( $atts );
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

		if ( $atts[ 'type' ] == 'contained' ) {
			// maybe add this in sooner
			ob_start();
			?>
			<span id='kiip-moment-container' class='kiip-moment-container-shortcode'></span>
			<?php
			return ob_get_clean();
			}
			}

			/**
			 * Add shortcode buttons to wordpress tiny mce plain text editor
			 *
			 * @since 3.1.6
			 *
			 */

			public

			function kiip_shortcode_button_script() {
				if ( wp_script_is( "quicktags" ) ) {
					$KMC_shortcode = __( "Kiip Moment Container", self::TEXTDOMAIN );
					$KMA_shortcode = __( "Kiip Moment Auto Popup", self::TEXTDOMAIN );
					$KMOS_shortcode = __( "Kiip Moment On Scroll", self::TEXTDOMAIN );
					$KMOC_shortcode = __( "Kiip Moment On Click", self::TEXTDOMAIN );
					?>
			<script type="text/javascript">
				//this function is used to add the shortcode buttons to the plain text editor
				QTags.addButton(
					"KMC_shortcode",
					"<?php echo $KMC_shortcode;?>",
					'[kiip_ad_shortcode type="contained"]'
				);
				QTags.addButton(
					"KMA_shortcode",
					"<?php echo $KMA_shortcode;?>",
					'[kiip_ad_shortcode type="fullscreen"]'
				);
				QTags.addButton(
					"KMOS_shortcode",
					"<?php echo $KMOS_shortcode;?>",
					'[kiip_ad_shortcode type="fullscreen-onscroll"]'
				);
				QTags.addButton(
					"KMOC_shortcode",
					"<?php echo $KMOC_shortcode;?>",
					'[kiip_ad_shortcode type="fullscreen-onclick"]'
				);
			</script>
			<?php
		}
	}

	/**
	 * create a button for wp editor
	 *
	 * @since 3.1.6
	 *
	 */

	public

	function kiip_add_tinymce_plugin( $plugin_array ) {
		$plugin_array[ 'kiip_mce_button' ] = plugin_dir_url( __FILE__ ) . 'admin/js/shortcodes/tinymce-shortcode-buttons.js';
		return $plugin_array;
	}

	/**
	 * register the button for wp editor
	 *
	 * @since 3.1.6
	 *
	 */

	public

	function kiip_register_button( $buttons ) {
		array_push( $buttons, "kiip_mce_button" );
		return $buttons;
	}

	/**
	 * Add params to admin js vars
	 *
	 * @since 3.1.6
	 *
	 */
	public

	function add_kiip_params_admin() {
		global $current_screen;
		$type = $current_screen->post_type;
		$params = kiip_for_wordpress::kiip_options_array();
		$kiipsetClick = $params['kiipsetClick'];
		if ( ($type == 'post') || ($type == 'page') ) {
			?>
			<script type="text/javascript">
				var kiipsetClick = "<?php echo $kiipsetClick; ?>";
			</script>
			<?php
		}
	}

	/**
	 * Add shortcode buttons to wordpress tiny mce rich text editor
	 *
	 * @since 3.1.6
	 *
	 */

	public

	function kiip_add_mce_button( $typenow ) {
		global $typenow;
		// check user permissions
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}
		// verify the post type
		if ( !in_array( $typenow, array( 'post', 'page' ) ) )
			return;
		// check if WYSIWYG is enabled
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( & $this, 'kiip_add_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( & $this, 'kiip_register_button' ) );
		}
	}

	/**
	 * Add plugin action links.
	 *
	 * Add a link to the settings page on the plugins.php page.
	 *
	 * @since 3.1.3
	 *
	 * @param  array  $links List of existing plugin action links.
	 * @return array         List of modified plugin action links.
	 */

	public

	function kiip_plugin_action_link( $links ) {
		$links = array_merge( array(
			'<i class="wp-menu-image dashicons-before dashicons-admin-tools"></i><a href="' . esc_url( admin_url( 'admin.php?page=kiip/admin/partials/kiip-for-wordpress-admin-display.php' ) ) . '">' . __( 'Settings', kiip_for_wordpress::TEXTDOMAIN ) . '</a> | <i class="wp-menu-image dashicons-before dashicons-share-alt"></i><a href="' . esc_url( 'https://paypal.me/kiipforwordpress' ) . '" style="color:#00ff0a; font-weight:bold;">' . __( 'Donate', kiip_for_wordpress::TEXTDOMAIN ) . '</a> | <i class="wp-menu-image dashicons-before dashicons-star-filled"></i><a href="' . esc_url( 'https://wordpress.org/support/plugin/kiip/reviews/' ) . '">' . __( 'Review', kiip_for_wordpress::TEXTDOMAIN ) . '</a>'
		), $links );
		return $links;
	}

	/**
	 * shortcode text area with codemirror js
	 *
	 * @since    1.0.0
	 *
	 */

	// Display textarea on admin settings page.
	public

	function kiip_admin_page_textarea() {
		// output text area
		$textarea =
			"<textarea rows=\"30\" cols=\"40\" class=\"CodeMirror-linenumbers\" id=\"newcontent\" name=\"newcontent\">\n\n&#91;kiip_ad_shortcode type=\"fullscreen\"&#93;\n\n&#91;kiip_ad_shortcode type=\"contained\"&#93;\n\n&#91;kiip_ad_shortcode type=\"fullscreen-onscroll\"&#93;\n\n&#91;kiip_ad_shortcode type=\"fullscreen-onclick\"&#93;\n\n" . str_repeat( "\n", 8 ) . "</textarea>";
		return $textarea;
	}

	/**
	 * attribute function
	 *
	 * @since    1.0.3
	 *
	 */

	public

	function we_normalize_attributes( $atts ) {
		foreach ( $atts as $key => $value ) {
			if ( is_int( $key ) ) {
				$atts[ $value ] = true;
				unset( $atts[ $key ] );
			}
		}
		return $atts;
	}

	/**
	 * path to directory function
	 *
	 * @since    3.1.3
	 *
	 */

	public

	function kiip_the_path() {
		/* constant path to the folder. */
		$path = trailingslashit( plugin_dir_path( __FILE__ ) );
		return ( $path );
	}

	/**
	 * url of plugin folder function
	 *
	 * @since    3.1.3
	 *
	 */

	public

	function kiip_the_url() {
		/* url to the folder. */
		$url = trailingslashit( plugins_url( basename( __DIR__ ) ) );
		return ( $url );
	}
}
}
/**
 * The instantiated version of this plugin's main class
 */

$kiip_for_wordpress = kiip_for_wordpress::init();

/**
 * path to directory function (outside class) @TODO: move to widget class
 *
 * @since    3.1.3
 *
 */

function kiip_the_path() {
	/* constant path to the folder. */
	$path = trailingslashit( plugin_dir_path( __FILE__ ) );
	return ( $path );
}

/**
 * url of plugin folder function (outside class) @TODO: move to widget class
 *
 * @since    3.1.3
 *
 */

function kiip_the_url() {
	/* url to the folder. */
	$url = trailingslashit( plugins_url( basename( __DIR__ ) ) );
	return ( $url );
}

/**
 * get the screen id, runs too late inside the main class
 *
 * @since    3.1.8
 *
 */

function kiip_admin_get_current_screen() {
    global $current_screen;
    if ( ! isset( $current_screen ) )
        return null;
    return $current_screen->id;
}

/**
 * Widget class for kiip moment display in an included file
 *
 * @since 3.1.6
 */
//require the widget class
require_once( kiip_the_path() . 'includes/kiip-for-wordpress-widget-class.php' );
