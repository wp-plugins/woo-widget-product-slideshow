<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Carousel Settings Page

TABLE OF CONTENTS

- var menu_slug
- var page_data

- __construct()
- page_init()
- page_data()
- add_admin_menu()
- tabs_include()
- admin_settings_page()

-----------------------------------------------------------------------------------*/

class WC_Product_Slider_Carousel_Page extends WC_Product_Slider_Admin_UI
{	
	/**
	 * @var string
	 */
	private $menu_slug = 'wc-product-slider-carousel-page';
	
	/**
	 * @var array
	 */
	private $page_data;
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->page_init();
		$this->tabs_include();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_init() */
	/* Page Init */
	/*-----------------------------------------------------------------------------------*/
	public function page_init() {
		
		add_filter( $this->plugin_name . '_add_admin_menu', array( $this, 'add_admin_menu' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_data() */
	/* Get Page Data */
	/*-----------------------------------------------------------------------------------*/
	public function page_data() {
		
		$page_data = array(
			'type'				=> 'submenu',
			'parent_slug'		=> 'wc-product-slider-widget-skin-page',
			'page_title'		=> __( 'Carousel', 'wc_product_slider' ),
			'menu_title'		=> __( 'Carousel', 'wc_product_slider' ),
			'capability'		=> 'manage_options',
			'menu_slug'			=> $this->menu_slug,
			'function'			=> 'wc_product_slider_carousel_page_show',
			'admin_url'			=> 'admin.php',
			'callback_function' => '',
			'script_function' 	=> '',
			'view_doc'			=> '',
		);
		
		if ( $this->page_data ) return $this->page_data;
		return $this->page_data = $page_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_admin_menu() */
	/* Add This page to menu on left sidebar */
	/*-----------------------------------------------------------------------------------*/
	public function add_admin_menu( $admin_menu ) {
		
		if ( ! is_array( $admin_menu ) ) $admin_menu = array();
		$admin_menu[] = $this->page_data();
		
		return $admin_menu;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tabs_include() */
	/* Include all tabs into this page
	/*-----------------------------------------------------------------------------------*/
	public function tabs_include() {
		
		include_once( $this->admin_plugin_dir() . '/tabs/carousel/carousel-settings-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/carousel/container-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/carousel/control-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/carousel/pager-tab.php' );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* admin_settings_page() */
	/* Show Settings Page */
	/*-----------------------------------------------------------------------------------*/
	public function admin_settings_page() {
		global $wc_product_slider_admin_init;
		
		add_filter( $this->plugin_name . '_pro_version_name', array( $this, 'get_carousel_version_name' ) );
		add_filter( $this->plugin_name . '_pro_plugin_page_url', array( $this, 'get_carousel_page_url' ) );
		
		$wc_product_slider_admin_init->admin_settings_page( $this->page_data() );
	}
	
	public function get_carousel_version_name( $pro_version_name ) {
		return __( 'WooCommerce Carousel and Slider Version', 'wc_product_slider' );
	}
	
	public function get_carousel_page_url( $pro_plugin_page_url ) {
		return $this->carousel_plugin_page_url;
	}
	
}

global $wc_product_slider_carousel_page;
$wc_product_slider_carousel_page = new WC_Product_Slider_Carousel_Page();

/** 
 * wc_product_slider_carousel_page_show()
 * Define the callback function to show page content
 */
function wc_product_slider_carousel_page_show() {
	global $wc_product_slider_carousel_page;
	$wc_product_slider_carousel_page->admin_settings_page();
}