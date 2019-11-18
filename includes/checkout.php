<?php

/**
 * Checkout Functions
 */


	/**
	 * Verify that the visitor is from the country for the discount code
	 * https://github.com/easydigitaldownloads/easy-digital-downloads/blob/master/includes/class-edd-discount.php#L1822-L1832
	 * @param  Boolean  $return The current validity value
	 * @param  Integer $id      The discount code ID
	 * @return Boolean          The new validity value
	 */
	function gmt_pricing_parity_verify_discount_code($return, $id) {

		// Check if the discount code is a pricing parity code
		$discount = get_posts(array(
			'post_type' => 'gmt_pricing_parity',
			'meta_key' => 'pricing_parity_price',
			'meta_value' => $id
		));
		if (empty($discount)) return $return;

		// Get the visitor's country and discount code allowed country
		$visitor_country = gmt_pricing_parity_get_country();
		$discount_country = get_post_meta( $discount[0]->ID, 'pricing_parity_country', true );

		// If the code is valid for the visitor's country, carry on
		if ($visitor_country['country_code'] && $visitor_country['country_code'] === $discount_country) return $return;

		// Otherwise, return an error
		edd_set_error( 'edd-discount-error', _x( 'Sorry, this discount code is only for visitors from another country.', 'error for when a discount is invalid based on visitor location' , 'easy-digital-downloads' ) );
		return false;

	}
	add_filter( 'edd_is_discount_valid', 'gmt_pricing_parity_verify_discount_code', 10, 3 );


	/**
	 * Allow more than one discount if one of them is a pricing parity discount
	 * @return [type] [description]
	 */
	function gmt_pricing_parity_discount_filters() {
		$discounts = edd_get_cart_discounts();
		if ( count($discounts) < 1 || (count($discounts) < 3 && gmt_pricing_parity_is_location_code($discounts)) ) {
			return true;
		} else {
			return false;
		}
	}
	add_filter( 'edd_multiple_discounts_allowed', 'gmt_pricing_parity_discount_filters' );


	/**
	 * Automatically add a pricing parity discount
	 */
	function gmt_pricing_parity_auto_set_discount() {

		// Get location details
		$country = gmt_pricing_parity_get_country();
		if (empty($country)) return;

		// Get discount by country
		$discount = gmt_pricing_parity_get_discount_by_country($country);
		if (empty($discount)) return;

		// If there's a discount, set it
		edd_set_cart_discount( $discount['discount'] );

	}
	add_action( 'init', 'gmt_pricing_parity_auto_set_discount' );