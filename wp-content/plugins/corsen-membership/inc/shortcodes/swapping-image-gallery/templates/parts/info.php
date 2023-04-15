<div class="qodef-m-info clearfix">
	<div class="qodef-m-thumbnails-holder qodef-grid qodef-layout--columns qodef-gutter--no qodef-col-num--2">
		<div class="qodef-grid-inner">
			<?php foreach ( $items as $image_item ) : ?>
				<div class="qodef-m-thumbnail qodef-grid-item">
					<div class="qodef-m-thumbnail-inner">
						<span class="qodef-e-inner">
							<?php echo wp_get_attachment_image( $image_item['thumbnail_image'], 'full' ); ?>
							<span class="qodef-e-hover-image">
								<?php echo wp_get_attachment_image( $image_item['active_thumbnail_image'], 'full' ); ?>
							</span>
						</span>
						<?php
						if ( ! empty( $image_item['thumbnail_title'] ) ) {
							?>
							<h6 itemprop="name" class="qodef-e-title entry-title"><?php echo esc_html( $image_item['thumbnail_title'] ); ?></h6>
						<?php } ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
