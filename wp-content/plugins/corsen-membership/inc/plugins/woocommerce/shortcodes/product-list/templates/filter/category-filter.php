<?php if ( 'yes' === $product_list_enable_filter_category ) { ?>
    <div class="qodef-category-filter">
        <div class="qodef-category-filter-list">
            <ul class="qodef-category-list">
                <?php echo corsen_core_get_product_list_category_filter( $params ); ?>
            </ul>
        </div>
    </div>
<?php } ?>

