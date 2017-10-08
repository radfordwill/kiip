<?php
/**
 * The plugin meta file
 *
 * This is the description
 * @link              http://radford.online/
 * @since             1.0.2
 * @package           Kiip_For_WP
 *
 * @wordpress-plugin
 * Plugin Name:       Kiip For WP
 * Plugin URI:        http://radford.online/
 * Description:       Kiip.me plugin for Wordpress. Make ad revenue. Create rewards and user retention.
 * Version:           1.0.2
 * Author:            Will Radford
 * Author URI:        http://radford.online/
 * License:           GPL-2.0
 * License URI:       http//www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kiip-for-wp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kiip-for-wordpress-activator.php
 */
function activate_kiip_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kiip-for-wordpress-activator.php';
	Kiip_For_Wordpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kiip-for-wordpress-deactivator.php
 */
function deactivate_kiip_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kiip-for-wordpress-deactivator.php';
	Kiip_For_Wordpress_Deactivator::deactivate();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-kiip-for-wordpress.php';
register_activation_hook( __FILE__, 'activate_kiip_for_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_kiip_for_wordpress' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kiip_for_wordpress() {

	$plugin = new Kiip_For_Wordpress();
	$plugin->run();
}
run_kiip_for_wordpress();