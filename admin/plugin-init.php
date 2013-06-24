<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Install Database, settings option
 */
function woo_gallery_widget_install(){
	update_option('woo_gallery_widget_version', '1.0.4');
}

update_option('woo_gallery_widget_plugin', 'woo_gallery_widget');

function woo_gallery_widget_init() {
	load_plugin_textdomain( 'woo_gallery_widget', false, WC_GALLERY_WIDGET_FOLDER.'/languages' );
}

add_action( 'init', 'woo_gallery_widget_init' );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Gallery_Widget_Hook_Filter', 'plugin_extra_links'), 10, 2 );

// Include stye at header
add_action( 'get_header', array('WC_Gallery_Widget_Hook_Filter', 'product_cycle_style') );

// Registry Widgets
add_action( 'widgets_init', create_function('', 'return register_widget("WC_Gallery_Cycle_Widget");') );

update_option('woo_gallery_widget_version', '1.0.4');
?>