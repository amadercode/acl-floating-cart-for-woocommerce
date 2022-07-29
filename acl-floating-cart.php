<?php
/*
 * Plugin Name: ACL Floating Cart for WooCommerce
 * Version: 0.9
 * Plugin URI: https://amadercode.com/premium-products/acl-floating-cart/
 * Description: Display Instant Shopping Floating/Drawer Cart after add to cart. Update cart items, quantities and prices etc via Ajax.
 * Author: AmaderCode Lab
 * Author URI: http://www.amadercode.com/
 * Requires at least: 4.0
 * Tested up to: 5.3
 * WC tested up to: 3.7
 * WC requires at least: 3.0
 * Text Domain: acl-floating-cart
 * Domain Path: /lang/
 * @package WordPress
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'ACL_FOCAWO_PLUGIN_FILE' ) ) {
    define( 'ACL_FOCAWO_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'ACL_FOCAWO_VERSION' ) ) {
    define('ACL_FOCAWO_VERSION', '1.0.0');
}
if ( ! defined( 'ACL_FOCAWO_REQUIRED_PHP_VERSION' ) ) {
    define('ACL_FOCAWO_REQUIRED_PHP_VERSION', '5.4.0');
}
if ( ! defined( 'ACL_FOCAWO_WP_VERSION' ) ) {
    define('ACL_FOCAWO_WP_VERSION', '4.0');
}
if ( ! defined( 'ACL_FOCAWO_ABSPATH' ) ) {
    define('ACL_FOCAWO_ABSPATH', dirname(ACL_FOCAWO_PLUGIN_FILE) . '/');
}
if ( ! defined( 'ACL_FOCAWO_URL' ) ) {
    define('ACL_FOCAWO_URL', plugin_dir_url(__FILE__));
}
if ( ! defined( 'ACL_FOCAWO_PATH' ) ) {
    define('ACL_FOCAWO_PATH', plugin_dir_path(__FILE__));
}
if ( ! defined( 'ACL_FOCAWO_IMG_URL' ) ) {
    define('ACL_FOCAWO_IMG_URL', plugin_dir_url(__FILE__) . 'assets/images/');
}
// Load plugin basic class files
include_once( 'includes/class-focawo-plugin.php');
include_once( 'includes/class-focawo-install.php');

/**
 * Returns the main instance of FOCAWO_Plugin to prevent the need to use globals.
 *@since  1.0.0
 * @return object FOCAWO_Plugin
 */
function acl_focawo_plugin (){
	$instance = ACL_FoCaWo_Plugin::instance( __FILE__, ACL_FOCAWO_VERSION );
	if ( is_null( $instance->settings ) ) {
		$instance->settings = ACL_FoCaWo_Settings::instance( $instance );
	}
	return $instance;
}

add_action('plugins_loaded', 'acl_focawo_plugin');

