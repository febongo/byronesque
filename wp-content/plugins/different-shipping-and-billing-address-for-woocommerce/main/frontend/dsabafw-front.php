<?php

if (!defined('ABSPATH')){
  exit;
}

function dsabafw_Query_get($tablename,$type,$userid,$id = NULL,$count=NULL){
    global $wpdb;
    if($count == 1){
    
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT count(*) as count FROM `$tablename` WHERE `type`=%s  AND `userid`=%d",$type,$userid));
    } else{

      if(isset($id)){
          $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `type`=%s  AND `userid`=%d AND `id`= %d",$type,$userid,$id));
      }else{
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `type`=%s  AND `userid`=%d",$type,$userid));
      }

    }
    return   $results;
}
function dsabafw_delete_Query_get($tablename,$delete_id){
  global $wpdb;
     
    $resultss =  $wpdb->query($wpdb->prepare("DELETE FROM `$tablename` WHERE `id`= %d", $delete_id));
        return   $resultss;
   
}

// Change Addresses Tab End Point My Account Page
function get_adress_book_endpoint_url( $address_book ) {
  $url = wc_get_endpoint_url( 'edit-address', 'shipping', get_permalink() );
  return add_query_arg( 'address-book', $address_book, $url );
}

// Change Addresses Tab Name On My Account Page
function dsabafw_wc_address_book_add_to_menu( $items ) {
  foreach ( $items as $key => $value ) {
    if ( 'edit-address' === $key ) {
      $items[ $key ] = __( 'Address Book', 'woo-address-book' );
    }
  }
  return $items;
}

