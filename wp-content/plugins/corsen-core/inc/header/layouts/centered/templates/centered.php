<?php
// Include logo
corsen_core_get_header_logo_image();
?>
<div class="qodef-centered-header-wrapper">
	<?php
	// Include widget area two
	corsen_core_get_header_widget_area( 'two' );

	// Include main navigation
	corsen_core_template_part( 'header', 'templates/parts/navigation' );

	// Include widget area one
	corsen_core_get_header_widget_area();
	?>
</div>
