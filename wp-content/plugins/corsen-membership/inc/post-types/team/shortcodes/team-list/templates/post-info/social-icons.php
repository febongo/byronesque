<?php
$social_icons = get_post_meta( get_the_ID(), 'qodef_team_member_social_icons', true );

if ( ! empty( $social_icons ) ) {
	$framework_icons = QodeFrameworkIcons::get_instance();
	?>
	<div class="qodef-team-member-social-icons">
		<?php

		foreach ( $social_icons as $icon ) {
			if ( ! empty( $icon['qodef_team_member_icon'] ) && 'no' === $icon['qodef_enable_text_icon'] ) {
				$social_link      = $icon['qodef_team_member_icon_link'];
				$social_target    = ! empty( $icon['qodef_team_member_icon_target'] ) ? $icon['qodef_team_member_icon_target'] : '_blank';
				$social_icon_pack = $icon['qodef_team_member_icon'];
				$social_icon_name = $framework_icons->get_formatted_icon_field_name( 'qodef_team_member_icon', $social_icon_pack, '-' );
				$social_icon      = $icon[ $social_icon_name ];

				if ( ! empty( $social_icon ) && 'no' === $icon['qodef_enable_text_icon'] ) {
					?>
					<a class="qodef-team-member-social-icon" href="<?php echo esc_url( $social_link ); ?>" target="<?php echo esc_attr( $social_target ); ?>">
						<?php echo qode_framework_wp_kses_html( 'html', $framework_icons->render_icon( $social_icon, $social_icon_pack ) ); ?>
					</a>
				<?php }
                ?>
			<?php }

			else if( 'yes' === $icon['qodef_enable_text_icon']) {
                $social_icon_text      = $icon['qodef_team_member_icon_text'];
                $social_link      = $icon['qodef_team_member_icon_link'];
                $social_target    = ! empty( $icon['qodef_team_member_icon_target'] ) ? $icon['qodef_team_member_icon_target'] : '_blank';
                if ( 'yes' === $icon['qodef_enable_text_icon'] ) {
                    ?>
                    <a class="qodef-team-member-social-icon icon-text" href="<?php echo esc_url( $social_link ); ?>" target="<?php echo esc_attr( $social_target ); ?>">
                        <?php echo esc_html( $social_icon_text ); ?>
                    </a>
                <?php }
            }
			?>
		<?php } ?>
	</div>
<?php } ?>