// For Popup Html
function dsabafw_popup_div_footer() {
  global $dsabafw_comman;
  ?>
  <div id="dsabafw_billing_popup" class="dsabafw_billing_popup_class">
  </div>
  <div id="dsabafw_shipping_popup" class="dsabafw_shipping_popup_class">
  </div>
  <?php
  $user_id  = get_current_user_id();
  global $wpdb;
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
 // $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
  $user = dsabafw_Query_get($tablename ,'billing' ,$user_id );
  if($dsabafw_comman['dsabafw_enable_different_billing_adress'] == 'yes'){
    ?>
    <div id="address_selection_popup_main" class="address_selection_popup_main">
      <div class="billing_popup_header">
        <h3><?php echo __('Choice Billing Address','different-shipping-and-billing-address-for-woocommerce');?></h3>
      </div>
      <div class="address_selection_popup_inner">
        <span class="dsabafw_close_choice_section"><?php echo __('×','different-shipping-and-billing-address-for-woocommerce');?></span>
        <div class="address_selection_popup_body">
          <?php
          if(!empty($user)){   
            foreach($user as $row){  

              $userdata_bil = $row->userdata;
              $user_data = unserialize($userdata_bil);
              ?>
              <div class="address_line">
                <div class="address_line_inner">
                  <h5><?php echo esc_attr($user_data['reference_field']);?></h5>
                  <ul>
                    <li><?php echo esc_attr($user_data['billing_first_name']) .'&nbsp'.esc_attr($user_data['billing_last_name']);?></li>
                    <li><?php echo esc_attr($user_data['billing_company']);?></li>
                    <li><?php echo esc_attr($user_data['billing_address_1']);?></li>
                    <li><?php echo esc_attr($user_data['billing_address_2']);?></li>
                    <li><?php echo esc_attr($user_data['billing_city']).'&nbsp'.esc_attr($user_data['billing_postcode']);?></li>
                    <li><?php echo esc_attr($user_data['billing_state']).', '.esc_attr($user_data['billing_country']);?></li>
                  </ul>
                  <div class="address_select_button">
                    <a href="javascript:void(0)" class="choice_address" data-id="<?php echo esc_attr($row->id); ?>"><?php echo __('Choice This Address','different-shipping-and-billing-address-for-woocommerce');?></a>
                  </div>
                </div>
              </div>
              <?php
            }
          }else{
            ?>
            <div class="billing_address_empty">
              <p class="billing_empty_message">You have no billing addresses.</p>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php 
    }    
    //$user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
    $user = dsabafw_Query_get($tablename ,'shipping' ,$user_id );
    if($dsabafw_comman['dsabafw_enable_different_shipping_adress'] == 'yes'){
    ?>
    <div id="shipping_address_selection_popup_main" class="shipping_address_selection_popup_main">
      <div class="shipping_popup_header">
        <h3><?php echo __('Choice Shipping Address','different-shipping-and-billing-address-for-woocommerce');?></h3>
      </div>
      <div class="shipping_address_selection_popup_inner">
        <span class="shipping_dsabafw_close_choice_section">×</span>
        <div class="shipping_address_selection_popup_body">
          <?php
          if (!empty($user)) {
            foreach($user as $row){   
              $userdata_bil=$row->userdata;
              $user_data = unserialize($userdata_bil);
              ?>
              <div class="shipping_address_line">
                <div class="shipping_address_line_inner">
                  <h5><?php echo esc_attr($user_data['reference_field']);?></h5>
                  <ul>
                    <li><?php echo esc_attr($user_data['shipping_first_name']) .'&nbsp'.esc_attr($user_data['shipping_last_name']);?></li>
                    <li><?php echo esc_attr($user_data['shipping_company']);?></li>
                    <li><?php echo esc_attr($user_data['shipping_address_1']);?></li>
                    <li><?php echo esc_attr($user_data['shipping_address_2']);?></li>
                    <li><?php echo esc_attr($user_data['shipping_city']).'&nbsp'.esc_attr($user_data['shipping_postcode']);?></li>
                    <li><?php echo esc_attr($user_data['shipping_state']).', '.esc_attr($user_data['shipping_country']);?></li>
                  </ul>
                  <div class="shipping_address_select_button">
                    <a href="javascript:void(0)" class="choice_shipping_address" data-id="<?php echo esc_attr($row->id); ?>"><?php echo __('Choice This Address','different-shipping-and-billing-address-for-woocommerce');?></a>
                  </div>
                </div>
              </div>
              <?php
            }
          }else{
            ?>
            <div class="shipping_address_empty">
              <p class="shipping_empty_message"><?php esc_html('You have no shipping addresses.','different-shipping-and-billing-address-for-woocommerce');?></p>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php   
  }  
}

// For My Account Page New Content
function dsabafw_my_account_endpoint_content() {  
  $user_id = get_current_user_id();
  global $wpdb,$dsabafw_comman;
  $tablename=$wpdb->prefix.'dsabafw_billingadress';  
  //$user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
  $user = dsabafw_Query_get($tablename ,'billing' ,$user_id );
  echo '<div class="dsabafwdefalte"></div>';
  echo '<div class="dsabafw_table_custom">';
  if($dsabafw_comman['dsabafw_enable_different_billing_adress'] == 'yes'){
    echo '<div class="dsabafw_table_bill">';
    if(!empty($user)){   
      foreach($user as $row){    
        $userdata_bil=$row->userdata;
        $defalt_addd=$row->Defalut;

        $user_data = unserialize($userdata_bil);  
        if($defalt_addd==1){
          $checked = "checkeddd";
        } else{
          $checked = "";
        }
        ?>
        <div class="billing_address">
          <button class="defalut_address <?php echo esc_attr($checked);?>"  data-value="<?php echo esc_attr($defalt_addd);?>" data-add_id="<?php echo esc_attr($row->id);?>"  data-type="billing"><?php echo __('DefalutAddress','different-shipping-and-billing-address-for-woocommerce');?></button><button class="form_option_edit" data-id="<?php echo esc_attr($user_id);?>"  data-eid-bil="<?php echo esc_attr($row->id);?>"><?php echo __('edit','different-shipping-and-billing-address-for-woocommerce');?></button>
          <span class="delete_bill_address"><a href="?action=delete_dsabafw&did=<?php echo esc_attr($row->id);?>"><?php echo __('Delete','different-shipping-and-billing-address-for-woocommerce');?></a></span><br>
          <span class="billing_address_inner">
            <?php echo esc_attr($user_data['reference_field'])."<br>".
            esc_attr($user_data['billing_first_name']) .'&nbsp'.esc_attr($user_data['billing_last_name'])."<br>".
            esc_attr($user_data['billing_company'])."<br>".
            esc_attr($user_data['billing_address_1'])."<br>".
            esc_attr($user_data['billing_address_2'])."<br>".
            esc_attr($user_data['billing_city'])." ".esc_attr($user_data['billing_postcode'])."<br>".
            esc_attr($user_data['billing_state']).', '.esc_attr($user_data['billing_country']);
            ?>
          </span>
        </div>
        <?php
      }
    }else{
      ?>
      <div class="billing_address_empty">
        <p class="billing_empty_message">You have no billing addresses.</p>
      </div>
      <?php
    }
    echo '</div>';
  }
  //$user_shipping = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
  $user_shipping = dsabafw_Query_get($tablename ,'shipping' ,$user_id );
  if($dsabafw_comman['dsabafw_enable_different_shipping_adress'] == 'yes'){
    echo '<div class="dsabafw_table_ship">';
    if(!empty($user_shipping)){
      foreach($user_shipping as $row){    
        $userdata_ship=$row->userdata;
        $defalt_addd=$row->Defalut;
         if($defalt_addd==1){
          $checked = "checkeddd";
        } else{
          $checked = "";
        }
        $user_data = unserialize($userdata_ship);  
        ?>
        <div class="shipping_address">
          <button class="defalt_addd_shipping <?php echo esc_attr($checked);?>"  data-value="<?php echo esc_attr($defalt_addd);?>" data-add_id="<?php echo esc_attr($row->id);?>"  data-type="shipping"><?php echo __('DefalutAddress','different-shipping-and-billing-address-for-woocommerce');?></button><button class="form_option_ship_edit" data-id="<?php echo esc_attr($user_id);?>"  data-eid-ship="<?php echo esc_attr($row->id);?>"><?php echo __('edit','different-shipping-and-billing-address-for-woocommerce');?></button>
          <span class="delete_ship_address"><a href="?action=delete_ship&did-ship=<?php echo esc_attr($row->id);?>"><?php echo __('Delete','different-shipping-and-billing-address-for-woocommerce');?></a></span><br>
          <span class="shipping_address_inner">
            <?php echo esc_attr($user_data['reference_field'])."<br>".
            esc_attr($user_data['shipping_first_name']) .'&nbsp'.esc_attr($user_data['shipping_last_name'])."<br>".
            esc_attr($user_data['shipping_company'])."<br>".
            esc_attr($user_data['shipping_address_1'])."<br>".
            esc_attr($user_data['shipping_address_2'])."<br>".
            esc_attr($user_data['shipping_city'])." ".esc_attr($user_data['shipping_postcode'])."<br>".
            esc_attr($user_data['shipping_state']).', '.esc_attr($user_data['shipping_country']);
            ?>
          </span>
        </div>
        <?php
      }      
    }else{
      ?>
      <div class="shipping_address_empty">
        <p class="shipping_empty_message"><?php esc_html('You have no shipping addresses.','different-shipping-and-billing-address-for-woocommerce');?></p>
      </div>
      <?php
    }
    echo '</div>';
  }
  echo '</div>';
  ?>
  <div class="cus_menu">
    <?php
    if($dsabafw_comman['dsabafw_enable_different_billing_adress'] == 'yes'){
      ?>
      <div class="billling-button">
        <button class="form_option_billing" data-id="<?php echo esc_attr($user_id); ?>" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size: 15px;"><?php echo __('Add New Billing Address','different-shipping-and-billing-address-for-woocommerce')?></button>
      </div>
      <?php
    }
    if($dsabafw_comman['dsabafw_enable_different_shipping_adress'] == 'yes'){
    ?>
      <div class="shipping-button">
        <button class="form_option_shipping" data-id="<?php echo esc_attr($user_id); ?>" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size: font-size: 15px; "><?php echo __('Add Shipping Address','different-shipping-and-billing-address-for-woocommerce')?></button>
      </div>
      <?php
    }
    ?>
  </div>
  <?php      
}

// For Billing Popup Ajax Html Return
function dsabafw_billing_popup_open() {
  global $wpdb,$dsabafw_comman;

  $user_id = sanitize_text_field($_REQUEST['popup_id_pro']);
  $edit_id = sanitize_text_field( $_REQUEST['eid-bil']);
  $tablename = $wpdb->prefix.'dsabafw_billingadress'; 
  if(empty($edit_id)){
    //$user = $wpdb->get_results( "SELECT count(*) as count FROM {$tablename} WHERE type='billing'  AND userid=".$user_id );
    $user = dsabafw_Query_get($tablename ,'billing' ,$user_id ,0, 1);   
    $save_adress=$user[0]->count;
    $max_count= 3;
    if($save_adress >= $max_count){
      echo '<div class="dsabafw_modal-content">';
      echo '<span class="dsabafw_close">&times;</span>';
      echo "<h3 class='dsabafw_border'>you can add maximum 3 addresses !</h3>";
      echo '</div>';
      echo '</div>';
    }else{
      echo '<div class="dsabafw_modal-content">';
      echo '<span class="dsabafw_close">&times;</span>';
      $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));
      ?>
      <form method="post" id="dsabafw_add_billing_form">
        <div class="dsabafw_woocommerce-address-fields">
          <div class="dsabafw_woocommerce-address-fields_field-wrapper">
            <input type="hidden" name="type"  value="billing">
            <p class="form-row form-row-wide" id="reference_field" data-priority="30">
              <label for="reference_field" class="">
                <b><?php echo __('Reference Name:','different-shipping-and-billing-address-for-woocommerce');?></b>
                <abbr class="required" title="required">*</abbr>
              </label>
              <span class="woocommerce-input-wrapper">
                <input type="text" class="input-text" name="reference_field" id="dsabafw_refname">
              </span>
            </p>
            <?php
            foreach ($address_fields as $key => $field) {
              woocommerce_form_field($key, $field, wc_get_post_data_by_key($key));
            }
            ?>
          </div>
          <p>
            <button type="submit" name="add_billing" id="dsabafw_add_billing_form_submit" class="button" value="dsabafw_billpp_save_option"><?php echo __('Save Address','different-shipping-and-billing-address-for-woocommerce');?></button>
          </p>
        </div>
      </form>
      <?php    
      echo '</div>';
      echo '</div>';
    }
  }else{
    // echo $edit_id;
    ob_start();
    ?>
    <div class="dsabafw_modal-content">
      <span class="dsabafw_close">&times;</span> 
      <?php
      $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$edit_id);
      $user_data = unserialize($user[0]->userdata);
      $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));
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
    </div>
    <?php
    $edit_html = ob_get_clean();
    $return_arr[] = array("html" => $edit_html);
    echo json_encode($return_arr);
  }
  die();   
}

