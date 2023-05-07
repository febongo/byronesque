<?php 

/**
 * IMPORTER FUNCTION
 * THIS IS ONLY INTENTED FOR BYRONEQUE 
 * IMPORT PRODUCTS USING CSV
 */

//  add_menu_page( 
//     'Import Products', 
//     'Import Products', 
//     'manage_options', 
//     'import-products', 
//     'import_products_page' 
// ); 
// add_menu_page('My Custom Page', 'My Custom Page', 'manage_options', 'my-top-level-slug');
function import_products_page() {

    $htmlMessage="";

    if ( isset( $_FILES['import_file'] ) && ! empty( $_FILES['import_file']['name'] ) ) { 
        $uploaded_file = $_FILES['import_file']; 
        $upload_overrides = array( 'test_form' => false ); 
        $movefile = wp_handle_upload( $uploaded_file, $upload_overrides ); 
        $file_path = $movefile['file']; 
    }    
    
    if ( isset( $file_path ) ) { 
        $file = fopen( $file_path, 'r' ); 
        if ( $file ) { 
            $parent_product_id;
            while ( ( $data = fgetcsv( $file ) ) !== false ) { 
                // get data from CSV and map to product fields

                $dataArray = assigndataToArray($data);
                if ( $dataArray['productType'] && $dataArray['title'] != "BRAND" ) {
                    // check if the product with the SKU already exists
                    $product_id = wc_get_product_id_by_sku( $dataArray['sku'] );
                    
                    // $csvCategory = explode(",",$dataArray['category']);
                    $productTypeString="product attribute";
                    if ($dataArray['productParent']) {
                        $productTypeString="product";
                    }

                    if ( !$product_id ) {
                        $product_id = saveDataFromCsv($dataArray);
                        $htmlMessage .= "<li>Created {$productTypeString} ({$dataArray['sku']})</li>";
                    } else {
                        $htmlMessage .= "<li>Updated {$productTypeString} ({$dataArray['sku']})</li>";
                        
                    }
                    if($dataArray['productParent']) $parent_product_id = $product_id;

                    updateDataFromCsv($parent_product_id,$product_id, $dataArray);


                } // END IF

            } // END WHILE LOOP
            fclose( $file );  // CLOSE FILE
        } 
    } 

    if ( isset( $_POST['submit'] ) ) { 
        echo '<div class="updated"><p>Products imported successfully!</p><ul>'.$htmlMessage.'</ul></div>'; 
    } 
?> 
    <div class="wrap"> 
        <h2>Import Products</h2> 
        <form method="post" enctype="multipart/form-data"> 
            <input type="file" name="import_file"> 
            <?php submit_button( 'Import Products' ); ?> 
        </form> 
    </div> 
<?php 
} 

// ASSIGN DATA TO FORMATTED ARRAY
function assigndataToArray($data){

    $separator='|';
    $cnt=0;
    return [
        "title"                 => $data[$cnt++],
        "brand"                 => explode($separator,$data[$cnt++]),
        "subHeader"             => $data[$cnt++],
        "sy"                    => $data[$cnt++],
        "price"                 => $data[$cnt++],
        "size"                  => explode($separator,$data[$cnt++]),
        "location"              => explode($separator,$data[$cnt++]),
        "loa"                   => $data[$cnt++],
        "clickThrough"          => $data[$cnt++],
        "byroSay"               => $data[$cnt++],
        "details"               => $data[$cnt++],
        "measurements"          => $data[$cnt++],
        "conditionNotes"        => $data[$cnt++],
        "shippingReturnPolicy"  => $data[$cnt++],
        "sku"                   => $data[$cnt++],
        "shippingWeight"        => $data[$cnt++],
        "shippingBox"           => explode("x",$data[$cnt++]),
        "commission"            => $data[$cnt++],
        "archivingFee"          => $data[$cnt++],
        "costOfGoods"           => $data[$cnt++],
        "category"              => explode($separator,$data[$cnt++]),
        "seoKeywords"           => $data[$cnt++],
        "seoTitle"              => $data[$cnt++],
        "seoDescription"        => $data[$cnt++],
        "productType"           => $data[$cnt++],
        "productParent"         => $data[$cnt++]
    ];
}

function saveDataFromCsv($dataArray){

    if (!$dataArray['productParent']) {
        return null;
    }

    // echo "TYPE: {$dataArray['productType']}";
    if ($dataArray['productType'] == 'variable') {
        // echo "Createing variable";
        $product = new WC_Product_Variable();
    } else {
        $product = new WC_Product_Simple();
        // echo "Createing simple";
    }

    $product->set_name( $dataArray['title'] );
    $product->set_short_description( $dataArray['subHeader'] );
    $product->set_regular_price( $dataArray['price'] );
    $product->set_description( $dataArray['details'] );

    // if($catArr)
    // $product->set_category_ids( $catArr );

    $product->set_sku( $dataArray['sku'] );
    $product->set_purchase_note( $dataArray['conditionNotes'] );
    $product->set_weight( $dataArray['shippingWeight'] );

    $product->set_length( $dataArray['shippingBox'][0] );
    $product->set_width( $dataArray['shippingBox'][1] );
    $product->set_height( $dataArray['shippingBox'][2] );

    // shippingBox


    $product->save();

    return $product->get_id();
}

