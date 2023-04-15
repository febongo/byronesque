<?php

if ( ! function_exists( 'corsen_core_add_single_image_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param $shortcodes array
	 *
	 * @return array
	 */
	function corsen_core_add_single_image_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Single_Image_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_single_image_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Single_Image_Shortcode extends CorsenCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'corsen_core_filter_single_image_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'corsen_core_filter_single_image_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/single-image' );
			$this->set_base( 'corsen_core_single_image' );
			$this->set_name( esc_html__( 'Single Image', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image element', 'corsen-core' ) );
			$this->set_scripts(
				array(
					'jquery-magnific-popup' => array(
						'registered' => true,
					),
				)
			);
			$this->set_necessary_styles(
				array(
					'magnific-popup' => array(
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
					'field_type'    => 'select',
					'name'          => 'retina_scaling',
					'title'         => esc_html__( 'Enable Retina Scaling', 'corsen-core' ),
					'description'   => esc_html__( 'Image uploaded should be two times the height.', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'center_align_image',
					'title'         => esc_html__( 'Center Align Image', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no', false ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'images_proportion',
					'default_value' => 'full',
					'title'         => esc_html__( 'Image Proportions', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'list_image_dimension', false ),
					'dependency'    => array(
						'hide' => array(
							'retina_scaling' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_width',
					'title'       => esc_html__( 'Custom Image Width', 'corsen-core' ),
					'description' => esc_html__( 'Enter image width in px', 'corsen-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'custom_image_height',
					'title'       => esc_html__( 'Custom Image Height', 'corsen-core' ),
					'description' => esc_html__( 'Enter image height in px', 'corsen-core' ),
					'dependency'  => array(
						'show' => array(
							'images_proportion' => array(
								'values'        => 'custom',
								'default_value' => 'full',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'image_action',
					'title'      => esc_html__( 'Image Action', 'corsen-core' ),
					'options'    => array(
						''            => esc_html__( 'No Action', 'corsen-core' ),
						'open-popup'  => esc_html__( 'Open Popup', 'corsen-core' ),
						'custom-link' => esc_html__( 'Custom Link', 'corsen-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Custom Link', 'corsen-core' ),
					'dependency' => array(
						'show' => array(
							'image_action' => array(
								'values'        => array( 'custom-link' ),
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Custom Link Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'dependency'    => array(
						'show' => array(
							'image_action' => array(
								'values'        => 'custom-link',
								'default_value' => '',
							),
						),
					),
				)
			);

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'parallax_item',
					'title'         => esc_html__( 'Enable Parallax Item', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'yes_no' ),
					'default_value' => '',
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

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'corsen_core_single_image', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {

			if ( isset( $atts['image_action'] ) && 'open-popup' === $atts['image_action'] ) {
				wp_enqueue_style( 'magnific-popup' );
				wp_enqueue_script( 'jquery-magnific-popup' );
			}
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );

			return corsen_core_get_template_part( 'shortcodes/single-image', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-single-image';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['parallax_item'] ) && ( 'yes' === $atts['parallax_item'] ) ? 'qodef-parallax-item' : '';
			$holder_classes[] = ( 'yes' === $atts['retina_scaling'] ) ? 'qodef--retina' : '';
			$holder_classes[] = ! empty( $atts['center_align_image'] ) ? 'qodef-center-align-image--' . $atts['center_align_image'] : '';
			$holder_classes[] = ( 'yes' === $atts['enable_appear'] ) ? 'qodef--has-appear' : '';

			return implode( ' ', $holder_classes );
		}
	}
}
