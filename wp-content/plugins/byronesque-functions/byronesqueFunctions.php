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

include('inc/productExtraFields.php');
include('inc/importer.php');
// include('account-pages/customAccountpages.php');

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


// ------------------
// 1. Add request EndPoint
function add_request_selling_request() {
    add_rewrite_endpoint( 'customer-request', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'customer-selling', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'address-book', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'address-book-add', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'address-book-edit', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'add_request_selling_request' );
  
// ------------------
// 2. Add new query var
  
function request_query_vars( $vars ) {
    $vars[] = 'customer-request';
    $vars[] = 'customer-selling';
    $vars[] = 'address-book';
    $vars[] = 'address-book-add';
    $vars[] = 'address-book-edit';
    return $vars;
}
  
add_filter( 'query_vars', 'request_query_vars', 0 );
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function add_customer_request_links_my_account( $items ) {
    // $items['customer-request'] = 'Request';
    // $items['customer-selling'] = 'Selling';
    // var_dump($items);
    $list = [
        'dashboard' => 'Account',
        'edit-account' => 'Preferences',
        'orders' => 'Orders & Returns',
        'customer-request' => 'Requests',
        'customer-selling' => 'Selling',
        'address-book' => 'Address Book',
        'customer-logout' => 'Logout'
    ];

    return $list;
}
  
add_filter( 'woocommerce_account_menu_items', 'add_customer_request_links_my_account' );
  
// ------------------
// 4. Add content to the new tab
  
function add_request_contents() {
   echo '<h3>Requests</h3>';
   echo do_shortcode( ' [customer-request type="request"] ' );
}
  
add_action( 'woocommerce_account_customer-request_endpoint', 'add_request_contents' );

function add_selling_contents() {
    echo '<h3>Selling</h3>';
    echo do_shortcode( ' [customer-request type="selling"]' );
 }
   
add_action( 'woocommerce_account_customer-selling_endpoint', 'add_selling_contents' );

function address_book_contents() {
    global $wpdb;

    echo '<h3>Address Book</h3>';
   
    $querystr = "
                SELECT *
                FROM QYp_dsabafw_billingadress
                WHERE userid=".get_current_user_id()."
                ORDER BY Defalut DESC
                ";
    $query_results = $wpdb->get_results($querystr);


    if ($query_results) {
        // var_dump($data);
        echo "<ul class='address-book-list'>";
        foreach($query_results as $address){ 
            $address->userdata = unserialize($address->userdata);
            // echo "<pre>";
            // var_dump($address);
            // echo "</pre>";
            echo "<div class='address-wrap'>";
            if ($address->Defalut == 1) echo "<p class='default'>".($address->type == "shipping" ? "Prefered delivery address" : "Prefered billing address")."</p>"; 
                echo "<div class='addresses-contents'>";
                    echo "<p>".$address->userdata[$address->type.'_first_name']. " " .$address->userdata[$address->type.'_last_name']. "</p>";
                    echo "<p>".$address->userdata[$address->type.'_address_1']."</p>";
                    echo "<p>".$address->userdata[$address->type.'_postcode']. " " .$address->userdata[$address->type.'_state'] . ", "  .$address->userdata[$address->type.'_country'] .  "</p>";
                echo "</div>";
                echo "<div class='addresses-actions'>";
                    echo "<p class='actions-links'><span><a href='/my-account/address-book-edit/?address-id=".$address->id."'>Edit</a>".
                        "<span class='removeAddress' data-address-id='".$address->id."' data-action='remove'>Remove</span>" . 
                        (!$address->Defalut ? "<span class='setDefault' data-address-id='".$address->id."' data-address-type='".$address->type."'>Set as default ".($address->type == "shipping" ? "delivery" : "billing")."</span>" : "")
                        ."</p>";
                echo "</div>";
            echo "</div>";
        }
        echo "</ul>";

        echo "<a href='/my-account/address-book-add/' class='button wc-forward wp-element-button'>Add Addresses</a>";
    } else {
        echo "<p>Please add prefered address.</p>";

        echo "<a href='/my-account/address-book-add/' class='button wc-forward wp-element-button'>Add Addresses</a>";
    }
 }
   
add_action( 'woocommerce_account_address-book_endpoint', 'address_book_contents' );

function address_book_add() {

    global $wpdb;

            // $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 0), array('userid' => '2', 'type' => 'billing'));


    echo '<h3>Address Book</h3>';

    if ($_POST) {
        echo "post request";
        echo "Billing ".$_POST['defaultBilling'];
        echo "Shipping ".$_POST['defaultShipping'];
        // save fields
        $isdBilling=($_POST['defaultBilling'] ? 1 : 0 );
        $isdShipping=($_POST['defaultShipping'] ? 1 : 0 );
        $addressFields = [
            '_first_name'=>'',
            '_last_name'=>'',
            '_country'=>'',
            '_address_1'=>'',
            '_city'=>'',
            '_postcode'=>'',
            '_phone'=>'',
        ];

        $shippingData=["reference_field"=>$_POST['_first_name'].' '.$_POST['_last_name']]; 
        $billingdata=["reference_field"=>$_POST['_first_name'].' '.$_POST['_last_name']]; 
        foreach($addressFields as $key=>$field){
            $value = $_POST[$key] ? $_POST[$key] : '';
            $shippingData['shipping'.$key] = $value;
            $billingdata['billing'.$key] = $value;
        }
        
        // if set to default
        // remove old default
        if ($isdBilling) {
            $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 0), array('userid' => get_current_user_id(), 'type' => 'billing'));
        }
        if ($isdShipping) {
            $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 0), array('userid' => get_current_user_id(), 'type' => 'shipping'));
        }

        // save shipping and billing address

        $wpdb->insert('QYp_dsabafw_billingadress', array(
            'userid' => get_current_user_id(),
            'userdata' => serialize($shippingData),
            'type' => 'shipping', 
            'Defalut' => $isdShipping, 
        ));
        // $shippingId = $wpdb->insert_id;
        $wpdb->insert('QYp_dsabafw_billingadress', array(
            'userid' => get_current_user_id(),
            'userdata' => serialize($billingdata),
            'type' => 'billing', 
            'Defalut' => $isdBilling, 
        ));
        // $billingId = $wpdb->insert_id;

        
    // } catch (Exception $e) {
    //     var_dump($e);
    // }
        header('Location: /my-account/address-book/');
        die;
    }

    $countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
    // var_dump($countries);
    ?>
    <form method="post">
        <h4>Add address (shipping/billing)</h4>
    <div class="address-book">
        <p class="form-row form-row-first" id="_first_name_field" data-priority="10">
            <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text " name="_first_name" id="_first_name" placeholder="Name*" value="" required>
            </span>
        </p>
        <p class="form-row form-row-last" id="_last_name_field" data-priority="20">
            <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text " name="_last_name" id="_last_name" placeholder="Last name*" value="" required>
            </span>
        </p>
        <p class="form-row form-row-wide" id="_country_field" data-priority="40">
            <span class="woocommerce-input-wrapper">
                <select name="_country" id="_country" class="country_to_state country_select " data-placeholder="Country*" data-label="Country / Region" tabindex="-1" aria-hidden="true" required>
                    <option value="">Select a country / region…</option>
                    <?php foreach ($countries as $key => $country) : ?>
                        <option value="<?= $key ?>"><?= $country ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </p>
        <p class="form-row form-row-wide" id="_address_1_field" data-priority="50">
            <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text " name="_address_1" id="_address_1" placeholder="Street address*" value="" data-placeholder="Street address*" required>
            </span>
        </p>
        <p class="form-row form-row-wide" id="_city_field" >
            <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text " name="_city" id="_city" placeholder="City*" value="" data-placeholder="City*" required>
            </span>
        </p>
        <p class="form-row form-row-wide" id="_postcode_field">
            <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text " name="_postcode" id="_postcode" placeholder="Zip Code*" value="" data-placeholder="Zip Code*" required>
            </span>
        </p>
        <p class="form-row form-row-wide" id="_phone_field" data-priority="">
            <span class="woocommerce-input-wrapper">
                <input type="tel" class="input-text " name="_phone" id="_phone" placeholder="Phone(ex. +33 123 45 67)*" value="" required>
            </span>
        </p>
    </div>
    <div class="submit-btn">
        <div>
        <label class='chk-container'>Save as default shipping address
            <input type='checkbox' name='defaultShipping' value="1">
            <span class='checkmark'></span>
        </label>
                    </div>
                    <div>
        <label class='chk-container'>Save as default billing address
            <input type='checkbox' name='defaultBilling' value="1">
            <span class='checkmark'></span>
        </label></div>
    </div>
    <div class="submit-btn">
        <input class="btn " type="submit" value="Save changees">
        <a href="/my-account/address-book/" class="btn">Exit without saving changes</a>
    </div>
    </form>
    <?php
 }
   
