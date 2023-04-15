<div class="qodef-admin-widgets-page">
	<form class="qodef-widgets-list qodef-dashboard-ajax-form" data-action="widget">
		<div class="qodef-admin-widget-header">
			<div class="qodef-widget-header-left">
				<div class="qodef-widget-header-left-inner">
					<?php qi_blocks_template_part( 'admin/admin-pages', 'sub-pages/widgets/templates/parts/search' ); ?>
				</div>
			</div>
			<div class="qodef-widget-header-right">
				<div class="qodef-widget-header-right-inner">
					<?php qi_blocks_template_part( 'admin/admin-pages', 'templates/parts/save', '', array( 'page_slug' => 'widget' ) ); ?>
				</div>
			</div>
		</div>
		<?php foreach ( $blocks as $block_subcategory => $subcat_blocks ) : ?>
			<div class="qodef-widgets-section">
				<?php
				qi_blocks_template_part(
					'admin/admin-pages',
					'sub-pages/widgets/templates/parts/section-title',
					'',
					array(
						'block_subcategory'   => $block_subcategory,
						'enabled_subcategory' => $enabled_subcategory,
					)
				);
				?>
				<div class="qodef-widget-grid">
					<div class="qodef-widget-grid-inner">
						<?php
						foreach ( $subcat_blocks as $block_key => $block ) :
							qi_blocks_template_part(
								'admin/admin-pages',
								'sub-pages/widgets/templates/item',
								'',
								array(
									'premium_flag' => $premium_flag,
									'disabled'     => $disabled,
									'block_key'    => $block_key,
									'block'        => $block,
								)
							);
						endforeach;
						?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</form>
</div>
