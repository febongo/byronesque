<?php

class CorsenCore_Twitter_List_Shortcode_Elementor extends CorsenCore_Elementor_Widget_Base {

	public function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'corsen_core_twitter_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'twitter' ) ) {
	corsen_core_register_new_elementor_widget( new CorsenCore_Twitter_List_Shortcode_Elementor() );
}
