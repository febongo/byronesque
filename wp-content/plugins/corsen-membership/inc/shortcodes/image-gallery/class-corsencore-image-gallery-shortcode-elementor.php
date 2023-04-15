<?php

class CorsenCore_Image_Gallery_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_image_gallery' );

		parent::__construct( $data, $args );
	}
}

corsen_core_register_new_elementor_widget( new CorsenCore_Image_Gallery_Shortcode_Elementor() );
