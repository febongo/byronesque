<?php

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_variation_type_1' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_variation_type_1( $variations ) {
		$variations['type-1'] = esc_html__( 'Type 1', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_layouts', 'corsen_core_add_vertical_split_slider_variation_type_1' );
}

if ( ! function_exists( 'corsen_core_add_vertical_split_slider_options_type_1' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function corsen_core_add_vertical_split_slider_options_type_1( $options ) {
		$type_1_options            = array();
		$type_1_options_dependency = array(
			'show' => array(
				'slide_content_layout' => array(
					'values'        => 'type-1',
					'default_value' => '',
				),
			),
		);

		$type_1_title     = array(
			'field_type' => 'text',
			'name'       => 'type_1_title',
			'title'      => esc_html__( 'Title', 'corsen-core' ),
			'dependency' => $type_1_options_dependency,
		);
		$type_1_options[] = $type_1_title;

		$type_1_title_tag = array(
			'field_type' => 'select',
			'name'       => 'type_1_title_tag',
			'title'      => esc_html__( 'Title Tag', 'corsen-core' ),
			'options'    => corsen_core_get_select_type_options_pool( 'title_tag' ),
			'dependency' => $type_1_options_dependency,
		);
		$type_1_options[] = $type_1_title_tag;

		$type_1_text      = array(
			'field_type' => 'textarea',
			'name'       => 'type_1_text',
			'title'      => esc_html__( 'Text', 'corsen-core' ),
			'dependency' => $type_1_options_dependency,
		);
		$type_1_options[] = $type_1_text;

		$type_1_button_text = array(
			'field_type' => 'text',
			'name'       => 'type_1_button_text',
			'title'      => esc_html__( 'Button Text', 'corsen-core' ),
			'dependency' => $type_1_options_dependency,
		);
		$type_1_options[]   = $type_1_button_text;

		$type_1_button_link = array(
			'field_type' => 'text',
			'name'       => 'type_1_button_link',
			'title'      => esc_html__( 'Button Link', 'corsen-core' ),
			'dependency' => $type_1_options_dependency,
		);
		$type_1_options[]   = $type_1_button_link;

		$type_1_button_target = array(
			'field_type'    => 'select',
			'name'          => 'type_1_button_target',
			'title'         => esc_html__( 'Button Target', 'corsen-core' ),
			'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
			'default_value' => '_self',
			'dependency'    => $type_1_options_dependency,
		);
		$type_1_options[]     = $type_1_button_target;

		return array_merge( $options, $type_1_options );
	}

	add_filter( 'corsen_core_filter_vertical_split_slider_extra_repeater_options', 'corsen_core_add_vertical_split_slider_options_type_1' );
}
