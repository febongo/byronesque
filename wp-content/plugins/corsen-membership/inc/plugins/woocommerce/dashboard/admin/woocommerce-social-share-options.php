<?php

if ( ! function_exists( 'corsen_core_add_woo_social_share_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_woo_social_share_options( $cpt_tab ) {

		if ( $cpt_tab ) {
			$cpt_tab->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_woo_enable_social_share',
					'title'         => esc_html__( 'Enable Social Share For WooCommerce Pages', 'corsen-core' ),
					'description'   => esc_html__( 'Enable this option to display social share sections on WooCommerce singles and certain lists by default', 'corsen-core' ),
					'default_value' => 'yes',
				)
			);
		}
	}

	add_action( 'corsen_core_action_after_social_share_cpt_options_map', 'corsen_core_add_woo_social_share_options' );
}
