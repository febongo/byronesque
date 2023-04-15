<?php if ( ! empty( $label ) ) { ?>
	<div class="qodef-m-label">
		<div class="qodef-m-label-wrapper" <?php qode_framework_inline_style( $label_styles ); ?>>
			<span class="qodef-m-label-value"><?php echo esc_html( $label ); ?></span>
		</div>
	</div>
<?php } ?>
