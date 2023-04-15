<?php

class CorsenCore_Text_Marquee_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_text_marquee' );

		parent::__construct( $data, $args );
	}
}

corsen_core_register_new_elementor_widget( new CorsenCore_Text_Marquee_Shortcode_Elementor() );
