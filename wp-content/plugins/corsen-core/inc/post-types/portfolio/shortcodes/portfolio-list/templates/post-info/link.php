<?php
$portfolio_url = corsen_core_get_portfolio_list_item_url( get_the_ID() );
?>
<a itemprop="url" class="qodef-e-post-link" href="<?php echo esc_url( $portfolio_url['link'] ); ?>" target="<?php echo esc_attr( $portfolio_url['target'] ); ?>"></a>
