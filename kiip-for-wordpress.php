<?php

/**
 * Plugin Name: Kiip For Wordpress
 *
 * Description: Kiip.me plugin for Wordpress. Simple to use with shortcodes, widgets and editor buttons. Kiip is a marketing and monetization platform unique in style and user reward platforms. Reward your users and monetize your website today! Make ad revenue. Create rewards and user retention.
 *
 * Plugin URI: http://radford.online
 * Version: 3.1.6
 *
 * Author: Will Radford
 * Author URI: http:/radford.online
 * License: GPLv2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * @package kiip
 * Text Domain:  kiip
 * Domain Path:  /languages
 *
 */

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

	/**
	 * This plugin's name
	 */
	const NAME = 'Kiip for Wordpress';

	/**
	 * This plugin's version
	 */
	const VERSION = '3.1.6';

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

	public

	function __construct() {
		$this->initialize();
		global $admin_menu_link;

		if ( is_admin() ) {
			$this->load_plugin_textdomain();

			// load admin files
			$this->enqueue_styles_admin();
			$this->enqueue_scripts_admin();

			// add settings to db from settings api
			$this->register_settings();

			if ( is_multisite() ) {
				$admin_menu = 'network_admin_menu';
				$this->admin_menu_link = self::FOLDERNAME . '/admin/partials/kiip-for-wordpress-admin-display.php';
			} else {
				$admin_menu = 'admin_menu';
				$this->admin_menu_link = self::FOLDERNAME . '/admin/partials/kiip-for-wordpress-admin-display.php';
			}

			register_activation_hook( __FILE__, array( & $this, 'activate' ) );
			if ( $this->options[ 'deactivate_deletes_data' ] ) {
				register_deactivation_hook( __FILE__, array( & $this, 'deactivate' ) );
			}
			add_action( $admin_menu, array( & $this, 'kiip_admin_menu' ) );
			// add shortcode buttons to the text editor
			add_action( 'admin_print_footer_scripts', array( & $this, 'kiip_shortcode_button_script' ) );
			// add params to admin js vars for rich editor shortcode button
			add_action( 'admin_head', array( & $this, 'add_kiip_params_admin' ) );
			// add shortcode button to rich editor
			add_action( 'admin_head', array( & $this, 'kiip_add_mce_button' ) );
			// add custom links to this plugin's page entry
			add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'kiip_plugin_action_link' );
		} else {
			// load public files
			$this->enqueue_styles_public();
			$this->enqueue_scripts_public();
			// add shortcodes
			add_shortcode( 'kiip_ad_shortcode', array( $this, 'kiip_ad_shortcodes' ) );
		}
	}

	/**
	 * Sets the object's properties and options - Future use
	 *
	 * This is separated out from the constructor to avoid undesirable
	 * recursion.  The constructor sometimes instantiates the admin class,
	 * which is a child of this class.  So this method permits both the
	 * parent and child classes access to the settings and properties.
	 *
	 * @return void
	 *
	 */

	protected

	function initialize() {
		//dummy
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
		$checkbox_defaults = array(
			'default' => 'off'
		);
		//registering settings
		register_setting( 'kiip-settings-group', 'public_key' );
		register_setting( 'kiip-settings-group', 'is_test_mode', $checkbox_defaults );
		register_setting( 'kiip-settings-group', 'test_mode_email' );
		register_setting( 'kiip-settings-group', 'test_mode_userid' );
		register_setting( 'kiip-settings-group', 'test_mode_post_moment' );
		register_setting( 'kiip-settings-group', 'test_mode_set_click', 'kiip-adclick' );
	}

	/**
	 * Add menu link with icon in admin
	 *
	 * @since    1.0.3
	 *
	 */

	// Admin Menu Main page.
	public

	function kiip_admin_menu() {
		// admin menu slug links
		add_menu_page( 'Kiip for WP Settings',
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

	function enqueue_scripts_public( $file_name ) {
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
		// Load only on plugin id, id for $current_screen does not get called soon enough to load in header??
		if ( 'kiip/admin/partials/kiip-for-wordpress-admin-display.php' != $_GET[ 'page' ] ) {
			return;
		}
		//$current_page_id = self::check_current_screen_admin();
		//if( $current_page_id == "kiip/admin/partials/kiip-for-wordpress-admin-display" ) {		
		// bootstrap 3  affects other admin pages when loaded without conditions to exclude it from the rest of the admin.
		wp_enqueue_style( 'bootstrap-3.3.7', plugin_dir_url( __FILE__ ) . 'admin/css/bootstrap/bootstrap.min.css' );
	}
	//}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.2
	 */

	public

	function enqueue_scripts_admin() {
		// get page id and load js only on this plugins settings page
		$current_page_id = self::check_current_screen_admin();
		if ( $current_page_id != "kiip/admin/partials/kiip-for-wordpress-admin-display" ) {
			return;
		}
		//unused
		//wp_enqueue_script( self::NAME, plugin_dir_url( __FILE__ ) . 'admin/js/kiip-for-wordpress-admin.js', array( 'jquery' ), self::VERSION, false );
		// microlight syntax highlighjter
		wp_enqueue_script( 'microlight', plugin_dir_url( __FILE__ ) . 'admin/js/microlight/microlight.js', '', '', false );
		// popper.min.js
		wp_enqueue_script( 'popper-1.12.5', plugin_dir_url( __FILE__ ) . 'admin/js/bootstrap/popper.min.js', array( 'jquery' ), self::VERSION, false );
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
					?>
			<script type="text/javascript">
				//this function is used to add the shortcode buttons to the plain text editor
				QTags.addButton(
					"KMC_shortcode",
					"Kiip Moment Container",
					'[kiip_ad_shortcode type="contained"]'
				);
				QTags.addButton(
					"KMA_shortcode",
					"Kiip Moment Auto Popup ",
					'[kiip_ad_shortcode type="fullscreen"]'
				);
				QTags.addButton(
					"KMOS_shortcode",
					"Kiip Moment On Scroll",
					'[kiip_ad_shortcode type="fullscreen-onscroll"]'
				);
				QTags.addButton(
					"KMOC_shortcode",
					"Kiip Moment On Click",
					'[kiip_ad_shortcode type="fullscreen-onclick"]'
				);
			</script>
			<?php
		}
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
		$params = self::kiip_options_array();
		if ( is_admin() && $type == 'post' || $type == 'page' ) {
			?>
			<script type="text/javascript">
				var kiipsetClick = '<?php echo $params['kiipsetClick']; ?>';
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

	function kiip_add_mce_button() {
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
			add_filter( 'mce_external_plugins', 'kiip_add_tinymce_plugin' );
			add_filter( 'mce_buttons', 'kiip_register_button' );
		}
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

	/**
	 * supposed to get the page id, runs too late for this plugin
	 *
	 * @since    3.1.4
	 *
	 */

	public

	function check_current_screen_admin() {
		if ( !is_admin() ) return;
		global $current_screen;
		return ( $current_screen->id );
	}
}

/**
 * The instantiated version of this plugin's main class
 */

$kiip_for_wordpress = new kiip_for_wordpress();

/**
 * create a button for wp editor
 *
 * @since 3.1.6
 *
 */

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

function kiip_register_button( $buttons ) {
	array_push( $buttons, "kiip_mce_button" );
	return $buttons;
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

function kiip_plugin_action_link( $links ) {
	$links = array_merge( array(
		'<i class="wp-menu-image dashicons-before dashicons-admin-tools"></i><a href="' . esc_url( admin_url( 'admin.php?page=kiip/admin/partials/kiip-for-wordpress-admin-display.php' ) ) . '">' . __( 'Settings', kiip_for_wordpress::ID ) . '</a> | <i class="wp-menu-image dashicons-before dashicons-share-alt"></i><a href="' . esc_url( 'https://paypal.me/kiipforwordpress' ) . '" style="color:#00ff0a; font-weight:bold;">' . __( 'Donate', kiip_for_wordpress::ID ) . '</a> | <i class="wp-menu-image dashicons-before dashicons-star-filled"></i><a href="' . esc_url( 'https://wordpress.org/support/plugin/kiip/reviews/' ) . '">' . __( 'Review', kiip_for_wordpress::ID ) . '</a>'
	), $links );
	return $links;
}

/**
 * Widget class for kiip moment display
 * supported in wide sidebars for now
 * shortcode takes priority over this widget
 *
 * @since 3.1.3
 */

class kiip_Widget extends WP_Widget {

	// Set up the widget name and description.
	public

	function __construct() {
		$widget_options = array( 'classname' => 'kiip_moment_widget', 'description' => 'Displays a container kiip moment in a widget. Takes priority over shortcodes.' );
		parent::__construct( 'kiip_moment_widget', 'Kiip Moment Widget', $widget_options );
	}

	// Create the widget output.
	public

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		$blog_title = get_bloginfo( 'name' );
		$tagline = get_bloginfo( 'description' );
		echo $args[ 'before_widget' ] . $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		// add html to widget contents
		?>
		<?php echo '<span id=\'kiip-moment-container\' class=\'kiip-moment-container-widget\'></span>'; ?>
		<?php
		echo $args[ 'after_widget' ];
	}

	// Create the admin area widget settings form.
	public

	function form( $instance ) {
		$title = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	// Apply settings to the widget instance.
	public

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
	}

}

add_action( 'widgets_init', 'kiip_moment_register_widget' );

/**
 * Set up scripts and styles for the widget
 *
 * @since 3.1.3
 * 
 */

function kiip_setup_enque_actions() {
	$plugin_data = new kiip_for_wordpress();
	wp_enqueue_script( 'kiip-for-wp-public', plugin_dir_url( __FILE__ ) . 'public/js/kiip-for-wordpress-public-contained.js', array( 'jquery' ), kiip_for_wordpress::VERSION );
	wp_localize_script( 'kiip-for-wp-public', 'php_vars', $plugin_data->kiip_options_array() );
}

/**
* checking pages, posts, posts page etc for our shortcode outside any classes
*
* @since 3.1.3
*
*/

function kiip_check_for_shortcode() {
	global $wp_query;
	$posts = $wp_query->posts;
	$pattern = get_shortcode_regex();
	foreach ( $posts as $post ) {
		if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) &&
			array_key_exists( 2, $matches ) &&
			in_array( 'kiip_ad_shortcode', $matches[ 2 ] ) ) {
			break;
		} else {
			add_action( 'wp_enqueue_scripts', 'kiip_setup_enque_actions' );
		}
	}
}

// check for our shortcode outside any classes. wp.
add_action( 'wp', 'kiip_check_for_shortcode' );

// Register the widget.
function kiip_moment_register_widget() {
	register_widget( 'kiip_Widget' );
}