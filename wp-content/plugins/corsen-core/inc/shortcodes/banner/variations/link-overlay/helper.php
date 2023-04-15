<?php

if ( ! function_exists( 'corsen_core_add_banner_variation_link_overlay' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_banner_variation_link_overlay( $variations ) {
		$variations['link-overlay'] = esc_html__( 'Link Overlay', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_banner_layouts', 'corsen_core_add_banner_variation_link_overlay' );
}
