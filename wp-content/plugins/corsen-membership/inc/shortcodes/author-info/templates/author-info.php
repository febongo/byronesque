<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <?php
    $author_id = 1;
    if ( ! empty( $author_username ) ) {
        $author = get_user_by( 'login', $author_username );

        if ( ! empty( $author ) ) {
            $author_id = $author->ID;
        }
    }

    $author_name = get_the_author_meta( 'display_name', $author_id );
    $author_link = ! empty( $author_custom_link ) ? $author_custom_link : get_author_posts_url( $author_id );
    $author_bio  = get_the_author_meta( 'description', $author_id );
    $author_bio  = ! empty( $author_custom_description ) ? $author_custom_description : get_the_author_meta( 'description', $author_id );

    if ( ! empty( $author_name ) && ! empty( $author_name_line_break_positions ) ) {
        $split_author_name          = explode( ' ', $author_name );
        $line_break_positions = explode( ',', str_replace( ' ', '', $author_name_line_break_positions ) );

        foreach ( $line_break_positions as $position ) {
            $position = intval( $position );
            if ( isset( $split_author_name[ $position - 1 ] ) && ! empty( $split_author_name[ $position - 1 ] ) ) {
                $split_author_name[ $position - 1 ] = $split_author_name[ $position - 1 ] . '<br />';
            }
        }

        $author_name = implode( ' ', $split_author_name );
    }
    ?>
    <div class="qodef-author-info-inner">
        <?php if ( ! empty( $disable_author_link ) && 'no' === $disable_author_link ) { ?>
        <a itemprop="url" class="qodef-author-info-image" href="<?php echo esc_url( $author_link ); ?>">
            <?php } ?>
            <?php echo get_avatar( $author_id, 222 ); ?>
            <?php if ( ! empty( $disable_author_link ) && 'no' === $disable_author_link ) { ?>
        </a>
    <?php } ?>
        <h4 class="qodef-author-info-name vcard author">
            <?php if ( ! empty( $disable_author_link ) && 'no' === $disable_author_link ) { ?>
            <a itemprop="url" href="<?php echo esc_url( $author_link ); ?>">
                <?php } ?>
                <span class="fn"><?php echo qode_framework_wp_kses_html( 'content', $author_name ); ?></span>
                <?php if ( ! empty( $disable_author_link ) && 'no' === $disable_author_link ) { ?>
            </a>
        <?php } ?>
        </h4>
    </div>
    <?php if ( ! empty( $author_bio ) ) { ?>
        <p itemprop="description" class="qodef-author-info-description"><?php echo esc_html( $author_bio ); ?></p>
    <?php } ?>
</div>
