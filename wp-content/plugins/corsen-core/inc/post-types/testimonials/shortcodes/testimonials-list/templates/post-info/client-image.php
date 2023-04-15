<?php
$item_id            = get_the_ID();
$client_image       = get_post_meta( $item_id, 'qodef_testimonials_client_image', true );

if ( ! empty( $client_image ) && 'no' === $hide_client_images ) : ?>
    <div class="qodef-e-client-images-decoration">
        <svg xmlns="http://www.w3.org/2000/svg" width="12.279" height="12.278" viewBox="0 0 12.279 12.278"><g fill="none" stroke="currentColor" stroke-width="2"><path d="m.707.707 10.864 10.865"/><path d="M11.571.707.707 11.572"/></g></svg>
    </div>
    <div class="qodef-e-client-image">
        <div class="qodef-e-image">
            <?php echo wp_get_attachment_image( $client_image, 'full' ); ?>
        </div>
    </div>
<?php endif; ?>
