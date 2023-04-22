<?php

if (!defined('ABSPATH')){
  exit;
}

// Add Submenu In Woocommerce Tab
add_action( 'admin_menu',   'DSABAFW_submenu_page');
function DSABAFW_submenu_page() {
    add_submenu_page( 'woocommerce', 'Different Address Option', 'Different Address Option', 'manage_options', 'different-address', 'DSABAFW_callback');
}

// Submenu Callback Function For Content
function DSABAFW_callback() {
    global $dsabafw_comman;
    ?>    
    <div class="wrap">
        <h2><?php echo __('Different Shipping And Billing Address Setting','different-shipping-and-billing-address-for-woocommerce');?></h2>
        <div class="card dsabafwd_notice">
            <h2><?php echo __('Please help us spread the word & keep the plugin up-to-date', 'different-shipping-and-billing-address-for-woocommerce');?></h2>
            <p>
                <a class="button-primary button" title="<?php echo __('Support Different Shipping And Billing Address', 'different-shipping-and-billing-address-for-woocommerce');?>" target="_blank" href="https://www.plugin999.com/support/"><?php echo __('Support', 'different-shipping-and-billing-address-for-woocommerce'); ?></a>
                <a class="button-primary button" title="<?php echo __('Rate WP Reset', 'different-shipping-and-billing-address-for-woocommerce');?>" target="_blank" href="https://wordpress.org/support/plugin/different-shipping-and-billing-address-for-woocommerce/reviews/?filter=5"><?php echo __('Rate the plugin ★★★★★', 'different-shipping-and-billing-address-for-woocommerce'); ?></a>
            </p>
        </div>
        <?php if(isset($_REQUEST['message']) && $_REQUEST['message'] == 'success'){ ?>
            <div class="notice notice-success is-dismissible"> 
                <p><strong><?php echo __('Record updated successfully.','different-shipping-and-billing-address-for-woocommerce');?></strong></p>
            </div>
        <?php } ?>
        <div class="dsabafw-container">
            <form method="post" >
                <?php wp_nonce_field( 'dsabafw_nonce_action', 'dsabafw_nonce_field' ); ?>
                <div id="poststuff">
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2><?php echo __('Different Billing Address Setting','different-shipping-and-billing-address-for-woocommerce');?></h2>
                        </div>
                        <div class="inside">
                            <table class="dsabafw_data_table">
                                <tr>
                                    <th><?php echo __('Enable Different Billing Address','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="checkbox" name="dsabafw_comman[dsabafw_enable_different_billing_adress]" class="dsabafw_enable_multi_bill_adress" value="yes"<?php if($dsabafw_comman['dsabafw_enable_different_billing_adress'] == 'yes'){echo "checked";} ?>>
                                    </td>
                                </tr>
                                <tr class="billing_address_setting">
                                    <th><?php echo __('MAX Billing Address','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="number" name="dsabafw_comman[dsabafw_max_adress]" class="regular-text" value="3" disabled>
                                        <label class="dsabafw_pro_link">
                                            <?php echo esc_html_e('This Option Available in','different-shipping-and-billing-address-for-woocommerce');?> <a href="https://www.plugin999.com/plugin/different-shipping-and-billing-address-for-woocommerce/" target="_blank">Pro Version</a>
                                        </label>
                                    </td>
                                </tr>
                                <tr class="billing_address_setting">
                                    <th><?php echo __('Select Billing Address Type On Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_select_address_type]" class="regular-text">
                                            <option value="Dropdown"<?php if($dsabafw_comman['dsabafw_select_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="Popup"<?php if($dsabafw_comman['dsabafw_select_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="billing_address_setting">
                                    <th><?php echo __('Select Billing Address position Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_select_address_position]" class="regular-text">
                                            <option value="billing_before_form_data"<?php if($dsabafw_comman['dsabafw_select_address_position'] == 'billing_before_form_data'){echo "selected";}?>><?php echo __('Before Billing Form Data','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="billing_after_form_data"<?php if($dsabafw_comman['dsabafw_select_address_position'] == 'billing_after_form_data'){echo "selected";}?>><?php echo __('After Billing Form Data','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="billing_address_setting">
                                    <th><?php echo __('Select Billing Popup Button Style Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_select_popup_btn_style]" class="regular-text">
                                            <option value="button"<?php if($dsabafw_comman['dsabafw_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="link"<?php if($dsabafw_comman['dsabafw_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="billing_address_setting">
                                    <th><?php echo __('Button Title for Billing','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="regular-text" name="dsabafw_comman[dsabafw_head_title]" value="Add New Billing Address" disabled>
                                            <label class="dsabafw_pro_link">
                                                <?php echo esc_html_e('This Option Available in','different-shipping-and-billing-address-for-woocommerce');?> <a href="https://www.plugin999.com/plugin/different-shipping-and-billing-address-for-woocommerce/" target="_blank">Pro Version</a>
                                            </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2><?php echo __('Different Shipping Address Setting','different-shipping-and-billing-address-for-woocommerce');?></h2>
                        </div>
                        <div class="inside">
                            <table class="dsabafw_data_table">
                                <tr>
                                    <th><?php echo __('Enable Different Shipping Address','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="checkbox" name="dsabafw_comman[dsabafw_enable_different_shipping_adress]" class="dsabafw_enable_multi_ship_adress" value="yes"<?php if($dsabafw_comman['dsabafw_enable_different_shipping_adress'] == 'yes'){echo "checked";} ?>>
                                    </td>
                                </tr>
                                <tr class="shipping_address_setting">
                                    <th><?php echo __('MAX Shipping Address','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="number" name="dsabafw_comman[dsabafw_max_shipping_adress]" class="regular-text" value="3" disabled>
                                        <label class="dsabafw_pro_link"><?php echo esc_html_e('This Option Available in','different-shipping-and-billing-address-for-woocommerce');?> <a href="https://www.plugin999.com/plugin/different-shipping-and-billing-address-for-woocommerce/" target="_blank">Pro Version</a></label>
                                    </td>
                                </tr>
                                <tr class="shipping_address_setting">
                                    <th><?php echo __('Select Shipping Address Type On Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_select_shipping_address_type]" class="regular-text">
                                            <option value="Dropdown"<?php if($dsabafw_comman['dsabafw_select_shipping_address_type'] == 'Dropdown'){echo "selected";}?>><?php echo __('Dropdown','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="Popup"<?php if($dsabafw_comman['dsabafw_select_shipping_address_type'] == 'Popup'){echo "selected";}?>><?php echo __('Popup','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="shipping_address_setting">
                                    <th><?php echo __('Select Shipping Address position Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_select_shipping_address_position]" class="regular-text">
                                            <option value="shipping_before_form_data"<?php if($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_before_form_data'){echo "selected";}?>><?php echo __('Before Shipping Form Data','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="shipping_after_form_data"<?php if($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_after_form_data'){echo "selected";}?>><?php echo __('After Shipping Form Data','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="shipping_address_setting">
                                    <th><?php echo __('Select Shipping Popup Button Style Checkout Page','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select name="dsabafw_comman[dsabafw_shipping_select_popup_btn_style]" class="regular-text">
                                            <option value="button"<?php if($dsabafw_comman['dsabafw_shipping_select_popup_btn_style'] == 'button'){echo "selected";}?>><?php echo __('Button','different-shipping-and-billing-address-for-woocommerce');?></option>
                                            <option value="link"<?php if($dsabafw_comman['dsabafw_shipping_select_popup_btn_style'] == 'link'){echo "selected";}?>><?php echo __('Link','different-shipping-and-billing-address-for-woocommerce');?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="shipping_address_setting">
                                    <th><?php echo __('Button Title for Shipping','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="regular-text" name="dsabafw_comman[dsabafw_head_title_ship]" value="Add New Shipping Address" disabled>
                                        <label class="dsabafw_pro_link" ><?php echo esc_html_e('This Option Available in','different-shipping-and-billing-address-for-woocommerce');?> <a href="https://www.plugin999.com/plugin/different-shipping-and-billing-address-for-woocommerce/" target="_blank">Pro Version</a></label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2><?php echo __('Different Shipping And Billing Button Style','different-shipping-and-billing-address-for-woocommerce');?></h2>
                        </div>
                        <div class="inside">
                            <table class="dsabafw_data_table">
                                <tr>
                                    <th><?php echo __('Font size','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="regular-text" name="dsabafw_comman[dsabafw_font_size]" value="15" disabled>
                                         <label class="dsabafw_pro_link"><?php echo esc_html_e('This Option Available in','different-shipping-and-billing-address-for-woocommerce');?> <a href="https://www.plugin999.com/plugin/different-shipping-and-billing-address-for-woocommerce/" target="_blank">Pro Version</a></label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Font color','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="color-picker" data-alpha="true" name="dsabafw_comman[dsabafw_font_clr]" value="<?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Background Color','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="color-picker" data-alpha="true" name="dsabafw_comman[dsabafw_btn_bg_clr]" value="<?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Button Padding','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="text" class="regular-text" name="dsabafw_comman[dsabafw_btn_padding]" value="<?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>">
                                        <span><?php echo __('give value in px(ex.6px 8px)','different-shipping-and-billing-address-for-woocommerce');?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2><?php echo __('User Role Selection Setting','different-shipping-and-billing-address-for-woocommerce');?></h2>
                        </div>
                        <div class="inside">
                            <table class="dsabafw_data_table">
                                <tr>
                                    <th><?php echo __('User Role Selection Enable/Disable','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <input type="checkbox" name="dsabafw_comman[dsabafw_user_role_enable_disable]" class="user_role_enable_disable" value="yes"<?php if($dsabafw_comman['dsabafw_user_role_enable_disable'] == 'yes'){echo "checked";} ?>>
                                    </td>
                                </tr>
                                <tr class="user_role_setting">
                                    <th><?php echo __('User Role Selection','different-shipping-and-billing-address-for-woocommerce');?></th>
                                    <td>
                                        <select id="different_select_user_role" name="different_roles_select[]" multiple="multiple" style="width:100%;">
                                            <?php 
                                                $user_roles = get_option('different_roles_select');
                                                
                                                if (!empty($user_roles)) {
                                                    foreach ($user_roles as $key => $value) {
                                                        $role_names = ( mb_strlen( $value ) > 50 ) ? mb_substr( $value, 0, 49 ) . '...' : $value;
                                                        ?>
                                                            <option value="<?php echo esc_attr($value);?>" selected="selected"><?php echo esc_html($role_names);?></option>
                                                        <?php   
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="dsabafw_save_option">
                <input type="submit" value="Save changes" name="submit" class="button-primary" id="wfc-btn-space">
            </form>  
        </div>
    </div>
    <?php
}

// For Sanitize Text Field Or Array
function DSABAFW_recursive_sanitize_text_field( $array ) {
    if(!empty($array)){
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = DSABAFW_recursive_sanitize_text_field($value);
            }else{
                $value = sanitize_text_field( $value );
            }
        }
    }
    return $array;
}

// Save All Settings
add_action( 'init',   'DSABAFW_save_options');
function DSABAFW_save_options(){
    global $wpdb;
    $tablename=$wpdb->prefix.'dsabafw_billingadress';
    if( isset($_REQUEST['action']) && $_REQUEST['action']=="delete_dsabafw_admin"){
        $delete_id = sanitize_text_field($_REQUEST['did']);
        $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
        $wpdb->query($sql);
        wp_redirect( admin_url( '/user-edit.php?user_id='.sanitize_text_field($_REQUEST['user_id']) ) );
        exit;
    }
    if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete-ship"){
        $delete_id=sanitize_text_field($_REQUEST['did-ship']);
        $sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
        $wpdb->query($sql);
        wp_redirect( admin_url( '/user-edit.php?user_id='.sanitize_text_field($_REQUEST['user_id']) ) );
        exit;
    }     

    if( current_user_can('administrator') ) { 
        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'dsabafw_save_option'){
            if(!isset( $_POST['dsabafw_nonce_field'] ) || !wp_verify_nonce( $_POST['dsabafw_nonce_field'], 'dsabafw_nonce_action' ) ){
                print 'Sorry, your nonce did not verify.';
                exit;
            }else{

                $isecheckbox = array(
                    'dsabafw_enable_different_billing_adress',
                    'dsabafw_enable_different_shipping_adress',
                    'dsabafw_user_role_enable_disable',
                );

                foreach ($isecheckbox as $key_isecheckbox => $value_isecheckbox) {
                    if(!isset($_REQUEST['dsabafw_comman'][$value_isecheckbox])){
                        $_REQUEST['dsabafw_comman'][$value_isecheckbox] ='no';
                    }
                }   

                if(!empty($different_roles_select)){
                    $different_roles_select = DSABAFW_recursive_sanitize_text_field( $_REQUEST['different_roles_select'] );
                    update_option('different_roles_select', $different_roles_select, 'yes');
                }

                //print_r($_REQUEST);
                foreach ($_REQUEST['dsabafw_comman'] as $key_dsabafw_comman => $value_dsabafw_comman) {
                   // echo $key_dsabafw_comman;
                    update_option($key_dsabafw_comman, sanitize_text_field($value_dsabafw_comman), 'yes');
                }
            }

            wp_redirect( admin_url( '/admin.php?page=different-address&message=success' ) );
            exit;
        }
    }
}

// Role Field Ajax
add_action( 'wp_ajax_nopriv_wg_roles_ajax', 'dsabafw_role_ajax' );
add_action( 'wp_ajax_wg_roles_ajax',  'dsabafw_role_ajax' ); 
function dsabafw_role_ajax(){
    global $wp_roles;
    $return = array();
    foreach( $wp_roles->role_names as $role => $name ) {
        $return[] = array( $role, $name );
    }
    echo json_encode( $return );
    die;
}

// For Validate Edit Billing Form Field
add_action('wp_ajax_dsabafw_validate_edit_billing_form_fields',  'dsabafw_validate_edit_billing_form_fields_func' );
add_action('wp_ajax_nopriv_dsabafw_validate_edit_billing_form_fields',  'dsabafw_validate_edit_billing_form_fields_func');
function dsabafw_validate_edit_billing_form_fields_func() {
    global $wpdb;

    $user_id = $_REQUEST['userid'];
    $tablename = $wpdb->prefix.'dsabafw_billingadress';
    $address_fields = wc()->countries->get_address_fields(get_user_meta($user_id, 'billing_country', true));
    $edit_id = sanitize_text_field($_REQUEST['edit_id']);
    $dsabafw_userid= $user_id;
    $billing_data = array();
    $field_errors = array();
    $billing_data['reference_field'] = sanitize_text_field($_REQUEST['reference_field']);
    if($_REQUEST['reference_field'] == '') {
      $field_errors['dsabafw_refname'] = '1';
    }

    foreach ($address_fields as $key => $field) {
        $billing_data[$key] = sanitize_text_field($_REQUEST[$key]);
        if($_REQUEST[$key] == '') {
            if($field['required'] == 1) {
                $field_errors[$key] = '1';
            }
        }
    }

    unset($field_errors['billing_state']);

    if(empty($field_errors)) {
        $billing_data_serlized=serialize( $billing_data );
        $condition = array(
            'id'=>$edit_id,
            'userid' =>$dsabafw_userid,
            'type' =>sanitize_text_field($_REQUEST['type'])
        );

        $wpdb->update($tablename, array( 'userdata' =>$billing_data_serlized),$condition);
        $added = 'true';
    } else {
        $added  = 'false';
    }

    $return_arr = array(
        "added" => $added,
        "field_errors" => $field_errors
    );
    echo json_encode($return_arr);
    exit;
}

// Add New Section For User Addresses In User Edit Page
add_action( 'show_user_profile',  'yoursite_extra_user_profile_fields', 999 );
add_action( 'edit_user_profile',  'yoursite_extra_user_profile_fields', 999 );
function yoursite_extra_user_profile_fields( $user ) {
    global $wpdb;
    $user_data = $user->data;
    $user_id = $user_data->ID;
    $tablename=$wpdb->prefix.'dsabafw_billingadress';  
    $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
    $user_shipping = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
    ?>
    <div class="bil_ship_address_user">
        <div class="bil_ship_address_user_inner">
            <div class="billing_address_main_section">
                <div class="billing_address_main_section_inner">
                    <h2>Billing Address</h2>
                    <?php
                    if(!empty($user)){   
                        echo "<div class='billing_address_all'>";
                        foreach($user as $row){    
                            $userdata_bil=$row->userdata;
                            $user_data = unserialize($userdata_bil);
                            ?>
                            <div class="billing_address_main">
                                <div class="billing_address">
                                    <button class="form_option_edit_admin" data-id="<?php echo esc_attr($user_id);?>"  data-eid-bil="<?php echo esc_attr($row->id);?>"><?php echo __('edit','different-shipping-and-billing-address-for-woocommerce');?></button>
                                    <span class="delete_bill_address"><a href="?user_id=<?php echo esc_attr($user_id);?>&action=delete_dsabafw_admin&did=<?php echo esc_attr($row->id);?>"><?php echo __('Delete','different-shipping-and-billing-address-for-woocommerce');?></a></span><br>
                                    <span class="billing_address_inner">
                                      <?php echo esc_html($user_data['reference_field'])."<br>".
                                      esc_html($user_data['billing_first_name']) .'&nbsp'.esc_html($user_data['billing_last_name'])."<br>".
                                      esc_html($user_data['billing_company'])."<br>".
                                      esc_html($user_data['billing_address_1'])."<br>".
                                      esc_html($user_data['billing_address_2'])."<br>".
                                      esc_html($user_data['billing_city'])." ".esc_html($user_data['billing_postcode'])."<br>".
                                      esc_html($user_data['billing_state']).', '.esc_html($user_data['billing_country']);
                                      ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
                        echo "</div>";
                    }else{
                        ?>
                        <div class="billing_address_empty">
                            <p class="billing_empty_message"><?php echo esc_html('You have no billing addresses.','different-shipping-and-billing-address-for-woocommerce'); ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="bil_ship_border_line"></div>
            <div class="shipping_address_main_section">
                <div class="shipping_address_main_section_inner">
                    <h2>Shipping Address</h2>
                    <?php
                    if(!empty($user_shipping)){
                        echo "<div class='shipping_address_all'>";
                        foreach($user_shipping as $row){    
                            $userdata_ship=$row->userdata;
                            $user_data = unserialize($userdata_ship);  
                            ?>
                            <div class="shipping_address_main">
                                <div class="shipping_address">
                                    <button class="form_option_ship_edit_admin" data-id="<?php echo esc_attr($user_id);?>"  data-eid-ship="<?php echo esc_attr($row->id);?>"><?php echo __('edit','different-shipping-and-billing-address-for-woocommerce');?></button>
                                    <span class="delete_ship_address"><a href="?user_id=<?php echo esc_attr($user_id);?>&action=delete-ship&did-ship=<?php echo esc_attr($row->id);?>"><?php echo __('Delete','different-shipping-and-billing-address-for-woocommerce');?></a></span><br>
                                    <span class="shipping_address_inner">
                                        <?php echo esc_html($user_data['reference_field'])."<br>".
                                        esc_html($user_data['shipping_first_name']) .'&nbsp'.esc_html($user_data['shipping_last_name'])."<br>".
                                        esc_html($user_data['shipping_company'])."<br>".
                                        esc_html($user_data['shipping_address_1'])."<br>".
                                        esc_html($user_data['shipping_address_2'])."<br>".
                                        esc_html($user_data['shipping_city'])." ".esc_html($user_data['shipping_postcode'])."<br>".
                                        esc_html($user_data['shipping_state']).', '.esc_html($user_data['shipping_country']);
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                        } 
                        echo "</div>"; 
                    }else{
                        ?>
                        <div class="shipping_address_empty">
                            <p class="shipping_empty_message">You have no shipping addresses.</p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// For Popup Html
add_action('admin_footer',  'my_admin_footer_function');
function my_admin_footer_function($data) {
    ?>
    <div id="dsabafw_billing_popup_admin" class="dsabafw_billing_popup_classadmin">
    </div>
    <div id="dsabafw_shipping_popup_admin" class="dsabafw_shipping_popup_classadmin">
    </div>
    <?php
} 

// For Validate Edit Shipping Form Field
add_action('wp_ajax_dsabafw_validate_edit_shipping_form_fields',  'dsabafw_validate_edit_shipping_form_fields_func' );
add_action('wp_ajax_nopriv_dsabafw_validate_edit_shipping_form_fields',  'dsabafw_validate_edit_shipping_form_fields_func');
function dsabafw_validate_edit_shipping_form_fields_func() {
    global $wpdb; 
    $tablename=$wpdb->prefix.'dsabafw_billingadress';
    $edit_id = sanitize_text_field($_REQUEST['edit_id']);
    $countries = new WC_Countries();
    $country = $countries->get_base_country();
    $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );
    $dsabafw_userid = sanitize_text_field($_REQUEST['userid']);
    $billing_data = array();
    $field_errors = array();
    $billing_data['reference_field'] = sanitize_text_field($_REQUEST['reference_field']);

    if($_REQUEST['reference_field'] == '') {
      $field_errors['dsabafw_refname'] = '1';
    }

    foreach ($address_fields as $key => $field) {
        $billing_data[$key] = sanitize_text_field($_REQUEST[$key]);
        if($_REQUEST[$key] == '') {
            if($field['required'] == 1) {
                $field_errors[$key] = '1';
            }
        }
    }

    unset($field_errors['shipping_state']);

    if(empty($field_errors)) {
        $billing_data_serlized=serialize( $billing_data );
        $condition=array(
            'id'=>$edit_id,
            'userid' =>$dsabafw_userid,
            'type' =>sanitize_text_field($_REQUEST['type'])
        );
        $wpdb->update($tablename,array( 'userdata' =>$billing_data_serlized),$condition);
        $added = 'true';
    } else {
        $added  = 'false';
    }

    $return_arr = array(
        "added" => $added,
        "field_errors" => $field_errors
    );
    echo json_encode($return_arr);
    exit;
}

// For Open Popup Billing
add_action('wp_ajax_productscommentsbilling_admin',  'dsabafw_billing_popup_open_admin' );
add_action('wp_ajax_nopriv_productscommentsbilling_admin',  'dsabafw_billing_popup_open_admin');
function dsabafw_billing_popup_open_admin() {
    global $wpdb;

    $user_id = sanitize_text_field($_REQUEST['popup_id_pro_admin']);
    $edit_id = sanitize_text_field($_REQUEST['eid-bil-admin']);
    $tablename=$wpdb->prefix.'dsabafw_billingadress'; 
    // echo $edit_id;
    ob_start();
    ?>
    <div class="dsabafw_modal-content">
        <span class="dsabafw_close">&times;</span> 
        <?php
        $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$edit_id);
        $user_data = unserialize($user[0]->userdata);
        $address_fields = wc()->countries->get_address_fields(get_user_meta($user_id, 'billing_country', true));
        ?>
        <form method="post" id="dsabafw_edit_billing_form">
            <div class="dsabafw_woocommerce-address-fields">
                <div class="dsabafw_woocommerce-address-fields_field-wrapper">
                    <input type="hidden" name="userid"  value="<?php echo esc_attr($user_id); ?>">
                    <input type="hidden" name="edit_id"  value= "<?php echo  esc_attr($edit_id); ?>">
                    <input type="hidden" name="type"  value="billing">
                    <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                        <label for="reference_field" class="">
                            <b><?php echo __('Reference Name:','different-shipping-and-billing-address-for-woocommerce');?></b>
                            <abbr class="required" title="required">*</abbr>
                        </label>
                        <span class="woocommerce-input-wrapper">
                            <input type="text" class="input-text" id="dsabafw_refname" name="reference_field" value="<?php echo esc_attr($user_data['reference_field']); ?>">
                        </span>
                    </p>
                    <?php
                    foreach ($address_fields as $key => $field) {  
                        woocommerce_form_field($key, $field, $user_data[$key]);
                    }
                    ?>
                </div>
                <p>
                    <button type="submit" name="add_billing_edit" id="dsabafw_edit_billing_form_submit" class="button" value="dsabafw_billpp_save_option"><?php echo __('Update Address','different-shipping-and-billing-address-for-woocommerce');?></button>   
                </p>
            </div>
        </form>
    </div>
    <?php
    $edit_html = ob_get_clean();

    $return_arr[] = array("html" => $edit_html);
    echo json_encode($return_arr);
    die();   
}

// For Open Popup Shipping
add_action('wp_ajax_productscommentsshipping_admin',  'dsabafw_shipping_popup_open_admin' );
add_action('wp_ajax_nopriv_productscommentsshipping_admin',  'dsabafw_shipping_popup_open_admin');
function dsabafw_shipping_popup_open_admin() {
    global $wpdb;

    $user_id = sanitize_text_field( $_REQUEST['popup_id_pro_ship']);
    $edit_id = sanitize_text_field($_REQUEST['eid-ship-popup']);
    //echo $edit_id;
    $tablename=$wpdb->prefix.'dsabafw_billingadress';
    echo '<div class="dsabafw_modal-content_ship">';
        echo '<span class="dsabafw_closeship">&times;</span>'; 
        $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id." AND id=".$edit_id);
        $user_data = unserialize($user[0]->userdata);
        $countries = new WC_Countries();
        if ( ! isset( $country ) ) {
            $country = $countries->get_base_country();
        }
        if ( ! isset( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );
        ?>
        <form method="post" id="dsabafw_edit_shipping_form">
            <div class="dsabafw_woocommerce-address-fields">
                <div class="dsabafw_woocommerce-address-fields_field-wrapper">
                    <input type="hidden" name="type"  value="shipping">
                    <input type="hidden" name="userid"  value="<?php echo esc_attr($user_id); ?>">
                    <input type="hidden" name="edit_id"  value= "<?php echo esc_attr($edit_id); ?>">
                    <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                        <label for="reference_field" class="">
                            <b><?php echo __('Reference Name:','different-shipping-and-billing-address-for-woocommerce');?></b>
                            <abbr class="required" title="required">*</abbr>
                        </label>
                        <span class="woocommerce-input-wrapper">
                            <input type="text" class="input-text" id="dsabafw_refname" name="reference_field" value="<?php echo esc_attr($user_data['reference_field']); ?>">
                        </span>
                    </p>
                    <?php
                    foreach ($address_fields as $key => $field) { 
                        woocommerce_form_field($key, $field, $user_data[$key]);
                    }
                    ?>
                </div>
                <p>
                    <button type="submit" name="add_shipping_edit" class="button" id="dsabafw_edit_shipping_form_submit" value="dsabafw_shippp_save_optionn"><?php echo __('Update Address','different-shipping-and-billing-address-for-woocommerce');?></button>   
                </p>
            </div>
        </form>
        <?php    
    echo '</div>';
    die();
}