<?php

if ( ! function_exists( 'corsen_core_add_mobile_header_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_mobile_header_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => CORSEN_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'layout'      => 'tabbed',
				'slug'        => 'mobile-header',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Mobile Header', 'corsen-core' ),
				'description' => esc_html__( 'Global Mobile Header Options', 'corsen-core' ),
			)
		);

		if ( $page ) {
			$general_tab = $page->add_tab_element(
				array(
					'name'  => 'tab-mobile-header-general',
					'icon'  => 'fa fa-cog',
					'title' => esc_html__( 'General Settings', 'corsen-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'default_value' => 'no',
					'name'          => 'qodef_mobile_header_scroll_appearance',
					'title'         => esc_html__( 'Sticky Mobile Header', 'corsen-core' ),
					'description'   => esc_html__( 'Set mobile header to be sticky', 'corsen-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'radio',
					'name'          => 'qodef_mobile_header_layout',
					'title'         => esc_html__( 'Mobile Header Layout', 'corsen-core' ),
					'description'   => esc_html__( 'Choose a mobile header layout to set for your website', 'corsen-core' ),
					'args'          => array( 'images' => true ),
					'default_value' => apply_filters( 'corsen_core_filter_mobile_header_layout_default_option', '' ),
					'options'       => apply_filters( 'corsen_core_filter_mobile_header_layout_option', array() ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_mobile_header_in_grid',
					'title'         => esc_html__( 'Content in Grid', 'corsen-core' ),
					'description'   => esc_html__( 'Set content to be in grid', 'corsen-core' ),
					'default_value' => 'no',
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_mobile_menu_icon_source',
					'title'         => esc_html__( 'Icon Source', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'icon_source', false ),
					'default_value' => 'predefined',
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_mobile_menu_icon_pack',
					'title'         => esc_html__( 'Icon Pack', 'corsen-core' ),
					'options'       => qode_framework_icons()->get_icon_packs( array( 'linea-icons', 'dripicons', 'simple-line-icons' ) ),
					'default_value' => 'elegant-icons',
					'dependency'    => array(
						'show' => array(
							'qodef_mobile_menu_icon_source' => array(
								'values'        => 'icon_pack',
								'default_value' => 'predefined',
							),
						),
					),
				)
			);

			$section_svg_path = $general_tab->add_section_element(
				array(
					'title'      => esc_html__( 'SVG Path', 'corsen-core' ),
					'name'       => 'qodef_mobile_menu_svg_path_section',
					'dependency' => array(
						'show' => array(
							'qodef_mobile_menu_icon_source' => array(
								'values'        => 'svg_path',
								'default_value' => 'predefined',
							),
						),
					),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_mobile_menu_icon_svg_path',
					'title'       => esc_html__( 'Mobile Menu Open Icon SVG Path', 'corsen-core' ),
					'description' => esc_html__( 'Enter your mobile menu open icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'corsen-core' ),
				)
			);

			$section_svg_path->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_mobile_menu_close_icon_svg_path',
					'title'       => esc_html__( 'Mobile Menu Close Icon SVG Path', 'corsen-core' ),
					'description' => esc_html__( 'Enter your mobile menu close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'corsen-core' ),
				)
			);

			$opener_section = $general_tab->add_section_element(
				array(
					'name'  => 'qodef_mobile_header_opener_section',
					'title' => esc_html__( 'Mobile Header Opener Styles', 'corsen-core' ),
				)
			);

			$opener_section_row = $opener_section->add_row_element(
				array(
					'name' => 'qodef_mobile_header_opener_row',
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_header_opener_color',
					'title'      => esc_html__( 'Color', 'corsen-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'color',
					'name'       => 'qodef_mobile_header_opener_hover_color',
					'title'      => esc_html__( 'Hover/Active Color', 'corsen-core' ),
					'args'       => array(
						'col_width' => 3,
					),
				)
			);

			$opener_section_row->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_mobile_header_opener_size',
					'title'      => esc_html__( 'Icon Size', 'corsen-core' ),
					'args'       => array(
						'col_width' => 3,
						'suffix'    => 'px',
					),
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_mobile_header_options_map', $page, $general_tab );
		}
	}

	add_action( 'corsen_core_action_default_options_init', 'corsen_core_add_mobile_header_options', corsen_core_get_admin_options_map_position( 'mobile-header' ) );
}
