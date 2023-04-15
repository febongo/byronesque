<?php

if ( ! function_exists( 'corsen_core_get_header_logo_image' ) ) {
	/**
	 * This function print header logo image
	 *
	 * @param array $parameters
	 */
	function corsen_core_get_header_logo_image( $parameters = array() ) {
		$header_skin     = corsen_core_get_post_value_through_levels( 'qodef_header_skin' );
		$logo_height     = corsen_core_get_post_value_through_levels( 'qodef_logo_height' );
		$logo_source     = corsen_core_get_post_value_through_levels( 'qodef_logo_source' );
		$logo_svg_path   = corsen_core_get_post_value_through_levels( 'qodef_logo_svg_path' );
		$logo_text       = corsen_core_get_post_value_through_levels( 'qodef_logo_text' );
		$customizer_logo = corsen_core_get_customizer_logo();

		$logo_classes = array();
		if ( ! empty( $logo_height ) ) {
			$logo_classes[] = 'qodef-height--set';
		} else {
			$logo_classes[] = 'qodef-height--not-set';
		}

		if ( ! empty( $logo_source ) ) {
			$logo_classes[] = 'qodef-source--' . esc_attr( $logo_source );
		}

		$parameters = array_merge(
			$parameters,
			array(
				'logo_classes' => implode( ' ', $logo_classes ),
			)
		);

		$logo_html  = array();
		$is_enabled = false;

		if ( 'svg-path' === $logo_source && ! empty( $logo_svg_path ) ) {
			$logo_html['logo_main_image'] = apply_filters( 'corsen_core_filter_header_logo_svg_path', $logo_svg_path, $parameters );

			$is_enabled = true;
		} elseif ( 'textual' === $logo_source && ! empty( $logo_text ) ) {
			$logo_html['logo_main_image'] = esc_html( apply_filters( 'corsen_core_filter_header_logo_textual', $logo_text, $parameters ) );

			$is_enabled = true;
		} else {
			$available_logos = apply_filters(
				'corsen_core_filter_available_header_logo_images',
				array(
					'main'  => 'main',
					'dark'  => 'dark',
					'light' => 'light',
				),
				$parameters
			);

			foreach ( $available_logos as $logo_key => $option_value ) {
				$logo_html[ 'logo_' . $logo_key . '_image' ] = '';

				$logo_image_id = corsen_core_get_post_value_through_levels( 'qodef_logo_' . $option_value );

				if ( empty( $logo_image_id ) && ! empty( $header_skin ) ) {
					$logo_image_id = corsen_core_get_post_value_through_levels( 'qodef_logo_main' );
				}

				if ( ! empty( $logo_image_id ) ) {
					$logo_image_attr = array(
						'class'    => 'qodef-header-logo-image qodef--' . str_replace( '_', '-', $logo_key ),
						'itemprop' => 'image',
						'alt'      => sprintf( esc_attr__( 'logo %s', 'corsen-core' ), str_replace( '_', ' ', $logo_key ) ),
					);

					$image      = wp_get_attachment_image( $logo_image_id, 'full', false, $logo_image_attr );
					$image_html = ! empty( $image ) ? $image : qode_framework_get_image_html_from_src( $logo_image_id, $logo_image_attr );

					$logo_html[ 'logo_' . $logo_key . '_image' ] = qode_framework_wp_kses_html( 'img', $image_html );

					$is_enabled = true;
				}
			}

			if ( ! empty( $customizer_logo ) ) {
				$logo_html['logo_main_image'] = $customizer_logo;
			}
		}

		$parameters['logo_image'] = implode( '', apply_filters( 'corsen_core_filter_header_logo_image_html', $logo_html, $parameters ) );

		if ( $is_enabled ) {
			echo apply_filters( 'corsen_core_filter_get_header_logo_image', corsen_core_get_template_part( 'header/templates', 'parts/logo', '', $parameters ), $parameters );
		}
	}
}

