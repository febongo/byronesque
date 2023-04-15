<?php
$social_share_enabled = 'yes' === corsen_core_get_post_value_through_levels( 'qodef_blog_enable_social_share' );
$social_share_layout  = corsen_core_get_post_value_through_levels( 'qodef_social_share_layout' );

if ( class_exists( 'CorsenCore_Social_Share_Shortcode' ) && $social_share_enabled ) { ?>
	<div class="qodef-e-info-item qodef-e-info-social-share">
		<?php
		$params = array(
			'title'  => esc_html__( 'Share:', 'corsen-core' ),
			'layout' => $social_share_layout,
		);

		echo CorsenCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
