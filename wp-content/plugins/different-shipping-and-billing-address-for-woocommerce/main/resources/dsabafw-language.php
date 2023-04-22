<?php

// Use load textdomain
add_action( 'plugins_loaded', 'DSABAFW_load_textdomain_pro' );
function DSABAFW_load_textdomain_pro() {
    load_plugin_textdomain( 'different-shipping-and-billing-address-for-woocommerce', false, dirname( DSABAFW_BASE_NAME ) . '/languages' ); 
}

// Use load textdomain mofile
function DSABAFW_load_my_own_textdomain_pro( $mofile, $domain ) {
    if ( 'different-shipping-and-billing-address-for-woocommerce' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( DSABAFW_BASE_NAME ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'DSABAFW_load_my_own_textdomain_pro', 10, 2 );