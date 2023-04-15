<?php

if ( ! function_exists( 'corsen_core_add_portfolio_list_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_portfolio_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Portfolio_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_portfolio_list_shortcode' );
}

if ( class_exists( 'CorsenCore_List_Shortcode' ) ) {
	class CorsenCore_Portfolio_List_Shortcode extends CorsenCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'corsen_core_filter_portfolio_list_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'corsen_core_filter_portfolio_list_extra_options', array() ) );
			$this->set_hover_animation_options( apply_filters( 'corsen_core_filter_portfolio_list_hover_animation_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-list' );
			$this->set_base( 'corsen_core_portfolio_list' );
			$this->set_name( esc_html__( 'Portfolio List', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of portfolios', 'corsen-core' ) );
			$this->set_scripts( apply_filters( 'corsen_core_filter_portfolio_list_register_assets', array() ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'corsen-core' ),
				)
			);
			$this->map_list_options();
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options(
				array(
					'layouts'          => $this->get_layouts(),
					'hover_animations' => $this->get_hover_animation_options(),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'custom_margin',
					'title'         => esc_html__( 'Use Item Custom Margin', 'corsen-core' ),
					'description'   => esc_html__( 'If you set this option to “Yes”, the margin values defined in the Portfolio Item Custom Margin field will be applied', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'no_yes', false ),
					'default_value' => 'no',
					'dependency'    => array(
						'show' => array(
							'behavior' => array(
								'values'        => array( 'columns', 'masonry' ),
								'default_value' => 'columns',
							),
						),
					),
					'group'         => esc_html__( 'Layout', 'corsen-core' ),
				)
			);
			$this->map_additional_options();
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'corsen_core_portfolio_list', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'corsen_core_action_portfolio_list_load_assets', $this->get_atts() );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

			$atts = $this->get_atts();

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_filter_taxonomy( $atts );

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['query_result']   = new \WP_Query( corsen_core_get_query_params( $atts ) );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['data_attr']      = corsen_core_get_pagination_data( CORSEN_CORE_REL_PATH, 'post-types/portfolio/shortcodes', 'portfolio-list', 'portfolio', $atts );

			$atts['this_shortcode'] = $this;

			return corsen_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/content', $atts['behavior'], $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-list';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';

			$list_classes            = $this->get_list_classes( $atts );
			$hover_animation_classes = $this->get_hover_animation_classes( $atts );
			$holder_classes          = array_merge( $holder_classes, $list_classes, $hover_animation_classes );

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$list_item_classes = $this->get_list_item_classes( $atts );

			if ( isset( $atts['custom_margin'] ) && 'yes' === $atts['custom_margin'] ) {
				$list_item_classes[] = 'qodef-custom-margin';
			}

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

		public function get_list_item_style( $atts ) {
			$styles = array();

			if ( isset( $atts['custom_margin'] ) && 'yes' === $atts['custom_margin'] ) {
				$margin = get_post_meta( get_the_ID(), 'qodef_portfolio_item_padding', true );

				if ( isset( $margin ) && '' !== $margin ) {
					$styles[] = 'margin: ' . get_post_meta(get_the_ID(), 'qodef_portfolio_item_padding', true);
				}
			}

			return $styles;
		}
	}
}
