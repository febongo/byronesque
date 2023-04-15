<?php

if ( ! function_exists( 'corsen_core_add_button_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function corsen_core_add_button_widget( $widgets ) {
		$widgets[] = 'CorsenCore_Button_Widget';

		return $widgets;
	}

	add_filter( 'corsen_core_filter_register_widgets', 'corsen_core_add_button_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class CorsenCore_Button_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'corsen_core_button',
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'corsen_core_button' );
				$this->set_name( esc_html__( 'Corsen Button', 'corsen-core' ) );
				$this->set_description( esc_html__( 'Add a button element into widget areas', 'corsen-core' ) );
			}
		}

		public function render( $atts ) {
			echo CorsenCore_Button_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
