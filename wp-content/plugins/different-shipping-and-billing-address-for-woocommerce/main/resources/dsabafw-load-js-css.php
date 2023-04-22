<?php

//Add JS and CSS on Backend
add_action('admin_enqueue_scripts', 'DSABAFW_load_admin_script_style');
function DSABAFW_load_admin_script_style() {
	wp_enqueue_style( 'DSABAFW_admin_css', DSABAFW_PLUGIN_DIR . '/assets/css/back_style.css', false, '1.0.0' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', DSABAFW_PLUGIN_DIR . '/assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '1.0.0', true );
	wp_enqueue_script( 'DSABAFW_admin_js',DSABAFW_PLUGIN_DIR . '/assets/js/back.js', array( 'jquery', 'select2'), false, '1.0.0', true );

	$translation_arrayimg = DSABAFW_PLUGIN_DIR;
	wp_localize_script( 'DSABAFW_admin_js', 'DSABAFWscript_admin', 
	    array(
	      	'ajaxurl' => admin_url('admin-ajax.php'),
	      	'objectname' => $translation_arrayimg,
	    )
  	);
  	wp_enqueue_style( 'woocommerce_admin_styles-css', WP_PLUGIN_URL. '/woocommerce/assets/css/admin.css',false,'1.0',"all");
}

//Add JS and CSS on Frontend
add_action('wp_enqueue_scripts',  'DSABAFW_load_script_style');
function DSABAFW_load_script_style() {
  	wp_enqueue_style( 'DSABAFW_front_css',DSABAFW_PLUGIN_DIR . '/assets/css/front_style.css', false, '1.0.0' );
  	wp_enqueue_script( 'DSABAFW_front_js',DSABAFW_PLUGIN_DIR . '/assets/js/front.js', array("jquery"), false, '1.0.0', true );
  	$translation_array_img = DSABAFW_PLUGIN_DIR;
  	wp_localize_script( 'DSABAFW_front_js', 'DSABAFWscript', 
    	array(
	      	'ajax_url' => admin_url('admin-ajax.php'),
	      	'object_name' => $translation_array_img,
    	)
  	);
}