<?php
if ( ! function_exists( 'corsen_core_add_top_area_meta_options' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function corsen_core_add_top_area_meta_options( $page ) {
		$top_area_section = $page->add_section_element(
			array(
				'name'       => 'qodef_top_area_section',
				'title'      => esc_html__( 'Top Area', 'corsen-core' ),
				'dependency' => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => corsen_core_dependency_for_top_area_options(),
							'default_value' => '',
						),
					),
				),
			)
		);

		$top_area_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header',
				'title'       => esc_html__( 'Top Area', 'corsen-core' ),
				'description' => esc_html__( 'Enable top area', 'corsen-core' ),
				'options'     => corsen_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$top_area_options_section = $top_area_section->add_section_element(
			array(
				'name'        => 'qodef_top_area_options_section',
				'title'       => esc_html__( 'Top Area Options', 'corsen-core' ),
				'description' => esc_html__( 'Set desired values for top area', 'corsen-core' ),
				'dependency'  => array(
					'show' => array(
						'qodef_top_area_header' => array(
							'values'        => 'yes',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_top_area_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'corsen-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'corsen-core' ),
				'options'       => corsen_core_get_select_type_options_pool( 'no_yes' ),
				'default_value' => '',
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_height',
				'title'       => esc_html__( 'Top Area Height', 'corsen-core' ),
				'description' => esc_html__( 'Enter top area height (default is 30px)', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'corsen-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'text',
				'name'       => 'qodef_top_area_header_side_padding',
				'title'      => esc_html__( 'Top Area Side Padding', 'corsen-core' ),
				'args'       => array(
					'suffix' => esc_html__( 'px or %', 'corsen-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_set_top_area_header_content_alignment',
				'title'       => esc_html__( 'Content Alignment', 'corsen-core' ),
				'description' => esc_html__( 'Set widgets content alignment inside top header area', 'corsen-core' ),
				'options'     => array(
					''       => esc_html__( 'Default', 'corsen-core' ),
					'center' => esc_html__( 'Center', 'corsen-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_background_color',
				'title'       => esc_html__( 'Top Area Background Color', 'corsen-core' ),
				'description' => esc_html__( 'Choose top area background color', 'corsen-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_border_color',
				'title'       => esc_html__( 'Top Area Border Color', 'corsen-core' ),
				'description' => esc_html__( 'Enter top area border color', 'corsen-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_border_width',
				'title'       => esc_html__( 'Top Area Border Width', 'corsen-core' ),
				'description' => esc_html__( 'Enter top area border width size', 'corsen-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'corsen-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header_border_style',
				'title'       => esc_html__( 'Top Area Border Style', 'corsen-core' ),
				'description' => esc_html__( 'Choose top area border style', 'corsen-core' ),
				'options'     => corsen_core_get_select_type_options_pool( 'border_style' ),
			)
		);

		$custom_sidebars = corsen_core_get_custom_sidebars();
		if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_left',
					'title'       => esc_html__( 'Choose Custom Left Widget Area for Top Area Header', 'corsen-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside left widget area', 'corsen-core' ),
					'options'     => $custom_sidebars,
				)
			);

			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_right',
					'title'       => esc_html__( 'Choose Custom Right Widget Area for Top Area Header', 'corsen-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside right widget area', 'corsen-core' ),
					'options'     => $custom_sidebars,
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_page_header_meta_map', 'corsen_core_add_top_area_meta_options', 20 );
}
