<?php


	function gmt_pricing_parity_get_discount($data) {

		// Get location details
		$country = gmt_pricing_parity_get_country();

		// If a test call, return country details
		if ($data['test'] === 'test') {
			return new WP_REST_Response($country, 200);
		}

		// If there's no location info, throw 400 error
		if (empty($country)) {
			return new WP_Error( 400, __( 'Location not found.', 'edd_for_courses' ) );
		}

		// Get discount by country
		$discount = gmt_pricing_parity_get_discount_by_country($country, $_GET['country_code']);
		if (empty($discount)) {
			return new WP_REST_Response(array('status' => 'no_discount', 'msg' => __( 'No discounts found.', 'pricing_parity' )), 200);
		}

		// Otherwise, return the discount
		return new WP_REST_Response($discount, 200);

	}


	function gmt_pricing_parity_register_routes () {
		register_rest_route('gmt-pricing-parity/v1', '/discount', array(
			'methods' => 'GET',
			'callback' => 'gmt_pricing_parity_get_discount',
		));

		register_rest_route('gmt-pricing-parity/v1', '/discount/(?P<test>\S+)', array(
			'methods' => 'GET',
			'callback' => 'gmt_pricing_parity_get_discount',
			'args' => array(
				'test' => array(
					'type' => 'string',
				),
			),
		));
	}
	add_action('rest_api_init', 'gmt_pricing_parity_register_routes');