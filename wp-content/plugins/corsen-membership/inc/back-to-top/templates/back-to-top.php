<?php
$custom_icon    = corsen_core_get_custom_svg_opener_icon_html( 'back_to_top' );
$holder_classes = array();
if ( empty( $custom_icon ) ) {
	$holder_classes[] = 'qodef--predefined';
}
?>
<a id="qodef-back-to-top" href="#" <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<span class="qodef-back-to-top-icon">
		<?php
		if ( ! empty( $custom_icon ) ) {
			echo corsen_core_get_custom_svg_opener_icon_html( 'back_to_top' );
		} else {
			echo qode_framework_icons()->get_specific_icon_from_pack( 'back-to-top', 'elegant-icons' );
		}
		?>
	</span>
</a>