add_action( 'woocommerce_account_address-book-add_endpoint', 'address_book_add' );

function address_book_edit() {
    global $wpdb;

    $id = $_GET['address-id'];
    $address = get_customer_addresses_id($id);

    echo '<h3>Address Book</h3>';

    $addressFields = [
        '_first_name'=>$address->type.'_first_name',
        '_last_name'=>$address->type.'_last_name',
        '_country'=>$address->type.'_country',
        '_address_1'=>$address->type.'_address_1',
        '_city'=>$address->type.'_city',
        '_postcode'=>$address->type.'_postcode',
        '_phone'=>$address->type.'_phone',
    ];

    if ($_POST) {

        $isDefault=($_POST['setDefault'] ? 1 : 0 );


        
        // if set to default
        // remove old default
        if ($isDefault) {
            $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 0), array('userid' => get_current_user_id(), 'type' => $address->type));
        }

        // save shipping and billing address

        $wpdb->insert('QYp_dsabafw_billingadress', array(
            'userid' => get_current_user_id(),
            'userdata' => serialize($_POST),
            'type' => $address->type, 
            'Defalut' => $isDefault, 
        ));


        header('Location: /my-account/address-book/');
        die;
    }

    $countries_obj   = new WC_Countries();
    $countries   = $countries_obj->__get('countries');
    // var_dump($countries);
    ?>
    <form method="post">
        <h4>Edit address <?= $address->type ?></h4>
        <div class="address-book">
            <p class="form-row form-row-first" id="_first_name_field" data-priority="10">
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text " name="<?= $address->type ?>_first_name" id="_first_name" placeholder="Name*" value="<?= $address->userdata[$addressFields['_first_name']] ?>" required>
                    <input type="hidden" class="input-text " name="reference_field" id="reference_field" value="<?= $address->userdata['reference_field'] ?>">
                </span>
            </p>
            <p class="form-row form-row-last" id="_last_name_field" data-priority="20">
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text " name="<?= $address->type ?>_last_name" id="<?= $address->type ?>_last_name" placeholder="Last name*" value="<?= $address->userdata[$addressFields['_last_name']] ?>" required>
                </span>
            </p>
            <p class="form-row form-row-wide" id="_country_field" data-priority="40">
                <span class="woocommerce-input-wrapper">
                    <select name="<?= $address->type ?>_country" id="<?= $address->type ?>_country" class="country_to_state country_select " data-placeholder="Country*" data-label="Country / Region" tabindex="-1" aria-hidden="true" required>
                        <option value="">Select a country / region…</option>
                        <?php foreach ($countries as $key => $country) : ?>
                            <option value="<?= $key ?>" <?= ($address->userdata[$addressFields['_country']] == $key ? 'selected' : '') ?>><?= $country ?></option>
                        <?php endforeach; ?>
                    </select>
                </span>
            </p>
            <p class="form-row form-row-wide" id="_address_1_field" data-priority="50">
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text " name="<?= $address->type ?>_address_1" id="<?= $address->type ?>_address_1" placeholder="Street address*" value="<?= $address->userdata[$addressFields['_address_1']] ?>" data-placeholder="Street address*" required>
                </span>
            </p>
            <p class="form-row form-row-wide" id="_city_field" >
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text " name="<?= $address->type ?>_city" id="<?= $address->type ?>_city" placeholder="City*" value="<?= $address->userdata[$addressFields['_city']] ?>" data-placeholder="City*" required>
                </span>
            </p>
            <p class="form-row form-row-wide" id="_postcode_field">
                <span class="woocommerce-input-wrapper">
                    <input type="text" class="input-text " name="<?= $address->type ?>_postcode" id="<?= $address->type ?>_postcode" placeholder="Zip Code*" value="<?= $address->userdata[$addressFields['_postcode']] ?>" data-placeholder="Zip Code*" required>
                </span>
            </p>
            <p class="form-row form-row-wide" id="_phone_field" data-priority="">
                <span class="woocommerce-input-wrapper">
                    <input type="tel" class="input-text " name="<?= $address->type ?>_phone" id="<?= $address->type ?>_phone" placeholder="Phone(ex. +33 123 45 67)*" value="<?= $address->userdata[$addressFields['_phone']] ?>" required>
                </span>
            </p>
        </div>
        <div class="submit-btn">
        <div>
            <label class='chk-container'>Save as default <?= $address->type ?> address
                <input type='checkbox' name='setDefault' value="1">
                <span class='checkmark'></span>
            </label></div>
        </div>
        <div class="submit-btn">
            <input class="btn " type="submit" value="Save changes">
            <a href="/my-account/address-book/" class="btn">Exit without saving changes</a>
        </div>
    </form>
    <?php
 }
   
