<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<a class="qodef-social-share-dropdown-opener" href="javascript:void(0)">
		<span class="qodef-social-title qodef-custom-label"><?php echo ! empty( $title ) ? esc_html( $title ) : esc_html__( 'Share', 'corsen-core' ); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="17" viewBox="0 0 14 17">
            <g id="Group_509" data-name="Group 509" transform="translate(-718 -1553)">
                <g id="Ellipse_10" data-name="Ellipse 10" transform="translate(718 1553)" fill="#fff" stroke="#000" stroke-width="1">
                    <circle cx="2.5" cy="2.5" r="2.5" stroke="none"/>
                    <circle cx="2.5" cy="2.5" r="2" fill="none"/>
                </g>
                <g id="Ellipse_11" data-name="Ellipse 11" transform="translate(718 1565)" fill="#fff" stroke="#000" stroke-width="1">
                    <circle cx="2.5" cy="2.5" r="2.5" stroke="none"/>
                    <circle cx="2.5" cy="2.5" r="2" fill="none"/>
                </g>
                <g id="Ellipse_12" data-name="Ellipse 12" transform="translate(727 1559)" fill="#fff" stroke="#000" stroke-width="1">
                    <circle cx="2.5" cy="2.5" r="2.5" stroke="none"/>
                    <circle cx="2.5" cy="2.5" r="2" fill="none"/>
                </g>
                <path id="Path_678" data-name="Path 678" d="M-4976.653,6874.6l5.644,3.706" transform="translate(5699 -5318.098)" fill="none" stroke="#000" stroke-width="1"/>
                <path id="Path_679" data-name="Path 679" d="M-4976.653,6878.3l5.644-3.706" transform="translate(5699 -5312.098)" fill="none" stroke="#000" stroke-width="1"/>
            </g>
        </svg>
    </a>
	<div class="qodef-social-share-dropdown">
		<ul class="qodef-shortcode-list">
			<?php
			foreach ( $social_networks as $net ) {
				echo wp_kses(
					$net,
					array(
						'li'   => array(
							'class' => true,
						),
						'a'    => array(
							'itemprop' => true,
							'class'    => true,
							'href'     => true,
							'target'   => true,
							'onclick'  => true,
						),
						'img'  => array(
							'itemprop' => true,
							'class'    => true,
							'src'      => true,
							'alt'      => true,
						),
						'span' => array(
							'class' => true,
						),
					)
				);
			}
			?>
		</ul>
	</div>
</div>
