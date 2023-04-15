<?php if ( ! empty( $title ) ) : ?>
	<?php
	$title_tag = isset( $title_tag ) && ! empty( $title_tag ) ? $title_tag : 'h1';
	?>
	<?php echo '<' . esc_attr( $title_tag ); ?> class="qodef-m-title">
	<?php echo esc_html( $title ); ?>
	<?php echo '</' . esc_attr( $title_tag ); ?>>
<?php endif; ?>