add_action( 'woocommerce_account_address-book-edit_endpoint', 'address_book_edit' );


function customerRequest( $attr ) {

    $default = array(
        'type' => 'request',
    );
    $a = shortcode_atts($default, $attr);

    // get post
    $posts = get_posts(array(
        'numberposts'   => -1,
        'post_type'     => 'product_'.$a['type'],
        'meta_query'    => array(
            'relation'      => 'AND',
            array(
                'key'       => 'customer',
                'value'     => get_current_user_id(),
                'compare'   => '=',
            ),
        ),
    ));
    // echo "this is " . $a['type'];
    // var_dump($posts);
    if ($posts) {

        if ($a['type'] && $a['type'] == 'request'){
            echo "<p>We are currently working on sourcing your requested item(s).</p>";
        }

        ?><ul><?php
        foreach($posts as $post) {

            // setup_postdata( $post );
            $size = get_field('size',$post->ID);
            $price = get_field('price', $post->ID);
            ?>
            <li>
            <table class="table table-request">
                <tr>
                    <td>
                        <?= get_the_post_thumbnail($post->ID); ?>
                    </td>
                    <td>
                        <p><?= $post->post_title ?></p>
                        <p><?= $post->post_content ?></p>
                        <p><?= $size ?></p>
                        <p><?= $price ?></p>
                    </td>
                    <td>
                        <p><a href="#">Email us for update</a></p>
                        <p><a href="#">cancel request</a></p>
                    </td>
                </tr>
            </table>
            </li>
            <?php
        }
        ?></ul><?php
    } else {
        if ($a['type'] && $a['type'] == 'request'){
            echo "<p>You haven't made any requests yet.</p>";
            echo "<p>If you're looking for something specific and it's Byronesque enough, we have a large global network of buyers and sellers and we can find it. please contact our personal shoppping team <a href='/contact'>here</a></p>";
        } else {
            echo "<p>You haven't made any selling yet.</p>";
        }
    }
}

