<?php 

// Creating the widget
class wpb_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget', 
        
        // Widget name will appear in UI
        __('Byronesque Search', 'wpb_widget_domain'), 
        
        // Widget description
        array( 'description' => __( 'Realtime product search', 'wpb_widget_domain' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        // if ( ! empty( $title ) )
        // echo $args['before_title'] . $title . $args['after_title'];
        
        // This is where you run the code and display the output
        //echo __( 'Search Area Here', 'wpb_widget_domain' );
        ?>
            <div id="bn-search" class="search-area">
                <span class="menu-nav menu-nav-no-side" 
                    data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_b.svg'?>" 
                    data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.svg'?>" 
                    style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.svg'?>')">
                </span>
                <div class="bn-search-form">
                    <div id="bn-search-wrap" >
                        <span id="search-btn" style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.svg'?>')"></span>
                        <input id="bn-search-value" type="text" placeholder="Search Products" value="">
                        <span id="bn-search-close" class="bn-close-btn" style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/close.png'?>')"></span>
                    </div>
                    <div id="byro-search-result"></div>
                </div>
            </div>
        <?php
        // END FRONT END DISPLAY
        echo $args['after_widget'];
    }
     
    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }
        // Widget admin form
        ?>
        <p>Byronesque Search Function</p>
        <?php
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
     
    // Class wpb_widget ends here
} 


/*  Search action
/*-------------------*/

function search_product() {

    global $wpdb, $woocommerce;

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

        $keyword = sanitize_text_field($_POST['keyword']);

        // SEARCH PRODUCTS
        $search_term_like = '%' . $wpdb->esc_like($keyword) . '%';

        $querystr = "
            SELECT DISTINCT {$wpdb->posts}.ID, {$wpdb->posts}.post_title, {$wpdb->posts}.post_content, {$wpdb->terms}.name AS category_name, {$wpdb->terms}.slug AS category_slug, GROUP_CONCAT(DISTINCT {$wpdb->terms}.name SEPARATOR ', ') AS tag_names, GROUP_CONCAT(DISTINCT {$wpdb->terms}.slug SEPARATOR ', ') AS tag_slugs
            FROM {$wpdb->posts}
            LEFT JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)
            LEFT JOIN {$wpdb->term_taxonomy} ON ({$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->term_taxonomy}.term_taxonomy_id)
            LEFT JOIN {$wpdb->terms} ON ({$wpdb->term_taxonomy}.term_id = {$wpdb->terms}.term_id)
            WHERE {$wpdb->posts}.post_status = 'publish'
            AND {$wpdb->posts}.post_type = 'product'
            AND ({$wpdb->posts}.post_title LIKE '{$search_term_like}' OR {$wpdb->posts}.post_content LIKE '{$search_term_like}' OR {$wpdb->terms}.name LIKE '{$search_term_like}' OR {$wpdb->terms}.slug LIKE '{$search_term_like}' OR {$wpdb->terms}.name IN (SELECT DISTINCT {$wpdb->terms}.name FROM {$wpdb->terms} INNER JOIN {$wpdb->term_taxonomy} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id WHERE {$wpdb->term_taxonomy}.taxonomy = 'product_tag' AND {$wpdb->terms}.name LIKE '{$search_term_like}'))
            GROUP BY {$wpdb->posts}.ID
            LIMIT 4
        ";

        $query_results = $wpdb->get_results($querystr);

        // SEARCH DESIGNERS
        $designers = termSearch($keyword,'product_designer');

        $designerStr = "<div class='designers-search searchedBlock'><h3>Designers</h3>";
        if (!empty($designers)) {
            $designerStr .= "<ul>";
            foreach($designers as $designer) {
                $designerStr .= "<li><a href='".get_permalink( $designer->ID )."'>".$designer->name."</a></li>";
            }
            $designerStr .= "</ul></div>";
        } else {
            $designerStr = "";
        }

        // SEARCH EDITORIAL
        $argsEditorials = [
            'post_type' => 'post',
            's' => $keyword,
            'category' => 89,
            'numberposts'      => 2,
            'orderby'          => 'date',
            'order'            => 'DESC',
            // Rest of your arguments
        ];

        $editorialSearch = get_posts( $argsEditorials );
        
        $editorialStr = "<div class='editorial-search searchedBlock'><h3>Editorials</h3>";
        if (!empty($editorialSearch)) {
            $editorialStr .= "<ul>";
            foreach($editorialSearch as $editorial) {
                // $editorialPost = get_post( $editorial );

                // $excerpt = strip_tags($editorial->post_content);
                // if (strlen($excerpt) > 100) {
                // $excerpt = substr($excerpt, 0, 100);
                // $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
                // $excerpt .= '...';
                // }

                $excerpt = get_the_excerpt($editorial->ID);

                $editorialStr .= "<li>
                                    <a href='".get_permalink( $editorial->ID ).
                                        "'>".
                                        get_the_post_thumbnail( $editorial->ID, 'full' ) .
                                        "<h4>". $editorial->post_title . "</h4>" .
                                        "<p>".$excerpt."</p>".
                                    "</a></li>";
            }
            $editorialStr .= "</ul><a href='#' class='btn-search'>BROWSE EDITORIAL</a></div>";
        } else {
            $editorialStr = "";
        }

        if (!empty($query_results)) {

            $output = '';

            foreach ($query_results as $result) {

                $price      = get_post_meta($result->ID,'_regular_price');
                $price_sale = get_post_meta($result->ID,'_sale_price');
                $currency   = get_woocommerce_currency_symbol();
                $product = new WC_Product($result->ID);

                $pexcerpt = strip_tags($result->post_content);
                if (strlen($pexcerpt) > 100) {
                    $pexcerpt = substr($pexcerpt, 0, 100);
                    $pexcerpt = substr($pexcerpt, 0, strrpos($excerpt, ' '));
                    $pexcerpt .= '...';
                }
                $subHeaderTitle = $product->short_description;
                // echo "short >> $product->short_description";
                $output .= '<li>';
                    $output .= '<a href="'.get_post_permalink($result->ID).'">';
                        $output .= '<div class="product-image">';
                            $output .= '<img src="'.esc_url(get_the_post_thumbnail_url($result->ID,'full')).'">';
                        $output .= '</div>';
                        $output .= '<div class="product-data">';
                            $output .= '<h6>'.$result->post_title.'</h6>';
                            $output .= '<p>'.($subHeaderTitle ? $subHeaderTitle : $pexcerpt).'</p>';
                            if (!empty($price)) {
                                $output .= '<div class="product-price">';
                                    $output .= $product->get_price_html();
                                $output .= '</div>';
                            }
 

                        $output .= '</div>';
                        $output .= '</a>';
                $output .= '</li>';
            }

            if (!empty($output)) {
                echo $designerStr;
                echo "<div class='product-search searchedBlock'><h3>Products</h3><ul>";
                echo $output;
                echo "</ul><a href='".home_url()."/shop' class='btn-search'>VIEW ALL PRODUCTS</a></div>";
                echo $editorialStr;
            }
        }
    }

    die();
}


    

add_action( 'wp_ajax_search_product', 'search_product' );
add_action( 'wp_ajax_nopriv_search_product', 'search_product' );
