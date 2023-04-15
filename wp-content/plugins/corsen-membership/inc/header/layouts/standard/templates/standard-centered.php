<div class="qodef-header-wrapper">
	<div class="qodef-header-logo">
		<?php
		// Include logo
		corsen_core_get_header_logo_image();
		?>
	</div>
	<?php
	// Include main navigation
	corsen_core_template_part( 'header', 'templates/parts/navigation' );

	// Include widget area one
	corsen_core_get_header_widget_area();
	?>
</div>