add_shortcode('customer-request', 'customerRequest');


add_filter( 'woocommerce_default_address_fields', 'modified_addresses' );
function modified_addresses( $fields ) {
	// echo "this";
	// $fields[ 'first_name' ][ 'label' ] = 'Name';
	$fields[ 'first_name' ][ 'placeholder' ] = 'Name*';
	$fields[ 'last_name' ][ 'placeholder' ] = 'Last name*';
	$fields[ 'address_1' ][ 'placeholder' ] = 'Street address*';
	$fields[ 'city' ][ 'placeholder' ] = 'City*';
	$fields[ 'country' ][ 'placeholder' ] = 'Country*';
	$fields[ 'state' ][ 'placeholder' ] = 'county*';
	$fields[ 'postcode' ][ 'placeholder' ] = 'Zip Code*';
	$fields[ 'phone' ][ 'placeholder' ] = 'Phone(ex. +33 123 45 67)*';
	$fields[ 'phone' ][ 'required' ] = true;

    // unset( $fields[ 'state' ] );
    unset( $fields[ 'address_2' ] );
    unset( $fields[ 'company' ] );

	return $fields;
	
}

add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Phone(ex. +33 123 45 67)*';
    $fields['billing']['billing_phone']['required'] = true;
    return $fields;
}

