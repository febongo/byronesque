<?php 

// Creating the widget
class wpb_widget_cart extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget_cart', 
        
        // Widget name will appear in UI
        __('Byronesque Cart Drop Down', 'wpb_widget_cart_domain'), 
        
        // Widget description
        array( 'description' => __( 'Currency Switcher', 'wpb_widget_cart_domain' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        ?>
            <div id="bn-cart-ico" class="menu-area">
                <span class="menu-nav menu-nav-side" 
                    data-action="get_cart"
                    data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/cart_b.svg'?>" 
                    data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/cart_w.svg'?>" 
                    style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/cart_w.svg'?>')">
                <?php echo do_shortcode("[byro_cart_counter]"); ?>
                </span>
                
            </div>
            <div id="get_cart" style="display:none">
                
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
            $title = __( 'New title', 'wpb_widget_cart_domain' );
        }
        // Widget admin form
        ?>
        <p>Byronesque Cart Function</p>
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

// create shortcode
add_shortcode ('byro_cart_counter', 'byro_cart_counter' );
/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */
function byro_cart_counter() {
	ob_start();
 
        $cart_count = WC()->cart->cart_contents_count; // Set variable for cart item count
        $cart_url = wc_get_cart_url();  // Set Cart URL
        if ($cart_count > 0){
            echo $cart_count;
        }
	        
    return ob_get_clean();
 
}
// update cart counter AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'byro_cart_counter_update' );
/**
 * Add AJAX Shortcode when cart contents update
 */
function byro_cart_counter_update( $fragments ) {
 
    ob_start();
    
    $cart_count = WC()->cart->cart_contents_count;
    $cart_url = wc_get_cart_url();
    
    if ($cart_count > 0){
        echo $cart_count;
    }
        
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}

function get_cart() {

    
do_action( 'woocommerce_before_mini_cart' ); ?>
<h3>YOUR CART</h3>
<?php if ( ! WC()->cart->is_empty() ) : ?>
<div class="byro-mini-cart">
	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            // var_dump($cart_item);
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item-v2 <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					
                    <table class="cart-table">
                        <tr>
                            <td class="thumb-image">
                                <?php if ( empty( $product_permalink ) ) : ?>
                                    <?php echo $thumbnail;  ?>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( $product_permalink ); ?>">
                                        <?php echo $thumbnail;  ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="item-summary">
                                <?php echo "<span>".wp_kses_post( $product_name )."</span>"; ?>
                                <?= "<span>QTY: ".$cart_item['quantity']."</span>" ?>
                                <?php
                                echo apply_filters( 
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">Remove from bag</a>',
                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                        esc_attr__( 'Remove this item', 'woocommerce' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $cart_item_key ),
                                        esc_attr( $_product->get_sku() )
                                    ),
                                    $cart_item_key
                                );
                                
                                ?>
                            </td>
                            <td class="item-price">
                                <?php echo WC()->cart->get_product_price( $_product ) ?>
                            </td>
                        </tr>
                    </table>

					

                    
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>
    <?php
    $taxes = WC()->cart->get_tax_totals();

    foreach($taxes as $tax) {
        echo '<p class="woocommerce-mini-cart__total total">
                <strong>Tax:</strong> 
                <span class="woocommerce-Price-amount amount">'.$tax->formatted_amount.'</span>	
            </p>';
    }


    // echo '<p class="woocommerce-mini-cart__total total">
    //             <strong>Total:</strong> 
    //             <span class="woocommerce-Price-amount amount">'.WC()->cart->get_cart_shipping_total().'</span>	
    //         </p>';

    echo '<p class="woocommerce-mini-cart__total total">
                <strong>Total:</strong> 
                <span class="woocommerce-Price-amount amount">'.WC()->cart->get_total_ex_tax().'</span>	
            </p>';

    ?>

    <ul>
        <li><b>You may have to pay customs charges to receive your item(s)</b></li>
    </ul>


	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

    <p class="mini-cart-note">You won’t be charged for your item(s) yet.</p>
	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>
<?php
    die();
}

function bro_get_cart_count(  ) {
    return WC()->cart->get_cart_contents_count();
}


add_action( 'wp_ajax_get_cart', 'get_cart' );
add_action( 'wp_ajax_nopriv_get_cart', 'get_cart' );

add_action( 'wp_ajax_bro_get_cart_count', 'bro_get_cart_count' );
add_action( 'wp_ajax_nopriv_bro_get_cart_count', 'bro_get_cart_count' );

add_filter('wc_add_to_cart_message_html', function ($message, $products) {
    //echo $products[0];
    // echo $message;
    $cart_count = WC()->cart->cart_contents_count;
    
    foreach($products as $key => $val){
        $_product = wc_get_product( $key );
        $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name() );
        $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image());
        $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ));
        
        $message = "<p class='added-notif' >Added to bag <span style='background-image: url(".plugin_dir_url( dirname( __FILE__ ) ) ."assets/img/cart_b.png)'>$cart_count</span></p>
                    <table>
                        <tr>
                            <td style='width:35%'>$thumbnail</td>
                            <td>
                                <p>$product_name</p>
                                <p>".$_product->post->post_excerpt."</p>
                                <p>$product_price</p>
                            </td>
                        </tr>
                    </table>
                    ";
        // var_dump($product_name);

    }
  return $message;
}, 10, 2);

// add_action( 'woocommerce_after_shop_loop_item', 'woo_show_excerpt_shop_page', 2 );
// function woo_show_excerpt_shop_page() {
// 	global $product;

// 	echo "<p class='short-description'>".$product->post->post_excerpt."</p>";
// }

