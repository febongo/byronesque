<?php if ( has_nav_menu( 'divided-menu-right-navigation' ) ) : ?>
	<nav class="qodef-header-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Divided Right Menu', 'corsen-core' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'divided-menu-right-navigation',
				'container'      => '',
				'link_before'    => '<span class="qodef-menu-item-text">',
				'link_after'     => '</span>',
				'walker'         => new CorsenCoreRootMainMenuWalker(),
			)
		);
		?>
	</nav>
<?php endif; ?>
