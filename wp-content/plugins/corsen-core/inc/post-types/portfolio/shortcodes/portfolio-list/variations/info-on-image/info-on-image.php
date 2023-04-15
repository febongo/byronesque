<?php

if ( ! function_exists( 'corsen_core_add_portfolio_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_portfolio_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_portfolio_list_layouts', 'corsen_core_add_portfolio_list_variation_info_on_image' );
}
