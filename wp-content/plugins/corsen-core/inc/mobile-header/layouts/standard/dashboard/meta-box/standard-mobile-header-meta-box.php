<?php

if ( ! function_exists( 'corsen_core_add_standard_mobile_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function corsen_core_add_standard_mobile_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_standard_mobile_header_section',
				'title'      => esc_html__( 'Standard Mobile Header', 'corsen-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => array( '', 'standard' ),
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_mobile_header_height',
				'title'       => esc_html__( 'Header Height', 'corsen-core' ),
				'description' => esc_html__( 'Enter header height', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'corsen-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'corsen-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'corsen-core' ),
				),
				'dependency'  => array(
					'show' => array(
						'qodef_mobile_header_in_grid' => array(
							'values'        => 'no',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header background color', 'corsen-core' ),
			)
		);
	}

	add_action( 'corsen_core_action_after_page_mobile_header_meta_map', 'corsen_core_add_standard_mobile_header_meta', 10, 2 );
}
