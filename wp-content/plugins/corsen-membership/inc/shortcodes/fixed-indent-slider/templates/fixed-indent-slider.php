<div <?php qode_framework_class_attribute( $holder_outer_classes ); ?>>
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
			'button_layout' => 'filled',
			'custom_class'  => 'qodef-m-button',
			);

			if ( ! empty( $button_params ) && ! empty( $button_params['text'] ) && class_exists( 'CorsenCore_Button_Shortcode' ) ) {
				echo CorsenCore_Button_Shortcode::call_shortcode( $button_params );
			}
			?>
		</div>
	</div>
	<div class="qodef-right-slider">
		<div class="qodef-fixed-indent-slider-holder swiper-container-horizontal" <?php qode_framework_inline_attr( $slider_data, 'data-options' ); ?>>
			<div class="qodef-m-items" <?php qode_framework_inline_attrs( $data_attrs ); ?>>
				<div class="qodef-m-swiper">
					<div class="swiper-wrapper">
						<?php
						foreach ( $items as $item ) :
							$image_alt = get_post_meta( $item['item_image'], '_wp_attachment_image_alt', true ); ?>

							<div class="qodef-m-item swiper-slide">
								<?php if ( ! empty( $item['item_link'] ) ) : ?>
									<a class="qodef-m-item-link" href="<?php echo esc_url( $item['item_link'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
								<?php endif; ?>
									<?php echo wp_get_attachment_image( $item['item_image'], 'full' ); ?>
									<span class="qodef-m-item-overlay"></span>
								<?php if ( ! empty( $item['item_link'] ) ) : ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div><!-- .swiper-wrapper -->
				</div><!-- .qodef-m-swiper -->
			</div><!-- .qodef-m-items -->
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
