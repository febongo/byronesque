<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/static-title', '', $params ); ?>
	<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/quote-mark', '', $params ); ?>
	<?php if ( ! empty( $behavior ) && 'slider' === $behavior && '1' === $columns && 'no' === $hide_client_images) : ?>
		<div class="qodef-text-holder">
            <div class="swiper-wrapper">
                <?php
                // Include items
                corsen_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop', '', $params );
                ?>
            </div>
		</div>
		<div class="qodef-thumbnails-holder">
			<div class="swiper-wrapper">
				<?php
				// Include items
				corsen_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop-navigation', '', $params );
				?>
			</div>
		</div>
	<?php else : ?>
		<div class="swiper-wrapper">
			<?php
			// Include items
			corsen_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop', '', $params );
			?>
		</div>
	<?php endif; ?>
	<?php corsen_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
	<?php corsen_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
</div>
