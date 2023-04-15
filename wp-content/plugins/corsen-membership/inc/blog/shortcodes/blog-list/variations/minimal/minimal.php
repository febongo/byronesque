<?php

if ( ! function_exists( 'corsen_core_add_blog_list_variation_minimal' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_blog_list_variation_minimal( $variations ) {
		$variations['minimal'] = esc_html__( 'Minimal', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_blog_list_layouts', 'corsen_core_add_blog_list_variation_minimal' );
	add_filter( 'corsen_core_filter_simple_blog_list_widget_layouts', 'corsen_core_add_blog_list_variation_minimal' );
}
