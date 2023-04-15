<?php

class CorsenCore_Vertical_Sliding_Header extends CorsenCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'vertical-sliding' );
		$this->set_overriding_whole_header( true );

		add_filter( 'corsen_core_filter_available_header_logo_images', array( $this, 'set_logo_image' ) );

		parent::__construct();
	}

	/**
	 * @return CorsenCore_Vertical_Sliding_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function enqueue_additional_assets() {
		wp_enqueue_style( 'perfect-scrollbar', CORSEN_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.css', array() );
		wp_enqueue_script( 'perfect-scrollbar', CORSEN_CORE_URL_PATH . 'assets/plugins/perfect-scrollbar/perfect-scrollbar.jquery.min.js', array( 'jquery' ), false, true );
	}

	public function set_nav_menu_header_selector( $selector ) {
		return '.qodef-header--vertical-sliding .qodef-header-vertical-sliding-navigation';
	}

	public function set_nav_menu_narrow_header_selector( $selector ) {
		return '';
	}

	public function set_logo_image( $available_logo_images ) {
		$available_logo_images         = array();
		$available_logo_images['main'] = 'vertical_sliding';

		return $available_logo_images;
	}
}
