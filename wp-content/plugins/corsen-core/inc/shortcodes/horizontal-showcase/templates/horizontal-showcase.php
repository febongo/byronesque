<div <?php qode_framework_class_attribute( $holder_classes ); ?>>

	<div class="qodef-slides-holder">
		<?php if ( ! empty( $featured_image ) ) { ?>
			<div class="qodef-m-item qodef-horizontal-slide qodef-featured">
				<?php echo wp_get_attachment_image( $featured_image, 'full' ); ?>
			</div>
		<?php } ?>
		<?php
		$counter   = 1;
		$max_count = count( $items );
		foreach ( $items as $item ) {
			$item_classes = $this_shortcode->get_slide_classes( $item );
			if ( $counter === $max_count ) {
				$item_classes .= ' qodef-last-item';
			} elseif ( $counter === 1 ) {
				$item_classes .= ' qodef-first-item';
			}
			?>
			<div <?php qode_framework_class_attribute( $item_classes ); ?> <?php qode_framework_inline_style( $this_shortcode->get_slide_styles( $item ) ); ?>>
				<div class="qodef-slide-content">

					<div class="qodef-slide-images">
						<?php
						foreach ( array( 1, 2 ) as $index ) {
							if ( ! empty( $item[ 'item_image' . $index ] ) ) {
								?>

								<?php
									$slide_image_classes = 'qodef-slide-image qodef-slide-image--' . $index;
								?>

								<div class="<?php echo esc_attr( $slide_image_classes ); ?>">
									<?php if ( ! empty( $item[ 'item_image' . $index . '_link' ] ) ) { ?>
										<a itemprop="url" class="qodef-img-holder" href="<?php echo esc_url( $item[ 'item_image' . $index . '_link' ] ); ?>" target="<?php echo esc_attr( $item[ 'item_image' . $index . '_target' ] ); ?>">
											<?php echo wp_get_attachment_image( $item[ 'item_image' . $index ], 'full', false, array( 'loading' => 'eager' ) ); ?>
										</a>
									<?php } else { ?>
										<span class="qodef-img-holder">
											<?php echo wp_get_attachment_image( $item[ 'item_image' . $index ], 'full', false, array( 'loading' => 'eager' ) ); ?>
										</span>
									<?php } ?>

								<?php if ( ! empty( $item[ 'item_image' . $index . '_title' ] ) || ! empty( $item[ 'item_image' . $index . '_button_link' ] ) ) { ?>
									<div class="qodef-content-holder">
										<h2 class="qodef-e-title"><?php esc_html_e( $item[ 'item_image' . $index . '_title' ] ); ?></h2>

										<?php
										$button_params = array(
											'button_layout' => 'outlined',
											'link'   => $item[ 'item_image' . $index . '_button_link' ],
											'target' => $item[ 'item_image' . $index . '_button_target' ],
											'text'   => $item[ 'item_image' . $index . '_button_text' ],
										);

										if ( class_exists( 'CorsenCore_Button_Shortcode' ) && ! empty( $button_params['link'] ) && ! empty( $button_params['text'] ) ) {
											?>
											<?php echo CorsenCore_Button_Shortcode::call_shortcode( $button_params ); ?>
											<?php
										}
										?>
									</div>
								<?php } ?>

									<?php if ( ! empty( $item[ 'item_image' . $index . '_title_first_line' ] ) || ! empty( $item[ 'item_image' . $index . '_title_second_line' ] ) ) { ?>
										<h6 class="qodef-e-title">
											<?php if ( ! empty( $item[ 'item_image' . $index . '_title_first_line' ] ) ) { ?>
												<span class="qodef-title-first-line"><?php esc_html_e( $item[ 'item_image' . $index . '_title_first_line' ] ); ?></span>
											<?php } ?>
											<?php if ( ! empty( $item[ 'item_image' . $index . '_title_second_line' ] ) ) { ?>
												<span class="qodef-title-second-line"><?php esc_html_e( $item[ 'item_image' . $index . '_title_second_line' ] ); ?></span>
											<?php } ?>
										</h6>
									<?php } ?>
								</div>
								<?php
							}
						}
						?>

					</div>
				</div>
			</div>
			<?php
			$counter ++;
		}
		?>

		<?php if ( ! empty( $scroll_back ) && 'yes' === $scroll_back ) { ?>
			<div class="qodef-scroll-back">
				<?php
				$button_params = array(
					'custom_class'  => 'qodef-label',
					'button_layout' => 'textual',
					'link'          => '#',
					'target'        => '',
					'text'          => esc_html__( 'Back to Start', 'corsen-core' ),
				);

				if ( class_exists( 'CorsenCore_Button_Shortcode' ) ) {
					echo CorsenCore_Button_Shortcode::call_shortcode( $button_params );
				}
				?>

				<?php if ( ! empty( $social_items ) ) { ?>
					<div class="qodef-m-social-info">

						<?php if ( ! empty( $social_items ) ) { ?>
							<div class="qodef-m-social-info-inner">
								<?php
								foreach ( $social_items as $social_item ) {
									if ( ! empty( $social_item['social_item_text'] ) && ! empty( $social_item['social_item_link'] ) ) {
										?>
										<a class="qodef-social-item" href="<?php echo esc_url( $social_item['social_item_link'] ); ?>" target="<?php echo esc_attr( $social_links_target ); ?>"><?php echo esc_html( $social_item['social_item_text'] ); ?></a>
										<?php
									}
								}
								?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

	</div>
	<?php if ( ! empty( $featured_image ) ) { ?>
		<div class="qodef-featured-fixed">
			<?php echo wp_get_attachment_image( $featured_image, 'full' ); ?>
		</div>
	<?php } ?>
</div>
