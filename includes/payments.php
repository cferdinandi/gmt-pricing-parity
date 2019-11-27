<?php

/**
 * Payments Functions
 */


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
		$price = gmt_pricing_parity_get_item_preadjusted_price( $item['id'], $options );
		$discounted_price = edd_cart_item_price( $item['id'], $options );

		// If they don't match, display a message
		if ( $price !== $discounted_price ) {
			echo '<div><em class="text-small text-muted">(' . edd_currency_filter( edd_format_amount( $price, false ) ) . ' before discount)</em></div>';
		}

	}
	add_action( 'edd_checkout_cart_item_price_after', 'gmt_pricing_parity_item_price_message' );


	function gmt_pricing_parity_discount_details($payment_id) {
		$discount = get_post_meta( $payment_id, 'pricing_parity_discount', true );
		?>
			<div class="edd-order-pricing-parity edd-admin-box-inside">
				<p>
					<span class="label"><?php _e( 'Pricing Parity:', 'pricing_parity' ); ?></span>&nbsp;
					<?php if (empty($discount)) : ?>
					<?php _e( 'none', 'pricing_parity' ); ?>
					<?php else : ?>
					<?php echo $discount['country']; ?> - <?php echo $discount['amount']; ?>%
					<?php endif; ?>
				</p>
			</div>
		<?php
	}
	add_action( 'edd_view_order_details_payment_meta_before', 'gmt_pricing_parity_discount_details' );