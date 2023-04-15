<<?php echo esc_attr( $title_tag ); ?> class="qodef-accordion-title">
	<span class="qodef-tab-title"><?php echo esc_html( $title ); ?></span>
	<span class="qodef-accordion-mark">
		<span class="qodef-icon--plus">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24">
                <g data-name="Group 1077" transform="translate(0.087 0.087)">
                    <g data-name="Rectangle 571" transform="translate(-0.087 -0.087)" fill="#fff" stroke="#000" stroke-width="1">
                        <rect width="24" height="24" stroke="none"/>
                        <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                    </g>
                    <path d="M0,4.535,4.047,0,8.094,4.535" transform="translate(7.866 9.646)" fill="none" stroke="#000" stroke-width="1"/>
                </g>
            </svg>
        </span>
		<span class="qodef-icon--minus">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24">
             <g transform="translate(0.087 0.087)">
                 <g transform="translate(-0.087 -0.087)" fill="#fff" stroke="#000" stroke-width="1">
                    <rect width="24" height="24" stroke="none"/>
                    <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                    </g>
                    <path d="M0,4.535,4.047,0,8.094,4.535" transform="translate(16 14) rotate(180)" fill="none" stroke="#000" stroke-width="1"/>
                </g>
            </svg>
        </span>
	</span>
</<?php echo esc_attr( $title_tag ); ?>>
<div class="qodef-accordion-content">
	<div class="qodef-accordion-content-inner">
		<?php echo do_shortcode( $content ); ?>
	</div>
</div>
