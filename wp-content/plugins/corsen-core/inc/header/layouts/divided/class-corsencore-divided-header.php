<?php

class CorsenCore_Divided_Header extends CorsenCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'divided' );
        $this->set_search_layout( 'revealing' );
		$this->default_header_height = 103;

		parent::__construct();
	}

	/**
	 * @return CorsenCore_Divided_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
