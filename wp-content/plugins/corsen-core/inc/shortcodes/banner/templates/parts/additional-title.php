<?php if ( ! empty( $additional_title ) ) : ?>
    <span class="qodef-title-decoration-svg">
      <svg xmlns="http://www.w3.org/2000/svg" width="17.526" height="17.525" viewBox="0 0 17.526 17.525">
        <g transform="translate(-1397.768 -3042.303)">
            <path d="M1398.829,3043.364l15.4,15.4" fill="none" stroke="#fff" stroke-width="3"/>
            <path d="M1414.234,3043.364l-15.4,15.4" fill="none" stroke="#fff" stroke-width="3"/>
        </g>
    </svg>
    </span>
	<?php echo '<' . esc_attr( $title_tag ); ?> class="qodef-m-additional-title" <?php qode_framework_inline_style( $title_styles ); ?>>
		<?php echo esc_html( $additional_title ); ?>
	<?php echo '</' . esc_attr( $title_tag ); ?>>
<?php endif; ?>
