<svg class="<?php echo esc_attr( $class ); ?>" width="100" height="100" viewBox="0 0 100 100">
	<filter id="<?php echo esc_attr( $class ) . '-' . wp_unique_id(); ?>" x="-30%" y="-30%" width="160%" height="150%">
		<feGaussianBlur in="SourceGraphic" stdDeviation="0"></feGaussianBlur>
	</filter>
</svg>


