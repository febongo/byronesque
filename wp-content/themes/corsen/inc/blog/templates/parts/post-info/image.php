<?php if ( has_post_thumbnail() ) { ?>
    <div class="qodef-image-date">
        <?php
        // Include post date info
        corsen_template_part( 'blog', 'templates/parts/post-info/date' );
        ?>
    </div>
	<div class="qodef-e-media-image">
		<?php if ( ! is_single() ) { ?>
			<a itemprop="url" href="<?php the_permalink(); ?>">
		<?php } ?>
			<?php the_post_thumbnail( 'full' ); ?>
		<?php if ( ! is_single() ) { ?>
			</a>
		<?php } ?>
		<?php
		// Hook to include additional content after blog post featured image
		do_action( 'corsen_action_after_post_thumbnail_image' );
		?>
	</div>
<?php } ?>
