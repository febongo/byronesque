<?php

if ( ! function_exists( 'corsen_core_add_dropcaps_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_dropcaps_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Dropcaps_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_dropcaps_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Dropcaps_Shortcode extends CorsenCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/dropcaps' );
			$this->set_base( 'corsen_core_dropcaps' );
			$this->set_name( esc_html__( 'Dropcaps', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays dropcaps with provided parameters', 'corsen-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'type',
					'title'         => esc_html__( 'Type', 'corsen-core' ),
					'options'       => array(
						'simple' => esc_html__( 'Simple', 'corsen-core' ),
						'circle' => esc_html__( 'Circle', 'corsen-core' ),
						'square' => esc_html__( 'Square', 'corsen-core' ),
					),
					'default_value' => 'simple',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'letter',
					'title'         => esc_html__( 'Letter', 'corsen-core' ),
					'default_value' => esc_html__( 'S', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'letter_color',
					'title'      => esc_html__( 'Letter Color', 'corsen-core' ),
					'group'      => esc_html__( 'Letter Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'letter_background_color',
					'title'      => esc_html__( 'Letter Background Color', 'corsen-core' ),
					'group'      => esc_html__( 'Letter Style', 'corsen-core' ),
					'dependency' => array(
						'hide' => array(
							'type' => array(
								'values'        => 'simple',
								'default_value' => 'simple',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text',
					'title'      => esc_html__( 'Text', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'corsen-core' ),
					'group'      => esc_html__( 'Text Style', 'corsen-core' ),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['letter_styles']  = $this->get_letter_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );

			return corsen_core_get_template_part( 'shortcodes/dropcaps', 'templates/dropcaps', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-dropcaps';
			$holder_classes[] = ! empty( $atts['type'] ) ? 'qodef-type--' . $atts['type'] : '';

			return implode( ' ', $holder_classes );
		}

		private function get_letter_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['letter_color'] ) ) {
				$styles[] = 'color: ' . $atts['letter_color'];
			}

			if ( 'simple' !== $atts['type'] && ! empty( $atts['letter_background_color'] ) ) {
				$styles[] = 'background-color: ' . $atts['letter_background_color'];
			}

			return $styles;
		}

		private function get_text_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			return $styles;
		}
	}
}
