<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <div class="qodef-m-image-inner-holder">
        <?php
        if ( count( $image_params ) ) {
            corsen_core_template_part( 'shortcodes/image-with-text', 'templates/parts/image', '', $params );
        }
        ?>
        <?php if ( 'scrolling-image' === $params['image_action'] ) { ?>
            <?php if ( 'large' === $params['scrolling_frame_size'] ) { ?>
                <img class="qodef-m-iwt-frame" src="<?php echo CORSEN_CORE_SHORTCODES_URL_PATH ?>/image-with-text/assets/img/scrolling-image-frame-large.png" alt="<?php esc_html_e('Scrolling Image Frame', 'corsen-core') ?>" />
            <?php } elseif ( 'small' === $params['scrolling_frame_size'] ) { ?>
                <img class="qodef-m-iwt-frame" src="<?php echo CORSEN_CORE_SHORTCODES_URL_PATH ?>/image-with-text/assets/img/scrolling-image-frame-small.png" alt="<?php esc_html_e('Scrolling Image Frame', 'corsen-core') ?>" />
            <?php } elseif ( 'tall' === $params['scrolling_frame_size'] ) { ?>
                <img class="qodef-m-iwt-frame" src="<?php echo CORSEN_CORE_SHORTCODES_URL_PATH ?>/image-with-text/assets/img/scrolling-image-frame-tall.png" alt="<?php esc_html_e('Scrolling Image Frame', 'corsen-core') ?>" />
            <?php } ?>
        <?php } ?>
    </div>
	<div class="qodef-m-content">
		<?php corsen_core_template_part( 'shortcodes/image-with-text', 'templates/parts/title', '', $params ); ?>
		<?php corsen_core_template_part( 'shortcodes/image-with-text', 'templates/parts/text', '', $params ); ?>
	</div>
</div>
