<?php

if ( ! function_exists( 'corsen_core_filter_portfolio_list_info_below_overlay' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_filter_portfolio_list_info_below_overlay( $variations ) {
		$variations['overlay'] = esc_html__( 'Overlay', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_portfolio_list_info_below_animation_options', 'corsen_core_filter_portfolio_list_info_below_overlay' );
}
