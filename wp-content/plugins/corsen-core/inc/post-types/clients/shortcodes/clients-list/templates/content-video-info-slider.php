<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
    <div class="qodef-images-holder">
        <div class="swiper-wrapper">
            <?php
            // Include items
            corsen_core_template_part( 'post-types/clients/shortcodes/clients-list', 'templates/loop-video', '', $params );
            ?>
        </div>
    </div>

    <div class="qodef-thumbnails-holder">
        <div class="swiper-wrapper">
            <?php
            // Include items
            corsen_core_template_part( 'post-types/clients/shortcodes/clients-list', 'templates/loop-navigation', '', $params );
            ?>
        </div>
    </div>
</div>
