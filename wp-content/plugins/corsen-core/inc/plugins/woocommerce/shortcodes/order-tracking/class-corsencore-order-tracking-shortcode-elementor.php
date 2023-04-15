<?php

class CorsenCore_Order_Tracking_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_order_tracking' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	corsen_core_register_new_elementor_widget( new CorsenCore_Order_Tracking_Shortcode_Elementor() );
}
