			</div><!-- close #qodef-page-inner div from header.php -->
		</div><!-- close #qodef-page-outer div from header.php -->
		<?php
		// Hook to include page footer template
		do_action( 'corsen_action_page_footer_template' );

		// Hook to include additional content before wrapper close tag
		do_action( 'corsen_action_before_wrapper_close_tag' );
		?>
	</div><!-- close #qodef-page-wrapper div from header.php -->
	<?php
	// Hook to include additional content before body tag closed
	do_action( 'corsen_action_before_body_tag_close' );
	?>
<?php wp_footer(); ?>
<div class="popUpNotification closeNtification">
	<div class="message-content">
		<div class="closeNtification btn-close">x</div>
		<div class="message"></div>
	</div>
</div>
</body>
</html>
