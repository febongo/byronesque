<?php

if ( ! function_exists( 'corsen_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_icon_with_text_layouts', 'corsen_core_add_icon_with_text_variation_before_title' );
}
