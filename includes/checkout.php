<?php

/**
 * Checkout Functions
 */


	/**
	 * Verify that the visitor is from the country for the discount code
	 * https://github.com/easydigitaldownloads/easy-digital-downloads/blob/master/includes/class-edd-discount.php#L1822-L1832
	 * @todo   Deprecate after cutover
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

		// Otherwise, return an error
		edd_set_error( 'edd-discount-error', _x( 'This code is no longer needed. Location-based discounts are now applied automatically, and will be noted in the cart details above.' , 'easy-digital-downloads' ) );
		return false;

	}
	add_filter( 'edd_is_discount_valid', 'gmt_pricing_parity_verify_discount_code', 10, 3 );


	/**
	 * Check for any valid pricing discounts on page load, and save them to the session
	 */
	function gmt_pricing_parity_set_discount() {

		// Check for a discount
		$country = gmt_pricing_parity_get_country();
		$discount = empty($country) ? null : gmt_pricing_parity_get_discount_by_country($country);

		// Set pricing parity discount
		EDD()->session->set( 'pricing_parity', (empty($discount) ? null : $discount) );

	}
	add_action( 'init', 'gmt_pricing_parity_set_discount' );


	/**
	 * If one exists, apply the location based discount to each item in the cart
	 * @param  Float   $price The price
	 * @return Float          The location-adjusted price
	 */
	function gmt_pricing_parity_adjust_item_price($price, $download_id) {
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return $price;
		$no_discount = get_post_meta( $download_id, 'pricing_parity_no_discount', true );
		if ($no_discount === 'on') return $price;
		$price = floatval($price);
		return $price - ($price * (intval($discount['amount']) / 100));
	}
	add_filter( 'edd_cart_item_price', 'gmt_pricing_parity_adjust_item_price', 10, 2 );


	/**
	 * Display the original price after each price-adjusted item in the cart
	 * @param  Array  $item The item details
	 * @return String       The message
	 */
	function gmt_pricing_parity_item_price_message($item) {

		// If there's no pricing parity discount, do nothing
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return;

		// Get the pre-adusted and discounted prices
		$price = gmt_pricing_parity_get_item_preadjusted_price( $item['id'], $item['options'] );
		$discounted_price = edd_cart_item_price( $item['id'], $item['options'] );

		// If they don't match, display a message
		if ( edd_currency_filter( edd_format_amount( $price, true ) ) !== $discounted_price ) {
			echo '<div><em class="text-small text-muted">(' . edd_currency_filter( edd_format_amount( $price, false ) ) . ' before discount)</em></div>';
		} else {
			echo '<div><em class="text-small text-muted">(This product is not eligible for location-based pricing)</span>';
		}

	}
	add_action( 'edd_checkout_cart_item_price_after', 'gmt_pricing_parity_item_price_message' );


	/**
	 * Display a price-adjustment message above the cart
	 * @return String The message
	 */
	function gmt_pricing_parity_cart_message() {

		$cart_items = edd_get_cart_contents();
		if (empty($cart_items)) return;

		// If there's no pricing parity discount, do nothing
		$discount = EDD()->session->get( 'pricing_parity');
		if (empty($discount)) return;

		// Otherwise, display a discount message
		echo '<div class="clearfix pricing-parity-discount"><img width="100" style="float:left;margin: 0.5em 1em 1em 0;" src="https://flagpedia.net/data/flags/normal/' . $discount['code'] . '.png"><p><em>Hi! Looks like you\'re from <strong>' . $discount['country'] . '</strong>, where my products might be a bit expensive. <strong>A discount of ' . $discount['amount'] . '%</strong> has automatically been applied to the items in your cart. Cheers!</em></p></div>';

	}
	add_action( 'edd_cart_items_before', 'gmt_pricing_parity_cart_message' );


	/**
	 * Add pricing parity details to the payment
	 * @param  array $merged_data The payment meta data
	 * @param  array
	 */
	function gmt_pricing_parity_add_details_to_payment($merged_data) {

		// Check for a discount
		$discount = EDD()->session->get( 'pricing_parity');

		// Add discount to data
		if (!empty($discount)) {
			$merged_data['pricing_parity'] = $discount;
		}

		return $merged_data;

	}
	add_filter( 'edd_payment_meta', 'gmt_pricing_parity_add_details_to_payment' );