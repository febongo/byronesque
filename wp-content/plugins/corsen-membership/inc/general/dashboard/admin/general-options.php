<?php

if ( ! function_exists( 'corsen_core_add_general_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_general_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_main_color',
					'title'       => esc_html__( 'Main Color', 'corsen-core' ),
					'description' => esc_html__( 'Choose the most dominant theme color', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_background_color',
					'title'       => esc_html__( 'Page Background Color', 'corsen-core' ),
					'description' => esc_html__( 'Set background color', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_background_image',
					'title'       => esc_html__( 'Page Background Image', 'corsen-core' ),
					'description' => esc_html__( 'Set background image', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_repeat',
					'title'       => esc_html__( 'Page Background Image Repeat', 'corsen-core' ),
					'description' => esc_html__( 'Set background image repeat', 'corsen-core' ),
					'options'     => array(
						''          => esc_html__( 'Default', 'corsen-core' ),
						'no-repeat' => esc_html__( 'No Repeat', 'corsen-core' ),
						'repeat'    => esc_html__( 'Repeat', 'corsen-core' ),
						'repeat-x'  => esc_html__( 'Repeat-x', 'corsen-core' ),
						'repeat-y'  => esc_html__( 'Repeat-y', 'corsen-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_size',
					'title'       => esc_html__( 'Page Background Image Size', 'corsen-core' ),
					'description' => esc_html__( 'Set background image size', 'corsen-core' ),
					'options'     => array(
						''        => esc_html__( 'Default', 'corsen-core' ),
						'contain' => esc_html__( 'Contain', 'corsen-core' ),
						'cover'   => esc_html__( 'Cover', 'corsen-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_attachment',
					'title'       => esc_html__( 'Page Background Image Attachment', 'corsen-core' ),
					'description' => esc_html__( 'Set background image attachment', 'corsen-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'corsen-core' ),
						'fixed'  => esc_html__( 'Fixed', 'corsen-core' ),
						'scroll' => esc_html__( 'Scroll', 'corsen-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding',
					'title'       => esc_html__( 'Page Content Padding', 'corsen-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding_mobile',
					'title'       => esc_html__( 'Page Content Padding Mobile', 'corsen-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_boxed',
					'title'         => esc_html__( 'Boxed Layout', 'corsen-core' ),
					'description'   => esc_html__( 'Set boxed layout', 'corsen-core' ),
					'default_value' => 'no',
				)
			);

			$boxed_section = $page->add_section_element(
				array(
					'name'       => 'qodef_boxed_section',
					'title'      => esc_html__( 'Boxed Layout Section', 'corsen-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_boxed' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_boxed_background_color',
					'title'       => esc_html__( 'Boxed Background Color', 'corsen-core' ),
					'description' => esc_html__( 'Set boxed background color', 'corsen-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_boxed_background_pattern',
					'title'       => esc_html__( 'Boxed Background Pattern', 'corsen-core' ),
					'description' => esc_html__( 'Set boxed background pattern', 'corsen-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_boxed_background_pattern_behavior',
					'title'       => esc_html__( 'Boxed Background Pattern Behavior', 'corsen-core' ),
					'description' => esc_html__( 'Set boxed background pattern behavior', 'corsen-core' ),
					'options'     => array(
						'fixed'  => esc_html__( 'Fixed', 'corsen-core' ),
						'scroll' => esc_html__( 'Scroll', 'corsen-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_passepartout',
					'title'         => esc_html__( 'Passepartout', 'corsen-core' ),
					'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'corsen-core' ),
					'default_value' => 'no',
				)
			);

			$passepartout_section = $page->add_section_element(
				array(
					'name'       => 'qodef_passepartout_section',
					'title'      => esc_html__( 'Passepartout Section', 'corsen-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_passepartout' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_passepartout_color',
					'title'       => esc_html__( 'Passepartout Color', 'corsen-core' ),
					'description' => esc_html__( 'Choose background color for passepartout', 'corsen-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_passepartout_image',
					'title'       => esc_html__( 'Passepartout Background Image', 'corsen-core' ),
					'description' => esc_html__( 'Set background image for passepartout', 'corsen-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size',
					'title'       => esc_html__( 'Passepartout Size', 'corsen-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout', 'corsen-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'corsen-core' ),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size_responsive',
					'title'       => esc_html__( 'Passepartout Responsive Size', 'corsen-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (1024px and below)', 'corsen-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'corsen-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_content_width',
					'title'         => esc_html__( 'Initial Width of Content', 'corsen-core' ),
					'description'   => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'content_width', false ),
					'default_value' => '1100',
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_general_options_map', $page );

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_custom_js',
					'title'       => esc_html__( 'Custom JS', 'corsen-core' ),
					'description' => esc_html__( 'Enter your custom JavaScript here', 'corsen-core' ),
				)
			);
		}
	}

	add_action( 'corsen_core_action_default_options_init', 'corsen_core_add_general_options', corsen_core_get_admin_options_map_position( 'general' ) );
}
