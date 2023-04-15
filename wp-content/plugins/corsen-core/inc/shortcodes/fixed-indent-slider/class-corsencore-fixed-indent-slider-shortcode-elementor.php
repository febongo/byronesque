<?php

class CorsenCore_Fixed_Indent_Slider_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_fixed_indent_slider' );

		parent::__construct( $data, $args );
	}
}

corsen_core_register_new_elementor_widget( new CorsenCore_Fixed_Indent_Slider_Shortcode_Elementor() );
