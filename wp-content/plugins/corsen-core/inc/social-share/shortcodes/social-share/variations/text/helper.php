<?php

if ( ! function_exists( 'corsen_core_add_social_share_variation_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_social_share_variation_text( $variations ) {
		$variations['text'] = esc_html__( 'Text', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_social_share_layouts', 'corsen_core_add_social_share_variation_text' );
	add_filter( 'corsen_core_filter_social_share_layout_options', 'corsen_core_add_social_share_variation_text' );
}
