<?php
// Our custom post type function
function create_posttype() {
  
    register_post_type( 'product_request',
        array(
            'labels' => array(
                'name' => __( 'Product Request' ),
                'singular_name' => __( 'Request' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'product-request'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'custom-fields','thumbnail' ),
            'menu_icon' => 'dashicons-format-aside',
        )
    );

    register_post_type( 'product_selling',
        array(
            'labels' => array(
                'name' => __( 'Product Selling' ),
                'singular_name' => __( 'Selling' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'product-selling'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'custom-fields','thumbnail' ),
            'menu_icon' => 'dashicons-format-aside',
        )
    );

}

  
function create_designer_taxonomy() {
    
    $labels = array(
        'name'                       => 'Designers',
        'singular_name'              => 'Designer',
        'menu_name'                  => 'Designers',
        'all_items'                  => 'All Designers',
        'parent_item'                => 'Parent Designer',
        'parent_item_colon'          => 'Parent Designer:',
        'new_item_name'              => 'New Designer Name',
        'add_new_item'               => 'Add New Designer',
        'edit_item'                  => 'Edit Designer',
        'update_item'                => 'Update Designer',
        'separate_items_with_commas' => 'Separate Designer with commas',
        'search_items'               => 'Search Designers',
        'add_or_remove_items'        => 'Add or remove Designer',
        'choose_from_most_used'      => 'Choose from the most used Designers',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );  
    register_taxonomy( 'product_designer', 'product', $args );
  
}

function create_brand_taxonomy() {

    $labels = array(
        'name'                       => 'Brands',
        'singular_name'              => 'Brand',
        'menu_name'                  => 'Brands',
        'all_items'                  => 'All Brands',
        'parent_item'                => 'Parent Brand',
        'parent_item_colon'          => 'Parent Brand:',
        'new_item_name'              => 'New Brand Name',
        'add_new_item'               => 'Add New Brand',
        'edit_item'                  => 'Edit Brand',
        'update_item'                => 'Update Brand',
        'separate_items_with_commas' => 'Separate Brand with commas',
        'search_items'               => 'Search Brands',
        'add_or_remove_items'        => 'Add or remove Brands',
        'choose_from_most_used'      => 'Choose from the most used Brands',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'product_brand', 'product', $args );
  
}

function create_editorial_taxonomy() {

    $labels = array(
        'name'                       => 'Editorials',
        'singular_name'              => 'Editorial',
        'menu_name'                  => 'Editorials',
        'all_items'                  => 'All Editorials',
        'parent_item'                => 'Parent Editorial',
        'parent_item_colon'          => 'Parent Editorial:',
        'new_item_name'              => 'New Editorial Name',
        'add_new_item'               => 'Add New Editorial',
        'edit_item'                  => 'Edit Editorial',
        'update_item'                => 'Update Editorial',
        'separate_items_with_commas' => 'Separate Editorial with commas',
        'search_items'               => 'Search Editorials',
        'add_or_remove_items'        => 'Add or remove Editorials',
        'choose_from_most_used'      => 'Choose from the most used Editorials',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'editorials', 'post', $args );
  
}

function side_menu_nav() {
    register_nav_menu('byronesque-side-menu',__( 'Byronesque Side Navigation' ));
    register_nav_menu('byronesque-my-shop-menu1',__( 'Byronesque My Shop Navigation 1' ));
    register_nav_menu('byronesque-my-shop-menu2',__( 'Byronesque My Shop Navigation 2' ));
    register_nav_menu('byronesque-my-shop-menu3',__( 'Byronesque My Shop Navigation 3' ));
    register_nav_menu('byronesque-account-settings',__( 'Byronesque Account Settings' ));
}
add_action( 'init', 'side_menu_nav' );

// Hooking up theme setup
add_action( 'init', 'create_posttype' );
// add_action( 'init', 'create_brand_taxonomy');
add_action( 'init', 'create_designer_taxonomy');
// add_action( 'init', 'create_editorial_taxonomy');

?>