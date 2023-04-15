<?php

if ( ! function_exists( 'corsen_core_add_pricing_table_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_pricing_table_variation_standard( $variations ) {

		$variations['standard'] = esc_html__( 'Standard', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_pricing_table_layouts', 'corsen_core_add_pricing_table_variation_standard' );
}