if ( ! function_exists( 'corsen_core_set_header_logo_styles' ) ) {
	/**
	 * Function that generates module inline styles
	 *
	 * @param string $style
	 *
	 * @return string
	 */
	function corsen_core_set_header_logo_styles( $style ) {
		$logo_styles  = array();
		$logo_height  = corsen_core_get_post_value_through_levels( 'qodef_logo_height' );
		$logo_padding = corsen_core_get_post_value_through_levels( 'qodef_logo_padding' );

		if ( ! empty( $logo_height ) ) {
			$logo_styles['height'] = intval( $logo_height ) . 'px';
		}

		if ( ! empty( $logo_padding ) ) {
			$logo_styles['padding'] = esc_attr( $logo_padding );
		}

		if ( ! empty( $logo_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-page-header .qodef-header-logo-link',
				),
				$logo_styles
			);
		}

		// Logo SVG Source
		$svg_styles     = array();
		$svg_icon_color = corsen_core_get_post_value_through_levels( 'qodef_logo_svg_path_color' );

		if ( ! empty( $svg_icon_color ) ) {
			$svg_styles['color'] = $svg_icon_color;
		}

		if ( ! empty( $svg_styles ) ) {
			$style .= qode_framework_dynamic_style( '#qodef-page-header .qodef-header-logo-link.qodef-source--svg-path', $svg_styles );
		}

		$svg_icon_styles = array();
		$svg_icon_size   = corsen_core_get_post_value_through_levels( 'qodef_logo_svg_path_size' );

		if ( ! empty( $svg_icon_size ) ) {
			if ( qode_framework_string_ends_with_typography_units( $svg_icon_size ) ) {
				$svg_icon_styles['width'] = $svg_icon_size;
			} else {
				$svg_icon_styles['width'] = intval( $svg_icon_size ) . 'px';
			}
		}

		if ( ! empty( $svg_icon_styles ) ) {
			$style .= qode_framework_dynamic_style( '#qodef-page-header .qodef-header-logo-link.qodef-source--svg-path svg', $svg_icon_styles );
		}

		$svg_hover_styles     = array();
		$svg_icon_hover_color = corsen_core_get_post_value_through_levels( 'qodef_logo_svg_path_hover_color' );

		if ( ! empty( $svg_icon_hover_color ) ) {
			$svg_hover_styles['color'] = $svg_icon_hover_color;
		}

		if ( ! empty( $svg_hover_styles ) ) {
			$style .= qode_framework_dynamic_style(
				array(
					'#qodef-page-header .qodef-header-logo-link.qodef-source--svg-path:hover',
				),
				$svg_hover_styles
			);
		}

		// Logo Textual Source
		$textual_styles       = corsen_core_get_typography_styles( 'qodef_logo_text', '', null );
		$textual_hover_styles = corsen_core_get_typography_hover_styles( 'qodef_logo_text', null );

		if ( ! empty( $textual_styles ) ) {
			$style .= qode_framework_dynamic_style( '#qodef-page-header .qodef-header-logo-link.qodef-source--textual', $textual_styles );
		}

		if ( ! empty( $textual_hover_styles ) ) {
			$style .= qode_framework_dynamic_style( '#qodef-page-header .qodef-header-logo-link.qodef-source--textual:hover', $textual_hover_styles );
		}

		return $style;
	}

	add_filter( 'corsen_filter_add_inline_style', 'corsen_core_set_header_logo_styles' );
}

if ( ! function_exists( 'corsen_core_get_header_widget_area' ) ) {
	/**
	 * This function return header widgets area
	 *
	 * @param string $widget_area
	 * @param string $widget_area_slug
	 * @param string $custom_widget_area_slug
	 * @param bool $enabled
	 */
	function corsen_core_get_header_widget_area( $widget_area = 'one', $widget_area_slug = 'header-widget-area', $custom_widget_area_slug = '', $enabled = false ) {
		$page_id    = qode_framework_get_page_id();
		$is_enabled = 'no' !== get_post_meta( $page_id, 'qodef_show_header_widget_areas', true );

		if ( $is_enabled || $enabled ) {
			$default_widget_area_slug = 'qodef-' . esc_attr( $widget_area_slug ) . '-' . esc_attr( $widget_area );
			$custom_widget_area_slug  = ! empty( $custom_widget_area_slug ) ? 'qodef_' . esc_attr( $custom_widget_area_slug ) . '_header_custom_widget_area_' . esc_attr( $widget_area ) : 'qodef_header_custom_widget_area_' . esc_attr( $widget_area );

			$parameters = apply_filters(
				'corsen_core_filter_header_widget_area',
				array(
					'page_id'             => $page_id,
					'widget_area'         => $widget_area,
					'default_widget_area' => $default_widget_area_slug,
					'custom_widget_area'  => get_post_meta( $page_id, $custom_widget_area_slug, true ),
				)
			);

			corsen_core_template_part( 'header/templates', 'parts/widgets', '', $parameters );
		}
	}
}
