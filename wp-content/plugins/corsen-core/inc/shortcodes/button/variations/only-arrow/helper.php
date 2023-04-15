<?php

if ( ! function_exists( 'corsen_core_add_button_variation_only_arrow' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_button_variation_only_arrow( $variations ) {
		$variations['only-arrow'] = esc_html__( 'Only Arrow', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_button_layouts', 'corsen_core_add_button_variation_only_arrow' );
}
