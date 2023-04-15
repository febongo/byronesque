<div id="qodef-fullscreen-area">
	<?php if ( $fullscreen_menu_in_grid ) { ?>
	<div class="qodef-content-grid">
	<?php } ?>

		<div id="qodef-fullscreen-area-inner">
			<?php if ( has_nav_menu( 'fullscreen-menu-navigation' ) ) { ?>
				<nav class="qodef-fullscreen-menu" role="navigation" aria-label="<?php esc_attr_e( 'Full Screen Menu', 'corsen-core' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'fullscreen-menu-navigation',
							'container'      => '',
							'link_before'    => '<span class="qodef-menu-item-text">',
							'link_after'     => '</span>',
							'walker'         => new CorsenCoreRootMainMenuWalker(),
						)
					);
					?>
				</nav>
			<?php } ?>

            <div class="qodef-fullscreen-image-area">
            <?php
            if ( ! empty( $fullscreen_menu_image ) ) { ?>
                <div class="qodef-fullscreen-image-holder">
                    <?php echo wp_get_attachment_image( $fullscreen_menu_image, 'full' ); ?>
                </div>
            <?php
            }
            ?>

                <div class="qodef-fullscreen-content-holder">
                    <?php

                    if ( ! empty( $fullscreen_menu_side_title ) ) { ?>
                        <h2 class="qodef-m-title"><?php echo esc_html( $fullscreen_menu_side_title ); ?></h2>
                    <?php
                    }
                    ?>

                    <?php
                    $button_params = array(
                        'link'          => $fullscreen_menu_side_button_link,
                        'text'          => $fullscreen_menu_side_button_text,
                        'button_layout' => 'outlined',
                    );

                    if ( class_exists( 'CorsenCore_Button_Shortcode' ) & ! empty( $fullscreen_menu_side_button_text ) ) { ?>
                        <?php echo CorsenCore_Button_Shortcode::call_shortcode( $button_params ); ?>
                    <?php } ?>
                </div>
            </div>

            <?php
            corsen_core_get_header_widget_area( 'two' );
            ?>
		</div>

	<?php if ( $fullscreen_menu_in_grid ) { ?>
	</div>
	<?php } ?>
</div>