// For Shipping Popup Ajax Html Return
function dsabafw_shipping_popup_open() {
  global $wpdb,$dsabafw_comman;
  $user_id =sanitize_text_field( $_REQUEST['popup_id_pro']);
  $edit_id = sanitize_text_field($_REQUEST['eid-ship']);
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  if(empty($edit_id)){
    $user = $wpdb->get_results( "SELECT count(*) as count FROM {$tablename} WHERE type='shipping'  AND userid=".$user_id );
    $save_adress=$user[0]->count;
    $max_count= 3;
    if($save_adress >= $max_count){
      echo '<div class="dsabafw_modal-content">';
      echo '<span class="dsabafw_close">&times;</span>';
      echo "<h3 class='dsabafw_border'>you can add maximum  3 addresses ! !</h3>";
      echo '</div>';
      echo '</div>';
    }else{
      echo '<div class="dsabafw_modal-content">';
        echo '<span class="dsabafw_close">&times;</span>'; 
        $countries = new WC_Countries();
        if ( ! isset( $country ) ) {
          $country = $countries->get_base_country();
        }
        if ( ! isset( $user_id ) ) {
          $user_id = get_current_user_id();
        }
        $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );
        ?>
        <form method="post" id="dsabafw_add_shipping_form">
          <div class="dsabafw_woocommerce-address-fields">
            <div class="dsabafw_woocommerce-address-fields_field-wrapper">
              <input type="hidden" name="type"  value="shipping">
              <p class="form-row form-row-wide" id="reference_field" data-priority="30">
                <label for="reference_field" class="">
                  <b><?php echo __('Reference Name:','different-shipping-and-billing-address-for-woocommerce');?></b>
                  <abbr class="required" title="required">*</abbr>
                </label>
                <span class="woocommerce-input-wrapper">
                  <input type="text" class="input-text" id="dsabafw_refname" name="reference_field">
                </span>
              </p>
              <?php
              foreach ($address_fields as $key => $field) {  
                 woocommerce_form_field($key, $field, wc_get_post_data_by_key($key));         
              }
              ?>
            </div>
            <p>
              <button type="submit" name="add_shipping" id="dsabafw_add_shipping_form_submit" class="button" value="dsabafw_shippp_save_optionn"><?php echo __('Save Address','different-shipping-and-billing-address-for-woocommerce');?></button>   
            </p>
          </div>
        </form>
        <?php    
      echo '</div>';
      echo '</div>'; 
    }  
  }else{
    echo '<div class="dsabafw_modal-content">';
      echo '<span class="dsabafw_close">&times;</span>'; 
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
    echo '</div>';  
  }       
  die();
}

