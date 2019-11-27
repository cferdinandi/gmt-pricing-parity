<?php

/**
 * Payments Functions
 */


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