<?php

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_variation_type_3' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_variation_type_3( $variations ) {
		$variations['type-3'] = esc_html__( 'Type 3', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_layouts', 'corsen_core_add_vertical_split_slider_variation_type_3' );
}

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_options_type_3' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_options_type_3( $options ) {
		$type_3_options            = array();
		$type_3_options_dependency = array(
			'show' => array(
				'slide_content_layout' => array(
					'values'        => 'type-3',
					'default_value' => '',
				),
			),
		);

		$type_3_testimonial_id = array(
			'field_type' => 'select',
			'name'       => 'type_3_id',
			'title'      => esc_html__( 'Testimonial', 'corsen-core' ),
			'options'    => qode_framework_get_cpt_items( 'testimonials', array( 'numberposts' => '-1' ) ),
			'dependency' => $type_3_options_dependency,
		);
		$type_3_options[]      = $type_3_testimonial_id;

		$type_3_testimonial_skin = array(
			'field_type' => 'select',
			'name'       => 'type_3_skin',
			'title'      => esc_html__( 'Skin', 'corsen-core' ),
			'options'    => corsen_core_get_select_type_options_pool( 'shortcode_skin' ),
			'dependency' => $type_3_options_dependency,
		);
		$type_3_options[]        = $type_3_testimonial_skin;

		return array_merge( $options, $type_3_options );
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_extra_repeater_options', 'corsen_core_add_vertical_split_slider_options_type_3' );
}
