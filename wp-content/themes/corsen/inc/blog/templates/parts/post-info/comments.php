<?php if ( comments_open() ) { ?>
	<a itemprop="url" href="<?php comments_link(); ?>" class="qodef-e-info-comments-link">
		<span><?php comments_number( '0 ' . esc_html__( 'Comments', 'corsen' ), '1 ' . esc_html__( 'Comment', 'corsen' ), '% ' . esc_html__( 'Comments', 'corsen' ) ); ?></span>
	</a>
    <?php if ( corsen_is_installed( 'core' ) ) { ?>
        <div class="qodef-info-separator-end"></div>
    <?php } ?>
<?php } ?>
