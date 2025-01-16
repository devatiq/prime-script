<?php
/**
 * Plugin Name: PrimeScript - Insert Header and Footer Script
 * Description: Allows users to inject header and footer scripts via a settings page.
 * Version: 1.0.0
 * Plugin URI: https://github.com/devatiq/prime-script
 * Author: ABCPlugin
 * Author URI: https://abcplugin.com/
 * Text Domain: prime-script
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * 
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants.
define( 'PRIMESCRIPT_VERSION', '1.0.0' );
define( 'PRIMESCRIPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PRIMESCRIPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include required files.
require_once PRIMESCRIPT_PLUGIN_DIR . 'includes/admin-settings.php';
require_once PRIMESCRIPT_PLUGIN_DIR . 'includes/script-injection.php';

/**
 * Initialize the plugin.
 */
function primescript_init() {
    // Initialize admin settings and script injection.
    PrimeScript\Admin_Settings::init();
    PrimeScript\Script_Injection::init();
}
add_action( 'plugins_loaded', 'primescript_init' );

//Settings link
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'primescript_add_settings_link');
function primescript_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('admin.php?page=prime-script-settings') . '">' . __('Settings', 'prime-script') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
