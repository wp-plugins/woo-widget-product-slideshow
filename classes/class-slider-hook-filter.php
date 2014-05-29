<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Product Slider Widget Hook Filter
 *
 * Hook anf Filter into woocommerce plugin
 *
 * Table Of Contents
 *
 *
 * frontend_scripts_register()
 * include_slider_widget_scripts()
 * include_slider_card_scripts()
 * include_slider_mobile_scripts()
 * add_google_fonts()
 * include_customized_style()
 * a3_wp_admin()
 * admin_sidebar_menu_css()
 * plugin_extra_links()
 */
class WC_Product_Slider_Hook_Filter 
{
	
	public static function frontend_scripts_register() {
		global $wp_scripts;
		
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_style( 'wc-product-slider-styles', WC_PRODUCT_SLIDER_CSS_URL . '/wc-product-slider.css' );
		
		wp_register_script( 'a3-cycle2-script', WC_PRODUCT_SLIDER_JS_URL . '/jquery.cycle2'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-center-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.center'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-caption2-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.caption2'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-swipe-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.swipe'. $suffix .'.js', array('jquery'), '2.1.2' );
		
		wp_register_script( 'a3-cycle2-flip-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.flip'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-scrollVert-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.scrollVert'. $suffix .'.js', array('jquery'), '2.1.2' );
		wp_register_script( 'a3-cycle2-ie-fade-script', WC_PRODUCT_SLIDER_EXTENSION_JS_URL . '/jquery.cycle2.ie-fade'. $suffix .'.js', array('jquery'), '2.1.2' );
		$wp_scripts->add_data( 'a3-cycle2-ie-fade-script', 'conditional', 'IE' );
					
		wp_register_script( 'wc-product-slider-script', WC_PRODUCT_SLIDER_JS_URL . '/wc-product-slider-script.js', array('jquery') );
			
	}
	
	public static function include_slider_widget_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'a3-cycle2-script' );
		wp_enqueue_script( 'a3-cycle2-center-script' );
		wp_enqueue_script( 'a3-cycle2-caption2-script' );
		wp_enqueue_script( 'a3-cycle2-flip-script' );
		wp_enqueue_script( 'a3-cycle2-scrollVert-script' );
		wp_enqueue_script( 'a3-cycle2-ie-fade-script' );
		
		wp_enqueue_script( 'wc-product-slider-script' );
	}
		
