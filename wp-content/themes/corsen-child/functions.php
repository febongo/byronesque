<?php

if ( ! function_exists( 'corsen_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function corsen_child_theme_enqueue_scripts() {
		$main_style = 'corsen-main';

		wp_enqueue_style( 'corsen-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'corsen_child_theme_enqueue_scripts' );
}



// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to Bag', 'woocommerce' ); 
}

// Pagination
add_filter( 'woocommerce_pagination_args' , 'tq73et_override_pagination_args' );
function tq73et_override_pagination_args( $args ) {
	$args['prev_text'] = __( 'Previous' );
	$args['next_text'] = __( 'Next' );
	return $args;
}

//show attributes after summary in product single view
add_action('woocommerce_single_product_summary', function() {
	//template for this is in storefront-child/woocommerce/single-product/product-attributes.php
	global $product;
	echo $product->list_attributes();
}, 25);


// Blog Page Title
function page_title_sc( ){
   return get_the_title();
}
add_shortcode( 'page_title', 'page_title_sc' );


// Blog page Publish Date
function shortcode_post_published_date(){
 return get_the_date();
}
add_shortcode( 'post_published', 'shortcode_post_published_date' );


// Blog Page Featured Image
add_shortcode('thumbnail', 'thumbnail_in_content');

function thumbnail_in_content($atts) {
    global $post;

    return get_the_post_thumbnail($post->ID);
}

// Blog Page product name
add_shortcode('product_data','custom_product_data');
function custom_product_data($atts)
{
    $post_id = $atts['id'];
    $title = get_the_title($post_id);
    $link = get_the_permalink($post_id);
    $data ='<a href="'.$link.'">'.$title.'</a>';
    return $data;
}

// Blog Page product image
add_shortcode('product_image','custom_product_image');
function custom_product_image($atts)
{
    $post_id = $atts['id'];
    $link = get_the_permalink($post_id);
    $image = get_the_post_thumbnail($post_id);
    $data ='<div><a>'.$image.'</div>';
    return $data;
}

// Blog Page post title
add_shortcode('post_title','custom_post_title');
function custom_post_title($atts)
{
    $post_id = $atts['id'];
    $title = get_the_title($post_id);
    $data = $title;
    return $data;
}


// echo "**************************************************************called ********************************************************";
// $email = 'febongotest@example.com';
// $list_id = 'bd26333b2e';
// add_mailchimp_subscriber($email, $list_id);

// var_dump(get_user_meta(3,'mailchimp_woocommerce_is_subscribed'));
// $mailchimp = Mailchimp_WooCommerce();
// var_dump($mailchimp);
// $api = MC4WP_MailChimp_WooCommerce::get_instance();
// var_dump($api);


// $integration = mc4wp_get_integration('woocommerce');
// var_dump($integration);

/**
 * Override the WooCommerce product image display
 */
add_action( 'woocommerce_before_single_product_summary', 'custom_woocommerce_show_product_images', 20 );
function custom_woocommerce_show_product_images() {
    global $product;
    // Get the product image gallery
    $attachment_ids = $product->get_gallery_image_ids();

    if ( $attachment_ids && $product->get_image_id() ) {
        // Check if the user is on a mobile device
        $is_mobile = wp_is_mobile();
		echo "<section id='productMobileSlider' style='width:100%;max-height:400px;overflow:hidden'>";
        foreach ( $attachment_ids as $attachment_id ) {
            // Get the image URL
            $image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

            // Get the image sizes for mobile and desktop
            $mobile_size = 'medium';
            $desktop_size = 'full';

            // Set the image size based on the user's device
            $image_size = $is_mobile ? $mobile_size : $desktop_size;
			if ($is_mobile) {
				echo '<div class="mobile-view">';
				echo wp_get_attachment_image( $attachment_id, $image_size );
				echo '</div>';	
			}
            
        } // End ForEach
		echo "</section>";
    }
}
