<?php

/**
 * Payments Functions
 */


	function gmt_pricing_parity_discount_details($payment_id) {
		$payment_meta = edd_get_payment_meta($payment_id);
		$discount = $payment_meta['pricing_parity'];
		?>
			<div class="edd-order-pricing-parity edd-admin-box-inside edd-admin-box-inside--row">
				<span class="label"><?php _e( 'Pricing Parity:', 'pricing_parity' ); ?></span>
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