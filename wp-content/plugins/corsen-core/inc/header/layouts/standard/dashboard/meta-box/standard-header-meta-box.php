<?php

if ( ! function_exists( 'corsen_core_add_standard_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function corsen_core_add_standard_header_meta( $page ) {
		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_standard_header_section',
				'title'      => esc_html__( 'Standard Header', 'corsen-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => array( '', 'standard' ),
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'corsen-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'corsen-core' ),
				'default_value' => '',
				'options'       => corsen_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_height',
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
				'name'        => 'qodef_standard_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'corsen-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'corsen-core' ),
				),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'text',
                'name'        => 'qodef_standard_header_side_margin',
                'title'       => esc_html__( 'Header Side Margin', 'corsen-core' ),
                'description' => esc_html__( 'Enter side margin for header area', 'corsen-core' ),
                'args'        => array(
                    'suffix' => esc_html__( 'px or %', 'corsen-core' ),
                ),
            )
        );

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header background color', 'corsen-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header border color', 'corsen-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'corsen-core' ),
				'description' => esc_html__( 'Enter header border width size', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'corsen-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_standard_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'corsen-core' ),
				'description' => esc_html__( 'Choose header border style', 'corsen-core' ),
				'options'     => corsen_core_get_select_type_options_pool( 'border_style' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_menu_position',
				'title'         => esc_html__( 'Menu position', 'corsen-core' ),
				'default_value' => '',
				'options'       => array(
					''       => esc_html__( 'Default', 'corsen-core' ),
					'left'   => esc_html__( 'Left', 'corsen-core' ),
					'center' => esc_html__( 'Center', 'corsen-core' ),
					'right'  => esc_html__( 'Right', 'corsen-core' ),
				),
			)
		);
	}

	add_action( 'corsen_core_action_after_page_header_meta_map', 'corsen_core_add_standard_header_meta' );
}
