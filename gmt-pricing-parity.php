<?php

/**
 * Plugin Name: GMT Pricing Parity
 * Plugin URI: https://github.com/cferdinandi/gmt-pricing-parity/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-pricing-parity/
 * Description: Provide custom discounts based on geographic location
 * Version: 2.3.4
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */

// Define constants
define( 'GMT_PRICING_PARITY_VERSION', '2.3.4' );

// Utilities
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );

// Shortcode
require_once( plugin_dir_path( __FILE__ ) . 'includes/shortcode.php' );

// API
require_once( plugin_dir_path( __FILE__ ) . 'includes/api.php' );

// Checkout
require_once( plugin_dir_path( __FILE__ ) . 'includes/checkout.php' );

// Payments
require_once( plugin_dir_path( __FILE__ ) . 'includes/payments.php' );

// Custom Post Type
require_once( plugin_dir_path( __FILE__ ) . 'includes/cpt.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/metabox.php' );


/**
 * Check the plugin version and make updates if needed
 */
function gmt_pricing_parity_check_version() {

	// Get plugin data
	$old_version = get_site_option( 'gmt_pricing_parity_version' );

	// Update plugin to current version number
	if ( empty( $old_version ) || version_compare( $old_version, GMT_PRICING_PARITY_VERSION, '<' ) ) {
		update_site_option( 'gmt_pricing_parity_version', GMT_PRICING_PARITY_VERSION );
	}

}
add_action( 'plugins_loaded', 'gmt_pricing_parity_check_version' );