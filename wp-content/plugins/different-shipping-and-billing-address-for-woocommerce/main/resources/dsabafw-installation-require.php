<?php

// Check If Woocommerce Is Install Or Not
add_action('admin_init', 'DSABAFW_check_plugin_state');
function DSABAFW_check_plugin_state(){
    if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
        set_transient( get_current_user_id() . 'dsabafwerror', 'message' );
    }
}

// Add Notice For Require Plugin
add_action('admin_notices', 'DSABAFW_show_notice');
function DSABAFW_show_notice() {
    if ( get_transient( get_current_user_id() . 'dsabafwerror' ) ) {
        deactivate_plugins( DSABAFW_BASE_NAME );
        delete_transient( get_current_user_id() . 'dsabafwerror' );
        echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
    }
}