/* Billigdata */          
function dsabafw_billing_data_select(){
  global $wpdb;
  $user_id = get_current_user_id();
  $select_id = sanitize_text_field($_REQUEST['sid']);
  $tablename=$wpdb->prefix.'dsabafw_billingadress'; 
  $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id." AND id=".$select_id);
  $user_data = unserialize($user[0]->userdata);
  echo json_encode($user_data);
  exit();
}

/* Shippingdata */
function dsabafw_shipping_data_select(){
  $user_id = get_current_user_id();
  $select_id = sanitize_text_field($_REQUEST['sid']);
  global $wpdb;
  $tablename=$wpdb->prefix.'dsabafw_billingadress'; 
  $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id." AND id=".$select_id);
  $user_data = unserialize($user[0]->userdata);
  echo json_encode($user_data);
  exit();
}

// For All Billing Address Section
function DSABAFW_all_billing_address(){
  $user_id  = get_current_user_id();
  global $wpdb,$dsabafw_comman;
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  if (is_user_logged_in()) {
    if($dsabafw_comman['dsabafw_enable_different_billing_adress'] == 'yes'){
      if($dsabafw_comman['dsabafw_select_address_type'] == 'Dropdown'){
        ?>
        <select class="dsabafw_select">
          <option value="">...Choose address...</option>
          <?php
          $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=".$user_id);
          foreach($user as $row){  
            $userdata_bil=$row->userdata;
            $user_data = unserialize($userdata_bil);
            if($row->Defalut == 1){
              $valid =  "selected";
            }else{
              $valid =  "";
            }?> 
            <option value="<?php echo esc_attr($row->id); ?>" <?php echo  esc_attr($valid); ?>>  <?php echo esc_html($user_data['reference_field']); ?></option>
            <?php 
          } ?>
        </select>
        <?php
      }elseif ($dsabafw_comman['dsabafw_select_address_type'] == 'Popup') {
        $userbtn = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='billing' AND userid=$user_id AND Defalut=1");
        if (!empty($userbtn)) {
          $defsid = $userbtn[0]->id;
        }else{
          $defsid = '';
        }
        if($dsabafw_comman['dsabafw_select_popup_btn_style'] == 'button'){
          ?>
          <a href="javascript:void(0)" defid="<?php echo $defsid;?>" class="choice_bil_address" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size: 15px;"><?php echo __('Choice Billing Address','different-shipping-and-billing-address-for-woocommerce');?></a>
          <?php
        }
        if($dsabafw_comman['dsabafw_select_popup_btn_style'] == 'link'){
          ?>
          <a href="javascript:void(0)" defid="<?php echo $defsid;?>" id="choice_bil_address" class="choice_bil_address"><?php echo __('Choice Billing Address','different-shipping-and-billing-address-for-woocommerce');?></a>
          <?php
        }
      }
      ?>
      <button class="form_option_billing" data-id="<?php echo esc_attr($user_id); ?>" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size: 15px;"><?php echo __('Add New Billing Address','different-shipping-and-billing-address-for-woocommerce')?></button>
      <?php
    }
  }
}

