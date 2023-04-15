<div class="qodef-divided-header-left-wrapper">
	<?php
	// Include divided left navigation
	corsen_core_template_part( 'header/layouts/divided', 'templates/parts/left-navigation' );
	?>
</div>
<?php
// Include logo
corsen_core_get_header_logo_image();
?>
<div class="qodef-divided-header-right-wrapper">
	<?php
	// Include divided right navigation
	corsen_core_template_part( 'header/layouts/divided', 'templates/parts/right-navigation' );

	// Include widget area one
	corsen_core_get_header_widget_area();
	?>
</div>
