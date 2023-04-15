<?php

if ( ! function_exists( 'corsen_core_add_separator_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function corsen_core_add_separator_widget( $widgets ) {
		$widgets[] = 'CorsenCore_Separator_Widget';

		return $widgets;
	}

	add_filter( 'corsen_core_filter_register_widgets', 'corsen_core_add_separator_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class CorsenCore_Separator_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'corsen_core_separator',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'corsen_core_separator' );
				$this->set_name( esc_html__( 'Corsen Separator', 'corsen-core' ) );
				$this->set_description( esc_html__( 'Add a separator element into widget areas', 'corsen-core' ) );
			}
		}

		public function render( $atts ) {
			echo CorsenCore_Separator_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
