<?php

if ( ! function_exists( 'corsen_core_add_blog_list_variation_metro' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_blog_list_variation_metro( $variations ) {
		$variations['metro'] = esc_html__( 'Metro', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_blog_list_layouts', 'corsen_core_add_blog_list_variation_metro' );
}
