<?php

if ( ! function_exists( 'corsen_core_add_text_marquee_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_text_marquee_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_text_marquee_layouts', 'corsen_core_add_text_marquee_variation_default' );
}