// this function is dependent on multiple address plugin 
function get_customer_addresses( ) {
    // TYPE IS EITHER shipping | billing
    $type = $_GET['type'];
    
    $data = get_customer_addresses_default($type);

    echo wp_json_encode($data);

    die();
}

add_action( 'wp_ajax_get_customer_addresses', 'get_customer_addresses' );
add_action( 'wp_ajax_nopriv_get_customer_addresses', 'get_customer_addresses' );

function get_customer_addresses_default( $type='shipping' ) {
    global $wpdb;

    // echo $type;
    $querystr = "
                SELECT *
                FROM QYp_dsabafw_billingadress
                WHERE userid=".get_current_user_id()."
                AND type='".$type."'
                AND Defalut=1
                ";
    $query_results = $wpdb->get_results($querystr);
    $data=null;
    if ($query_results) {
        $data = $query_results[0];
        $data->userdata = unserialize($data->userdata);
    }

    return $data;
}

function get_customer_addresses_id( $id ) {
    global $wpdb;

    // echo $type;
    $querystr = "
                SELECT *
                FROM QYp_dsabafw_billingadress
                WHERE id=".$id."
                ";
    $query_results = $wpdb->get_results($querystr);
    $data=null;
    if ($query_results) {
        $data = $query_results[0];
        $data->userdata = unserialize($data->userdata);
    }

    return $data;
}

function set_customer_default( ) {
    global $wpdb;

    // TYPE IS EITHER shipping | billing
    $type = $_GET['type'];
    $id = $_GET['id'];
    // echo $type;
    if (!$type || !$id) {
        echo wp_json_encode([
            "status"=> "failed"
        ]);
    
        die();
    }
    
    // remove default per type
    $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 0), array('userid' => get_current_user_id(), 'type' => $type));
    // set new default per type
    $wpdb->update('QYp_dsabafw_billingadress', array('Defalut' => 1), array('id' => $id, 'type' => $type));


    echo wp_json_encode([
        "status"=> "ok"
    ]);

    die();
}

add_action( 'wp_ajax_set_customer_default', 'set_customer_default' );
add_action( 'wp_ajax_nopriv_set_customer_default', 'set_customer_default' );

function delete_customer_address( ) {
    global $wpdb;
    // TYPE IS EITHER shipping | billing
    $id = $_GET['id'];
    
    $wpdb->delete('QYp_dsabafw_billingadress', array('id' => $id));

    echo wp_json_encode([
        'status' => "ok"
    ]);

    die();
}

add_action( 'wp_ajax_delete_customer_address', 'delete_customer_address' );
add_action( 'wp_ajax_nopriv_delete_customer_address', 'delete_customer_address' );


add_filter( 'woocommerce_cart_shipping_method_full_label', 'change_cart_shipping_method_full_label', 10, 2 );
function change_cart_shipping_method_full_label( $label, $method ) {
    $has_cost  = 0 < $method->cost;
    $hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );

    $label = str_replace(":"," / ", $label);

    return $label;
}


add_action( 'woocommerce_before_shop_loop_item_title', 'wp_kama_woocommerce_before_shop_loop_item_title_action' );

function wp_kama_woocommerce_before_shop_loop_item_title_action(){
    $product_list_hover_image = get_post_meta( get_the_ID(), 'qodef_product_list_image_hover', true );
    $has_image          = ! empty( $product_list_hover_image );

    if ( $has_image ) {
        $image_dimension     = isset( $image_dimension ) && ! empty( $image_dimension ) ? esc_attr( $image_dimension['size'] ) : apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 0;
        $custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 0;
        ?>
        <div class="qodef-e-image-hover">
            <?php echo corsen_core_get_list_shortcode_item_image( $image_dimension, $product_list_hover_image, $custom_image_width, $custom_image_height ); ?>
        </div>
    <?php }
}

add_filter('post_class', function($classes, $class, $product_id) {
    $product_list_hover_image = get_post_meta( $product_id, 'qodef_product_list_image_hover', true );
    $has_image          = ! empty( $product_list_hover_image );

    if ($has_image)
    $classes = array_merge(['has-hover-image'], $classes);
    
    return $classes;
},10,3);


?>