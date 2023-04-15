<?php

if ( ! function_exists( 'corsen_core_add_clients_meta_box' ) ) {
	/**
	 * Function that adds fields for clients
	 */
	function corsen_core_add_clients_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'clients' ),
				'type'  => 'meta',
				'slug'  => 'clients',
				'title' => esc_html__( 'Clients Parameters', 'corsen-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_logo_image',
					'title'      => esc_html__( 'Client Logo Image', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_logo_hover_image',
					'title'      => esc_html__( 'Client Logo Hover Image', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_client_link',
					'title'      => esc_html__( 'Client Link', 'corsen-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_client_link_target',
					'title'      => esc_html__( 'Client Link Target', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'link_target' ),
				)
			);

            $page->add_field_element(
                array(
                    'field_type'  => 'image',
                    'name'        => 'qodef_client_video_image',
                    'title'       => esc_html__( 'Client Video Image', 'corsen-core' ),
                    'description' => esc_html__( 'Used for Client List Element with Video Info Slider List Appearance.', 'corsen-core' ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_client_video_link',
                    'title'      => esc_html__( 'Client Video Link', 'corsen-core' ),
                    'description' => esc_html__( 'Used for Client List Element with Video Info Slider List Appearance.', 'corsen-core' ),
                )
            );

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_clients_meta_box_map', $page );
		}
	}

	add_action( 'corsen_core_action_default_meta_boxes_init', 'corsen_core_add_clients_meta_box' );
}
