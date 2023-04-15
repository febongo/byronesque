<?php

if ( ! function_exists( 'corsen_core_add_counter_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_counter_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_counter_layouts', 'corsen_core_add_counter_variation_simple' );
}
