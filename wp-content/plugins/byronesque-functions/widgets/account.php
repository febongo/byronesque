<?php 

// Creating the widget
class wpb_widget_account extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget_account', 
        
        // Widget name will appear in UI
        __('Byronesque Account Menu', 'wpb_widget_account_domain'), 
        
        // Widget description
        array( 'description' => __( 'Account Dropdown', 'wpb_widget_account_domain' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        ?>
            <div id="bn-account-ico" class="account-area">
                <span class="menu-nav menu-nav-side" 
                    data-action="get_account"
                    data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/person_b.svg'?>" 
                    data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/person_w.svg'?>" 
                    style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/person_w.svg'?>')">
                </span>
            </div>
            <div id="get_account" style="display:none">
                
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
            $title = __( 'New title', 'wpb_widget_account_domain' );
        }
        // Widget admin form
        ?>
        <p>Byronesque Menu Function</p>
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

function get_account() {

    ?>
    
        <h4>Account</h4>
        <?php if(!is_user_logged_in()) : ?>
        <?= do_shortcode('[byro-login-form]'); ?>
        <?php //do_shortcode('[miniorange_social_login shape="longbuttonwithtext" theme="default" space="8" width="180" height="35" color="000000"]'); ?>
        <?php else : 
            $menu_name = 'byronesque-account-settings'; //menu slug
            $locations = get_nav_menu_locations();
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
            $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
    
            
        ?>
            <ul>
                <?php foreach($menuitems as $menuitem) { ?>
                    <li><a href="<?= $menuitem->url ?>"><?= $menuitem->title ?></a></li>
                <?php } ?>
            </ul>
            <p class="side-signout"><a href="<?php echo wc_logout_url( get_permalink() ); ?>">Sign out</a></p>
        <?php endif; ?>
    
    <?php

    die();
}

// add_action( 'login_form_middle', 'add_lost_password_link' );
// function add_lost_password_link() {
//     return '<a class="lost-password" href="/wp-login.php?action=lostpassword">Forgot Your Password?</a>';
// }

add_action( 'login_form_middle', 'add_social_links' );
function add_social_links() {
    return '<a class="loss-password" href="/wp-login.php?action=lostpassword">Forgot Your Password?</a>' . do_shortcode('[miniorange_social_login shape="longbuttonwithtext" theme="default" space="8" width="180" height="35" color="000000"]');
}

if(!function_exists('byro_login_form'))
{
  function byro_login_form()
  {
      $str = home_url($_SERVER['REQUEST_URI']);
      $pattern = "/wp-admin/i";
      $currentURL = home_url();
      if (!preg_match($pattern, $str) ) {
          $currentURL = $str;
      } else if(isset($_COOKIE['currentLink'])){
        $currentURL = $_COOKIE['currentLink'];
      }
      
      $args = array(
        'echo'           => true,
        'remember'       => true,
        'redirect'       => home_url(),
        'form_id'        => 'loginform',
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'label_username' => __( 'Username or Email Address' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Keep me signed in' ),
        'label_log_in'   => __( 'Continue' ),
        'value_username' => '',
        'value_remember' => false
    );
    wp_login_form($args);
    // add_lost_password_link();
  }
  add_shortcode('byro-login-form', 'byro_login_form');
}


add_action( 'wp_ajax_get_account', 'get_account' );
add_action( 'wp_ajax_nopriv_get_account', 'get_account' );

add_action('init', function() {
    if (!isset($_COOKIE['currentLink'])) {
        $currentURL = home_url($_SERVER['REQUEST_URI']);
        $pattern = "/wp-admin/i";
        
        if (preg_match($pattern, $currentURL) ) {
            $currentURL = home_url();
        }
        setcookie('currentLink', $currentURL, strtotime('+1 day'));
    }
});

     

// preload images
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_b.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/region_b.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/region_w.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/cart_b.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/cart_w.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/close.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/menu_ico_b.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/menu_ico.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/person_b.png">';
// echo '<link rel="preload" as="image" href="'.plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/person_w.png">';
  

