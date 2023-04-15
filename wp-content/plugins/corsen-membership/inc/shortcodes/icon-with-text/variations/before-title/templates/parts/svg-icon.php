<?php if ( 'svg-icon' === $icon_type && ! empty( $svg ) ) { ?>
    <span class="qodef-icon-holder">
		<span class="qodef-m-svg" <?php echo qode_framework_get_inline_style( $svg_styles ); ?>>
			<?php echo qode_framework_wp_kses_html( 'html', $svg ); ?>
		</span>
	</span>
    <?php
}
