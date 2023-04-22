<?php

if (!defined('ABSPATH')){
    exit;
}

// Save All Admin Setting Fields Comman 
add_action('init','dsabafw_dsabafw_comman_field_values_saved');
function dsabafw_dsabafw_comman_field_values_saved() {
    global $dsabafw_comman;
    $optionget = array(
        'dsabafw_enable_different_billing_adress' => 'yes',
        'dsabafw_max_adress' => '3',
        'dsabafw_select_address_type' => 'Dropdown',
        'dsabafw_select_address_position' => 'billing_before_form_data',
        'dsabafw_head_title' => 'Add New Billing Address',
        'dsabafw_enable_different_shipping_adress' => 'yes',
        'dsabafw_max_shipping_adress' => '3',
        'dsabafw_select_shipping_address_type' => 'Dropdown',
        'dsabafw_select_shipping_address_position' => 'shipping_before_form_data',
        'dsabafw_head_title_ship' => 'Add New Shipping Address',
        'dsabafw_font_size' => '15',
        'dsabafw_font_clr' => '#ffffff',
        'dsabafw_btn_bg_clr' => '#000000',
        'dsabafw_btn_padding' => '8px 10px',
        'dsabafw_select_popup_btn_style' => 'button',
        'dsabafw_shipping_select_popup_btn_style' => 'button',
        'dsabafw_user_role_enable_disable' => '',
    );
   
    foreach ($optionget as $key_optionget => $value_optionget) {
       $dsabafw_comman[$key_optionget] = get_option( $key_optionget,$value_optionget );
    }
}