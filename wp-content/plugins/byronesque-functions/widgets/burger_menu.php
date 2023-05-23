<?php 

// Creating the widget
class wpb_widget_menu extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget_menu', 
        
        // Widget name will appear in UI
        __('Byronesque Burger Menu', 'wpb_widget_menu_domain'), 
        
        // Widget description
        array( 'description' => __( 'Currency Switcher', 'wpb_widget_menu_domain' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $newsletter = apply_filters( 'widget_title', $instance['newsletter'] );
        $instagram_link = apply_filters( 'widget_title', $instance['instagram_link'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        ?>
            <div id="bn-menu-ico" class="menu-area">
                <span class="menu-nav menu-nav-side" 
                    data-action="get_side_menu"
                    data-img-close="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/close.png'?>" 
                    data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/menu_ico_b.svg'?>" 
                    data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/menu_ico.svg'?>" 
                    style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/menu_ico.svg'?>')">
                </span>
            </div>
            <div id="get_side_menu" style="display:none">
                <?php 
                $menu_name = 'byronesque-side-menu'; //menu slug
                $locations = get_nav_menu_locations();
                $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
                $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
            
                ?>
                <div id="byronesque-side-nav">
                    <ul class="byro-side-nav">
                        <?php foreach($menuitems as $menuitem) { ?>
                            <li><a href="<?= $menuitem->url ?>"><?= $menuitem->title ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="bottom-links">
                        <span class="open-news-form"><a href="#">NEWSLETTER</a></span>
                        <span><a href="<?= $instagram_link ?>"><i class="fa fa-instagram"></i>INSTAGRAM</a></span>
                    </div>
            
                    <?php if ($newsletter) : ?>
                        <div class="newsletter-form">
                            <h3 id="newsletterSide">NEWSLETTER</h3>
                            <?php 
                                $newsl = '[mc4wp_form id="'.$newsletter.'" title="Newsletter"]';
                                echo do_shortcode($newsl);
                            ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        // END FRONT END DISPLAY
        echo $args['after_widget'];
    }
     
    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'newsletter' ] ) ) {
            $newsletter = $instance[ 'newsletter' ];
        } else {
            $newsletter = __( '6201', 'wpb_widget_menu_domain' );
        }

        if ( isset( $instance[ 'instagram_link' ] ) ) {
            $instagram_link = $instance[ 'instagram_link' ];
        } else {
            $instagram_link = __( '#', 'wpb_widget_menu_domain' );
        }
        // Widget admin form
        ?>
        <p>Byronesque Menu Function</p>

        <p>
            <label for="<?php echo $this->get_field_id( 'newsletter' ); ?>"><?php _e( 'Newsletter Short Code ID:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'newsletter' ); ?>" name="<?php echo $this->get_field_name( 'newsletter' ); ?>" type="text" value="<?php echo esc_attr( $newsletter ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'instagram_link' ); ?>"><?php _e( 'Instagram Link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'instagram_link' ); ?>" name="<?php echo $this->get_field_name( 'instagram_link' ); ?>" type="text" value="<?php echo esc_attr( $instagram_link ); ?>" />
        </p>
        <?php
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['newsletter'] = ( ! empty( $new_instance['newsletter'] ) ) ? strip_tags( $new_instance['newsletter'] ) : '';
        $instance['instagram_link'] = ( ! empty( $new_instance['instagram_link'] ) ) ? strip_tags( $new_instance['instagram_link'] ) : '';
        return $instance;
    }
     
    // Class wpb_widget ends here
} 