// For All Shipping Address Section
function DSABAFW_all_shipping_address(){
  $user_id  = get_current_user_id();
  global $wpdb,$dsabafw_comman;
  $tablename=$wpdb->prefix.'dsabafw_billingadress';  
  if (is_user_logged_in()) {
    if($dsabafw_comman['dsabafw_enable_different_shipping_adress'] == 'yes'){
      if($dsabafw_comman['dsabafw_select_shipping_address_type'] == 'Dropdown'){
        ?>
        <select class="dsabafw_select_shipping">
          <option value="">...Choose address...</option><?php
          $user = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=".$user_id);
          foreach($user as $row){   
            if($row->Defalut == 1){
              $valid =  "selected";
            }else{
              $valid =  "";
            }
            $userdata_bil=$row->userdata;
            $user_data = unserialize($userdata_bil);
            ?><option value="<?php echo esc_attr($row->id); ?>" <?php echo esc_attr($valid); ?>>  <?php echo esc_html($user_data['reference_field']); ?></option><?php 
          } ?>
        </select>
        <?php
      }elseif ($dsabafw_comman['dsabafw_select_shipping_address_type'] == 'Popup') {
        $userbtn = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE type='shipping' AND userid=$user_id AND Defalut=1");
        if (!empty($userbtn)) {
          $defsid = $userbtn[0]->id;
        }else{
          $defsid = '';
        }
        if($dsabafw_comman['dsabafw_shipping_select_popup_btn_style'] == 'button'){
          ?>
          <a href="javascript:void(0)" defid="<?php echo $defsid;?>" class="choice_sheep_address" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size: 15px;"><?php echo __('Choice shipping Address','different-shipping-and-billing-address-for-woocommerce');?></a>
          <?php
        }
        if($dsabafw_comman['dsabafw_shipping_select_popup_btn_style'] == 'link'){
          ?>
          <a href="javascript:void(0)" defid="<?php echo $defsid;?>" id="choice_sheep_address" class="choice_sheep_address"><?php echo __('Choice shipping Address','different-shipping-and-billing-address-for-woocommerce');?></a>
          <?php
        }
      }
      ?>
      <button class="form_option_shipping" data-id="<?php echo esc_attr($user_id); ?>" style="background-color: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_bg_clr']);?>; color: <?php echo esc_attr($dsabafw_comman['dsabafw_font_clr']);?>; padding: <?php echo esc_attr($dsabafw_comman['dsabafw_btn_padding']);?>; font-size:15px;"><?php echo __('Add Shipping Address','different-shipping-and-billing-address-for-woocommerce')?></button>
      <?php
    }
  }
}

