<div <?php qode_framework_class_attribute( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/image', '', $params ); ?>
		<div class="qodef-e-content">
			<?php
			if ( ! empty( $behavior ) && 'columns' === $behavior ) :
				?>
				<span class="qodef-e-testimonials-icon">
					<?php corsen_core_render_svg_icon( 'quote-testimonials' ); ?>
				</span>
			<?php endif; ?>
			<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/title', '', $params ); ?>
			<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/text', '', $params ); ?>
			<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/author', '', $params ); ?>
			<?php
			if ( ! empty( $behavior ) && 'columns' === $behavior || '1' !== $columns ) :
				?>
				<?php corsen_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/client-image', '', $params ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
