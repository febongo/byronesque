<?php

if ( ! function_exists( 'corsen_core_add_social_share_variation_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_social_share_variation_list( $variations ) {
		$variations['list'] = esc_html__( 'List', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_social_share_layouts', 'corsen_core_add_social_share_variation_list' );
	add_filter( 'corsen_core_filter_social_share_layout_options', 'corsen_core_add_social_share_variation_list' );
}

if ( ! function_exists( 'corsen_core_set_default_social_share_variation_list' ) ) {
	/**
	 * Function that set default variation layout for this module
	 *
	 * @return string
	 */
	function corsen_core_set_default_social_share_variation_list() {
		return 'text';
	}

	add_filter( 'corsen_core_filter_social_share_layout_default_value', 'corsen_core_set_default_social_share_variation_list' );
}
