<?php

if ( ! function_exists( 'corsen_core_add_horizontal_showcase_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_horizontal_showcase_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Horizontal_Showcase_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_horizontal_showcase_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Horizontal_Showcase_Shortcode extends CorsenCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/horizontal-showcase' );
			$this->set_base( 'corsen_core_horizontal_showcase' );
			$this->set_name( esc_html__( 'Horizontal Showcase', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds horizontal showcase holder', 'corsen-core' ) );
			$this->set_scripts(
				array_merge(
					array(
						'SmoothScrollbar'        => array(
							'registered' => false,
							'url'        => CORSEN_CORE_SHORTCODES_URL_PATH . '/horizontal-showcase/assets/js/plugins/smooth-scrollbar.js',
							'dependency' => array( 'jquery' ),
						),
						'HorizontalScrollPlugin' => array(
							'registered' => false,
							'url'        => CORSEN_CORE_SHORTCODES_URL_PATH . '/horizontal-showcase/assets/js/plugins/HorizontalScrollPlugin.js',
							'dependency' => array( 'jquery' ),
						),
						'overscroll'             => array(
							'registered' => false,
							'url'        => CORSEN_CORE_SHORTCODES_URL_PATH . '/horizontal-showcase/assets/js/plugins/overscroll.js',
							'dependency' => array( 'jquery' ),
						),
					),
					apply_filters(
						'corsen_core_filter_horizontal_showcase_register_assets',
						array()
					)
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
					'field_type' => 'image',
					'name'       => 'featured_image',
					'title'      => esc_html__( 'Featured Image', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Slides', 'corsen-core' ),
					'items'      => array(
						array(
							'field_type' => 'color',
							'name'       => 'background_color',
							'title'      => esc_html__( 'Background Color', 'corsen-core' ),
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image1',
							'title'      => esc_html__( 'Image 1', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image1_link',
							'title'      => esc_html__( 'Image 1 Link', 'corsen-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_image1_target',
							'title'         => esc_html__( 'Image 1 Link Target', 'corsen-core' ),
							'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
							'default_value' => '_self',
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image1_title_first_line',
							'title'      => esc_html__( 'Image 1 Title First Line', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image1_title_second_line',
							'title'      => esc_html__( 'Image 1 Title Second Line', 'corsen-core' ),
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image2',
							'title'      => esc_html__( 'Image 2', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image2_link',
							'title'      => esc_html__( 'Image 2 Link', 'corsen-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_image2_target',
							'title'         => esc_html__( 'Image 2 Link Target', 'corsen-core' ),
							'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
							'default_value' => '_self',
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image2_title',
							'title'      => esc_html__( 'Image 2 Title', 'corsen-core' ),
						),
						array(
							'field_type'    => 'text',
							'name'          => 'item_image2_button_text',
							'title'         => esc_html__( 'Image 2 Button Text', 'corsen-core' ),
							'default_value' => esc_html__( 'SHOP COLLECTION', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_image2_button_link',
							'title'      => esc_html__( 'Image 2 Button Link', 'corsen-core' ),
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_image2_button_target',
							'title'         => esc_html__( 'Image 2 Button Target', 'corsen-core' ),
							'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
							'default_value' => '_self',
						),
						array(
							'field_type'    => 'select',
							'name'          => 'item_image_hover',
							'title'         => esc_html__( 'Image Hover Animation', 'corsen-core' ),
							'options'       => corsen_core_get_select_type_options_pool( 'yes_no', false ),
							'default_value' => 'no',
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'scroll_back',
					'title'         => esc_html__( 'Show Scroll Back', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'yes',
					'group'         => esc_html__( 'Scroll Back', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'social_links_target',
					'title'         => esc_html__( 'Social Links Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'group'         => esc_html__( 'Scroll Back', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'social',
					'title'      => esc_html__( 'Social Links', 'corsen-core' ),
					'group'      => esc_html__( 'Scroll Back', 'corsen-core' ),
					'items'      => array(
						array(
							'field_type' => 'text',
							'name'       => 'social_item_text',
							'title'      => esc_html__( 'Item Text', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'social_item_link',
							'title'      => esc_html__( 'Item Link', 'corsen-core' ),
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			// fixed atts
			$atts['item_size_type'] = '';

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );
			$atts['social_items']   = $this->parse_repeater_items( $atts['social'] );
			$atts['this_shortcode'] = $this;

			return corsen_core_get_template_part( 'shortcodes/horizontal-showcase', 'templates/horizontal-showcase', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-horizontal-showcase qodef-custom-horizontal-slider';

			return implode( ' ', $holder_classes );
		}

		public function get_slide_classes( $slide_atts ) {
			$classes = array( 'qodef-m-item', 'qodef-horizontal-slide' );

			if ( ! empty( $slide_atts['item_size_type'] ) ) {
				$classes[] = 'qodef-size-type--' . $slide_atts['item_size_type'];
			}

			if ( ! empty( $slide_atts['item_image_hover'] && 'yes' === $slide_atts['item_image_hover'] ) ) {
				$classes[] = 'qodef-hover-animation';
			}

			return implode( ' ', $classes );
		}

		public function get_slide_styles( $slide_atts ) {
			$styles = array();

			if ( ! empty( $slide_atts['background_color'] ) ) {
				$styles[] = 'background-color: ' . $slide_atts['background_color'];
			}

			return $styles;
		}
	}
}
