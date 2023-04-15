<?php if ( ! post_password_required() ) { ?>
	<div class="qodef-e-read-more">
		<?php
		if ( corsen_post_has_read_more() ) {
			$button_params = array(
				'link'          => get_permalink() . '#more-' . get_the_ID(),
				'button_layout' => 'textual',
				'text'          => esc_html__( 'Read More', 'corsen' ),
			);
		} else {
			$button_params = array(
				'link'          => get_the_permalink(),
				'button_layout' => 'filled',
				'text'          => esc_html__( 'Read More', 'corsen' ),
			);
		}

		corsen_render_button_element( $button_params, 'qodef-textual-button' );
		?>
	</div>
<?php } ?>
