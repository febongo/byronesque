<?php
// Hook to include additional content before page content holder
do_action( 'corsen_action_before_page_content_holder' );
?>
<main id="qodef-page-content" class="qodef-grid qodef-layout--template <?php echo esc_attr( corsen_get_grid_gutter_classes() ); ?>" role="main">
	<div class="qodef-grid-inner">
		<?php
		// Hook to include additional content before blog and sidebar
		do_action( 'corsen_action_before_blog_sidebar' );

		// Include blog template
		echo apply_filters( 'corsen_filter_blog_template', corsen_get_template_part( 'blog', 'templates/blog' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Include page content sidebar
		corsen_template_part( 'sidebar', 'templates/sidebar' );
		?>
	</div>
</main>
<?php
// Hook to include additional content after main page content holder
do_action( 'corsen_action_after_page_content_holder' );
?>
