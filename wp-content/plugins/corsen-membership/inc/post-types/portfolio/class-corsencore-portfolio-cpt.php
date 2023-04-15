<?php

if ( ! function_exists( 'corsen_core_register_portfolio_for_meta_options' ) ) {
	/**
	 * Function that add custom post type into global meta box allowed items array for saving meta box options
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	function corsen_core_register_portfolio_for_meta_options( $post_types ) {
		$post_types[] = 'portfolio-item';

		return $post_types;
	}

	add_filter( 'qode_framework_filter_meta_box_save', 'corsen_core_register_portfolio_for_meta_options' );
	add_filter( 'qode_framework_filter_meta_box_remove', 'corsen_core_register_portfolio_for_meta_options' );
}

if ( ! function_exists( 'corsen_core_add_portfolio_custom_post_type' ) ) {
	/**
	 * Function that adds portfolio custom post type
	 *
	 * @param array $cpts
	 *
	 * @return array
	 */
	function corsen_core_add_portfolio_custom_post_type( $cpts ) {
		$cpts[] = 'CorsenCore_Portfolio_CPT';

		return $cpts;
	}

	add_filter( 'corsen_core_filter_register_custom_post_types', 'corsen_core_add_portfolio_custom_post_type' );
}

if ( class_exists( 'QodeFrameworkCustomPostType' ) ) {
	class CorsenCore_Portfolio_CPT extends QodeFrameworkCustomPostType {

		public function map_post_type() {
			$name = esc_html__( 'Portfolio', 'corsen-core' );
			$this->set_base( 'portfolio-item' );
			$this->set_menu_position( 10 );
			$this->set_menu_icon( 'dashicons-grid-view' );
			$this->set_slug( 'portfolio-item' );
			$this->set_name( $name );
			$this->set_path( CORSEN_CORE_CPT_PATH . '/portfolio' );
			$this->set_labels(
				array(
					'name'          => esc_html__( 'Corsen Portfolio', 'corsen-core' ),
					'singular_name' => esc_html__( 'Portfolio Item', 'corsen-core' ),
					'add_item'      => esc_html__( 'New Portfolio Item', 'corsen-core' ),
					'add_new_item'  => esc_html__( 'Add New Portfolio Item', 'corsen-core' ),
					'edit_item'     => esc_html__( 'Edit Portfolio Item', 'corsen-core' ),
				)
			);
			$this->add_post_taxonomy(
				array(
					'base'          => 'portfolio-category',
					'slug'          => 'portfolio-category',
					'singular_name' => esc_html__( 'Category', 'corsen-core' ),
					'plural_name'   => esc_html__( 'Categories', 'corsen-core' ),
				)
			);
			$this->add_post_taxonomy(
				array(
					'base'          => 'portfolio-tag',
					'slug'          => 'portfolio-tag',
					'singular_name' => esc_html__( 'Tag', 'corsen-core' ),
					'plural_name'   => esc_html__( 'Tags', 'corsen-core' ),
				)
			);
		}
	}
}
