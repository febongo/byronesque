<?php

// ------------------
// 1. Add request EndPoint
function add_request_selling_request() {
    add_rewrite_endpoint( 'customer-request', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'customer-selling', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'address-book', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'add_request_selling_request' );
  
// ------------------
// 2. Add new query var
  
function request_query_vars( $vars ) {
    $vars[] = 'customer-request';
    $vars[] = 'customer-selling';
    $vars[] = 'address-book';
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
        'edit-address' => 'Address Book edit',
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
            echo "<div class='address-wrap'>";
            if ($address->Defalut == 1) echo "<p class='default'>".($address->type == "shipping" ? "Prefered delivery address" : "Prefered billing address")."</p>"; 
                echo "<div class='addresses-contents'>";
                echo "<p>".$address->userdata[$address->type.'_first_name']. " " .$address->userdata[$address->type.'_last_name']. "</p>";
                echo "<p>".$address->userdata[$address->type.'_address_1']."</p>";
                echo "<p>".$address->userdata[$address->type.'_postcode']. " " .$address->userdata[$address->type.'_state'] . ", "  .$address->userdata[$address->type.'_country'] .  "</p>";
                echo "</div>";
            echo "</div>";
        }
        echo "</ul>";
    } else {
        echo "<p>Please add prefered address.</p>";
    }
 }
   
add_action( 'woocommerce_account_address-book_endpoint', 'address_book_contents' );

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

 ?>