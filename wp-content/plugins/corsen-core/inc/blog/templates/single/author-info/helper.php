<?php

if ( ! function_exists( 'corsen_core_include_blog_single_author_info_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function corsen_core_include_blog_single_author_info_template() {
		if ( is_single() ) {
			include_once CORSEN_CORE_INC_PATH . '/blog/templates/single/author-info/templates/author-info.php';
		}
	}

	add_action( 'corsen_action_after_blog_post_item', 'corsen_core_include_blog_single_author_info_template', 15 );  // permission 15 is set to define template position
}

if ( ! function_exists( 'corsen_core_get_author_social_networks' ) ) {
	/**
	 * Function which includes author info templates on single posts page
	 */
	function corsen_core_get_author_social_networks( $user_id ) {
		$icons           = array();
		$social_networks = array(
			'facebook',
			'twitter',
			'linkedin',
			'instagram',
			'pinterest',
		);

		foreach ( $social_networks as $network ) {
			$network_meta = get_the_author_meta( 'qodef_user_' . $network, $user_id );

			if ( ! empty( $network_meta ) ) {
				$$network = array(
					'url'   => $network_meta,
					'icon'  => 'social_' . $network,
					'class' => 'qodef-user-social-' . $network,
				);

				$icons[ $network ] = $$network;
			}
		}

		return $icons;
	}
}

if ( ! function_exists( 'corsen_core_get_author_social_icons' ) ) {
    /**
     * Function which includes author info templates on single posts page
     */
    function corsen_core_get_author_social_icons( $social_icon ) {

        switch ( $social_icon ) {
            case 'social_facebook':
                $icon = 'FB';
                break;

            case 'social_twitter':
                $icon = 'TW';
                break;

            case 'social_linkedin':
                $icon = 'LN';
                break;

            case 'social_instagram':
                $icon = 'IN';
                break;

            case 'social_pinterest':
                $icon = 'PN';
                break;

            default:
                $icon = '';
        }

        return $icon;
    }
}
