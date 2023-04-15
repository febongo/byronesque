<?php
$additional_info_enabled  = corsen_get_post_value_through_levels( 'qodef_blog_list_enable_additional_info' ) !== 'no';
?>
<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		corsen_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/media', '', $params );
		?>
		<div class="qodef-e-content">
            <div class="qodef-e-top-holder">
                <div class="qodef-e-info">
                    <?php
                    if ( ! has_post_thumbnail() ) {
                        // Include post date info
                        corsen_template_part( 'blog', 'templates/parts/post-info/date' );
                    }

                    if ( $additional_info_enabled  && corsen_is_installed( 'core' ) ) {
                        // Include post category info
                        corsen_template_part('blog', 'templates/parts/post-info/author');

                        // Include post category info
                        corsen_template_part( 'blog', 'templates/parts/post-info/comments' );
                    }

                    // Include post category info
                    corsen_template_part( 'blog', 'templates/parts/post-info/categories' );

                    ?>
                </div>
            </div>
            <div class="qodef-e-text">
                <?php
                // Include post title
                corsen_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );

                // Include post excerpt
                corsen_template_part( 'blog', 'templates/parts/post-info/excerpt' );

                // Hook to include additional content after blog single content
                do_action( 'corsen_action_after_blog_single_content' );
                ?>
            </div>
            <div class="qodef-e-bottom-holder">
                <div class="qodef-e-left">
                    <?php

                    corsen_template_part( 'blog', 'templates/parts/post-info/tags' );
                    ?>
                </div>
                <div class="qodef-e-right qodef-e-info">
                    <?php

                    // Include post social share info
                    corsen_template_part( 'blog', 'templates/parts/post-info/social-share' );
                    ?>
                </div>
            </div>
            <?php
            // Include post read more
            if ( $additional_info_enabled  && corsen_is_installed( 'core' ) ) {
                // Include read more
                corsen_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/read-more', '', $params );
            }
            ?>
		</div>
	</div>
</article>
