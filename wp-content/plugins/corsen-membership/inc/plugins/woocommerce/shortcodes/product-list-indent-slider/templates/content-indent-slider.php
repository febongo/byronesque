<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <div class="qodef-left-info">
        <div class="qodef-left-info-content">
            <?php if ( ! empty( $info_title ) ) { ?>
                <h3 class="qodef-e-title entry-title"><?php echo qode_framework_wp_kses_html( 'content', $info_title ); ?></h3>
            <?php } ?>

            <?php if ( ! empty( $info_text ) ) { ?>
                <p class="qodef-e-text"><?php echo qode_framework_wp_kses_html( 'content', $info_text ); ?></p>
            <?php } ?>

            <?php
            $button_params = array(
                'link'          => $button_link,
                'text'          => $button_text,
                'target'        => $button_target,
                'button_layout' => 'outlined',
                'custom_class'  => 'qodef-m-button',
            );

            if ( ! empty( $button_params ) && ! empty( $button_params['text'] ) && class_exists( 'CorsenCore_Button_Shortcode' ) ) {
                echo CorsenCore_Button_Shortcode::call_shortcode( $button_params );
            }
            ?>

            <?php
            // Include slider navigation
            corsen_core_template_part('plugins/woocommerce/shortcodes/product-list-indent-slider', 'templates/post-info/swiper-nav', '', $params);
            ?>
        </div>
    </div>
    <div class="qodef-right-slider">
        <div class="qodef-fixed-indent-slider-holder swiper-container-horizontal" <?php qode_framework_inline_attr( $slider_data, 'data-options' ); ?>>
            <div class="qodef-m-items" <?php qode_framework_inline_attrs( $data_attrs ); ?>>
                <div class="qodef-m-swiper">
                    <ul class="swiper-wrapper">
                        <?php
                        // Include items
                        corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list-indent-slider', 'templates/loop', '', $params );
                        ?>
                    </ul><!-- .swiper-wrapper -->
                </div><!-- .qodef-m-swiper -->
            </div><!-- .qodef-m-items -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
