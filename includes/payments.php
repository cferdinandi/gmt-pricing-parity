<?php

/**
 * Payments Functions
 */


	function gmt_pricing_parity_discount_details($payment_id) {
		$payment = edd_get_payment($payment_id);
		$payment_meta = empty($payment) ? array() : $payment->get_meta();
		$discount = in_array('pricing_parity', $payment_meta) ? $payment_meta['pricing_parity'] : null;
		?>
			<div class="edd-order-gateway edd-admin-box-inside edd-admin-box-inside--row">
					<span class="label"><?php _e( 'Pricing Parity', 'pricing_parity' ); ?></span>
					<span class="value">
						<?php if (empty($discount)) : ?>
						<?php _e( 'none', 'pricing_parity' ); ?>
						<?php else : ?>
						<?php echo $discount['country']; ?> - <?php echo $discount['amount']; ?>%
						<?php endif; ?>
					</span>
			</div>
		<?php
	}
	add_action( 'edd_view_order_details_payment_meta_before', 'gmt_pricing_parity_discount_details' );