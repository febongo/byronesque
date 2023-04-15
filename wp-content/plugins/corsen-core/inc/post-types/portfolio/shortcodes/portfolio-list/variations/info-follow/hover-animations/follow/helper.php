<?php

if ( ! function_exists( 'corsen_core_filter_portfolio_list_info_follow' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_filter_portfolio_list_info_follow( $variations ) {
		$variations['follow'] = esc_html__( 'Follow', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_portfolio_list_info_follow_animation_options', 'corsen_core_filter_portfolio_list_info_follow' );
}
