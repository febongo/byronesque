<?php

if ( ! function_exists( 'corsen_core_fullscreen_menu_options' ) ) {
	/**
	 * Function that add global options for current module
	 */
	function corsen_core_fullscreen_menu_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => CORSEN_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fullscreen-menu',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Fullscreen Menu', 'corsen-core' ),
				'description' => esc_html__( 'Global Fullscreen Menu Options', 'corsen-core' ),
			)
		);

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_fullscreen_menu_hide_logo',
					'title'         => esc_html__( 'Fullscreen Menu Hide Logo', 'corsen-core' ),
					'default_value' => 'no',
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_fullscreen_menu_background_color',
					'title'      => esc_html__( 'Background Color', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_fullscreen_menu_background_image',
					'title'      => esc_html__( 'Side Image', 'corsen-core' ),
				)
			);

            $page->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_fullscreen_menu_side_title',
                    'title'      => esc_html__( 'Side Title', 'corsen-core' ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_fullscreen_menu_side_button_text',
                    'title'      => esc_html__( 'Side Button Text', 'corsen-core' ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_fullscreen_menu_side_button_link',
                    'title'      => esc_html__( 'Side Button Link', 'corsen-core' ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type'    => 'select',
                    'name'          => 'qodef_fullscreen_icon_label',
                    'title'         => esc_html__( 'Icon Label', 'corsen-core' ),
                    'default_value' => 'no',
                    'options'       => corsen_core_get_select_type_options_pool( 'no_yes', false ),
                )
            );

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_fullscreen_menu_icon_source',
					'title'         => esc_html__( 'Icon Source', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'icon_source', false ),
					'default_value' => 'predefined',
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_fullscreen_menu_icon_pack',
					'title'         => esc_html__( 'Icon Pack', 'corsen-core' ),
					'options'       => qode_framework_icons()->get_icon_packs( array( 'linea-icons', 'dripicons', 'simple-line-icons' ) ),
					'default_value' => 'elegant-icons',
					'dependency'    => array(
						'show' => array(
							'qodef_fullscreen_menu_icon_source' => array(
								'values'        => 'icon_pack',
								'default_value' => 'icon_pack',
							),
						),
					),
				)
			);

			$section_svg_path = $page->add_section_element(
				array(
					'title'      => esc_html__( 'SVG Path', 'corsen-core' ),
					'name'       => 'qodef_fullscreen_menu_svg_path_section',
					'dependency' => array(
						'show' => array(
							'qodef_fullscreen_menu_icon_source' => array(
								'values'        => 'svg_path',
								'default_value' => 'icon_pack',
							),
						),
					),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_fullscreen_menu_icon_svg_path',
					'title'       => esc_html__( 'Fullscreen Menu Open Icon SVG Path', 'corsen-core' ),
					'description' => esc_html__( 'Enter your full screen menu open icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'corsen-core' ),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_fullscreen_menu_close_icon_svg_path',
					'title'       => esc_html__( 'Fullscreen Menu Close Icon SVG Path', 'corsen-core' ),
					'description' => esc_html__( 'Enter your full screen menu close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'corsen-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_fullscreen_menu_options_map', $page );
		}
	}

	add_action( 'corsen_core_action_default_options_init', 'corsen_core_fullscreen_menu_options', corsen_core_get_admin_options_map_position( 'fullscreen-menu' ) );
}
