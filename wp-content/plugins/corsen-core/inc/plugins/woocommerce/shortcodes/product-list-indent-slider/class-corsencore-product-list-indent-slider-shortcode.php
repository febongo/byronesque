<?php

if ( ! function_exists( 'corsen_core_add_product_list_indent_slider_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_product_list_indent_slider_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Product_List_Indent_Slider_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_product_list_indent_slider_shortcode' );
}

if ( class_exists( 'CorsenCore_List_Shortcode' ) ) {
	class CorsenCore_Product_List_Indent_Slider_Shortcode extends CorsenCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'product' );
			$this->set_post_type_taxonomy( 'product_cat' );
			$this->set_post_type_additional_taxonomies( array( 'product_tag', 'product_type' ) );
			$this->set_layouts( apply_filters( 'corsen_core_filter_product_list_indent_slider_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'corsen_core_filter_product_list_indent_slider_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_PLUGINS_URL_PATH . '/woocommerce/shortcodes/product-list-indent-slider' );
			$this->set_base( 'corsen_core_product_list_indent_slider' );
			$this->set_name( esc_html__( 'Product List Indent Slider', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of products', 'corsen-core' ) );
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
					'name'          => 'enable_border',
					'title'         => esc_html__( 'Enable Border Item', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'yes',
					'dependency'    => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-boxed', 'boxed-below', 'info-on-image' ),
								'default_value' => '',
							),
						),
					),
					'group'         => esc_html__( 'Layout', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'hover_border',
					'title'         => esc_html__( 'Hover Border', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'yes',
					'dependency'    => array(
						'show' => array(
							'layout' => array(
								'values'        => array( 'info-on-image' ),
								'default_value' => '',
							),
						),
					),
					'group'         => esc_html__( 'Layout', 'corsen-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'behavior',
					'title'         => esc_html__( 'List Appearance', 'corsen-core' ),
					'options'       => array(
						'indent-slider' => esc_html__( 'Indent Slider', 'corsen-core' ),
					),
					'default_value' => 'indent-slider',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'slider_position',
					'title'         => esc_html__( 'Slider Position', 'corsen-core' ),
					'options'       => array(
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
					'name'       => 'indent_slider_autoplay',
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
					'field_type' => 'select',
					'name'       => 'enable_image_hover',
					'title'      => esc_html__( 'Enable Image Change On Hover', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'no_yes', false ),
					'group'      => esc_html__( 'Layout', 'corsen-core' ),
				)
			);
			$this->map_list_options(
				array(
					'exclude_option' => array( 'behavior', 'columns_responsive', 'columns', 'space' ),
				)
			);
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'filterby',
					'title'         => esc_html__( 'Filter By', 'corsen-core' ),
					'options'       => array(
						''             => esc_html__( 'Default', 'corsen-core' ),
						'on_sale'      => esc_html__( 'On Sale', 'corsen-core' ),
						'featured'     => esc_html__( 'Featured', 'corsen-core' ),
						'top_rated'    => esc_html__( 'Top Rated', 'corsen-core' ),
						'best_selling' => esc_html__( 'Best Selling', 'corsen-core' ),
					),
					'default_value' => '',
					'group'         => esc_html__( 'Query', 'corsen-core' ),
				)
			);
			$this->map_layout_options(
				array(
					'layouts'                 => $this->get_layouts(),
					'default_value_title_tag' => 'h6',
				)
			);
			$this->map_additional_options( array( 'exclude_filter' => true ) );
			$this->map_extra_options();

			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'info_title',
					'title'      => esc_html__( 'Info Title', 'corsen-core' ),
					'group'      => esc_html__( 'Info Content', 'corsen-core' ),
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
					'field_type' => 'textarea',
					'name'       => 'info_text',
					'title'      => esc_html__( 'Info Text', 'corsen-core' ),
					'group'      => esc_html__( 'Info Content', 'corsen-core' ),
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
					'field_type' => 'text',
					'name'       => 'button_link',
					'title'      => esc_html__( 'Button Link', 'corsen-core' ),
					'group'      => esc_html__( 'Info Content', 'corsen-core' ),
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
					'field_type' => 'text',
					'name'       => 'button_text',
					'title'      => esc_html__( 'Button Text', 'corsen-core' ),
					'group'      => esc_html__( 'Info Content', 'corsen-core' ),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'corsen_core_product_list_indent_slider', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			// fixed atts
			$atts['slider_navigation'] = 'yes';

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_filter_taxonomy( $atts );

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['query_result']   = new \WP_Query( corsen_core_get_query_params( $atts ) );
			$atts['info_title']     = $this->get_modified_info_title( $atts );
			$atts['info_text']      = $this->get_modified_info_text( $atts );
			$atts['slider_data']    = $this->get_slider_data( $atts );
			$atts['data_attrs']     = $this->get_slider_inner_data_attrs( $atts );
			$atts['data_attr']      = corsen_core_get_pagination_data( CORSEN_CORE_REL_PATH, 'plugins/woocommerce/shortcodes', 'product-list-indent-slider', 'product', $atts );

			$atts['this_shortcode'] = $this;

			return corsen_core_get_template_part( 'plugins/woocommerce/shortcodes/product-list-indent-slider', 'templates/content', $atts['behavior'], $atts );
		}

		public function get_additional_query_args( $atts ) {
			$args = parent::get_additional_query_args( $atts );

			if ( ! empty( $atts['filterby'] ) ) {
				switch ( $atts['filterby'] ) {
					case 'on_sale':
						$sale_products         = wc_get_product_ids_on_sale();
						$args['no_found_rows'] = 1;
						$args['post__in']      = array_merge( array( 0 ), $sale_products );

						if ( ! empty( $atts['additional_params'] ) && 'id' === $atts['additional_params'] && ! empty( $atts['post_ids'] ) ) {
							$post_ids          = array_map( 'intval', explode( ',', $atts['post_ids'] ) );
							$new_sale_products = array();

							foreach ( $post_ids as $post_id ) {
								if ( in_array( $post_id, $sale_products, true ) ) {
									$new_sale_products[] = $post_id;
								}
							}

							if ( ! empty( $new_sale_products ) ) {
								$args['post__in'] = $new_sale_products;
							}
						}

						break;
					case 'featured':
						$featured_tax_query   = WC()->query->get_tax_query();
						$featured_tax_query[] = array(
							'taxonomy'         => 'product_visibility',
							'terms'            => 'featured',
							'field'            => 'name',
							'operator'         => 'IN',
							'include_children' => false,
						);

						if ( isset( $args['tax_query'] ) && ! empty( $args['tax_query'] ) ) {
							$args['tax_query'] = array_merge( $args['tax_query'], $featured_tax_query );
						} else {
							$args['tax_query'] = $featured_tax_query;
						}

						break;
					case 'top_rated':
						$args['meta_key'] = '_wc_average_rating';
						$args['order']    = 'DESC';
						$args['orderby']  = 'meta_value_num';
						break;
					case 'best_selling':
						$args['meta_key'] = 'total_sales';
						$args['order']    = 'DESC';
						$args['orderby']  = 'meta_value_num';
						break;
				}
			}

			return $args;
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-woo-shortcode';
			$holder_classes[] = 'qodef-woo-product-list indent-slider';
			$holder_classes[] = 'left' === $atts['slider_position'] ? 'qodef-slider--left' : '';
			$holder_classes[] = ! empty( $atts['enable_border'] ) ? 'qodef-enable-border--' . $atts['enable_border'] : '';
			$holder_classes[] = ! empty( $atts['hover_border'] ) ? 'qodef-hover-border--' . $atts['hover_border'] : '';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';
            $holder_classes[] = 'yes' === $atts['enable_image_hover'] ? 'qodef--hover-image' : '';

            $list_classes   = $this->get_list_classes( $atts );
			$holder_classes = array_merge( $holder_classes, $list_classes );

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes      = $this->init_item_classes();
			$item_classes[]    = 'swiper-slide';
			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		public function get_title_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			return $styles;
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

		public function get_slider_data( $atts, $data = array() ) {
			$data['loop']           = isset( $atts['slider_loop'] ) ? 'no' !== $atts['slider_loop'] : true;
			$data['autoplay']       = isset( $atts['indent_slider_autoplay'] ) ? 'no' !== $atts['indent_slider_autoplay'] : true;
			$data['speed']          = isset( $atts['slider_speed'] ) ? $atts['slider_speed'] : '';
			$data['speedAnimation'] = isset( $atts['slider_speed_animation'] ) ? $atts['slider_speed_animation'] : '';
			$data['slideAnimation'] = isset( $atts['slider_slide_animation'] ) ? $atts['slider_slide_animation'] : '';
			$data['sliderScroll']   = isset( $atts['slider_scroll'] ) ? $atts['slider_scroll'] : '';

			return json_encode( $data );
		}
	}
}
