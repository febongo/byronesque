<?php

if ( ! function_exists( 'corsen_core_add_interactive_link_showcase_variation_interactive_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_interactive_link_showcase_variation_interactive_list( $variations ) {
		$variations['interactive-list'] = esc_html__( 'Interactive List', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_interactive_link_showcase_layouts', 'corsen_core_add_interactive_link_showcase_variation_interactive_list' );
}
