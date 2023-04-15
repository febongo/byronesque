<?php

if ( ! function_exists( 'corsen_core_add_vertical_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function corsen_core_add_vertical_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_vertical_header_section',
				'title'      => esc_html__( 'Vertical Header', 'corsen-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'vertical',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_vertical_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header background color', 'corsen-core' ),
			)
		);
	}

	add_action( 'corsen_core_action_after_page_header_meta_map', 'corsen_core_add_vertical_header_meta' );
}
