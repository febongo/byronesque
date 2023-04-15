<?php

class CorsenCore_Minimal_Header extends CorsenCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'minimal' );
        $this->set_search_layout( 'revealing' );
		$this->default_header_height = 103;

		add_action( 'corsen_action_before_wrapper_close_tag', array( $this, 'fullscreen_menu_template' ) );

		parent::__construct();
	}

	/**
	 * @return CorsenCore_Minimal_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function fullscreen_menu_template() {
		$parameters = array(
			'fullscreen_menu_in_grid'          => 'yes' === corsen_core_get_post_value_through_levels( 'qodef_fullscreen_menu_in_grid' ),
            'fullscreen_menu_image'            => corsen_core_get_post_value_through_levels( 'qodef_fullscreen_menu_background_image' ),
            'fullscreen_menu_side_title'       => corsen_core_get_post_value_through_levels( 'qodef_fullscreen_menu_side_title' ),
            'fullscreen_menu_side_button_text' => corsen_core_get_post_value_through_levels( 'qodef_fullscreen_menu_side_button_text' ),
            'fullscreen_menu_side_button_link' => corsen_core_get_post_value_through_levels( 'qodef_fullscreen_menu_side_button_link' ),
		);

		corsen_core_template_part( 'fullscreen-menu', 'templates/full-screen-menu', '', $parameters );
	}
}