	public static function include_slider_mobile_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'a3-cycle2-script' );
		wp_enqueue_script( 'a3-cycle2-center-script' );
		wp_enqueue_script( 'a3-cycle2-caption2-script' );
		wp_enqueue_script( 'a3-cycle2-swipe-script' );
		
	}
		
	public static function add_google_fonts() {
		global $wc_product_slider_fonts_face;
		
		global $wc_product_slider_a3_widget_skin_title_settings;
		global $wc_product_slider_a3_widget_skin_price_settings;
		global $wc_product_slider_a3_widget_skin_product_link_settings;
		global $wc_product_slider_a3_widget_skin_category_tag_link_settings;
		
		$google_fonts = array( );
		
		extract( $wc_product_slider_a3_widget_skin_title_settings );
		extract( $wc_product_slider_a3_widget_skin_price_settings );
		extract( $wc_product_slider_a3_widget_skin_product_link_settings );
		extract( $wc_product_slider_a3_widget_skin_category_tag_link_settings );
		
		$google_fonts[] = $title_font['face'];
		$google_fonts[] = $price_font['face'];
		$google_fonts[] = $old_price_font['face'];
		$google_fonts[] = $product_link_font['face'];
		$google_fonts[] = $category_link_font['face'];
		$google_fonts[] = $tag_link_font['face'];
		
		if ( count( $google_fonts ) > 0 ) $wc_product_slider_fonts_face->generate_google_webfonts( $google_fonts );
	}
	
	public static function include_customized_style() { 
		include( WC_PRODUCT_SLIDER_DIR. '/includes/customized_style.php' );
	}
	
	public static function include_admin_script() {
		wp_enqueue_script( 'jquery' );
				
		wp_enqueue_script( 'wc-product-slider-admin-script', WC_PRODUCT_SLIDER_JS_URL.'/wc-product-slider-admin-script.js' );
	}
	
	public static function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WC_PRODUCT_SLIDER_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public static function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wc-product-slider-admin-sidebar-menu-style', WC_PRODUCT_SLIDER_CSS_URL . '/admin_sidebar_menu.css' );
	}
	
	public static function plugin_extension() {
		$html = '';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px; clear:right;" ><div class="a3-plugin-ui-icon a3-plugin-ui-a3-rev-logo"></div></a>';
		$html .= '<h3>'.__('Thanks for choosing the WooCommerce Widget Product Slider.', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__('All of that plugins features have been activated and are ready for you to use.', 'wc_product_slider').':</p>';
		$html .= '<h3>'.__('What is the Yellow border sections about?', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__('Inside the Yellow border you will see the settings for the WooCommerce Product Slider and WooCommerce Carousel and Slider upgrade version plugins. You can see the settings but they are not active.', 'wc_product_slider' ).'</p>';
		
		$html .= '<h3>'.__('Try an upgrade Version for FREE.', 'wc_product_slider').'</h3>';
		$html .= '<p>'.sprintf( __('<a href="%s" target="_blank">WooCommerce Product Slider</a>', 'wc_product_slider'), WC_PRODUCT_SLIDER_VERSION_URI ) .' - '.__( '5 day Free Trail', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates Touch Mobile Skin.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates adding sliders by shortcode.', 'wc_product_slider' );
		$html .= '</p>';
		
		$html .= '<p>'.sprintf( __('<a href="%s" target="_blank">WooCommerce Carousel and Slider</a>', 'wc_product_slider'), WC_CAROUSEL_SLIDER_VERSION_URI ) .' - '.__( '5 day Free Trail', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates Touch Mobile Skin.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates adding sliders by shortcode.', 'wc_product_slider' ).'<br />';
		$html .= '* '.__('Activates the Product Carousel feature.', 'wc_product_slider' );
		$html .= '</p>';
		
		$html .= '<h3>'.__('Important!', 'wc_product_slider').'</h3>';
		$html .= '<p>'.__("If you are trailing one of the other versions of this plugin you must:", 'wc_product_slider').'<br />';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__('DEACTIVATE this plugin BEFORE installing and activating another version.', 'wc_product_slider').'</li>';
		$html .= '<li>2. '.__("If you don't you will get a FATAL ERROR.", 'wc_product_slider').'</li>';
		$html .= '<li>3. '.__('All data - sliders, settings and activations will be present in the newly activated version.', 'wc_product_slider').'</li>';
		$html .= '<li>4. '.__('WARNING - If you DELETE this plugin BEFORE you activate another version of the slider, all slider settings will be lost.', 'wc_product_slider').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		
		$html .= '<h3>'.__('NO RISK FREE TRIALS', 'wc_product_slider').'</h3>';
		$html .= '<p>'. sprintf( __('All of our software is available for FREE evaluation before purchase at <a href="%s" target="_blank">a3rev.com</a>. The system is all automated which makes it really easy to try all of our software any time you think it might solve a problem for you or add a much needed feature.', 'wc_product_slider'), 'http://a3rev.com/product-category/woocommerce/' ).'</p>';
		
		$html .= '<p>&nbsp;</p><p>'.__("Thank you and all the best.", 'wc_product_slider').'</p>';
		$html .= '<p>'.__("Steve and the team @ a3rev.", 'wc_product_slider').'</p>';
		
		return $html;
	}
		
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_PRODUCT_SLIDER_NAME) {
			return $links;
		}
		$links[] = '<a href="'.WC_PRODUCT_SLIDER_DOCS_URI.'" target="_blank">'.__('Documentation', 'wc_product_slider').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/woo-widget-product-slideshow/" target="_blank">'.__('Support', 'wc_product_slider').'</a>';
		return $links;
	}
}
?>
