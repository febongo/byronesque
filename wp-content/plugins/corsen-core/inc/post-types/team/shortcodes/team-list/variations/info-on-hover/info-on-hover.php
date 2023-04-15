<?php

if ( ! function_exists( 'corsen_core_add_team_list_variation_info_on_hover' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_team_list_variation_info_on_hover( $variations ) {
		$variations['info-on-hover'] = esc_html__( 'Info on Hover', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_team_list_layouts', 'corsen_core_add_team_list_variation_info_on_hover' );
}
