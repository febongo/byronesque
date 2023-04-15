<?php

if ( ! function_exists( 'corsen_core_add_icon_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function corsen_core_add_icon_widget( $widgets ) {
		$widgets[] = 'CorsenCore_Icon_Widget';

		return $widgets;
	}

	add_filter( 'corsen_core_filter_register_widgets', 'corsen_core_add_icon_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class CorsenCore_Icon_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'corsen_core_icon',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'corsen_core_icon' );
				$this->set_name( esc_html__( 'Corsen Icon', 'corsen-core' ) );
				$this->set_description( esc_html__( 'Add a icon element into widget areas', 'corsen-core' ) );
			}
		}

		public function render( $atts ) {
			echo CorsenCore_Icon_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
