<?php

if ( ! function_exists( 'corsen_core_add_product_list_indent_slider_variation_boxed_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_product_list_indent_slider_variation_boxed_below( $variations ) {
		$variations['boxed-below'] = esc_html__( 'Boxed Below', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_product_list_indent_slider_layouts', 'corsen_core_add_product_list_indent_slider_variation_boxed_below' );
}
