<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sublimelinks.com
 * @since             1.0.2
 * @package           Level_system
 *
 * @wordpress-plugin
 * Plugin Name:       Level System
 * Description:       The one and only Level System for WordPress. Just add the widget to your favorite area and enjoy the fully customizable and responsive level system. Pick your own colors and width for the progress bar. Automatically give users on your website level and experience points as they contribute to your website. Possibilities to test all XP points & levels directly in your browser.
 * Version:           1.0.2
 * Author:            Simon Jakobsen
 * Author URI:        https://sublimelinks.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       level_system
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.2 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-level_system-activator.php
 */
function activate_level_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-level_system-activator.php';
	Level_system_Activator::activate();
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-level_system-widgets.php';
	Level_system_Widgets::update($new_instance, $old_instance);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-level_system-deactivator.php
 */
function deactivate_level_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-level_system-deactivator.php';
	Level_system_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_level_system' );
register_deactivation_hook( __FILE__, 'deactivate_level_system' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-level_system.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-level_system-widgets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.2
 */
function run_level_system() {

	$plugin = new Level_system();
	$plugin->run();

}
run_level_system();
