<?php

if ( ! function_exists( 'corsen_core_add_fixed_indent_slider_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_fixed_indent_slider_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Fixed_Indent_Slider_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_fixed_indent_slider_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Fixed_Indent_Slider_Shortcode extends CorsenCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'corsen_core_filter_fixed_indent_slider_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'corsen_core_filter_fixed_indent_slider_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/fixed-indent-slider' );
			$this->set_base( 'corsen_core_fixed_indent_slider' );
			$this->set_name( esc_html__( 'Fixed Indent Slider', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds fixed indent slider element', 'corsen-core' ) );
			$this->set_scripts(
				array(
					'swiper'                 => array(
						'registered' => true,
					),
					'corsen-main-js' => array(
						'registered' => true,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'corsen-core' ),
				)
			);
            $this->set_option(
                array(
                    'field_type' => 'select',
                    'name'       => 'slider_position',
                    'title'      => esc_html__( 'Slider Position', 'corsen-core' ),
                    'options'    => array(
                        ''     => esc_html__( 'Default (Right)', 'corsen-core' ),
                        'left' => esc_html__( 'Left', 'corsen-core' ),
                    ),
                    'default_value' => '',
                )
            );
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'slider_loop',
					'title'      => esc_html__( 'Enable Slider Loop', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'slider_scroll',
					'title'         => esc_html__( 'Enable Slider Scroll', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no', false ),
                    'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'slider_autoplay',
					'title'      => esc_html__( 'Enable Slider Autoplay', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'yes_no' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'slider_speed',
					'title'       => esc_html__( 'Slide Duration', 'corsen-core' ),
					'description' => esc_html__( 'Default value is 5000 (ms)', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'slider_speed_animation',
					'title'       => esc_html__( 'Slide Animation Duration', 'corsen-core' ),
					'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 800.', 'corsen-core' ),
				)
			);
            $this->set_option(
                array(
                    'field_type'  => 'select',
                    'name'        => 'show_image_borders',
                    'title'       => esc_html__( 'Show Image Borders', 'corsen-core' ),
                    'options'     => corsen_core_get_select_type_options_pool( 'yes_no', false ),
                    'description' => esc_html__( 'Enabling this option will display borders around images.', 'corsen-core' ),
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
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Child elements', 'corsen-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'corsen-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Image', 'corsen-core' ),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'info_title',
					'title'       => esc_html__( 'Info Title', 'corsen-core' ),
					'group'       => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_break_positions',
					'title'       => esc_html__( 'Positions of Line Break', 'corsen-core' ),
					'description' => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'corsen-core' ),
					'group'       => esc_html__( 'Info Content', 'corsen-core' ),
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
					'group'         => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'textarea',
					'name'        => 'info_text',
					'title'       => esc_html__( 'Info Text', 'corsen-core' ),
					'group'       => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
            $this->set_option(
                array(
                    'field_type'  => 'text',
                    'name'        => 'text_line_break_positions',
                    'title'       => esc_html__( 'Positions of Text Line Break', 'corsen-core' ),
                    'description' => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'corsen-core' ),
                    'group'       => esc_html__( 'Info Content', 'corsen-core' ),
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
                    'group'         => esc_html__( 'Info Content', 'corsen-core' ),
                )
            );
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'button_link',
					'title'       => esc_html__( 'Button Link', 'corsen-core' ),
					'group'       => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'button_target',
					'title'         => esc_html__( 'Button Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'group'         => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'button_text',
					'title'       => esc_html__( 'Button Text', 'corsen-core' ),
					'group'       => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']       = $this->get_holder_classes( $atts );
			$atts['holder_outer_classes'] = $this->get_holder_outer_classes( $atts );
			$atts['info_title']           = $this->get_modified_info_title( $atts );
			$atts['info_text']            = $this->get_modified_info_text( $atts );
			$atts['slider_data']          = $this->get_slider_data( $atts );
            $atts['data_attrs']           = $this->get_slider_inner_data_attrs( $atts );
			$atts['items']                = $this->parse_repeater_items( $atts['children'] );
			$atts['this_shortcode']       = $this;

			return corsen_core_get_template_part( 'shortcodes/fixed-indent-slider', 'templates/fixed-indent-slider', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-fixed-indent-slider';
			$holder_classes[] = 'yes' === $atts['show_image_borders'] ? 'qodef-show-image-borders--yes' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_outer_classes( $atts ) {
			$holder_outer_classes   = $this->init_holder_classes();

			$holder_outer_classes[] = 'qodef-fixed-indent-slider-holder-outer';
            $holder_outer_classes[] = 'left' === $atts['slider_position'] ? 'qodef-slider--left' : '';
            $holder_outer_classes[] = 'yes' === $atts['disable_title_break_words'] ? 'qodef-title-break--disabled' : '';
            $holder_outer_classes[] = 'yes' === $atts['disable_text_break_words'] ? 'qodef-text-break--disabled' : '';

			return implode( ' ', $holder_outer_classes );
		}

		private function get_modified_info_title( $atts ) {
			$title = $atts['info_title'];

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

		private function get_modified_info_text( $atts ) {
			$title = $atts['info_text'];

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

        private function get_slider_inner_data_attrs( $atts ) {
            $data = array();

            if ( ! empty( $atts['slider_position'] ) ) {
                $data['dir'] = 'rtl';
            }

            return $data;
        }

		private function get_slider_data( $atts ) {
			$data = array();

			$data['loop']           = isset( $atts['slider_loop'] ) ? 'no' !== $atts['slider_loop'] : true;
			$data['autoplay']       = isset( $atts['slider_autoplay'] ) ? 'no' !== $atts['slider_autoplay'] : true;
			$data['speed']          = isset( $atts['slider_speed'] ) ? $atts['slider_speed'] : '';
			$data['speedAnimation'] = isset( $atts['slider_speed_animation'] ) ? $atts['slider_speed_animation'] : '';
			$data['slideAnimation'] = isset( $atts['slider_slide_animation'] ) ? $atts['slider_slide_animation'] : '';
			$data['sliderScroll']   = isset( $atts['slider_scroll'] ) ? $atts['slider_scroll'] : '';

			return json_encode( $data );
		}
	}
}
