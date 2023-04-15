<?php

class CorsenCore_Centered_Header extends CorsenCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'centered' );
        $this->set_search_layout( 'revealing' );
		$this->default_header_height = 150;

		parent::__construct();
	}

	/**
	 * @return CorsenCore_Centered_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
