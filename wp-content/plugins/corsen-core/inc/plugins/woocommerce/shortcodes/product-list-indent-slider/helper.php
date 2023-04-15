<?php

if ( ! function_exists( 'corsen_core_product_list_indent_slider_filter_query' ) ) {
    /**
     * Function to adjust query for listing list parameters
     */
    function corsen_core_product_list_indent_slider_filter_query( $args, $params ) {

        switch ( $params['orderby'] ) {

            case 'price-range-high':
                $args['meta_query'] = array(
                    array(
                        'key'     => '_price',
                    ),
                );

                $args['order']   = 'DESC';
                $args['orderby'] = 'meta_value_num';
                break;

            case 'price-range-low':
                $args['meta_query'] = array(
                    array(
                        'key'     => '_price',
                    ),
                );

                $args['order']   = 'ASC';
                $args['orderby'] = 'meta_value_num';
                break;

            case 'popularity':
                $args['meta_query'] = array(
                    array(
                        'key'     => 'total_sales',
                    ),
                );

                $args['order']   = 'DESC';
                $args['orderby'] = 'meta_value_num';
                break;

            case 'newness':
                $args['order']   = 'DESC';
                $args['orderby'] = 'date';
                break;

            case 'rating':
                $args['meta_query'] = array(
                    array(
                        'key'     => '_wc_average_rating',
                    ),
                );

                $args['order']   = 'DESC';
                $args['orderby'] = 'meta_value_num';
                break;
        }

        return $args;
    }

    add_filter('corsen_filter_query_params', 'corsen_core_product_list_indent_slider_filter_query', 10, 2);
}

if ( ! function_exists( 'corsen_core_get_product_list_indent_slider_query_order_by_array' ) ) {
	function corsen_core_get_product_list_indent_slider_query_order_by_array() {

		$order = array(
            'popularity'	    => esc_html__( 'Popularity', 'corsen-core' ),
            'rating'	        => esc_html__( 'Average Rating', 'corsen-core' ),
            'newness'	        => esc_html__( 'Newness', 'corsen-core' ),
            'price-range-low'	=> esc_html__( 'Price: Low to High', 'corsen-core' ),
            'price-range-high'	=> esc_html__( 'Price: High to Low', 'corsen-core' ),
		);

		return $order;
	}
}


if ( ! function_exists( 'corsen_core_get_product_list_indent_slider_sorting_filter' ) ) {
	function corsen_core_get_product_list_indent_slider_sorting_filter() {
		$sorting_list_html = '';

		$include_order_by = corsen_core_get_product_list_indent_slider_query_order_by_array();

		foreach ( $include_order_by as $key => $value ) {
			$sorting_list_html .= '<li><a class="qodef-ordering-filter-link" data-ordering="' . $key . '" href="#">' . $value . '</a></li>';
		}

		return $sorting_list_html;
	}
}
