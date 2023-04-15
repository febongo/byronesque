<?php

if ( ! function_exists( 'corsen_core_filter_clients_list_image_only_fade' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_filter_clients_list_image_only_fade( $variations ) {
		$variations['fade'] = esc_html__( 'Fade', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_clients_list_image_only_animation_options', 'corsen_core_filter_clients_list_image_only_fade' );
}
