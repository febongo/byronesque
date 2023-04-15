<?php

if ( ! function_exists( 'corsen_core_add_divided_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function corsen_core_add_divided_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_divided_header_section',
				'title'      => esc_html__( 'Divided Header', 'corsen-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'divided',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_divided_header_height',
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
				'name'        => 'qodef_divided_header_side_padding',
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
                'name'        => 'qodef_divided_header_side_margin',
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
				'name'        => 'qodef_divided_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header background color', 'corsen-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_divided_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter header border color', 'corsen-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_divided_header_border_width',
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
				'name'        => 'qodef_divided_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'corsen-core' ),
				'description' => esc_html__( 'Choose header border style', 'corsen-core' ),
				'options'     => corsen_core_get_select_type_options_pool( 'border_style' ),
			)
		);
	}

	add_action( 'corsen_core_action_after_page_header_meta_map', 'corsen_core_add_divided_header_meta' );
}
