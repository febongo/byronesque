<?php

if ( ! function_exists( 'corsen_core_add_blog_list_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_blog_list_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_blog_list_layouts', 'corsen_core_add_blog_list_variation_simple' );
	add_filter( 'corsen_core_filter_simple_blog_list_widget_layouts', 'corsen_core_add_blog_list_variation_simple' );
}
