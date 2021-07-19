<?php

	/**
	 * Create the metabox
	 */
	function pricing_parity_create_metabox_no_discount() {
		add_meta_box( 'pricing_parity_metabox_no_discout', 'No Pricing Parity', 'pricing_parity_render_metabox_no_discount', 'download', 'side', 'default');
	}
	add_action( 'add_meta_boxes', 'pricing_parity_create_metabox_no_discount' );



	/**
	 * Render the metabox
	 */
	function pricing_parity_render_metabox_no_discount() {

		// Variables
		global $post;
		$no_discount = get_post_meta( $post->ID, 'pricing_parity_no_discount', true );

		?>

			<label for="pricing-parity-no-discount">
				<input type="checkbox" class="edd-checkbox" id="pricing-parity-no-discount" name="pricing-parity-no-discount" <?php checked($no_discount, 'on'); ?>>
				This product is not eligible for a pricing parity discount
			</label>

		<?php

		// Security field
		wp_nonce_field( 'pricing_parity_form_metabox_no_discount_nonce', 'pricing_parity_form_metabox_no_discount_process' );

	}



	/**
	 * Save the metabox
	 * @param  Number $post_id The post ID
	 * @param  Array  $post    The post data
	 */
	function pricing_parity_save_metabox_no_discount( $post_id, $post ) {

		if ( !isset( $_POST['pricing_parity_form_metabox_no_discount_process'] ) ) return;

		// Verify data came from edit screen
		if ( !wp_verify_nonce( $_POST['pricing_parity_form_metabox_no_discount_process'], 'pricing_parity_form_metabox_no_discount_nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Save data
		update_post_meta( $post->ID, 'pricing_parity_no_discount', ( isset($_POST['pricing-parity-no-discount']) ? 'on' : 'off' ) );

	}
	add_action('save_post', 'pricing_parity_save_metabox_no_discount', 1, 2);