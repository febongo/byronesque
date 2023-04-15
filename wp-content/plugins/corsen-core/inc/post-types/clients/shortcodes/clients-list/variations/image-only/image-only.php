<?php

if ( ! function_exists( 'corsen_core_add_clients_list_variation_image_only' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_clients_list_variation_image_only( $variations ) {
		$variations['image-only'] = esc_html__( 'Image Only', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_clients_list_layouts', 'corsen_core_add_clients_list_variation_image_only' );
}
