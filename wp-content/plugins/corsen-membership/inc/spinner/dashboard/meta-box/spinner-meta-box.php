<?php

if ( ! function_exists( 'corsen_core_add_page_spinner_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_page_spinner_meta_box( $general_tab ) {

		if ( $general_tab ) {
			$general_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_enable_page_spinner',
					'title'       => esc_html__( 'Enable Page Spinner', 'corsen-core' ),
					'description' => esc_html__( 'Enable Page Spinner Effect', 'corsen-core' ),
					'options'     => corsen_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_general_page_meta_box_map', 'corsen_core_add_page_spinner_meta_box', 9 );
}
