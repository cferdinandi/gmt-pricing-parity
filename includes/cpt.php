<?php

	/**
	 * Add custom post type for reusable content
	 */
	function gmt_pricing_parity_add_custom_post_type() {

		$labels = array(
			'name'               => _x( 'Pricing Parity', 'post type general name', 'gmt_pricing_parity' ),
			'singular_name'      => _x( 'Country Discount', 'post type singular name', 'gmt_pricing_parity' ),
			'add_new'            => _x( 'Add New', 'keel-pets', 'gmt_pricing_parity' ),
			'add_new_item'       => __( 'Add New Discount', 'gmt_pricing_parity' ),
			'edit_item'          => __( 'Edit Discount', 'gmt_pricing_parity' ),
			'new_item'           => __( 'New Discount', 'gmt_pricing_parity' ),
			'all_items'          => __( 'Pricing Parity', 'gmt_pricing_parity' ),
			'view_item'          => __( 'View Discount', 'gmt_pricing_parity' ),
			'search_items'       => __( 'Search Discounts', 'gmt_pricing_parity' ),
			'not_found'          => __( 'No discounts found', 'gmt_pricing_parity' ),
			'not_found_in_trash' => __( 'No discounts found in the Trash', 'gmt_pricing_parity' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Pricing Parity', 'gmt_pricing_parity' ),
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our discounts and discount-specific data',
			// 'public'        => true,
			'show_ui'       => true,
			// 'menu_position' => 5,
			'menu_icon'     => 'dashicons-editor-paste-text',
			'hierarchical'  => false,
			'supports'      => array(
				'title',
				// 'editor',
				// 'thumbnail',
				// 'excerpt',
				// 'revisions',
				// 'page-attributes',
				// 'wpcom-markdown',
			),
			'has_archive'   => false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'query_var' => false,
			'rewrite' => array(
				'slug' => 'pricing-parity',
			),
			'show_in_menu' => 'edit.php?post_type=download',
			// 'map_meta_cap'  => true,
			// 'capabilities' => array(
			// 	'create_posts' => false,
			// 	'edit_published_posts' => false,
			// 	'delete_posts' => false,
			// 	'delete_published_posts' => false,
			// )
		);
		register_post_type( 'gmt_pricing_parity', $args );
	}
	add_action( 'init', 'gmt_pricing_parity_add_custom_post_type' );



	/**
	 * Add discount amount to list table
	 * @param Array $columns The columns detail
	 */
	function gmt_pricing_parity_add_columns ($columns) {
		$columns['pricing_parity_amount'] = __('Amount', 'gmt-pricing-parity');
		return $columns;
	}
	add_filter('manage_gmt_pricing_parity_posts_columns' , 'gmt_pricing_parity_add_columns');




	/**
	 * Add discount amount value to list table column
	 * @param String  $column   The column detail
	 * @param Integer $post_id  The post ID
	 */
	function gmt_pricing_parity_custom_column_value ($column, $post_id) {
		if ($column === 'pricing_parity_amount') {
			echo get_post_meta( $post_id, 'pricing_parity_amount', true ) . '%';
		}
	}
	add_action( 'manage_gmt_pricing_parity_posts_custom_column', 'gmt_pricing_parity_custom_column_value', 10, 2 );