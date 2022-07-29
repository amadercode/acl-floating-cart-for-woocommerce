<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// register activation hook
register_activation_hook( ACL_FOCAWO_PLUGIN_FILE, 'acl_focawo_activation' );
function acl_focawo_activation() {
        global $wp_version;
        if ( version_compare( PHP_VERSION, ACL_FOCAWO_REQUIRED_PHP_VERSION, '<' ) ) {
            wp_die('Minimum PHP Version required: ' . ACL_FOCAWO_REQUIRED_PHP_VERSION );
        }
        if ( version_compare( $wp_version, ACL_FOCAWO_WP_VERSION, '<' ) ) {
            wp_die('Minimum Wordpress Version required: ' . ACL_FOCAWO_WP_VERSION );
        }
        if(!class_exists('WooCommerce')){
            wp_die('WooCommerce is required ');
        }
        // General Initial Options
        if(!get_option('acl_focawo_show_shipping_notice')) {
            update_option('acl_focawo_show_shipping_notice','on');
        }

        //Templates
        if(!get_option('acl_focawo_templates')) {
            update_option('acl_focawo_templates','1');
        }

        // Labels
        if(!get_option('acl_focawo_item_label')) {
            update_option('acl_focawo_item_label','Items');
        }
        if(!get_option('acl_focawo_cart_title')) {
            update_option('acl_focawo_cart_title','Shopping Cart');
        }
        if(!get_option('acl_focawo_sub_total_label')) {
            update_option('acl_focawo_sub_total_label','Sub Total');
        }
        if(!get_option('acl_focawo_shipping_notice_label')) {
            update_option('acl_focawo_shipping_notice_label','Shipping charge will be added at checkout page.');
        }
        // Style Initial Options
        if(!get_option('acl_focawo_custom_css')) {
            update_option('acl_focawo_custom_css','');
        }
        flush_rewrite_rules( true );
    }
?>