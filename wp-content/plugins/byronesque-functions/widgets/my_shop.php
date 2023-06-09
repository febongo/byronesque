<?php 

// Creating the widget
class wpb_widget_my_shop extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_widget_my_shop', 
        
        // Widget name will appear in UI
        __('Byronesque My Shop Link List', 'wpb_widget_domain'), 
        
        // Widget description
        array( 'description' => __( 'list links from my shop menu', 'wpb_widget_my_shop' ), )
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $title1 = apply_filters( 'widget_title', $instance['col_1_title'] );
        $title2 = apply_filters( 'widget_title', $instance['col_2_title'] );
        $title3 = apply_filters( 'widget_title', $instance['col_3_title'] );
        $feat_id = apply_filters( 'featured_post_id', $instance['featured_post_id'] );

        $menuName1 = 'byronesque-my-shop-menu1'; //menu slug
        $menuName2 = 'byronesque-my-shop-menu2'; //menu slug
        $menuName3 = 'byronesque-my-shop-menu3'; //menu slug
        $locations = get_nav_menu_locations();
        $menu1 = wp_get_nav_menu_object( $locations[ $menuName1 ] );
        $menu2 = wp_get_nav_menu_object( $locations[ $menuName2 ] );
        $menu3 = wp_get_nav_menu_object( $locations[ $menuName3 ] );
        $menuitems1 = wp_get_nav_menu_items( $menu1->term_id, array( 'order' => 'DESC' ) );
        $menuitems2 = wp_get_nav_menu_items( $menu2->term_id, array( 'order' => 'DESC' ) );
        $menuitems3 = wp_get_nav_menu_items( $menu3->term_id, array( 'order' => 'DESC' ) );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        // if ( ! empty( $title ) )
        // echo $args['before_title'] . $title . $args['after_title'];
        
        // This is where you run the code and display the output
        //echo __( 'Search Area Here', 'wpb_widget_domain' );
        ?>
            <div id="bn-shopby" class="shopby-area">
                <span class="menu-nav menu-nav-no-side shop-by-label" >
                    SHOP BY
                </span>
                <div class="bn-shop-container">
                    <div id="byro-shopby-filters" class="row">
                        
                        <div class="r-6 row shop-by-list">
                            <div class="r-4 b-r">
                                <?php if($title1) : ?><label class="menu-label mobile-menu-label"><?= $title1; ?></label><?php endif; ?>
                                <ul class="byro-shop-nav">
                                    <?php foreach($menuitems1 as $menuitem) { ?>
                                        <li><a href="<?= $menuitem->url ?>"><?= $menuitem->title ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="r-4 b-r">
                                <?php if($title2) : ?><label class="menu-label"><?= $title2; ?></label><?php endif; ?>
                                <ul class="byro-shop-nav">
                                    <?php foreach($menuitems2 as $menuitem) { ?>
                                        <li><a href="<?= $menuitem->url ?>"><?= $menuitem->title ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="r-4">
                                <?php if($title3) : ?><label class="menu-label"><?= $title3; ?></label><?php endif; ?>
                                <ul class="byro-shop-nav">
                                    <?php foreach($menuitems3 as $menuitem) { ?>
                                        <li><a href="<?= $menuitem->url ?>"><?= $menuitem->title ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php if($feat_id): $post   = get_post( $feat_id ); ?>
                            <?php if($post) : ?>
                                <div class="r-6 feat-wrap">
                                    <a href="<?= get_permalink( $post->ID ) ?>">
                                        <?= get_the_post_thumbnail( $post->ID, 'medium' ) ?>
                                        <div class="feat-contents">
                                            <p>
                                                <b>READ: <?= $post->post_title ?></b>
                                                <?php
                                                $excerpt = get_the_excerpt($post->ID);
                                                // if (strlen($excerpt) > 100) {
                                                //     $excerpt = get_the_excerpt($post->ID);
                                                //     $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
                                                // }
                                                ?>
                                                <br><?= $excerpt ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
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
            $title = __( 'New title', 'wpb_widget_my_shop' );
        }

        if ( isset( $instance[ 'col_1_title' ] ) ) {
            $col1Title = $instance[ 'col_1_title' ];
        } else {
            $col1Title = __( 'Column 1 Title', 'wpb_widget_my_shop' );
        }
        
        if ( isset( $instance[ 'col_2_title' ] ) ) {
            $col2Title = $instance[ 'col_2_title' ];
        } else {
            $col2Title = __( 'Column 2 Title', 'wpb_widget_my_shop' );
        }
        
        if ( isset( $instance[ 'col_3_title' ] ) ) {
            $col3Title = $instance[ 'col_3_title' ];
        } else {
            $col3Title = __( 'Column 3 Title', 'wpb_widget_my_shop' );
        }

        if ( isset( $instance[ 'featured_post_id' ] ) ) {
            $feat_id = $instance[ 'featured_post_id' ];
        } else {
            $feat_id = __( '2080', 'wpb_widget_my_shop' );
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'col_1_title' ); ?>"><?php _e( 'Column 1 Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'col_1_title' ); ?>" name="<?php echo $this->get_field_name( 'col_1_title' ); ?>" type="text" value="<?php echo esc_attr( $col1Title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'col_2_title' ); ?>"><?php _e( 'Column 2 Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'col_2_title' ); ?>" name="<?php echo $this->get_field_name( 'col_2_title' ); ?>" type="text" value="<?php echo esc_attr( $col2Title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'col_3_title' ); ?>"><?php _e( 'Column 3 Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'col_3_title' ); ?>" name="<?php echo $this->get_field_name( 'col_3_title' ); ?>" type="text" value="<?php echo esc_attr( $col3Title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'featured_post_id' ); ?>"><?php _e( 'Featured Post ID:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'featured_post_id' ); ?>" name="<?php echo $this->get_field_name( 'featured_post_id' ); ?>" type="text" value="<?php echo esc_attr( $feat_id ); ?>" />
        </p>
        <?php
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['col_1_title'] = ( ! empty( $new_instance['col_1_title'] ) ) ? strip_tags( $new_instance['col_1_title'] ) : '';
        $instance['col_2_title'] = ( ! empty( $new_instance['col_2_title'] ) ) ? strip_tags( $new_instance['col_2_title'] ) : '';
        $instance['col_3_title'] = ( ! empty( $new_instance['col_3_title'] ) ) ? strip_tags( $new_instance['col_3_title'] ) : '';
        $instance['featured_post_id'] = ( ! empty( $new_instance['featured_post_id'] ) ) ? strip_tags( $new_instance['featured_post_id'] ) : '';
        return $instance;
    }
     
    // Class wpb_widget ends here
} 


/*  Search action
/*-------------------*/

function my_shop() {

    ?>
    <div id="bn-search" class="search-area">
        <span class="menu-nav menu-nav-no-side" 
            data-img-hover="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_b.png'?>" 
            data-img="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.png'?>" 
            style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/search_w.png'?>')">
        </span>
        <div class="bn-search-form">
            <div id="bn-search-wrap" >
                <i id="search-btn" class="fa fa-search"></i>
                <input id="bn-search-value" type="text" placeholder="Search Products" value="">
                <span id="bn-search-close" class="bn-close-btn" style="background-image:url('<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/close.png'?>')"></span>
            </div>
            <div id="byro-search-result"></div>
        </div>
    </div>
    <?php

    die();
}


    

//add_action( 'wp_ajax_my_shop', 'my_shop' );
//add_action( 'wp_ajax_nopriv_my_shop', 'my_shop' );
