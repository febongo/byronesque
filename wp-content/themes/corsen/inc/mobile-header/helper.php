<?php

if ( ! function_exists( 'corsen_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function corsen_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'corsen_filter_mobile_header_template', corsen_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'corsen_action_page_header_template', 'corsen_load_page_mobile_header' );
}

if ( ! function_exists( 'corsen_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function corsen_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'corsen_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'corsen' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'corsen_action_after_include_modules', 'corsen_register_mobile_navigation_menus' );
}
