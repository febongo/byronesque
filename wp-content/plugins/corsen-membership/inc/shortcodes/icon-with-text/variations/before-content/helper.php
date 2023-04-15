<?php

if ( ! function_exists( 'corsen_core_add_icon_with_text_variation_before_content' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_icon_with_text_variation_before_content( $variations ) {
		$variations['before-content'] = esc_html__( 'Before Content', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_icon_with_text_layouts', 'corsen_core_add_icon_with_text_variation_before_content' );
}
