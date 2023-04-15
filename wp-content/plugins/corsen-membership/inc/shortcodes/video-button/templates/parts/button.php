<?php if ( ! empty( $video_link ) ) { ?>
	<a itemprop="url" class="qodef-m-play qodef-magnific-popup qodef-popup-item" <?php echo qode_framework_get_inline_style( $play_button_styles ); ?> href="<?php echo esc_url( $video_link ); ?>" data-type="iframe">
		<span class="qodef-m-play-inner">
			<svg xmlns="http://www.w3.org/2000/svg" width="22" height="27.7" viewBox="0 0 21.6 27.7">
                <path d="M21.6 14 0 27.7V0l21.6 13.8Z"/>
            </svg>
		</span>
	</a>
<?php } ?>
