<?php

if ( ! function_exists( 'corsen_core_add_sticky_header_options' ) ) {
	/**
	 * Function that add additional header layout global options
	 *
	 * @param object $page
	 * @param object $section
	 */
	function corsen_core_add_sticky_header_options( $page, $section ) {

		$sticky_section = $section->add_section_element(
			array(
				'name'       => 'qodef_sticky_header_section',
				'dependency' => array(
					'show' => array(
						'qodef_header_scroll_appearance' => array(
							'values'        => 'sticky',
							'default_value' => '',
						),
					),
				),
			)
		);

		$sticky_section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_sticky_header_appearance',
				'title'         => esc_html__( 'Sticky Header Appearance', 'corsen-core' ),
				'description'   => esc_html__( 'Select the appearance of sticky header when you scrolling the page', 'corsen-core' ),
				'options'       => array(
					'down' => esc_html__( 'Show Sticky on Scroll Down/Up', 'corsen-core' ),
					'up'   => esc_html__( 'Show Sticky on Scroll Up', 'corsen-core' ),
				),
				'default_value' => 'down',
			)
		);

		$sticky_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_sticky_header_skin',
				'title'       => esc_html__( 'Sticky Header Skin', 'corsen-core' ),
				'description' => esc_html__( 'Choose a predefined sticky header style for header elements', 'corsen-core' ),
				'options'     => corsen_core_get_select_type_options_pool( 'header_skin', false ),
			)
		);

		$sticky_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_sticky_header_scroll_amount',
				'title'       => esc_html__( 'Sticky Scroll Amount', 'corsen-core' ),
				'description' => esc_html__( 'Enter scroll amount for sticky header to appear', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'corsen-core' ),
				),
			)
		);

		$sticky_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_sticky_header_side_padding',
				'title'       => esc_html__( 'Sticky Header Side Padding', 'corsen-core' ),
				'description' => esc_html__( 'Enter side padding for sticky header area', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'corsen-core' ),
				),
			)
		);

        $sticky_section->add_field_element(
            array(
                'field_type'  => 'text',
                'name'        => 'qodef_sticky_header_side_margin',
                'title'       => esc_html__( 'Sticky Header Side Margin', 'corsen-core' ),
                'description' => esc_html__( 'Enter side margin for sticky header area', 'corsen-core' ),
                'args'        => array(
                    'suffix' => esc_html__( 'px or %', 'corsen-core' ),
                ),
            )
        );

		$sticky_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_sticky_header_background_color',
				'title'       => esc_html__( 'Sticky Header Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter sticky header background color', 'corsen-core' ),
			)
		);
	}

	add_action( 'corsen_core_action_after_header_scroll_appearance_options_map', 'corsen_core_add_sticky_header_options', 10, 2 );
}

if ( ! function_exists( 'corsen_core_add_sticky_header_logo_options' ) ) {
	/**
	 * Function that add additional header logo options
	 *
	 * @param object $page
	 * @param array  $header_tab
	 * @param array  $logo_image_section
	 */
	function corsen_core_add_sticky_header_logo_options( $page, $header_tab, $logo_image_section ) {

		if ( $header_tab ) {
			$logo_image_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_logo_sticky',
					'title'       => esc_html__( 'Logo - Sticky', 'corsen-core' ),
					'description' => esc_html__( 'Choose sticky logo image', 'corsen-core' ),
					'multiple'    => 'no',
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_header_logo_image_section_options_map', 'corsen_core_add_sticky_header_logo_options', 10, 3 );
}

if ( ! function_exists( 'corsen_core_add_sticky_header_logo_svg_options' ) ) {
	/**
	 * Function that add additional header logo options
	 *
	 * @param object $page
	 * @param array  $header_tab
	 * @param array  $logo_svg_path_section
	 */
	function corsen_core_add_sticky_header_logo_svg_options( $page, $header_tab, $logo_svg_path_section ) {

		if ( $header_tab ) {
			$logo_svg_path_section->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_logo_sticky_svg_path',
					'title'       => esc_html__( 'Logo Sticky - SVG Path', 'corsen-core' ),
					'description' => esc_html__( 'Enter your logo icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'corsen-core' ),
				)
			);
		}
	}

	add_action( 'corsen_core_action_before_header_logo_svg_path_section_options_map', 'corsen_core_add_sticky_header_logo_svg_options', 10, 3 );
}
