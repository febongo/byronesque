<?php
/*
Plugin Name: Byronesque Shop Functions
Description: Byronesque custom functions such as searching and mini cart functions
Author: Felix Bongo (febongo@gmail.com)
Version: 1.0
*/

// register jquery and style on initialization
add_action('init', 'register_script');
function register_script() {
    wp_register_script( 'bn_scripts', plugins_url('/assets/scripts.js', __FILE__), array('jquery'), '3.3.2', true );
    wp_register_script( 'isotope', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js', '', true );
    wp_localize_script(
        'bn_scripts',
        'opt',
        array(
            'ajaxUrl'   => admin_url('admin-ajax.php'),
            'noResults' => esc_html__( 'No products found', 'textdomain' ),
            )
        );
        
    wp_register_style( 'bn_styles', plugins_url('/assets/styles.css', __FILE__), false, '1.0.0', 'all');
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style');

function enqueue_style(){
    wp_enqueue_script('isotope');
    wp_enqueue_script('bn_scripts');
    
    wp_enqueue_style( 'bn_styles' );
}

// SHARED FUNCTIONS
function getUserGeoCountry(){
    $geo      = new WC_Geolocation(); // Get WC_Geolocation instance object
    $user_ip  = $geo->get_ip_address(); // Get user IP
    $user_geo = $geo->geolocate_ip( $user_ip ); // Get geolocated user data.
    $country  = $user_geo['country']; // Get the country code
    return WC()->countries->countries[ $country ]; // return the country name

}

// We get a list taxonomies on the search box
function termSearch($search_text, $term){

    $args = array(
        'taxonomy'      => array( $term ), 
        'orderby'       => 'id', 
        'order'         => 'ASC',
        'hide_empty'    => true,
        'fields'        => 'all',
        'name__like'    => $search_text
    ); 
    
    $terms = get_terms( $args );
    
    return $terms;
    
}



// INCLUDES
include('countries.php');
include('postTypes/post_types.php');
include('widgets/search.php');
include('widgets/currency_switcher.php');
include('widgets/burger_menu.php');
include('widgets/account.php');
include('widgets/cart.php');
include('widgets/my_shop.php');

// register widgets
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
    register_widget( 'wpb_widget_currency' );
    register_widget( 'wpb_widget_menu' );
    register_widget( 'wpb_widget_cart' );
    register_widget( 'wpb_widget_account' );
    register_widget( 'wpb_widget_my_shop' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


// REDIRECT WP LOGIN TO CUSTOM PAGE
add_action('init','custom_login');
function custom_login(){
 global $pagenow;
 if( 'wp-login.php' == $pagenow ) {
    //  check if logout 
    if($_GET['loggedout'] ){
        wp_redirect(home_url());
        exit();
    }
    
    // if(!$_GET['loggedout'] ){
    //     wp_redirect(home_url().'/my-account/');
    //     exit();
    // }
  
  
 }
}

add_action('wp_head', 'add_css_head');
function add_css_head() {
   if ( is_user_logged_in() ) {
   ?>
      <style>
          #wpadminbar .quicklinks .menupop ul li#wp-admin-bar-new-e-landing-page, 
          #wpadminbar .quicklinks .menupop ul li#wp-admin-bar-new-elementor_library,
          #wpadminbar .quicklinks .menupop ul li#wp-admin-bar-new-media,
          #wpadminbar .quicklinks .menupop ul li#wp-admin-bar-new-shop_coupon{
              display: none !important;
          }

      </style>
   <?php
   }

}

add_action('admin_head', 'add_custom_css_admin');
function add_custom_css_admin() { ?>



   <style id="custom-admin-css">
          p[class*="wcu_currency_unavailable"] {
              display: none;
          }
      </style>
   <?php
}

add_filter('the_title', 'modifyFetchTitleAddDescription', 20, 2);

function modifyFetchTitleAddDescription($the_title, $id)
{

  if (get_post_type($id) == 'product' && !is_admin()) : // runs only on the shop page

    $the_title = '<span class="product-title" style="font-style:inherit; font-size:inherit; color: inherit;display:block">'.$the_title.'</span>';
    $post = get_post( $id );

    $the_title .= '<span class="product-description">'.wp_trim_words( $post->post_content, 10 ).'</span>';

  endif;

  return $the_title;
}

/* Create Buy Now Button dynamically after Add To Cart button */
function add_content_after_addtocart() {
    
	// get the current post/product ID
	$current_product_id = get_the_ID();

	// get the product based on the ID
	$product = wc_get_product( $current_product_id );

	// get the "Checkout Page" URL
	$checkout_url = WC()->cart->get_checkout_url();

	// run only on simple products
	if( $product->is_type( 'simple' ) ){
		echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="single_add_to_cart_button button alt wp-element-button">Buy Now</a>';
		//echo '<a href="'.$checkout_url.'" class="buy-now button">Buy Now</a>';
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart' );


// CREATE FILTER SHORTCODE 
function shopFilters() {

    if (is_product_category()) { 
        $cat = get_queried_object();
        ?>
        <div class="qodef-page-title qodef-m qodef-title--standard qodef-alignment--left qodef-vertical-alignment--header-bottom">
            <div class="qodef-m-inner">
                <div class="qodef-m-content qodef-content-full-width ">
                    <h6 class="qodef-m-title entry-title"><?= $cat->name ?></h6>
                </div>
            </div>
        </div>
        <div style="display:flex;width: 100%;justify-content: center;padding: 40px 0 80px 0;">
            <section class="elementor-section elementor-top-section elementor-element elementor-element-4952c17 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="4952c17">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e0e2581" data-id="e0e2581" data-element_type="column">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-element-312765a elementor-widget elementor-widget-qi_addons_for_elementor_section_title" data-id="312765a" data-element_type="widget" data-widget_type="qi_addons_for_elementor_section_title.default">
                                <div class="elementor-widget-container">
                                    <div class="qodef-shortcode qodef-m  qodef-qi-section-title  qodef-decoration--italic   qodef-subtitle-icon--left">
                                        <h1 class="qodef-m-title">
                                        Buy it.<br>  Wear it for a long time.<br>  If you want it.<br>  We can find it.	</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php } ?>
    <div class="filter-container">
        <a href="/product-category/new-arrivals/" class="btn-filter <?= is_product_category('new-arrivals') ? 'active' : '' ?>">NEW ARRIVALS</a>
        <a href="/product-category/runway/" class="btn-filter <?= is_product_category('runway') ? 'active' : '' ?>">RUNWAY</a>
        <span class="browseBy">FILTER PRODUCTS: <span class="filter-icon"></span></span>
        <div class="filter-list-container">
            <div class="close-wrap"><span class="close-filter"></span></div>
            <div class="filters">
                <h5>Designer</h5>
                <div class="filters-list">
                    <?php
                    $strBrandList="";
                    $brands = get_terms( array(
                        'taxonomy' => 'product_designer',
                        'hide_empty' => false,
                    ) );
                    $counterSeparator=0;
                    foreach($brands as $key=>$brand){
                        $counterSeparator ++;
                        if ($counterSeparator == 1){
                            $strBrandList .= "<ul>";
                        }
                        
                        $strBrandList .= "<li>
                            <label class='chk-container'>$brand->name
                                <input type='checkbox' name='designers' value='$brand->slug'>
                                <span class='checkmark'></span>
                            </label>
                        </li>";
                        
                        if ($counterSeparator == 8){
                            $strBrandList .= "</ul>";
                            $counterSeparator=0;
                        }
                    }
                    
                    echo $strBrandList."</ul>"
                    ?>
                    
                </div>
            </div>
            <div class="filters">
                <h5>Category</h5>
                <div class="filters-list">
                <?php
                    $strCategoryList="";
                    $locations = get_nav_menu_locations();
                    $menu2 = wp_get_nav_menu_object( $locations[ 'byronesque-my-shop-menu2' ] );
                    $all_categories = wp_get_nav_menu_items( $menu2->term_id, array( 'order' => 'DESC' ) );
    
                    $counterSeparator = 0;
                    foreach($all_categories as $key=>$category){
                        $slug = basename($category->url);
                        $counterSeparator ++;
                        if ($counterSeparator == 1){
                            $strCategoryList .= "<ul>";
                        }
                        
                        $strCategoryList .= "<li>
                            <label class='chk-container'>$category->title
                                <input type='checkbox' name='category' value='$slug'>
                                <span class='checkmark'></span>
                            </label>
                        </li>";
                        
                        if ($counterSeparator == 8){
                            $strCategoryList .= "</ul>";
                            $counterSeparator=0;
                        }
                    }
                    
                    echo $strCategoryList."</ul>"
                ?>
                    
                </div>
            </div>
            <div class="filter-btns">
                    <a id="filter-products" class="btn btn-filter-products" href="<?= get_permalink( wc_get_page_id( 'shop' ) ) ?>">BROWSE</a>
            </div>
        </div>
    </div>
    <?php 
    
}
    // register shortcode
add_shortcode('shop-filters', 'shopFilters');


// add ajax to fetch images info 
function get_image_meta() {
    if (isset($_POST['imgurl']) && !empty($_POST['imgurl'])) {
        $url = $_POST['imgurl'];
        // REMOVE ADDED URI
        $url = str_replace("i0.wp.com/","",$url);
        $url = (explode("?",$url))[0];
        
        $id  = attachment_url_to_postid( $url );

        $attachment = get_post( $id );
        $imageData = array(
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink( $attachment->ID ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );

        if ($attachment->post_content && $attachment->post_title) {
            echo "<p class='js-home-fold-description'>
                    <span class='js-home-title'>".$attachment->post_title."</span>
                    <span class='js-home-desc'>".$attachment->post_content."</span>
                </p>";
        }
        

        // var_dump($imageData);
    }

    die();
}
add_action( 'wp_ajax_get_image_meta', 'get_image_meta' );
add_action( 'wp_ajax_nopriv_get_image_meta', 'get_image_meta' );

// function add_placeholder_text_to_tml_fields() {
//     if ( $user_login = tml_get_form_field( 'register', 'user_login' ) ) {
//         $user_login->add_attribute( 'placeholder', 'Email address*' );
//     }
// }
// add_action( 'init', 'add_placeholder_text_to_tml_fields' );

?>