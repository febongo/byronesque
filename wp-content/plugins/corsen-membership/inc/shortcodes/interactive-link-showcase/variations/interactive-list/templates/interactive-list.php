<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>>
	<div class="qodef-m-items">
		<?php
		$i = 0;

		foreach ( $items as $item ) {
			?>
			<a itemprop="url" class="qodef-m-item qodef-e" href="<?php echo esc_url( $item['item_link'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>" data-index="<?php echo intval( $i ++ ); ?>">
				<span class="qodef-e-title"><?php echo esc_html( $item['item_title'] ); ?></span>
                <span class="qodef-e-text"><?php echo esc_html( $item['item_text'] ); ?></span>
                <span class="qodef-e-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="52.545" height="37.527" viewBox="0 0 52.545 37.527">
                        <g transform="translate(-1083.402 -3650.684)">
                            <path d="M8134.4,7825.448h51.838" transform="translate(-7051 -4156)" fill="none" stroke="#000" stroke-width="1"/>
                            <path d="M8234.605,7820.28l18.41-18.41,18.41,18.41" transform="translate(8937.109 -4583.568) rotate(90)" fill="none" stroke="#000" stroke-width="1"/>
                        </g>
                    </svg>
                </span>
				<?php
				if ( isset( $item['item_image'] ) && ! empty( $item['item_image'] ) ) {
					$images = explode( ',', trim( $item['item_image'] ) );
					$urls   = array();
					foreach ( $images as $image ) {
						$urls[] = wp_get_attachment_image_url( $image, 'full' );
					}
					?>
					<span class="qodef-e-hover-content">
						<span class="qodef-e-hover-image" data-images="<?php echo implode( '|', $urls ); ?>" data-images-count="<?php echo count( $urls ); ?>">
							<?php echo wp_get_attachment_image( $images[0], 'full' ); ?>
						</span>
					</span>
				<?php } ?>
			</a>
		<?php } ?>
	</div>
</div>