// For Delete Address
function DSABAFW_save_optionsss(){
  global $wpdb; 
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
   
  if( isset($_REQUEST['action']) && $_REQUEST['action']=="delete_dsabafw"){
    $delete_id=sanitize_text_field($_REQUEST['did']);
    //$sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
    dsabafw_delete_Query_get($tablename,$delete_id);
    //$wpdb->query($sql);
    wp_safe_redirect( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) );
    exit;
  }  

  if(isset($_REQUEST['action']) && $_REQUEST['action']=="delete_ship"){
    $delete_id=sanitize_text_field($_REQUEST['did-ship']);
    dsabafw_delete_Query_get($tablename,$delete_id);
    //$sql = "DELETE  FROM {$tablename} WHERE id='".$delete_id."'" ;
    
    //$wpdb->query($sql);
    wp_safe_redirect( wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) );
    exit;
  }             
}

// For Validation Billing Form Fields Popup
function dsabafw_validate_billing_form_fields_func() {
  global $wpdb; 
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  
  $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));

  $dsabafw_userid = get_current_user_id();

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
    $wpdb->insert($tablename, array( 'userid' =>$dsabafw_userid, 'userdata' =>$billing_data_serlized, 'type' =>sanitize_text_field($_REQUEST['type'])));
    $added = 'true';
  } else {
    $added  = 'false';
  }

  $return_arr = array( "added" => $added, "field_errors" => $field_errors );
  echo json_encode($return_arr);
  exit;
}

// For Validation Shipping Form Fields Popup
function dsabafw_validate_shipping_form_fields_func() {

  global $wpdb; 

  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  $countries = new WC_Countries();
  $country = $countries->get_base_country();

  $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );

  $dsabafw_userid= get_current_user_id();

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
    $wpdb->insert($tablename, array( 'userid' =>$dsabafw_userid, 'userdata' =>$billing_data_serlized, 'type' =>sanitize_text_field($_REQUEST['type']) ));
    $added = 'true';
  } else {
    $added  = 'false';
  }

  $return_arr = array( "added" => $added, "field_errors" => $field_errors );
  echo json_encode($return_arr);
  exit;
}

// For Validation Edit Billing Form Fields
function dsabafw_validate_edit_billing_form_fields_funccc() {
  global $wpdb;
  $tablename = $wpdb->prefix.'dsabafw_billingadress';

  $address_fields = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));

  $edit_id = sanitize_text_field($_REQUEST['edit_id']);

  $dsabafw_userid= get_current_user_id();

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
    $condition = array( 'id'=>$edit_id, 'userid' =>$dsabafw_userid, 'type' =>sanitize_text_field($_REQUEST['type']) );
    $wpdb->update($tablename, array( 'userdata' =>$billing_data_serlized),$condition);
    $added = 'true';
  } else {
    $added  = 'false';
  }

  $return_arr = array( "added" => $added, "field_errors" => $field_errors );
  echo json_encode($return_arr);
  exit;
}

// For Validation Edit Shipping Form Fields
function dsabafw_validate_edit_shipping_form_fields_funcssss() {
  global $wpdb; 
  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  
  $edit_id = sanitize_text_field($_REQUEST['edit_id']);

  $countries = new WC_Countries();
  $country = $countries->get_base_country();

  $address_fields = WC()->countries->get_address_fields( $country, 'shipping_' );

  $dsabafw_userid= get_current_user_id();

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

    $condition=array( 'id'=>$edit_id, 'userid' =>$dsabafw_userid, 'type' =>sanitize_text_field($_REQUEST['type']) );
    $wpdb->update($tablename,array( 'userdata' =>$billing_data_serlized),$condition);
    $added = 'true';
  } else {
    $added  = 'false';
  }

  $return_arr = array( "added" => $added, "field_errors" => $field_errors );
  echo json_encode($return_arr);
  exit;
}

// For Default Address Billing
function dsabafw_default_address(){
  global $wpdb; 

  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  $defaltadd_id = sanitize_text_field($_REQUEST['defalteaddd_id']);
  $dealteadd_type = sanitize_text_field($_REQUEST['dealteadd_type']);
  $dsabafw_userid= get_current_user_id();

  $condition=array(
    'userid'=>$dsabafw_userid,
    'type'=>$dealteadd_type,
  );
  $wpdb->update( $tablename, array( 'Defalut' => '0' ), $condition );
  $condition=array( 'id' => $defaltadd_id, 'type' => $dealteadd_type );
  $wpdb->update( $tablename,array('Defalut' => '1'),$condition);
  exit;
}

