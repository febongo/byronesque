<article <?php post_class( 'qodef-blog-item qodef-e' ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		corsen_template_part( 'blog', 'templates/parts/post-info/media' );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-top-holder">
				<div class="qodef-e-info">
					<?php
                    if ( ! has_post_thumbnail() ) {
                        // Include post date info
                        corsen_template_part( 'blog', 'templates/parts/post-info/date' );
                    }

					// Include post category info
					corsen_template_part( 'blog', 'templates/parts/post-info/categories' );
					?>
				</div>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
				corsen_template_part( 'blog', 'templates/parts/post-info/title' );

				// Include post content
				the_content();

				// Hook to include additional content after blog single content
				do_action( 'corsen_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-bottom-holder">
				<div class="qodef-e-left qodef-e-info">
					<?php
                    // Include post tags info
                    corsen_template_part( 'blog', 'templates/parts/post-info/tags' );
					?>
				</div>
				<div class="qodef-e-right qodef-e-info">
					<?php
					// Include post tags info
					corsen_template_part( 'blog', 'templates/parts/post-info/social-share' );

                    if ( ! corsen_is_installed( 'core' ) ) {
                        corsen_template_part( 'blog', 'templates/parts/post-info/author' );
                        corsen_template_part( 'blog', 'templates/parts/post-info/comments' );
                    }
					?>
				</div>
			</div>
		</div>
	</div>
</article>
