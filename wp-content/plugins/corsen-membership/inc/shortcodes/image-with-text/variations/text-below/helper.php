<?php

if ( ! function_exists( 'corsen_core_add_image_with_text_variation_text_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_image_with_text_variation_text_below( $variations ) {
		$variations['text-below'] = esc_html__( 'Text Below', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_image_with_text_layouts', 'corsen_core_add_image_with_text_variation_text_below' );
}
