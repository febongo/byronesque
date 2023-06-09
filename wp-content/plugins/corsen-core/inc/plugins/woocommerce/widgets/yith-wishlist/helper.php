<?php

if( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ){
    function yith_wcwl_ajax_update_count(){
        wp_send_json( array(
            'count' => yith_wcwl_count_all_products()
        ) );
    }
    add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
    add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}