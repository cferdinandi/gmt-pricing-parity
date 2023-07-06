<?php

/**
 * Plugin Name: GMT Pricing Parity
 * Plugin URI: https://github.com/cferdinandi/gmt-pricing-parity/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-pricing-parity/
 * Description: Provide custom discounts based on geographic location
 * Version: 2.9.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */

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

// Products with no discount
require_once( plugin_dir_path( __FILE__ ) . 'includes/metabox-no-discount.php' );