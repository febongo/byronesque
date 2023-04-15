<?php

if ( ! function_exists( 'corsen_core_add_social_share_variation_dropdown' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_social_share_variation_dropdown( $variations ) {
		$variations['dropdown'] = esc_html__( 'Dropdown', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_social_share_layouts', 'corsen_core_add_social_share_variation_dropdown' );
	add_filter( 'corsen_core_filter_social_share_layout_options', 'corsen_core_add_social_share_variation_dropdown' );
}
