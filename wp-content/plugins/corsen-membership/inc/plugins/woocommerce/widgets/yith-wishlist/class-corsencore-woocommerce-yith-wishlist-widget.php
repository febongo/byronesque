<?php

if ( ! function_exists( 'corsen_core_add_yith_wishlist_widget' ) ) {
    /**
     * Function that add widget into widgets list for registration
     *
     * @param array $widgets
     *
     * @return array
     */
    function corsen_core_add_yith_wishlist_widget( $widgets ) {
        $widgets[] = 'CorsenCare_Core_Yith_Wishlist_Widget';

        return $widgets;
    }

    add_filter( 'corsen_core_filter_register_widgets', 'corsen_core_add_yith_wishlist_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
    class CorsenCare_Core_Yith_Wishlist_Widget extends QodeFrameworkWidget {

        public function map_widget() {
            $this->set_base( 'corsen_core_yith_wishlist' );
            $this->set_name( esc_html__( 'Corsen Yith Wishlist', 'corsen-core' ) );
            $this->set_description( esc_html__( 'Add Yith Wishlist to widget areas', 'corsen-core' ) );
            $this->set_widget_option(
                array(
                    'field_type'  => 'text',
                    'name'        => 'widget_margin',
                    'title'       => esc_html__( 'Margin', 'corsen-core' ),
                    'description' => esc_html__( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'corsen-core' )
                )
            );
            $this->set_widget_option(
                array(
                    'field_type'  => 'color',
                    'name'        => 'icon_color',
                    'title'       => esc_html__( 'Icon Color', 'corsen-core' )
                )
            );
        }

        public function render( $atts ) {

            $styles = array();
            $icon_styles = array();

            if ( $atts['widget_margin'] !== '' ) {
                $styles[] = 'margin: ' . $atts['widget_margin'];
            }
            if ( $atts['icon_color'] !== '' ) {
                $icon_styles[] = 'color: ' . $atts['icon_color'];
            }
            global $yith_wcwl;

            $wishlist_url = $yith_wcwl->get_wishlist_url();
            $number_of_items = yith_wcwl_count_all_products();

            if ( $number_of_items === 0 ) {
                $number_of_items = 0;
            }
            ?>

            <div class="widget qodef-wishlist-widget-holder">
                <div class="qodef-wishlist-inner" <?php qode_framework_inline_style( $styles ); ?>>
                    <a href="<?php echo esc_url($wishlist_url); ?>" class="qodef-wishlist-widget-link" title="<?php echo esc_attr__('View Wishlist', 'corsen-core'); ?>">
                        <span class="qodef-wishlist-icon-count-holder" <?php qode_framework_inline_style( $icon_styles ); ?>>
                            <span class="qodef-wishlist-widget-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12.123" height="15" viewBox="0 0 12.123 15"><g fill="none"><path d="M.49998437 13.98803125V.50023828h11.12304688V13.93725L6.61717187 9.7941836l-.30664062-.25390626-.31542969.2421875-5.49511719 4.20556641Z"/><path d="M.99998437 1.00023828v11.97558594l5.3232422-4.07421875 4.79980468 3.97265625V1.00023828H.99998437m-1-1h12.12304688v15L6.2988125 10.1794375l-6.29882813 4.82080078v-15Z" fill="currentColor"/></g></svg>
                            </span>
                            <span class="qodef-wishlist-count"><?php echo esc_html( $number_of_items ) ?></span>
                        </span>
                    </a>
                </div>
            </div>
            <?php
        }
    }
}