// For Default Address Shipping
function dsabafw_default_address_shipping(){
  global $wpdb; 

  $tablename=$wpdb->prefix.'dsabafw_billingadress';
  $defaltadd_id = sanitize_text_field($_REQUEST['defalteaddd_id']);
  $dealteadd_type = sanitize_text_field($_REQUEST['dealteadd_type']);
  $dsabafw_userid= get_current_user_id();

  $condition=array( 'userid'=>$dsabafw_userid, 'type'=>$dealteadd_type, );
  $wpdb->update( $tablename, array( 'Defalut' => '0'),$condition);
  $condition=array( 'id'=>$defaltadd_id, 'type'=>$dealteadd_type );
  $wpdb->update( $tablename, array( 'Defalut' => '1' ),$condition);
  exit;
}

// Load All Actions
add_action( 'init', 'DSABAFW_add_action_and_filters_load');
function DSABAFW_add_action_and_filters_load() {
  global $wpdb,$dsabafw_comman;
  if($dsabafw_comman['dsabafw_user_role_enable_disable'] == 'yes'){
    $user = wp_get_current_user();
    $user_roles = get_option('different_roles_select'); 
    if(!empty($user->roles) && !empty($user_roles)) {
      $current_user = $user->roles[0];
      if (in_array($current_user, $user_roles)) {
        $charset_collate = $wpdb->get_charset_collate();
        $tablename = $wpdb->prefix.'dsabafw_billingadress'; 
        $sql = "CREATE TABLE $tablename (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          userid TEXT NOT NULL,
          userdata TEXT NOT NULL,
          type TEXT NOT NULL,
          Defalut int  DEFAULT '0',
          PRIMARY KEY (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        add_filter( 'woocommerce_account_menu_items', 'dsabafw_wc_address_book_add_to_menu' ,10);
        add_action( 'woocommerce_account_edit-address_endpoint','dsabafw_my_account_endpoint_content');
        add_action('wp_footer', 'dsabafw_popup_div_footer' );
        add_action('wp_ajax_productscommentsbilling', 'dsabafw_billing_popup_open' );
        add_action('wp_ajax_nopriv_productscommentsbilling', 'dsabafw_billing_popup_open');
        add_action('wp_ajax_productscommentsshipping', 'dsabafw_shipping_popup_open' );
        add_action('wp_ajax_nopriv_productscommentsshipping', 'dsabafw_shipping_popup_open');
        
        if ($dsabafw_comman['dsabafw_select_address_position'] == 'billing_before_form_data') {
          add_action('woocommerce_before_checkout_billing_form', 'DSABAFW_all_billing_address');
        }elseif ($dsabafw_comman['dsabafw_select_address_position'] == 'billing_after_form_data'){
          add_action('woocommerce_after_checkout_billing_form', 'DSABAFW_all_billing_address');
        }

        if ($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_before_form_data') {
          add_action('woocommerce_before_checkout_shipping_form', 'DSABAFW_all_shipping_address');
        }elseif ($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_after_form_data'){
          add_action('woocommerce_after_checkout_shipping_form', 'DSABAFW_all_shipping_address');
        }

        add_action('wp_ajax_productscommentsbilling_select', 'dsabafw_billing_data_select' );
        add_action('wp_ajax_nopriv_productscommentsbilling_select', 'dsabafw_billing_data_select');
        add_action('wp_ajax_productscommentsshipping_select', 'dsabafw_shipping_data_select' );
        add_action('wp_ajax_nopriv_productscommentsshipping_select', 'dsabafw_shipping_data_select');
        add_action('wp_ajax_dsabafw_validate_billing_form_fields', 'dsabafw_validate_billing_form_fields_func' );
        add_action('wp_ajax_nopriv_dsabafw_validate_billing_form_fields', 'dsabafw_validate_billing_form_fields_func');
        add_action('wp_ajax_dsabafw_validate_shipping_form_fields', 'dsabafw_validate_shipping_form_fields_func' );
        add_action('wp_ajax_nopriv_dsabafw_validate_shipping_form_fields', 'dsabafw_validate_shipping_form_fields_func');
        add_action('wp_ajax_dsabafw_validate_edit_billing_form_fields', 'dsabafw_validate_edit_billing_form_fields_funccc' );
        add_action('wp_ajax_nopriv_dsabafw_validate_edit_billing_form_fields', 'dsabafw_validate_edit_billing_form_fields_funccc');
        add_action('wp_ajax_dsabafw_validate_edit_shipping_form_fields', 'dsabafw_validate_edit_shipping_form_fields_funcssss' );
        add_action('wp_ajax_nopriv_dsabafw_validate_edit_shipping_form_fields', 'dsabafw_validate_edit_shipping_form_fields_funcssss');
        add_action('wp_ajax_dsabafw_default_address', 'dsabafw_default_address' );
        add_action('wp_ajax_nopriv_dsabafw_default_address', 'dsabafw_default_address');
        add_action('wp_ajax_dsabafw_default_address_shipping', 'dsabafw_default_address_shipping');
        add_action('wp_ajax_nopriv_dsabafw_default_address_shipping', 'dsabafw_default_address_shipping');

        add_action( 'wp', 'DSABAFW_save_optionsss');
      }                                  
    }
  }else{
    $charset_collate = $wpdb->get_charset_collate();
    $tablename = $wpdb->prefix.'dsabafw_billingadress'; 
    $sql = "CREATE TABLE $tablename (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      userid TEXT NOT NULL,
      userdata TEXT NOT NULL,
      type TEXT NOT NULL,
      Defalut int  DEFAULT '0',
      PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    add_filter( 'woocommerce_account_menu_items', 'dsabafw_wc_address_book_add_to_menu' ,10);
    add_action( 'woocommerce_account_edit-address_endpoint','dsabafw_my_account_endpoint_content');
    add_action('wp_footer', 'dsabafw_popup_div_footer' );
    add_action('wp_ajax_productscommentsbilling', 'dsabafw_billing_popup_open' );
    add_action('wp_ajax_nopriv_productscommentsbilling', 'dsabafw_billing_popup_open');
    add_action('wp_ajax_productscommentsshipping', 'dsabafw_shipping_popup_open' );
    add_action('wp_ajax_nopriv_productscommentsshipping', 'dsabafw_shipping_popup_open');
    
    if ($dsabafw_comman['dsabafw_select_address_position'] == 'billing_before_form_data') {
      add_action('woocommerce_before_checkout_billing_form', 'DSABAFW_all_billing_address');
    }elseif ($dsabafw_comman['dsabafw_select_address_position'] == 'billing_after_form_data'){
      add_action('woocommerce_after_checkout_billing_form', 'DSABAFW_all_billing_address');
    }

    if ($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_before_form_data') {
      add_action('woocommerce_before_checkout_shipping_form', 'DSABAFW_all_shipping_address');
    }elseif ($dsabafw_comman['dsabafw_select_shipping_address_position'] == 'shipping_after_form_data'){
      add_action('woocommerce_after_checkout_shipping_form', 'DSABAFW_all_shipping_address');
    }

    add_action('wp_ajax_productscommentsbilling_select', 'dsabafw_billing_data_select' );
    add_action('wp_ajax_nopriv_productscommentsbilling_select', 'dsabafw_billing_data_select');
    add_action('wp_ajax_productscommentsshipping_select', 'dsabafw_shipping_data_select' );
    add_action('wp_ajax_nopriv_productscommentsshipping_select', 'dsabafw_shipping_data_select');
    add_action('wp_ajax_dsabafw_validate_billing_form_fields', 'dsabafw_validate_billing_form_fields_func' );
    add_action('wp_ajax_nopriv_dsabafw_validate_billing_form_fields', 'dsabafw_validate_billing_form_fields_func');
    add_action('wp_ajax_dsabafw_validate_shipping_form_fields', 'dsabafw_validate_shipping_form_fields_func' );
    add_action('wp_ajax_nopriv_dsabafw_validate_shipping_form_fields', 'dsabafw_validate_shipping_form_fields_func');
    add_action('wp_ajax_dsabafw_validate_edit_billing_form_fields', 'dsabafw_validate_edit_billing_form_fields_funccc' );
    add_action('wp_ajax_nopriv_dsabafw_validate_edit_billing_form_fields', 'dsabafw_validate_edit_billing_form_fields_funccc');
    add_action('wp_ajax_dsabafw_validate_edit_shipping_form_fields', 'dsabafw_validate_edit_shipping_form_fields_funcssss' );
    add_action('wp_ajax_nopriv_dsabafw_validate_edit_shipping_form_fields', 'dsabafw_validate_edit_shipping_form_fields_funcssss');
    add_action('wp_ajax_dsabafw_default_address', 'dsabafw_default_address' );
    add_action('wp_ajax_nopriv_dsabafw_default_address', 'dsabafw_default_address');
    add_action('wp_ajax_dsabafw_default_address_shipping', 'dsabafw_default_address_shipping' );
    add_action('wp_ajax_nopriv_dsabafw_default_address_shipping', 'dsabafw_default_address_shipping');

    add_action( 'wp', 'DSABAFW_save_optionsss');
  }
}