// UPDATE DATA 
function updateDataFromCsv($parent_product_id, $product_id, $dataArray){

    /**
     * Check parent if 1 | 0
     * if isParent then save categories, locations, brands, and custom fields
     * else save variable variations
     **/ 
    // echo "Product parent: {$dataArray['productParent']}";


    if ($dataArray['productParent']) {
        // save main information
        // echo "isParent";
        // save ACF FIELDS
        update_field( 'byronesque_say', $dataArray['byroSay'], $product_id ); 
        update_field( 'product_details', $dataArray['details'], $product_id ); 
        update_field( 'measurements', $dataArray['measurements'], $product_id ); 
        update_field( 'condition_and_', $dataArray['conditionNotes'], $product_id ); 
        update_field( 'shipping_and_return_policy', $dataArray['shippingReturnPolicy'], $product_id ); 

        // UPDATE PRODUCT EXTRA FIELDS
        if ($dataArray['commission']) 
            update_post_meta( $product_id, '_product_commission', $dataArray['commission'] );
        
        if ($dataArray['archivingFee']) 
            update_post_meta( $product_id, '_product_archiving_fee', $dataArray['archivingFee'] );
        
        if ($dataArray['costOfGoods'])
            update_post_meta( $product_id, '_product_cost_of_goods', $dataArray['costOfGoods'] );
        
        // UPDATE SEO TAGS
        if ($dataArray['costOfGoods'])
            update_post_meta($product_id, '_yoast_wpseo_title', $dataArray['seoTitle']);

        if ($dataArray['costOfGoods'])
            update_post_meta($product_id, '_yoast_wpseo_metadesc', $dataArray['seoDescription']);

        if ($dataArray['costOfGoods'])
            update_post_meta($product_id, '_yoast_wpseo_focuskw', $dataArray['seoKeywords']);

        // add size variations
        if ( sizeof($dataArray['size']) > 0 && $dataArray['productParent']) {
            $sizeAttribute = get_taxonomy( 'Size' );
            if ( !$sizeAttribute ) {
                $sizeAttribute = wc_create_attribute( array(
                    'name' => 'Size',
                    'slug' => 'size',
                    'type' => 'select',
                    'order_by' => 'menu_order',
                    'has_archives' => true,
                ) );
            }

            $attributes_data = array(
                array(
                    'name'=>'Size',  
                    'options'=> $dataArray['size'], 
                    'visible' => 1, 
                    'variation' => 1 
                )
            );
            // loop through options
            if( sizeof($attributes_data) > 0 ){
                $attributes = array(); // Initializing
        
                // Loop through defined attribute data
                foreach( $attributes_data as $key => $attribute_array ) {
                    if( isset($attribute_array['name']) && isset($attribute_array['options']) ){
                        // Clean attribute name to get the taxonomy
                        $taxonomy = 'pa_' . wc_sanitize_taxonomy_name( $attribute_array['name'] );
        
                        $option_term_ids = array(); // Initializing
        
                        // Loop through defined attribute data options (terms values)
                        foreach( $attribute_array['options'] as $option ){
                            if( term_exists( $option, $taxonomy ) ){
                                // Save the possible option value for the attribute which will be used for variation later
                                // echo "saving ";
                                wp_set_object_terms( $product_id, $option, $taxonomy, true );
                                // echo "saved";
                                // Get the term ID
                                $option_term_ids[] = get_term_by( 'name', $option, $taxonomy )->term_id;
                            }
                        }
                    }
                    // Loop through defined attribute data
        
                    $attributes[$taxonomy] = array(
                        'name'          => $taxonomy,
                        'value'         => $option_term_ids, // Need to be term IDs
                        'position'      => $key + 1,
                        'is_visible'    => $attribute_array['visible'],
                        'is_variation'  => $attribute_array['variation'],
                        'is_taxonomy'   => '1'
                    );
                }
                // Save the meta entry for product attributes
                // echo "<p>update post meta</p>";
                update_post_meta( $product_id, '_product_attributes', $attributes );
            }
        }

        // add location
        if ( sizeof($dataArray['location']) > 0 ) {
            $locationIds=[];
            foreach( $dataArray['location'] as $location ) {
                // get location
                $locationTerm = get_term_by('name', $location, 'location');

                if (!$locationTerm) {
                    $locationTerm = wp_insert_term(
                        $location,
                        'location'
                    );
                }
                // $location_id = $locationTerm->term_id;
                $locationIds[] = $locationTerm->term_id;
            }
            wp_set_object_terms( $product_id, $locationIds, 'location' );
        }

        // add brand
        if ( sizeof($dataArray['brand']) > 0 ) {
            $designIds=[];
            foreach( $dataArray['brand'] as $designer ) {
                // get location
                $designerTerm = get_term_by('name', $designer, 'product_designer');

                if (!$designerTerm) {
                    $designerTerm = wp_insert_term(
                        $designer,
                        'product_designer'
                    );
                }
                // $location_id = $locationTerm->term_id;
                $designIds[] = $designerTerm->term_id;
            }
            wp_set_object_terms( $product_id, $designIds, 'product_designer' );
        }

        // add category
        if ( sizeof($dataArray['category']) > 0 ){
            $cat_ids=[];
            foreach($dataArray['category'] as $category){
    
                $cat  = get_term_by('name', $category , 'product_cat');
                if (!$cat) {
                    // If the category doesn't exist, create it
                    $cat = wp_insert_term(
                      $category,
                      'product_cat'
                    );
                }
                $cat_ids[]=$cat->term_id;
            }
            wp_set_object_terms( $product_id, $cat_ids, 'product_cat' );
        }

        // echo "<p>End of simple save</p>";
    } else {
        // echo "<P>notParent</P>";

        // echo "<p>parent ID: {$parent_product_id}</p>";
        // save variations for variables

        // The variation data
        $variation_data =  array(
            'attributes' => array(
                'size'  => $dataArray['size'][0]
            ),
            'sku'           => $dataArray['sku'],
            'regular_price' => $dataArray['price'],
            'stock_qty'     => 1,
        );

        // The function to be run
        create_product_variation( $parent_product_id, $variation_data );

    } // END ELSE
 
}


