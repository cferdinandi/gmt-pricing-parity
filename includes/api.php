<?php


	function gmt_pricing_parity_get_discount($data) {

		// Get details
		$country = gmt_pricing_parity_get_country();
		if ($data['test'] === 'test') {
			return new WP_REST_Response(array_unique($country), 200);
		}
		if (empty($country) || !is_array($country) || !array_key_exists('country_name', $country) || !array_key_exists('country_code', $country)) {
			return new WP_Error( 400, __( 'Location not found.', 'edd_for_courses' ) );
		}
		$discount = get_posts(array(
			'post_type' => 'gmt_pricing_parity',
			'meta_key' => 'pricing_parity_country',
			'meta_value' => $_GET['country_code'] ? $_GET['country_code'] : $country['country_code']
		));
		if (empty($discount)) {
			return new WP_Error( 204, __( 'No discounts found.', 'edd_for_courses' ) );
		}

		// Get discount code
		$discount_id = get_post_meta( $discount[0]->ID, 'pricing_parity_price', true );
		$code = edd_get_discount_code($discount_id);
		if (empty($code)) {
			return new WP_Error( 204, __( 'No discounts found.', 'edd_for_courses' ) );
		}

		// Get discount details
		$type = edd_get_discount_type($discount_id);
		$amount = edd_format_discount_rate( $type, edd_get_discount_amount($discount_id) );

		// Update content
		$content = array(
			'discount' => $code,
			'amount' => $amount,
			'country' => $country['country_name'],
			'code' => strtolower($country['country_code']),
		);

		return new WP_REST_Response(array_unique($content), 200);

	}


	function gmt_pricing_parity_register_routes () {
		register_rest_route('gmt-pricing-parity/v1', '/discount', array(
			'methods' => 'GET',
			'callback' => 'gmt_pricing_parity_get_discount',
			// 'permission_callback' => function () {
			// 	return current_user_can( 'edit_theme_options' );
			// },
			// 'args' => array(
			// 	'test' => array(
			// 		'type' => 'string',
			// 	),
			// ),
		));

		register_rest_route('gmt-pricing-parity/v1', '/discount/(?P<test>\S+)', array(
			'methods' => 'GET',
			'callback' => 'gmt_pricing_parity_get_discount',
			// 'permission_callback' => function () {
			// 	return current_user_can( 'edit_theme_options' );
			// },
			'args' => array(
				'test' => array(
					'type' => 'string',
				),
			),
		));
	}
	add_action('rest_api_init', 'gmt_pricing_parity_register_routes');