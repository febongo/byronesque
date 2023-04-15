<?php

if ( ! function_exists( 'corsen_core_add_portfolio_single_variation_slider_small' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_portfolio_single_variation_slider_small( $variations ) {
		$variations['slider-small'] = esc_html__( 'Slider - Small', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_portfolio_single_layout_options', 'corsen_core_add_portfolio_single_variation_slider_small' );
}
