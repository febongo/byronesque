<?php

if ( ! function_exists( 'corsen_core_add_product_list_variation_boxed_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_product_list_variation_boxed_below( $variations ) {
		$variations['boxed-below'] = esc_html__( 'Boxed Below', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_product_list_layouts', 'corsen_core_add_product_list_variation_boxed_below' );
}

if ( ! function_exists( 'corsen_core_register_shop_list_boxed_below_actions' ) ) {
	/**
	 * Function that override product item layout for current variation type
	 */
	function corsen_core_register_shop_list_boxed_below_actions() {

		// IMPORTANT - THIS CODE NEED TO COPY/PASTE ALSO INTO THEME FOLDER MAIN WOOCOMMERCE FILE - set_default_layout method

		// Add additional tags around product list item
		add_action( 'woocommerce_before_shop_loop_item', 'corsen_add_product_list_item_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_link_open hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'corsen_add_product_list_item_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Add additional tags around product list item image
		add_action( 'woocommerce_before_shop_loop_item_title', 'corsen_add_product_list_item_image_holder', 5 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
		add_action( 'woocommerce_before_shop_loop_item_title', 'corsen_add_product_list_item_image_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

		// Add additional tags around content inside product list item image
		add_action( 'woocommerce_before_shop_loop_item_title', 'corsen_add_product_list_item_additional_image_holder', 15 ); // permission 15 is set because woocommerce_template_loop_product_thumbnail hook is added on 10
		add_action( 'woocommerce_before_shop_loop_item_title', 'corsen_add_product_list_item_additional_image_holder_end', 25 ); // permission 25 is set because corsen_add_product_list_item_image_holder_end hook is added on 30

		// Add additional tags around product list item content
		add_action( 'woocommerce_shop_loop_item_title', 'corsen_add_product_list_item_content_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_title hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'corsen_add_product_list_item_content_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Add product categories on list
		add_action( 'woocommerce_shop_loop_item_title', 'corsen_add_product_list_item_categories', 16 ); // permission 8 is set to be before woocommerce_template_loop_product_title hook it's added on 10

		// Change add to cart position on product list
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // permission 10 is default
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 ); // permission 20 is set because corsen_add_product_list_item_additional_image_holder hook is added on 15
	}

	add_action( 'corsen_core_action_shop_list_item_layout_boxed-below', 'corsen_core_register_shop_list_boxed_below_actions' );
}
