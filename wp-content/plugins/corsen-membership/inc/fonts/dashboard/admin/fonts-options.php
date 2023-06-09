<?php

if ( ! function_exists( 'corsen_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function corsen_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => CORSEN_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'corsen-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'corsen-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'corsen-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'corsen-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_google_fonts' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_repeater = $google_fonts_section->add_repeater_element(
				array(
					'name'        => 'qodef_choose_google_fonts',
					'title'       => esc_html__( 'Google Fonts to Include', 'corsen-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'corsen-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'corsen-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'corsen-core' ),
					'description' => esc_html__( 'Choose Google Font', 'corsen-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'corsen-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'corsen-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'corsen-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'corsen-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'corsen-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'corsen-core' ),
						'300'  => esc_html__( '300 Light', 'corsen-core' ),
						'300i' => esc_html__( '300 Light Italic', 'corsen-core' ),
						'400'  => esc_html__( '400 Regular', 'corsen-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'corsen-core' ),
						'500'  => esc_html__( '500 Medium', 'corsen-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'corsen-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'corsen-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'corsen-core' ),
						'700'  => esc_html__( '700 Bold', 'corsen-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'corsen-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'corsen-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'corsen-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'corsen-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'corsen-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'corsen-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'corsen-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'corsen-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'corsen-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'corsen-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'corsen-core' ),
						'greek'        => esc_html__( 'Greek', 'corsen-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'corsen-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'corsen-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'corsen-core' ),
					'description' => esc_html__( 'Add custom fonts', 'corsen-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'corsen-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'corsen-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'corsen-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'corsen-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'corsen-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'corsen-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'corsen_core_action_default_options_init', 'corsen_core_add_fonts_options', corsen_core_get_admin_options_map_position( 'fonts' ) );
}
