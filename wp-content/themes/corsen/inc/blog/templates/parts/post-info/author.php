<a itemprop="author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="qodef-e-info-author">
    <span><?php the_author_meta( 'display_name' ); ?></span>
</a>
<?php if ( corsen_is_installed( 'core' ) ) { ?>
    <div class="qodef-info-separator-end"></div>
<?php } ?>
