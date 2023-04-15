<?php

if ( ! function_exists( 'corsen_core_add_section_title_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_section_title_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Section_Title_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_section_title_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Section_Title_Shortcode extends CorsenCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/section-title' );
			$this->set_base( 'corsen_core_section_title' );
			$this->set_name( esc_html__( 'Section Title', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds section title element', 'corsen-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'corsen-core' ),
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
					'field_type'  => 'text',
					'name'        => 'line_break_positions',
					'title'       => esc_html__( 'Positions of Line Break', 'corsen-core' ),
					'description' => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'corsen-core' ),
					'group'       => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'disable_title_break_words',
					'title'         => esc_html__( 'Disable Title Line Break', 'corsen-core' ),
					'description'   => esc_html__( 'Enabling this option will disable title line breaks for screen size 1024 and lower', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'no',
					'group'         => esc_html__( 'Title Style', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h2',
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
					'name'       => 'link',
					'title'      => esc_html__( 'Title Custom Link', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Custom Link Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'textarea',
					'name'          => 'text',
					'title'         => esc_html__( 'Text', 'corsen-core' ),
					'default_value' => esc_html__( 'Contrary to popular belief, Lorem Ipsum is not simply random text.', 'corsen-core' ),
				)
			);
            $this->set_option(
                array(
                    'field_type'  => 'text',
                    'name'        => 'text_line_break_positions',
                    'title'       => esc_html__( 'Positions of Line Break', 'corsen-core' ),
                    'description' => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'corsen-core' ),
                    'group'       => esc_html__( 'Text Style', 'corsen-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'disable_text_break_words',
                    'title'         => esc_html__( 'Disable Text Line Break', 'corsen-core' ),
                    'description'   => esc_html__( 'Enabling this option will disable text line breaks for screen size 1024 and lower', 'corsen-core' ),
                    'options'       => corsen_core_get_select_type_options_pool( 'no_yes', false ),
                    'default_value' => 'no',
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
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'button_text',
                    'title'         => esc_html__( 'Button Text', 'corsen-core' ),
                    'default_value' => esc_html__( 'Button Text', 'corsen-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'button_link',
                    'title'      => esc_html__( 'Button Link', 'corsen-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'button_target',
                    'title'         => esc_html__( 'Button Target', 'corsen-core' ),
                    'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
                    'default_value' => '_self',
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'button_margin_top',
                    'title'      => esc_html__( 'Button Margin Top', 'corsen-core' ),
                    'group'      => esc_html__( 'Button Style', 'corsen-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'button_layout',
                    'title'         => esc_html__( 'Button Layout', 'corsen-core' ),
                    'options'       => array(
                        'outlined' => esc_html__( 'Outlined', 'corsen-core' ),
                        'filled'   => esc_html__( 'Filled', 'corsen-core' ),
                    ),
                    'default_value' => 'outlined',
                    'group'         => esc_html__( 'Button Style', 'corsen-core' ),
                )
            );
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'content_alignment',
					'title'      => esc_html__( 'Content Alignment', 'corsen-core' ),
					'options'    => array(
						''       => esc_html__( 'Default', 'corsen-core' ),
						'left'   => esc_html__( 'Left', 'corsen-core' ),
						'center' => esc_html__( 'Center', 'corsen-core' ),
						'right'  => esc_html__( 'Right', 'corsen-core' ),
					),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['title']          = $this->get_modified_title( $atts );
			$atts['text']           = $this->get_modified_text( $atts );
			$atts['title_styles']   = $this->get_title_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );
			$atts['button_styles']  = $this->get_button_styles( $atts );

			return corsen_core_get_template_part( 'shortcodes/section-title', 'templates/section-title', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-section-title';
			$holder_classes[] = ! empty( $atts['content_alignment'] ) ? 'qodef-alignment--' . $atts['content_alignment'] : 'qodef-alignment--left';
			$holder_classes[] = 'yes' === $atts['disable_title_break_words'] ? 'qodef-title-break--disabled' : '';
			$holder_classes[] = 'yes' === $atts['disable_text_break_words'] ? 'qodef-text-break--disabled' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_modified_title( $atts ) {
			$title = $atts['title'];

			if ( ! empty( $title ) && ! empty( $atts['line_break_positions'] ) ) {
				$split_title          = explode( ' ', $title );
				$line_break_positions = explode( ',', str_replace( ' ', '', $atts['line_break_positions'] ) );

				foreach ( $line_break_positions as $position ) {
					$position = intval( $position );
					if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
						$split_title[ $position - 1 ] = $split_title[ $position - 1 ] . '<br />';
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}

		private function get_modified_text( $atts ) {
			$title = $atts['text'];

			if ( ! empty( $title ) && ! empty( $atts['text_line_break_positions'] ) ) {
				$split_title          = explode( ' ', $title );
				$line_break_positions = explode( ',', str_replace( ' ', '', $atts['text_line_break_positions'] ) );

				foreach ( $line_break_positions as $position ) {
					$position = intval( $position );
					if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
						$split_title[ $position - 1 ] = $split_title[ $position - 1 ] . '<br />';
					}
				}

				$title = implode( ' ', $split_title );
			}

			return $title;
		}

		private function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
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

		private function get_button_styles( $atts ) {
			$styles = array();

			if ( '' !== $atts['button_margin_top'] ) {
				if ( qode_framework_string_ends_with_space_units( $atts['button_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['button_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['button_margin_top'] ) . 'px';
				}
			}

			return $styles;
		}
	}
}
