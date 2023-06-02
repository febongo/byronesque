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
<div class="popUpNotification closeNtification" style="position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.4);
    z-index: 199;
	display:none">
	<div class="message-content" style="    max-width: 500px;
    min-height: 300px;
    background: #fdfdfd;
    margin: auto;
    position: relative;
    top: 35%;">
		<div class="closeNtification">x</div>
		<div class="message"></div>
	</div>
</div>
</body>
</html>
