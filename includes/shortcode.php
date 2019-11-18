<?php

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
		if ($_GET['test_api']) {
			print('<pre>');
			print_r($country);
			print('</pre>');
		}
		if (empty($country)) return '<div id="pricing-parity-content"></div>';
		$discount = gmt_pricing_parity_get_discount_by_country($country);
		if (empty($discount)) return '<div id="pricing-parity-content"></div>';

		// Update content
		$content = str_replace(array(
			'{{country}}',
			'{{iso}}',
			'{{amount}}',
		), array(
			$country['country_name'],
			strtolower($country['country_code']),
			$discount['amount'],
		), $content);

		return '<div id="pricing-parity-content">' . wpautop( $content, false ) . '</div>';

	}
	add_shortcode( 'pricing_parity', 'gmt_pricing_parity_shortcode' );