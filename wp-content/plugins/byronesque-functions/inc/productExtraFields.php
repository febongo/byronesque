<?php 
// Add commission field to product general tab
add_action( 'woocommerce_product_options_general_product_data', 'add_product_extra_field' );
function add_product_extra_field() {
    woocommerce_wp_text_input( array(
        'id'          => '_product_commission',
        'label'       => __( 'Product Commission', 'woocommerce' ),
        'placeholder' => 'Enter commission percentage',
        'description' => __( 'Enter the commission percentage for this product.', 'woocommerce' ),
        'desc_tip'    => true,
        'type'        => 'number',
        'custom_attributes' => array(
            'min' => '0',
            'step' => '0.01'
        ),
    ) );

    woocommerce_wp_text_input( array(
        'id'          => '_product_archiving_fee',
        'label'       => __( 'Product Archiving Fee', 'woocommerce' ),
        'placeholder' => 'Enter Archiving Fee',
        'description' => __( 'Enter the archiving fee for this product.', 'woocommerce' ),
        'desc_tip'    => true,
        'type'        => 'number',
        'custom_attributes' => array(
            'min' => '0',
            'step' => '1'
        ),
    ) );

    woocommerce_wp_text_input( array(
        'id'          => '_product_cost_of_goods',
        'label'       => __( 'Product Cost of Goods', 'woocommerce' ),
        'placeholder' => 'Enter Cost of Goods',
        'description' => __( 'Enter the cost of goods for this product.', 'woocommerce' ),
        'desc_tip'    => true,
        'type'        => 'number',
        'custom_attributes' => array(
            'min' => '0',
            'step' => '1'
        ),
    ) );
}

// Save extra field value
add_action( 'woocommerce_process_product_meta', 'save_product_extra_field', 10, 2 );
function save_product_extra_field( $post_id, $post ) {

    if ( isset( $_POST['_product_commission'] ) ) {
        $product_commission = floatval( $_POST['_product_commission'] );
        update_post_meta( $post_id, '_product_commission', $product_commission );
    }

    if ( isset( $_POST['_product_archiving_fee'] ) ) {
        $product_archiving = floatval( $_POST['_product_archiving_fee'] );
        update_post_meta( $post_id, '_product_archiving_fee', $product_archiving );
    }

    if ( isset( $_POST['_product_cost_of_goods'] ) ) {
        $product_archiving = floatval( $_POST['_product_cost_of_goods'] );
        update_post_meta( $post_id, '_product_cost_of_goods', $product_archiving );
    }
}

