<?php

if ( ! function_exists( 'corsen_register_required_plugins' ) ) {
	/**
	 * Function that registers theme required and optional plugins. Hooks to tgmpa_register hook
	 */
	function corsen_register_required_plugins() {
		$plugins = array(
			array(
				'name'               => esc_html__( 'Qode Framework', 'corsen' ),
				'slug'               => 'qode-framework',
				'source'             => CORSEN_INC_ROOT_DIR . '/plugins/qode-framework.zip',
				'version'            => '1.1.9',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'               => esc_html__( 'Corsen Core', 'corsen' ),
				'slug'               => 'corsen-core',
				'source'             => CORSEN_INC_ROOT_DIR . '/plugins/corsen-core.zip',
				'version'            => '1.0',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
            array(
                'name'               => esc_html__( 'Corsen Membership', 'corsen' ),
                'slug'               => 'corsen-membership',
                'source'             => CORSEN_INC_ROOT_DIR . '/plugins/corsen-core.zip',
                'version'            => '1.0',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
			array(
				'name'               => esc_html__( 'Revolution Slider', 'corsen' ),
				'slug'               => 'revslider',
				'source'             => CORSEN_INC_ROOT_DIR . '/plugins/revslider.zip',
				'version'            => '6.6.10',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'     => esc_html__( 'Elementor Page Builder', 'corsen' ),
				'slug'     => 'elementor',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'Qi Addons for Elementor', 'corsen' ),
				'slug'     => 'qi-addons-for-elementor',
				'required' => true,
			),
            array(
                'name'     => esc_html__( 'Qi Blocks', 'corsen' ),
                'slug'     => 'qi-blocks',
                'required' => true,
            ),
			array(
				'name'     => esc_html__( 'WooCommerce Plugin', 'corsen' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Contact Form 7', 'corsen' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Custom Twitter Feeds', 'corsen' ),
				'slug'     => 'custom-twitter-feeds',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Instagram Feed', 'corsen' ),
				'slug'     => 'instagram-feed',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Envato Market', 'corsen' ),
				'slug'     => 'envato-market',
				'source'   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
				'required' => false,
			),
            array(
                'name'     => esc_html__( 'YITH Quickview', 'corsen' ),
                'slug'     => 'yith-woocommerce-quick-view',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH Whishlist', 'corsen' ),
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH Color and Label Variations', 'corsen' ),
                'slug'     => 'yith-color-and-label-variations-for-woocommerce',
                'required' => false,
            ),
		);

		$config = array(
			'domain'       => 'corsen',
			'default_path' => '',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'menu'         => 'install-required-plugins',
			'has_notices'  => true,
			'is_automatic' => false,
			'message'      => '',
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'corsen' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'corsen' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'corsen' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'corsen' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'corsen' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'corsen' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this website for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'corsen' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'corsen' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'corsen' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this website for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'corsen' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'corsen' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this website for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'corsen' ),
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'corsen' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'corsen' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'corsen' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'corsen' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'corsen' ),
				'nag_type'                        => 'updated',
			),
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'corsen_register_required_plugins' );
}
