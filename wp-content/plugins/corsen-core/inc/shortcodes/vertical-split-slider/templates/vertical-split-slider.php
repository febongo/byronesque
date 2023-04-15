<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="ms-left">
		<?php $count = 1; ?>
		<?php if ( ! empty( $items ) ) : ?>
			<?php foreach ( $items as $key => $item ) : ?>
				<?php
				$slide_image_classes   = $this_object->get_slide_classes( true, 'image', $item );
				$slide_image_styles    = $this_object->get_slide_image_styles( $item );
				$slide_content_classes = $this_object->get_slide_classes( true, 'content', $item );
				$slide_content_styles  = $this_object->get_slide_content_styles( $item );
				$slide_data            = $this_object->get_slide_data( $item ); // slide data only on left part of the slide
				$params['count']       = $count;
				$count ++;
				$params['item'] = $item;
				?>
				<?php if ( 'image-left' === $item['slide_layout'] ) : ?>
					<div <?php qode_framework_class_attribute( $slide_image_classes ); ?> <?php echo qode_framework_get_inline_attrs( $slide_data ); ?> <?php qode_framework_inline_style( $slide_image_styles ); ?>>
					</div>
				<?php else : ?>
					<div <?php qode_framework_class_attribute( $slide_content_classes ); ?> <?php qode_framework_inline_style( $slide_content_styles ); ?> <?php echo qode_framework_get_inline_attrs( $slide_data ); ?>>
						<?php
						// include content template
						corsen_core_template_part( 'shortcodes/vertical-split-slider', 'variations/' . $item['slide_content_layout'] . '/templates/' . $item['slide_content_layout'], '', $params );

						// include image template
						corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/image', '', $params );
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div><!-- .ms-left -->
	<div class="ms-right">
		<?php $count = 1; ?>
		<?php if ( ! empty( $items ) ) : ?>
			<?php foreach ( $items as $key => $item ) : ?>
				<?php
				$slide_image_classes   = $this_object->get_slide_classes( true, 'image', $item );
				$slide_image_styles    = $this_object->get_slide_image_styles( $item );
				$slide_content_classes = $this_object->get_slide_classes( true, 'content', $item );
				$slide_content_styles  = $this_object->get_slide_content_styles( $item );
				$params['count']       = $count;
				$count ++;
				$params['item'] = $item;
				?>
				<?php if ( 'image-right' === $item['slide_layout'] ) : ?>
					<div <?php qode_framework_class_attribute( $slide_image_classes ); ?> <?php qode_framework_inline_style( $slide_image_styles ); ?>>
					</div>
				<?php else : ?>
					<div <?php qode_framework_class_attribute( $slide_content_classes ); ?> <?php qode_framework_inline_style( $slide_content_styles ); ?>>
						<?php
						// include content template
						corsen_core_template_part( 'shortcodes/vertical-split-slider', 'variations/' . $item['slide_content_layout'] . '/templates/' . $item['slide_content_layout'], '', $params );

						// include image template
						corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/image', '', $params );
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div><!-- .ms-right -->
</div>
<div class="qodef-vertical-split-slider-responsive qodef-m">
	<?php $count = 1; ?>
	<?php if ( ! empty( $items ) ) : ?>
		<?php foreach ( $items as $key => $item ) : ?>
			<?php
			$slide_image_classes   = $this_object->get_slide_classes( false, 'image', $item );
			$slide_image_styles    = $this_object->get_slide_image_styles( $item );
			$slide_content_classes = $this_object->get_slide_classes( false, 'content', $item );
			$slide_content_styles  = $this_object->get_slide_content_styles( $item );
			$params['count']       = $count;
			$count ++;
			$params['item'] = $item;
			?>
			<div <?php qode_framework_class_attribute( $slide_image_classes ); ?> <?php qode_framework_inline_style( $slide_image_styles ); ?>>
			</div>
			<div <?php qode_framework_class_attribute( $slide_content_classes ); ?> <?php qode_framework_inline_style( $slide_content_styles ); ?>>
				<?php
				// include content template
				corsen_core_template_part( 'shortcodes/vertical-split-slider', 'variations/' . $item['slide_content_layout'] . '/templates/' . $item['slide_content_layout'], '', $params );
				?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
