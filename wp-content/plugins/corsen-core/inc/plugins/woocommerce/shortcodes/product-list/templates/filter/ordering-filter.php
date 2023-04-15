<?php
$symbol = get_woocommerce_currency_symbol();
$constant = ( $product_prices['max'] - $product_prices['min'] ) / 5;
$newMin = $product_prices['min'] + $constant;
?>

<?php if ( 'yes' === $product_list_enable_filter_order_by ) { ?>
	<div class="qodef-order-price-filter">
		<div class="qodef-filter-title-holder">
			<span class="qodef-filter-title qodef-preceding"><?php esc_html_e( 'Filter', 'corsen-core' ); ?></span>
			<span class="qodef-filter-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="8.576" height="4.995" viewBox="0 0 8.576 4.995">
                    <path d="M233.079,409.938l3.934,3.934-3.934,3.934" transform="translate(418.16 -232.725) rotate(90)" fill="none" stroke="#000" stroke-width="1"/>
                </svg>
            </span>
		</div>
        <div class="qodef-filter-holder-inner">
            <div class="qodef-filter-ordering">
                <h6><?php esc_html_e( 'Sort by', 'corsen-core' );?></h6>
                <div class="qodef-filter-list">
                    <ul class="qodef-sorting-filter">
                        <li>
                            <a class="qodef-ordering-filter-link" data-ordering="<?php echo esc_html( $orderby ); ?>" href="#"><?php echo esc_html__( 'Default', 'corsen-core' ); ?></a>
                        </li>
                        <?php echo corsen_core_get_product_list_sorting_filter( $params ); ?>
                    </ul>
                </div>
            </div>
            <div class="qodef-filter-price" data-type="price" data-range="<?php esc_attr_e( $constant ); ?>">
                <h6><?php esc_html_e( 'Price Range', 'corsen-core' );?></h6>
                <div class="qodef-filter-list">
                    <ul class="qodef-price-filter">
                        <li>
                            <a class="qodef-price-filter-link" name="qodef-plf-price" data-value="1" data-price="<?php esc_attr_e( $product_prices['min'] ); ?>" href=""><?php esc_attr_e( $symbol ); esc_attr_e( $product_prices['min'] ); ?> - <?php esc_attr_e( $symbol ); esc_attr_e(floor( $newMin ) ); ?></a>
                        </li>
                        <li>
                            <a class="qodef-price-filter-link" name="qodef-plf-price" data-value="2" data-price="<?php esc_attr_e( $newMin ); ?>" href=""><?php esc_attr_e( $symbol ); esc_attr_e ($newMin ); ?> - <?php esc_attr_e( $symbol ); esc_attr_e(floor( $newMin+$constant ) ); ?></a>
                        </li>
                        <li>
                            <a class="qodef-price-filter-link" name="qodef-plf-price" data-value="3" data-price="<?php esc_attr_e( $newMin + $constant ); ?>" href=""><?php esc_attr_e($symbol); esc_attr_e( $newMin+$constant ); ?> - <?php esc_attr_e( $symbol ); esc_attr_e(floor( $newMin+$constant*2 ) ); ?></a>
                        </li>
                        <li>
                            <a class="qodef-price-filter-link" name="qodef-plf-price" data-value="4" data-price="<?php esc_attr_e( $newMin + $constant * 2 ); ?>" href=""><?php esc_attr_e( $symbol ); esc_attr_e( $newMin+$constant*2 ); ?> - <?php esc_attr_e( $symbol ); esc_attr_e( floor($newMin+$constant*3 ) ); ?></a>
                        </li>
                        <li>
                            <a class="qodef-price-filter-link" name="qodef-plf-price" data-value="5" data-price="<?php esc_attr_e( $newMin + $constant * 3 ); ?>" href=""><?php esc_attr_e( $symbol ); esc_attr_e( $newMin + $constant * 3 ); ?><?php esc_html_e('+', 'corsen-core' ); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
	</div>
<?php } ?>
