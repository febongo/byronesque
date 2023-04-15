<?php

if ( ! function_exists( 'corsen_core_add_page_sidebar_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_page_sidebar_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => CORSEN_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'sidebar',
				'icon'        => 'fa fa-book',
				'title'       => esc_html__( 'Sidebar', 'corsen-core' ),
				'description' => esc_html__( 'Global Sidebar Options', 'corsen-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'corsen-core' ),
					'description'   => esc_html__( 'Choose a default sidebar layout for pages', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'sidebar_layouts', false ),
					'default_value' => 'no-sidebar',
				)
			);

			$custom_sidebars = corsen_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$page->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_page_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'corsen-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on pages', 'corsen-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'corsen-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'corsen-core' ),
					'options'     => corsen_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_sidebar_widgets_margin_bottom',
					'title'       => esc_html__( 'Widgets Margin Bottom', 'corsen-core' ),
					'description' => esc_html__( 'Set space value between widgets', 'corsen-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_page_sidebar_options_map', $page );
		}
	}

	add_action( 'corsen_core_action_default_options_init', 'corsen_core_add_page_sidebar_options', corsen_core_get_admin_options_map_position( 'sidebar' ) );
}
