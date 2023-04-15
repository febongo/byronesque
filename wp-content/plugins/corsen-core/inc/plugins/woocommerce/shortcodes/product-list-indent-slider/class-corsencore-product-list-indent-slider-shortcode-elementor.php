<?php

class CorsenCore_Product_List_Indent_Slider_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_product_list_indent_slider' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	corsen_core_register_new_elementor_widget( new CorsenCore_Product_List_Indent_Slider_Shortcode_Elementor() );
}
