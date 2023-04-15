<?php

if ( ! function_exists( 'corsen_core_add_banner_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_banner_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Banner_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_banner_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Banner_Shortcode extends CorsenCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'corsen_core_filter_banner_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'corsen_core_filter_banner_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/banner' );
			$this->set_base( 'corsen_core_banner' );
			$this->set_name( esc_html__( 'Banner', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds banner element', 'corsen-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'corsen-core' ),
				)
			);

			$options_map = corsen_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'corsen-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'image',
					'name'       => 'image',
					'title'      => esc_html__( 'Image', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link_url',
					'title'      => esc_html__( 'Link', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'title',
					'title'         => esc_html__( 'Title', 'corsen-core' ),
					'default_value' => esc_html__( 'Title Text', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'additional_title',
					'title'         => esc_html__( 'Additional Title', 'corsen-core' ),
					'default_value' => esc_html__( 'Title Text', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h3',
					'group'         => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'title_color',
					'title'      => esc_html__( 'Title Color', 'corsen-core' ),
					'group'      => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_margin_top',
					'title'      => esc_html__( 'Title Margin Top', 'corsen-core' ),
					'group'      => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'title_max_width',
					'title'       => esc_html__( 'Title Max Width', 'corsen-core' ),
					'description' => esc_html__( 'Set max width for the title on screen sizes above 1440px.', 'corsen-core' ),
					'group'       => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_font_size',
					'title'      => esc_html__( 'Title Font Size', 'corsen-core' ),
					'group'      => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title_line_height',
					'title'      => esc_html__( 'Title Line Height', 'corsen-core' ),
					'group'      => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'title_text_transform',
					'title'      => esc_html__( 'Title Text Transform', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'text_transform' ),
					'group'      => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'subtitle',
					'title'      => esc_html__( 'Subtitle', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'subtitle_tag',
					'title'         => esc_html__( 'Subtitle Tag', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h5',
					'group'         => esc_html__( 'Subtitle Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'subtitle_color',
					'title'      => esc_html__( 'Subtitle Color', 'corsen-core' ),
					'group'      => esc_html__( 'Subtitle Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'subtitle_margin_top',
					'title'      => esc_html__( 'Subtitle Margin Top', 'corsen-core' ),
					'group'      => esc_html__( 'Subtitle Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textarea',
					'name'       => 'text_field',
					'title'      => esc_html__( 'Text', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'text_tag',
					'title'         => esc_html__( 'Text Tag', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'p',
					'group'         => esc_html__( 'Text Style', 'corsen-core' ),
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
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_margin_top',
					'title'      => esc_html__( 'Text Margin Top', 'corsen-core' ),
					'group'      => esc_html__( 'Text Style', 'corsen-core' ),
				)
			);
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'corsen_core_button',
					'exclude'           => array( 'custom_class', 'link', 'target' ),
					'additional_params' => array(
						'nested_group' => esc_html__( 'Button', 'corsen-core' ),
						'dependency'   => array(
							'show' => array(
								'layout' => array(
									'values'        => 'link-button',
									'default_value' => '',
								),
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'skin',
					'title'      => esc_html__( 'Skin', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'shortcode_skin' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'enable_border',
					'title'      => esc_html__( 'Enable Border Around Image', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
            $this->set_option(
                array(
                    'field_type' => 'select',
                    'name'       => 'enable_appear',
                    'title'      => esc_html__( 'Enable Appear', 'corsen-core' ),
                    'options'    => corsen_core_get_select_type_options_pool( 'yes_no', false ),
                )
            );

			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']      = $this->get_holder_classes( $atts );
			$atts['title_holder_styles'] = $this->get_title_holder_styles( $atts );
			$atts['title_styles']        = $this->get_title_styles( $atts );
			$atts['subtitle_styles']     = $this->get_subtitle_styles( $atts );
			$atts['text_styles']         = $this->get_text_styles( $atts );
			$atts['button_params']       = $this->generate_button_params( $atts );

			return corsen_core_get_template_part( 'shortcodes/banner', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-banner';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['skin'] ) ? 'qodef-banner--' . $atts['skin'] : '';
			$holder_classes[] = ( 'yes' === $atts['enable_appear'] ) ? 'qodef--has-appear' : '';

			if ( 'yes' === $atts['enable_border'] ) {
				$holder_classes[] = 'qodef--enable-border';
			}

			return implode( ' ', $holder_classes );
		}

		private function get_title_holder_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['title_max_width'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_max_width'] ) ) {
					$styles[] = 'max-width: ' . $atts['title_max_width'];
				} else {
					$styles[] = 'max-width: ' . intval( $atts['title_max_width'] ) . 'px';
				}
			}

			return $styles;
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['title_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['title_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['title_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['title_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
			}

			if ( ! empty( $atts['title_font_size'] ) ) {
				$styles[] = 'font-size: ' . $atts['title_font_size'];
			}

			if ( ! empty( $atts['title_line_height'] ) ) {
				$styles[] = 'line-height: ' . $atts['title_line_height'];
			}

			if ( ! empty( $atts['title_text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['title_text_transform'];
			}

			return $styles;
		}

		private function get_subtitle_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['subtitle_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['subtitle_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['subtitle_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['subtitle_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['subtitle_color'] ) ) {
				$styles[] = 'color: ' . $atts['subtitle_color'];
			}

			return $styles;
		}

		private function get_text_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['text_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['text_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['text_margin_top'] ) . 'px';
				}
			}

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			return $styles;
		}

		private function generate_button_params( $atts ) {
			$params = $this->populate_imported_shortcode_atts(
				array(
					'shortcode_base' => 'corsen_core_button',
					'exclude'        => array( 'custom_class', 'link', 'target' ),
					'atts'           => $atts,
				)
			);

			$params['link']   = ! empty( $atts['link_url'] ) ? $atts['link_url'] : '';
			$params['target'] = ! empty( $atts['link_target'] ) ? $atts['link_target'] : '';

			return $params;
		}
	}
}
