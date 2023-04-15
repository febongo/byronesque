<?php
// Load title image template
corsen_core_get_page_title_image();
?>
<div class="qodef-m-content <?php echo esc_attr( corsen_core_get_page_title_content_classes() ); ?>">
	<?php
	// Load breadcrumbs template
	corsen_core_breadcrumbs();
	?>
</div>
