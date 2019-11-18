<?php

	/**
	 * Create the metabox
	 */
	function pricing_parity_create_metabox() {
		add_meta_box( 'pricing_parity_metabox', 'Pricing Parity Details', 'pricing_parity_render_metabox', 'gmt_pricing_parity', 'normal', 'default');
	}
	add_action( 'add_meta_boxes', 'pricing_parity_create_metabox' );



	/**
	 * Render the metabox
	 */
	function pricing_parity_render_metabox() {

		// Variables
		global $post;
		$countries = gmt_pricing_parity_get_countries();
		$country = get_post_meta( $post->ID, 'pricing_parity_country', true );
		$amount = get_post_meta( $post->ID, 'pricing_parity_amount', true );

		?>

			<fieldset>

				<div>
					<label for="pricing_parity_country">Country</label><br>
					<select id="pricing_parity_country" name="pricing_parity_country">
						<option></option>
						<?php foreach ($countries as $iso => $country_name) : ?>
							<option value="<?php echo esc_attr($iso); ?>" <?php selected($country, $iso); ?>><?php echo esc_attr($country_name); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<br>

				<div>
					<label for="pricing_parity_amount">Discount Percentage</label><br>
					<input type="number" name="pricing_parity_amount" id="pricing_parity_amount" value="<?php echo esc_attr(intval($amount)); ?>">
				</div>

			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'pricing_parity_form_metabox_nonce', 'pricing_parity_form_metabox_process' );

	}



	/**
	 * Save the metabox
	 * @param  Number $post_id The post ID
	 * @param  Array  $post    The post data
	 */
	function pricing_parity_save_metabox( $post_id, $post ) {

		if ( !isset( $_POST['pricing_parity_form_metabox_process'] ) ) return;

		// Verify data came from edit screen
		if ( !wp_verify_nonce( $_POST['pricing_parity_form_metabox_process'], 'pricing_parity_form_metabox_nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Check that events details are being passed along
		if ( !isset( $_POST['pricing_parity_country'] ) && !isset( $_POST['pricing_parity_amount'] ) ) {
			return $post->ID;
		}

		// Save data
		update_post_meta( $post->ID, 'pricing_parity_country', wp_filter_post_kses( $_POST['pricing_parity_country'] ) );
		update_post_meta( $post->ID, 'pricing_parity_amount', wp_filter_post_kses( $_POST['pricing_parity_amount'] ) );

	}
	add_action('save_post', 'pricing_parity_save_metabox', 1, 2);