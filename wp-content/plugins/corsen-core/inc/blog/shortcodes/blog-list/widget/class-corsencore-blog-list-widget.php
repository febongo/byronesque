<?php

if ( ! function_exists( 'corsen_core_add_blog_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function corsen_core_add_blog_list_widget( $widgets ) {
		$widgets[] = 'CorsenCore_Blog_List_Widget';

		return $widgets;
	}

	add_filter( 'corsen_core_filter_register_widgets', 'corsen_core_add_blog_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class CorsenCore_Blog_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'corsen-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'corsen_core_blog_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'corsen_core_blog_list' );
				$this->set_name( esc_html__( 'Corsen Blog List', 'corsen-core' ) );
				$this->set_description( esc_html__( 'Display a list of blog posts', 'corsen-core' ) );
			}
		}

		public function render( $atts ) {
			$atts['is_widget_element'] = 'yes';

			echo CorsenCore_Blog_List_Shortcode::call_shortcode( $atts ); // XSS OK
		}
	}
}
