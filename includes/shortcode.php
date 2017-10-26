<?php


   function get_client_ip() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP']) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if ($_SERVER['HTTP_X_FORWARDED']) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if ($_SERVER['HTTP_FORWARDED_FOR']) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if ($_SERVER['HTTP_FORWARDED']) {
		   $ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if ($_SERVER['REMOTE_ADDR']) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}


	function gmt_pricing_parity_get_country() {
		$ip = get_client_ip();
		$request = wp_remote_get( 'https://freegeoip.net/json/' . $ip );
		$response = wp_remote_retrieve_body( $request );
		$data = json_decode( $response, true );
		return $data;
	}

	/**
	 * Adds the pricing parity shortcode
	 * @param  array $atts The shortcode args
	 * @return string      The content snippet
	 */
	function gmt_pricing_parity_shortcode($atts, $content = null) {

		// Get shortcode atts
		// $pricing_parity = shortcode_atts(array(
		// 	'id' => null,
		// ), $atts);

		// Make sure there's content
		if (empty($content)) return;

		// Prevent this content from caching
		if (!defined('DONOTCACHEPAGE')) {
			define('DONOTCACHEPAGE', TRUE);
		}

		// Get details
		$country = gmt_pricing_parity_get_country();
		$discount = get_posts(array(
			'post_type' => 'gmt_pricing_parity',
			'meta_key' => 'pricing_parity_country',
			// 'meta_value' => $country['country_code']
			'meta_value' => 'US'
		));
		if (empty($discount)) return '<div id="pricing-parity-content"></div>';

		// Get discount code
		$discount_id = get_post_meta( $discount[0]->ID, 'pricing_parity_price', true );
		$code = edd_get_discount_code($discount_id);
		if (empty($code)) return '<div id="pricing-parity-content"></div>';

		// Get discount details
		$type = edd_get_discount_type($discount_id);
		$amount = edd_format_discount_rate( $type, edd_get_discount_amount($discount_id) );

		// Update content
		$content = str_replace(array(
			'{{code}}',
			'{{country}}',
			'{{iso}}',
			'{{amount}}',
		), array(
			$code,
			$country['country_name'],
			strtolower($country['country_code']),
			$amount,
		), $content);

		return '<div id="pricing-parity-content">' . wpautop( $content, false ) . '</div>';

	}
	add_shortcode( 'pricing_parity', 'gmt_pricing_parity_shortcode' );