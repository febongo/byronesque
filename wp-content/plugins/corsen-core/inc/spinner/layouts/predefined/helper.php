<?php

if ( ! function_exists( 'corsen_core_add_predefined_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function corsen_core_add_predefined_spinner_layout_option( $layouts ) {
		$layouts['predefined'] = esc_html__( 'Predefined', 'corsen-core' );

		return $layouts;
	}

	add_filter( 'corsen_core_filter_page_spinner_layout_options', 'corsen_core_add_predefined_spinner_layout_option' );
}

if ( ! function_exists( 'corsen_core_add_predefined_spinner_layout_classes' ) ) {
	/**
	 * Function that return classes for page spinner area
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function corsen_core_add_predefined_spinner_layout_classes( $classes ) {
		$type = corsen_core_get_post_value_through_levels( 'qodef_page_spinner_type' );

		if ( 'predefined' === $type ) {
			$classes[] = 'qodef--custom-spinner';
		}

		return $classes;
	}

	add_filter( 'corsen_core_filter_page_spinner_classes', 'corsen_core_add_predefined_spinner_layout_classes' );
}

if ( ! function_exists( 'corsen_core_set_predefined_spinner_layout_as_default_option' ) ) {
	/**
	 * Function that set default value for page spinner layout options map
	 *
	 * @param string $default_value
	 *
	 * @return string
	 */
	function corsen_core_set_predefined_spinner_layout_as_default_option( $default_value ) {
		return 'predefined';
	}

	add_filter( 'corsen_core_filter_page_spinner_default_layout_option', 'corsen_core_set_predefined_spinner_layout_as_default_option' );
}

if ( ! function_exists( 'corsen_enqueue_predefined_spinner_scripts' ) ) {
    /**
     * Function that enqueue 3rd party plugins script
     */
    function corsen_enqueue_predefined_spinner_scripts() {

        if ( 'predefined' === corsen_core_get_post_value_through_levels( 'qodef_page_spinner_type' )) {
            wp_enqueue_script( 'DrawSVG' );
        }
    }

    add_action( 'corsen_core_action_before_main_js', 'corsen_enqueue_predefined_spinner_scripts' );
}
