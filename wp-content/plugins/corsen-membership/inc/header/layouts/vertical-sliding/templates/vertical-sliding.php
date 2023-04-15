<?php do_action( 'corsen_action_before_page_header' ); ?>

<header id="qodef-page-header" role="banner">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'corsen_filter_header_inner_class', array(), 'default' ) ); ?>">
		<div class="qodef-vertical-sliding-area qodef--static">
			<?php
			// include opener
			corsen_core_get_opener_icon_html(
				array(
					'option_name'  => 'vertical_sliding_menu',
					'custom_class' => 'qodef-vertical-sliding-menu-opener',
                    'custom_icon'  => 'vertical-menu-opener',
				),
				true
			);

            // include logo
            corsen_core_get_header_logo_image();

			// include widget area one
			corsen_core_get_header_widget_area();
			?>
		</div>
		<div class="qodef-vertical-sliding-area qodef--dynamic">
			<?php
			// include vertical sliding navigation
			corsen_core_template_part( 'header', 'layouts/vertical-sliding/templates/navigation' );
			?>
		</div>
	</div>
</header>
