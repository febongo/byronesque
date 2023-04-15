<?php

if ( ! function_exists( 'corsen_core_add_interactive_link_showcase_variation_slider' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_interactive_link_showcase_variation_slider( $variations ) {
		$variations['slider'] = esc_html__( 'Slider', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_interactive_link_showcase_layouts', 'corsen_core_add_interactive_link_showcase_variation_slider' );
}