function create_product_variation( $product_id, $variation_data ){
    // Get the Variable product object (parent)
    $product = wc_get_product($product_id);

    $variation_post = array(
        'post_title'  => $product->get_name(),
        'post_name'   => 'product-'.$product_id.'-variation',
        'post_status' => 'publish',
        'post_parent' => $product_id,
        'post_type'   => 'product_variation',
        'guid'        => $product->get_permalink()
    );

    // Creating the product variation
    $variation_id = wp_insert_post( $variation_post );

    // Get an instance of the WC_Product_Variation object
    $variation = new WC_Product_Variation( $variation_id );

    // Iterating through the variations attributes
    foreach ($variation_data['attributes'] as $attribute => $term_name )
    {
        $taxonomy = 'pa_'.$attribute; // The attribute taxonomy

        // If taxonomy doesn't exists we create it (Thanks to Carl F. Corneil)
        if( ! taxonomy_exists( $taxonomy ) ){
            register_taxonomy(
                $taxonomy,
               'product_variation',
                array(
                    'hierarchical' => false,
                    'label' => ucfirst( $attribute ),
                    'query_var' => true,
                    'rewrite' => array( 'slug' => sanitize_title($attribute) ), // The base slug
                ),
            );
        }

        // Check if the Term name exist and if not we create it.
        if( ! term_exists( $term_name, $taxonomy ) )
            wp_insert_term( $term_name, $taxonomy ); // Create the term

        $term_slug = get_term_by('name', $term_name, $taxonomy )->slug; // Get the term slug

        // Get the post Terms names from the parent variable product.
        $post_term_names =  wp_get_post_terms( $product_id, $taxonomy, array('fields' => 'names') );

        // Check if the post term exist and if not we set it in the parent variable product.
        if( ! in_array( $term_name, $post_term_names ) )
            wp_set_post_terms( $product_id, $term_name, $taxonomy, true );

        // Set/save the attribute data in the product variation
        update_post_meta( $variation_id, 'attribute_'.$taxonomy, $term_slug );
    }

    ## Set/save all other data

    // SKU
    if( ! empty( $variation_data['sku'] ) )
        $variation->set_sku( $variation_data['sku'] );

    // Prices
    if( empty( $variation_data['sale_price'] ) ){
        $variation->set_price( $variation_data['regular_price'] );
    } else {
        $variation->set_price( $variation_data['sale_price'] );
        $variation->set_sale_price( $variation_data['sale_price'] );
    }
    $variation->set_regular_price( $variation_data['regular_price'] );

    // Stock
    if( ! empty($variation_data['stock_qty']) ){
        $variation->set_stock_quantity( $variation_data['stock_qty'] );
        $variation->set_manage_stock(true);
        $variation->set_stock_status('');
    } else {
        $variation->set_manage_stock(false);
    }
    
    $variation->set_weight(''); // weight (reseting)

    $variation->save(); // Save the data
}



