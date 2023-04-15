<?php
if ( ! function_exists( 'corsen_core_add_divided_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */

	function corsen_core_add_divided_header_global_option( $header_layout_options ) {
		$header_layout_options['divided'] = array(
			'image' => CORSEN_CORE_HEADER_LAYOUTS_URL_PATH . '/divided/assets/img/divided-header.png',
			'label' => esc_html__( 'Divided', 'corsen-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'corsen_core_filter_header_layout_option', 'corsen_core_add_divided_header_global_option' );
}


if ( ! function_exists( 'corsen_core_register_divided_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function corsen_core_register_divided_header_layout( $header_layouts ) {
		$header_layout = array(
			'divided' => 'CorsenCore_Divided_Header',
		);

		$header_layouts = array_merge( $header_layouts, $header_layout );

		return $header_layouts;
	}

	add_filter( 'corsen_core_filter_register_header_layouts', 'corsen_core_register_divided_header_layout' );
}

if ( ! function_exists( 'corsen_core_register_divided_menu' ) ) {
	/**
	 * Function which add additional main menu navigation into global list
	 *
	 * @param array $menus
	 *
	 * @return array
	 */
	function corsen_core_register_divided_menu( $menus ) {
		$menus['divided-menu-left-navigation']  = esc_html__( 'Divided Left Navigation', 'corsen-core' );
		$menus['divided-menu-right-navigation'] = esc_html__( 'Divided Right Navigation', 'corsen-core' );

		return $menus;
	}

	add_filter( 'corsen_filter_register_navigation_menus', 'corsen_core_register_divided_menu' );
}
