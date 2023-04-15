<?php

if ( ! function_exists( 'corsen_core_add_page_spinner_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_page_spinner_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_spinner',
					'title'         => esc_html__( 'Enable Page Spinner', 'corsen-core' ),
					'description'   => esc_html__( 'Enable Page Spinner Effect', 'corsen-core' ),
					'default_value' => 'no',
				)
			);

			$spinner_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_spinner_section',
					'title'      => esc_html__( 'Page Spinner Section', 'corsen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_page_spinner' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_spinner_type',
					'title'         => esc_html__( 'Select Page Spinner Type', 'corsen-core' ),
					'description'   => esc_html__( 'Choose a page spinner animation style', 'corsen-core' ),
					'options'       => apply_filters( 'corsen_core_filter_page_spinner_layout_options', array() ),
					'default_value' => apply_filters( 'corsen_core_filter_page_spinner_default_layout_option', '' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_background_color',
					'title'       => esc_html__( 'Spinner Background Color', 'corsen-core' ),
					'description' => esc_html__( 'Choose the spinner background color', 'corsen-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_color',
					'title'       => esc_html__( 'Spinner Color', 'corsen-core' ),
					'description' => esc_html__( 'Choose the spinner color', 'corsen-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_page_spinner_text',
					'title'         => esc_html__( 'Spinner Text', 'corsen-core' ),
					'description'   => esc_html__( 'Enter the spinner text', 'corsen-core' ),
					'default_value' => 'corsen',
					'dependency'    => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => 'textual',
								'default_value' => '',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type' => 'textarea',
					'name'       => 'qodef_spinner_svg',
					'title'      => esc_html__( 'Upload Spinner Svg', 'corsen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => array(
									'predefined',
								),
								'default_value' => '',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_spinner_background_image',
					'title'      => esc_html__( 'Upload Spinner Background Image', 'corsen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => array(
									'predefined',
								),
								'default_value' => '',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_page_spinner_fade_out_animation',
					'title'         => esc_html__( 'Enable Fade Out Animation', 'corsen-core' ),
					'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'corsen-core' ),
					'default_value' => 'no',
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_general_options_map', 'corsen_core_add_page_spinner_options' );
}
