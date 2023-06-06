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
<?php if ( is_product() ): ?>

	<!-- this script is only for mobile and in product page -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.min.js" integrity="sha512-mDFhdB9XVuD54kvKFiWsJZM4aCnLeV6tX4bGswCtMIqfzP4C9XHuGruVQWfWcsFtFe9p42rNQZoqIVSWbAEolg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script>
	jQuery(function($){
		console.log("slick loaded");

		$('#productMobileSlider').slick({
			arrows: true,
			infinite:false,
			variableWidth: false,
			dots: true,
			speed: 500,
			useTransform:false,
		});
		
		//$('#productMobileSlider .slick-slide:first-child').addClass('slick-current slick-active')
	})
	</script>
<?php endif; ?>

<?php wp_footer(); ?>

<div class="popUpNotification closeNtification">
	<div class="message-content">
		<div class="closeNtification btn-close">x</div>
		<div class="message"></div>
	</div>
</div>
</body>
</html>
