<?php

if ( ! function_exists( 'corsen_core_add_product_single_product_meta_box' ) ) {
    /**
     * Function that add general options for this module
     */
    function corsen_core_add_product_single_product_meta_box() {
        $qode_framework = qode_framework_get_framework_root();

        $page = $qode_framework->add_options_page(
            array(
                'scope' => array( 'product' ),
                'type'  => 'meta',
                'slug'  => 'product-single',
                'title' => esc_html__( 'Product Single', 'corsen-core' ),
            )
        );

        if ( $page ) {

            $single_layouts = apply_filters(
                'corsen_core_filter_woo_single_product_layouts',
                array(
                    ''         => esc_html__( 'Default', 'corsen-core' ),
                    'standard' => esc_html__( 'Standard', 'corsen-core' ),
                )
            );

            if ( count( $single_layouts ) > 1 ) {
                $page->add_field_element(
                    array(
                        'field_type'  => 'select',
                        'name'        => 'qodef_woo_single_layout',
                        'title'       => esc_html__( 'Product layout', 'corsen-core' ),
                        'description' => esc_html__( 'Choose a default layout for single product page', 'corsen-core' ),
                        'options'     => $single_layouts,
                    )
                );
            }

            $page->add_field_element(
                array(
                    'field_type'  => 'image',
                    'name'        => 'qodef_product_images_gallery',
                    'title'       => esc_html__( 'Upload Gallery Images', 'corsen-core' ),
                    'description' => esc_html__( 'Gallery used for this layout', 'corsen-core' ),
                    'multiple'    => 'yes',
                    'dependency'  => array(
                        'show' => array(
                            'qodef_woo_single_layout' => array(
                                'values'        => 'slider',
                                'default_value' => 'default',
                            ),
                        ),
                    ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type' => 'color',
                    'name'       => 'qodef_product_bg_color',
                    'title'      => esc_html__( 'Background Color', 'corsen-core' ),
                    'dependency' => array(
                        'show' => array(
                            'qodef_woo_single_layout' => array(
                                'values'        => array( 'slider', 'full-width' ),
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );

            $page->add_field_element(
                array(
                    'field_type'    => 'select',
                    'name'          => 'qodef_woo_single_thumb_images_position',
                    'title'         => esc_html__( 'Set Thumbnail Images Position', 'corsen-core' ),
                    'description'   => esc_html__( 'Choose position of the thumbnail images on single product page relative to featured image', 'corsen-core' ),
                    'options'       => array(
                        ''      => esc_html__( 'Default', 'corsen-core' ),
                        'below' => esc_html__( 'Below', 'corsen-core' ),
                        'left'  => esc_html__( 'Left', 'corsen-core' ),
                        'right' => esc_html__( 'Right', 'corsen-core' ),
                    ),
                    'default_value' => '',
                    'dependency'    => array(
                        'show' => array(
                            'qodef_woo_single_layout' => array(
                                'values'        => array( '', 'standard' ),
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );

            // Hook to include additional options after module options
            do_action( 'corsen_core_action_after_product_single_meta_box_map', $page );
        }
    }

    add_action( 'corsen_core_action_default_meta_boxes_init', 'corsen_core_add_product_single_product_meta_box' );
}
