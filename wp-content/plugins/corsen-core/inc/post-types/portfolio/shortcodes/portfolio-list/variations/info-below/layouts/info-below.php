<?php
$styles = array();
if ( ! empty( $info_below_content_margin_top ) ) {
	$margin_top = qode_framework_string_ends_with_space_units( $info_below_content_margin_top ) ? $info_below_content_margin_top : intval( $info_below_content_margin_top ) . 'px';
	$styles[]   = 'margin-top:' . $margin_top;
}
?>
<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner" <?php qode_framework_inline_style( $this_shortcode->get_list_item_style( $params ) ); ?>>
		<div class="qodef-e-image">
			<?php corsen_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/image', '', $params ); ?>
		</div>
		<div class="qodef-e-content" <?php qode_framework_inline_style( $styles ); ?>>
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
					// Include portfolio category info
					corsen_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/categories', '', $params );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php corsen_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'post-info/title', '', $params ); ?>
			</div>
		</div>
	</div>
</article>
