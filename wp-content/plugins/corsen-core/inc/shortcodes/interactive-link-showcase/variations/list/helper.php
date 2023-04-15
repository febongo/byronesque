<?php

if ( ! function_exists( 'corsen_core_add_interactive_link_showcase_variation_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_interactive_link_showcase_variation_list( $variations ) {
		$variations['list'] = esc_html__( 'List', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_interactive_link_showcase_layouts', 'corsen_core_add_interactive_link_showcase_variation_list' );
}
