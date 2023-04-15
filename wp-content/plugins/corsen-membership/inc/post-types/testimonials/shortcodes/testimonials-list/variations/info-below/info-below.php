<?php

if ( ! function_exists( 'corsen_core_add_testimonials_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_testimonials_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_testimonials_list_layouts', 'corsen_core_add_testimonials_list_variation_info_below' );
}
