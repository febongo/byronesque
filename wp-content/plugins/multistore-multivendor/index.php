<?php
/**
Plugin Name: Multistore Multivendor
Plugin URI: http://codingmall.com/wordpress/
Description: Serve multiple front end stores with different WooCommerce products. You need just a single WordPress and WooCommerce installation and this plugin. Creating a Multistore WooCommerce website is easy.
Author: CodingMall.com
Author URI: https://codingmall.com/wordpress/
Version: 1.1.1
License: GPLv2 (or later)
Text Domain: cm-mswoo
Domain Path: /languages/
**/

/*  Copyright CodingMall.com  (email : support@codingmall.com)
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	See our terms for details.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$obj = new cm__mswoo_idx();
$obj->initMe();


class cm__mswoo_idx{
	public $siteUrl='';public $home='';
	public $dom ='';
	public $mDom='';
	public $aid =0;
	public $isMain=false;
	
	public function initMe(){
		
		$this->dom  	= @$_SERVER['HTTP_HOST']; 
		$this->siteUrl	= get_option('siteurl');
		$this->home		= get_option('home');	
		$this->mDom 	= parse_url($this->siteUrl,PHP_URL_HOST);

		if ($this->dom==$this->mDom) $this->isMain=true;

		$this->setHooks();
		
		if (!$this->isMain){
			$this->aid  = $this->getAid($this->dom); 
			if ($this->aid==0) $this->aid='99999999999999999999';
		}
	}

	
	
	private function setHooks(){
		add_action('init', array($this, 'wpInit'));

		if (is_admin()){
			add_filter( 'wp_dropdown_users_args', array($this,'wpdocs_add_subscribers_to_dropdown'),10,1 );			
		}else{
			add_filter( 'pre_option_siteurl', array($this,'modif_url'), 10, 2 );
			add_filter( 'pre_option_home',    array($this,'modif_url'), 10, 2 );
			
			//add_action('wp_loaded', array($this, 'buffer_start'));
			//add_action('shutdown',  array($this, 'buffer_end'  ));
			add_action( 'woocommerce_product_query', array($this, 'modif_prod_qry') );
			add_filter( 'woocommerce_product_related_posts_query',array($this,'modif_related_prods'), 10, 3);
		}		
	}

	function wpdocs_add_subscribers_to_dropdown( $query_args ) {
		//echo '<pre>';var_dump($query_args); die();
		$query_args['role__in'] = array( 'contributor', 'administrator' );
		$query_args['capability'] = [];
		//$query_args['role__not_in'] = array( 'editor' );

		// Unset the 'who' as this defaults to the 'author' role
		unset( $query_args['who'] );
	 
		return $query_args;
	}

	function modif_url( $pre_option, $option ) {
		if ($this->isMain) return;
		
		if ($option=='home'){
			$u = str_ireplace($this->mDom,$this->dom,$this->home); 
		}else{
			$u = str_ireplace($this->mDom,$this->dom,$this->siteUrl);
		}
		
		return $u;
	}	
	
	public function modif_related_prods($query, $product_id, $args) {
		$query['where'] .= " AND post_author = '6' ";
		return $query;
    }
	
	public function modif_prod_qry($q){
		if ($this->isMain) return;
		$q->set( 'author', $this->aid );
	}

	public function wpInit(){
		add_post_type_support( 'product', array('author') );
	}

/* 	public function buffer_start() { ob_start(array($this, 'modifContent')); }
	public function buffer_end() { @ob_end_flush(); }
	
	public function modifContent($content){
		if ($this->isMain) return $content;

		$content = str_replace($home,$dom,$content);
		return $content;		
	} */
	
	private function getAid($dom){
		global $wpdb;    
		$q2="SELECT `ID` FROM ".$wpdb->prefix."users WHERE MD5(TRIM(TRAILING '/' FROM `user_url`)) = '"
				. MD5('https://'.$dom) ."' OR MD5(TRIM(TRAILING '/' FROM `user_url`)) = '"
				. MD5('http://'.$dom) ."'";	//die($dom.'!');
		$aid = (int) $wpdb->get_var( $q2 );
		return $aid;
	}
}

