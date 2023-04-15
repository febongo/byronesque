<?php

if ( ! function_exists( 'corsen_core_add_page_sidebar_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function corsen_core_add_page_sidebar_meta_box( $page ) {

		if ( $page ) {

			$sidebar_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-sidebar',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Sidebar Settings', 'corsen-core' ),
					'description' => esc_html__( 'Sidebar layout settings', 'corsen-core' ),
				)
			);

			$sidebar_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_layout',
					'title'       => esc_html__( 'Sidebar Layout', 'corsen-core' ),
					'description' => esc_html__( 'Choose a sidebar layout', 'corsen-core' ),
					'options'     => corsen_core_get_select_type_options_pool( 'sidebar_layouts' ),
				)
			);

			$custom_sidebars = corsen_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$sidebar_tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_page_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'corsen-core' ),
						'description' => esc_html__( 'Choose a custom sidebar', 'corsen-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$sidebar_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'corsen-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'corsen-core' ),
					'options'     => corsen_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_page_sidebar_meta_box_map', $sidebar_tab );
		}
	}

	add_action( 'corsen_core_action_after_general_meta_box_map', 'corsen_core_add_page_sidebar_meta_box' );
}

if ( ! function_exists( 'corsen_core_add_general_page_sidebar_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function corsen_core_add_general_page_sidebar_meta_box_callback( $callbacks ) {
		$callbacks['page-sidebar'] = 'corsen_core_add_page_sidebar_meta_box';

		return $callbacks;
	}

	add_filter( 'corsen_core_filter_general_meta_box_callbacks', 'corsen_core_add_general_page_sidebar_meta_box_callback' );
}
