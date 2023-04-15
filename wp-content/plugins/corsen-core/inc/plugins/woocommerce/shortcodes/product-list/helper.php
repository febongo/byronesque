<?php

if ( ! function_exists( 'corsen_core_product_list_filter_query' ) ) {
    /**
     * Function to adjust query for listing list parameters
     */
    function corsen_core_product_list_filter_query( $args, $params ) {

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

    add_filter('corsen_filter_query_params', 'corsen_core_product_list_filter_query', 10, 2);
}

if ( ! function_exists( 'corsen_core_get_product_list_query_order_by_array' ) ) {
	function corsen_core_get_product_list_query_order_by_array() {

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


if ( ! function_exists( 'corsen_core_get_product_list_sorting_filter' ) ) {
	function corsen_core_get_product_list_sorting_filter() {
		$sorting_list_html = '';

		$include_order_by = corsen_core_get_product_list_query_order_by_array();

		foreach ( $include_order_by as $key => $value ) {
			$sorting_list_html .= '<li><a class="qodef-ordering-filter-link" data-ordering="' . $key . '" href="#">' . $value . '</a></li>';
		}

		return $sorting_list_html;
	}
}

if ( ! function_exists( 'corsen_core_get_product_list_category_filter' ) ) {
    function corsen_core_get_product_list_category_filter( $params ) {
        $taxonomy_html = '';

        $taxonomy     = 'product_cat';
        $orderby      = 'name';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title        = '';
        $empty        = 0;
        $parent       = 0;

        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty,
            'parent'       => $parent
        );

        $all_categories_string = '';

        if ( 'tax' === $params['additional_params'] ) {
            $args['taxonomy'] = $params['tax'];

            if ( '' === $params['tax_slug'] ) {
                if ( '' === $params['filter_tax__in'] ) {
                    $all_categories = get_categories( $args );
                } else {
                    $all_categories = array();
                    $categories     = explode( ',', $params['filter_tax__in'] );
                    $i = 1;

                    foreach ( $categories as $cat ) {
                        $cat_term = get_term_by( 'id', $cat, 'product_cat' );
                        $all_categories[] = $cat_term;

                        if ( isset( $cat_term->slug ) ) {
	                        $all_categories_string .= $cat_term->slug;

	                        if ( sizeof( $categories ) !== $i ) {
		                        $all_categories_string .= ',';
		                        $i = $i + 1;
	                        }
                        }
                    }
                }
            } else {
                $all_categories_string = $params['tax_slug'];
                $all_categories        = array();
                $categories            = explode( ',', $params['tax_slug'] );
                foreach ( $categories as $cat ) {
                    $all_categories[] = get_term_by( 'slug', $cat, 'product_cat' );
                }
            }
        } else if ( 'id' === $params['additional_params'] ) {
            $products       = explode( ',', $params['post_ids'] );
            $all_categories = array();
            $categories     = array();
            $i = 1;

            foreach( $products as $product ) {
                $categories[] = wc_get_product_term_ids( $product, 'product_cat' );
            }

            $categories = array_unique( array_merge( ...$categories ) );

            if ( '' !== $params['filter_tax__in'] ) {
                $filtered_cats = explode( ',', $params['filter_tax__in'] );
                $categories = array_intersect( $categories, $filtered_cats );
            }

            foreach( $categories as $cat ) {
                $cat_term = get_term_by( 'id', $cat, 'product_cat' );
                $all_categories[] = $cat_term;
                $all_categories_string .= $cat_term->slug;

                if( sizeof( $categories ) !== $i ) {
                    $all_categories_string .= ',';
                    $i = $i + 1;
                }
            }

            $params['tax_slug'] = "";
        } else {
            $all_categories = array();
        }

        $taxonomy_html .= '<li><a class="qodef-category-filter-link qodef--active" data-category="' . $all_categories_string . '" href="#">' . esc_html__( 'All Products', 'corsen-core' ) . '</a></li>';

        foreach ( $all_categories as $cat ) {
            if ( $cat && '' !== $cat ) {

                if ( '' === $params['tax_slug'] ) {
                    $taxonomy_html .= '<li><a class="qodef-category-filter-link" data-category="' . $cat->slug . '" href="' . get_term_link( $cat->slug, 'product_cat' ) . '">' . $cat->name . '</a></li>';
                }

                $termchildren = get_term_children( $cat->term_id, 'product_cat' );

                if ( ! empty( $termchildren ) ) {
                    foreach ( $termchildren as $child ) {
                        $child_cat = get_term_by( 'id', $child, 'product_cat' );

                        if ( ! is_wp_error( $child_cat ) && ! empty( $child_cat ) ) {
                            $taxonomy_html .= '<li><a class="qodef-category-filter-link" data-category="' . $child_cat->slug . '" href="' . get_term_link( $child_cat->slug, 'product_cat' ) . '">' . $child_cat->name . '</a></li>';
                        }
                    }
                }
            }
        }

        return $taxonomy_html;
    }
}

if ( ! function_exists( 'corsen_core_get_filtered_price' ) ) {
    function corsen_core_get_filtered_price() {
        global $wpdb;

        $args = wc()->query->get_main_query();

        $tax_query  = isset( $args->tax_query->queries ) ? $args->tax_query->queries : array();
        $meta_query = isset( $args->query_vars['meta_query'] ) ? $args->query_vars['meta_query'] : array();

        foreach ( $meta_query + $tax_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new \WP_Meta_Query( $meta_query );
        $tax_query  = new \WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        $sql = "SELECT min( floor( price_meta.meta_value ) ) as min_price, max( round( price_meta.meta_value, 2 ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('_price')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $prices = $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.

        return [
            'min' => $prices->min_price,
            'max' => $prices->max_price
        ];
    }
}
