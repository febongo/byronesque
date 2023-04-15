<?php

if ( ! function_exists( 'corsen_core_add_centered_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function corsen_core_add_centered_header_global_option( $header_layout_options ) {
		$header_layout_options['centered'] = array(
			'image' => CORSEN_CORE_HEADER_LAYOUTS_URL_PATH . '/centered/assets/img/centered-header.png',
			'label' => esc_html__( 'Centered', 'corsen-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'corsen_core_filter_header_layout_option', 'corsen_core_add_centered_header_global_option' );
}

if ( ! function_exists( 'corsen_core_register_centered_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function corsen_core_register_centered_header_layout( $header_layouts ) {
		$header_layouts['centered'] = 'CorsenCore_Centered_Header';

		return $header_layouts;
	}

	add_filter( 'corsen_core_filter_register_header_layouts', 'corsen_core_register_centered_header_layout' );
}
