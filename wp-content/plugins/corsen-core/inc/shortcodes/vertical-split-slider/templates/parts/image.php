<?php if ( ! empty( $item['slide_content_image'] ) ) : ?>
	<div class="qodef-m-image">
		<?php echo wp_get_attachment_image( $item['slide_content_image'], 'medium' ); ?>
	</div>
<?php endif; ?>
