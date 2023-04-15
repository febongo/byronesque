<?php
	$spinner_bg_image       = corsen_core_get_post_value_through_levels( 'qodef_spinner_background_image' );
	$spinner_bg_image_url   = esc_url( wp_get_attachment_image_url( $spinner_bg_image, 'full' ) );
	$spinner_bg_image_style = ! empty( $spinner_bg_image_url ) ? 'background-image: url( ' . esc_url( $spinner_bg_image_url ) . ')' : '';
	$spinner_svg            = corsen_core_get_post_value_through_levels( 'qodef_spinner_svg' );
?>
<span class="qodef-m-spinner-bg-image" <?php qode_framework_inline_style( $spinner_bg_image_style ); ?>>
</span>
<span class="qodef-m-spinner-bg-image-overlay"></span>
<div class="qodef-m-predefined">
	<span class="qodef-m-spinner-logo-holder">
		<span class="qodef-m-spinner-logo"><?php echo qode_framework_wp_kses_html('svg custom', $spinner_svg) ?></span>
	</span>
</div>

