<?php

/**
 *
 * @link              https://wpauthor.com
 * @since             1.0.0
 * @package           We_Devs
 *
 * @wordpress-plugin
 * Plugin Name:       We Devs
 * Plugin URI:        
 * Description:       -
 * Version:           1.0.0
 * Author:            WP Author
 * Author URI:        https://wpauthor.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       we-devs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WE_DEVS_VERSION', '1.0.0' );

define( 'WE_DEVS_DIR', str_replace("\\",'/',plugin_dir_path(__FILE__)));

define( 'WE_DEVS_URL', plugin_dir_url(__FILE__));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-we-devs-activator.php
 */
function activate_we_devs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-we-devs-activator.php';
	We_Devs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-we-devs-deactivator.php
 */
function deactivate_we_devs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-we-devs-deactivator.php';
	We_Devs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_we_devs' );
register_deactivation_hook( __FILE__, 'deactivate_we_devs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-we-devs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_we_devs() {

	$plugin = new We_Devs();
	$plugin->run();

}
run_we_devs();
