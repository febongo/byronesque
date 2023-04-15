<?php

if ( ! function_exists( 'corsen_core_nav_menu_meta_options' ) ) {
	/**
	 * Function that add general options for this module
	 *
	 * @param object $page
	 */
	function corsen_core_nav_menu_meta_options( $page ) {

		if ( $page ) {

			$section = $page->add_section_element(
				array(
					'name'  => 'qodef_nav_menu_section',
					'title' => esc_html__( 'Main Menu', 'corsen-core' ),
				)
			);

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_dropdown_top_position',
					'title'       => esc_html__( 'Dropdown Position', 'corsen-core' ),
					'description' => esc_html__( 'Enter value in percentage of entire header height', 'corsen-core' ),
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_page_header_meta_map', 'corsen_core_nav_menu_meta_options' );
}
