<?php

if ( ! function_exists( 'corsen_core_add_fixed_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function corsen_core_add_fixed_header_option( $options ) {
		$options['fixed'] = esc_html__( 'Fixed', 'corsen-core' );

		return $options;
	}

	add_filter( 'corsen_core_filter_header_scroll_appearance_option', 'corsen_core_add_fixed_header_option' );
}
