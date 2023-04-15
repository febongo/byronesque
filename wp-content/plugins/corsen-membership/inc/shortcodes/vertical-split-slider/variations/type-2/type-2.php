<?php

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_variation_type_2' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_variation_type_2( $variations ) {
		$variations['type-2'] = esc_html__( 'Type 2', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_layouts', 'corsen_core_add_vertical_split_slider_variation_type_2' );
}

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_options_type_2' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_options_type_2( $options ) {
		$type_2_options            = array();
		$type_2_options_dependency = array(
			'show' => array(
				'slide_content_layout' => array(
					'values'        => 'type-2',
					'default_value' => '',
				),
			),
		);

        $type_2_product_id = array(
            'field_type' => 'select',
            'name'       => 'type_2_id',
            'title'      => esc_html__( 'Product', 'corsen-core' ),
            'options'    => qode_framework_get_cpt_items( 'product', array( 'numberposts' => '-1' ) ),
            'dependency' => $type_2_options_dependency,
        );
        $type_2_options[]      = $type_2_product_id;

		$type_2_product_image = array(
			'field_type' => 'image',
			'name'       => 'type_2_product_image',
			'title'      => esc_html__( 'Image Behind Product', 'corsen-core' ),
			'dependency' => $type_2_options_dependency,
		);
		$type_2_options[] = $type_2_product_image;

		return array_merge( $options, $type_2_options );
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_extra_repeater_options', 'corsen_core_add_vertical_split_slider_options_type_2' );
}
