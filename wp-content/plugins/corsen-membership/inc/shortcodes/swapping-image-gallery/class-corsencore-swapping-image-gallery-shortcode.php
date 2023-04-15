<?php

if ( ! function_exists( 'corsen_core_add_swapping_image_gallery_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function corsen_core_add_swapping_image_gallery_shortcode( $shortcodes ) {
		$shortcodes[] = 'CorsenCore_Swapping_Image_Gallery_Shortcode';

		return $shortcodes;
	}

	add_filter( 'corsen_core_filter_register_shortcodes', 'corsen_core_add_swapping_image_gallery_shortcode' );
}

if ( class_exists( 'CorsenCore_Shortcode' ) ) {
	class CorsenCore_Swapping_Image_Gallery_Shortcode extends CorsenCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( CORSEN_CORE_SHORTCODES_URL_PATH . '/swapping-image-gallery' );
			$this->set_base( 'corsen_core_swapping_image_gallery' );
			$this->set_name( esc_html__( 'Swapping Image Gallery', 'corsen-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds swapping image gallery holder', 'corsen-core' ) );
			$this->set_scripts(
				array(
					'swiper'         => array(
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
					'field_type'    => 'select',
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'corsen-core' ),
					'options'       => corsen_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'info_position',
					'title'         => esc_html__( 'Info Position', 'corsen-core' ),
					'options'       => array(
						''      => esc_html__( 'Default', 'corsen-core' ),
						'right' => esc_html__( 'Right', 'corsen-core' ),
						'left'  => esc_html__( 'Left', 'corsen-core' ),
					),
					'default_value' => 'right',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'corsen-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'corsen-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'image',
							'name'       => 'main_image',
							'title'      => esc_html__( 'Main Image', 'corsen-core' ),
						),
						array(
							'field_type' => 'image',
							'name'       => 'thumbnail_image',
							'title'      => esc_html__( 'Thumbnail Image', 'corsen-core' ),
						),
						array(
							'field_type' => 'image',
							'name'       => 'active_thumbnail_image',
							'title'      => esc_html__( 'Active Thumbnail Image', 'corsen-core' ),
						),
						array(
							'field_type' => 'text',
							'name'       => 'thumbnail_title',
							'title'      => esc_html__( 'Thumbnail Title', 'corsen-core' ),
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );
			$atts['slider_data']    = $this->get_slider_data();
			$atts['this_shortcode'] = $this;

			return corsen_core_get_template_part( 'shortcodes/swapping-image-gallery', 'templates/swapping-image-gallery', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-swapping-image-gallery';
			$holder_classes[] = ! empty( $atts['info_position'] ) ? 'qodef-info-position--' . $atts['info_position'] : 'qodef-info-position--right';

			return implode( ' ', $holder_classes );
		}

		private function get_slider_data() {
			$data = array();

			$data['slidesPerView'] = '1';
			$data['spaceBetween']  = 0;
			$data['autoplay']      = false;

			return json_encode( $data );
		}
	}
}
