<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/**
 * WooCommerce Product Slider Display
 *
 * Table Of Contents
 *
 * dispay_slider_widget()
 * get_title_widget_skin()
 * dispay_slider_card()
 */
class WC_Product_Slider_Display
{	
	
	public static function dispay_slider_widget( $slide_items = array(), $slider_settings = array(), $category_link = '', $tag_link = '' ) {
	
		global $wc_product_slider_a3_widget_skin_global_settings;
		global $wc_product_slider_a3_widget_skin_dimensions_settings;
		global $wc_product_slider_a3_widget_skin_title_settings;
		global $wc_product_slider_a3_widget_skin_product_link_settings;
		global $wc_product_slider_a3_widget_skin_category_tag_link_settings;
		
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
		
		extract( $wc_product_slider_a3_widget_skin_global_settings );
		// Detect the slider is viewing on Mobile, if True then Show Slider for Mobile 
		if ( $enable_slider_touch == 1 ) {
			require_once WC_PRODUCT_SLIDER_DIR . '/includes/mobile_detect.php';
			$device_detect = new WC_Product_Slider_Mobile_Detect();
			if ( $device_detect->isMobile() ) {
				$is_used_mobile_skin = false;
				
				require_once WC_PRODUCT_SLIDER_DIR . '/classes/class-slider-mobile-display.php';
				return WC_Product_Slider_Mobile_Display::mobile_dispay_slider( $slide_items, $is_used_mobile_skin , $slider_settings, $category_link, $tag_link );
			}
		}
		
		// TEST MOBILE
		//if ( $is_used_mobile_skin == 1 ) $is_used_mobile_skin = true;
		//else  $is_used_mobile_skin = false;
		//require_once WC_PRODUCT_SLIDER_DIR . '/classes/class-slider-mobile-display.php';
		//return WC_Product_Slider_Mobile_Display::mobile_dispay_slider( $slide_items, $is_used_mobile_skin , $slider_settings, $category_link, $tag_link );
		
		add_action( 'wp_footer', array( 'WC_Product_Slider_Hook_Filter', 'include_slider_widget_scripts' ) );
		
		extract( $wc_product_slider_a3_widget_skin_dimensions_settings );
		extract( $wc_product_slider_a3_widget_skin_title_settings );
		extract( $wc_product_slider_a3_widget_skin_product_link_settings );
		extract( $wc_product_slider_a3_widget_skin_category_tag_link_settings );
		
		// Return empty if it does not have any slides
		if ( ! is_array( $slide_items ) || count( $slide_items ) < 1 ) return '';
				
		$caption_fx_out = 'fadeOut';
		$caption_fx_in = 'fadeIn';
		
		$unique_id = rand( 100, 1000 );
				
		$caption_class = '#cycle-widget-skin-caption-' . $unique_id;
		$overlay_class = '#cycle-widget-skin-overlay-' . $unique_id;
		
		$slider_transition_data 		= WC_Product_Slider_Functions::get_slider_transition( $slider_settings['widget_effect'], $slider_settings );
		$fx 							= $slider_transition_data['fx'];
		$transition_attributes 			= $slider_transition_data['transition_attributes'];
		$timeout 						= $slider_transition_data['timeout'];
		$speed 							= $slider_transition_data['speed'];
		$delay 							= $slider_transition_data['delay'];
		
		$dynamic_tall = 'false';
		if ( $is_slider_tall_dynamic == 1 ) $dynamic_tall = 'container';
						
		ob_start();
	?>
    <div style="clear:both;"></div>
    <div class="wc-product-slider-widget-skin-container">
    <?php if ( $title_position == 'above' ) self::get_title_widget_skin( $unique_id ); ?>
        
    <div id="wc-product-slider-container-<?php echo $unique_id; ?>" class="wc-product-slider-container wc-product-slider-widget-skin">
    	<div style=" <?php if ( $is_slider_tall_dynamic == 0 ) { echo 'height:'.$slider_height_fixed. 'px'; } ?>" id="wc-product-slider-<?php echo $unique_id; ?>" class="cycle-slideshow wc-product-slider <?php if ( $is_slider_tall_dynamic == 1 ) { ?>wc-product-slider-dynamic-tall<?php } ?>"
        	data-cycle-fx="<?php echo $fx; ?>"
            <?php echo $transition_attributes; ?>
            
        	data-cycle-timeout=<?php echo $timeout; ?> 
            data-cycle-speed=<?php echo $speed; ?> 
            data-cycle-delay=<?php echo $delay; ?> 
            <?php if ( $enable_slider_touch == 1 ) { ?>
            data-cycle-swipe=true
            <?php } ?>
            
            data-cycle-prev="> .a3-cycle-controls .cycle-prev"
            data-cycle-next="> .a3-cycle-controls .cycle-next"
            data-cycle-pager="> .cycle-pager-container .cycle-pager-inside .cycle-pager"
            
            <?php if ( $is_slider_tall_dynamic == 0 ) { ?>
            data-cycle-center-vert=true
            <?php  } ?> 
            data-cycle-auto-height=<?php echo $dynamic_tall; ?>
    		data-cycle-center-horz=true
            
            data-cycle-caption="<?php echo $caption_class; ?>"
            data-cycle-caption-template="{{name}}"
            data-cycle-caption-plugin="caption2"
            data-cycle-caption-fx-out="<?php echo $caption_fx_out; ?>"
            data-cycle-caption-fx-in="<?php echo $caption_fx_in; ?>"
            
            data-cycle-overlay="<?php echo $overlay_class; ?>"
			data-cycle-overlay-fx-out="<?php echo $caption_fx_out; ?>"
			data-cycle-overlay-fx-in="<?php echo $caption_fx_in; ?>"
            
            data-cycle-loader=true
        >

        	<div class="a3-cycle-controls">
            	<span><a href="#" class="cycle-prev"><?php _e( 'Prev', 'wc_product_slider' ); ?></a></span>
                <span><a href="#" class="cycle-next"><?php _e( 'Next', 'wc_product_slider' ); ?></a></span>
                <span><a href="#" data-cycle-cmd="pause" data-cycle-context="#wc-product-slider-<?php echo $unique_id; ?>" onclick="return false;" class="cycle-pause" style=" <?php if ( $slider_settings['slider_auto_scroll'] == 'no' ) { echo 'display:none'; } ?>"><?php _e( 'Pause', 'wc_product_slider' ); ?></a></span>
                <span><a href="#" data-cycle-cmd="resume" data-cycle-context="#wc-product-slider-<?php echo $unique_id; ?>" onclick="return false;" class="cycle-play"  style=" <?php if ( $slider_settings['slider_auto_scroll'] != 'no' ) { echo 'display:none'; } ?>"><?php _e( 'Play', 'wc_product_slider' ); ?></a></span>
            </div>			
            
        	<div class="cycle-pager-container">
            	<div class="cycle-pager-inside">
            		<div class="cycle-pager-overlay"></div>
                	<div class="cycle-pager"></div>
                </div>
            </div>
        
        <?php $number_products = 0; ?>
		<?php foreach ( $slide_items as $product_id => $item ) { ?>
		<?php
				if ( trim( $item['img_url'] ) == '' ) continue;
				
				$number_products++;
				
				$item_title = '';
				if ( $enable_slider_title == 1 && trim( $item['item_title'] ) != '' ) {
					$item_title = '<div class="cycle-product-name"><a href="'. trim( $item['item_link'] ) .'">'. trim( stripslashes( $item['item_title'] ) ) .'</a></div>';
				}
				
				if ( version_compare( $woocommerce_db_version, '2.0', '<' ) && null !== $woocommerce_db_version ) {
					$product_data = new WC_Product( $product_id ); 
				} else {
					$product_data = get_product( $product_id );
				}
				
				$product_price = $product_data->get_price_html();
			
				$item_price = '';
				if ( trim( $product_price ) != '' )
					$item_price = '<div class="cycle-product-price">'. trim( $product_price ) .'</div>';
					
				$item_title .= $item_price;
				
				$item_linked_view = '';
				if ( $enable_product_link == 1 ) 
					$item_linked_view = '<a class="cycle-product-linked" href="'. trim( $item['item_link'] ) .'">' . trim( $product_link_text ) . '</a>';
		?>
        	<img src="<?php echo esc_attr( $item['img_url'] ); ?>" name="<?php echo esc_attr( $item_title ); ?>" title="" data-cycle-desc="<?php echo esc_attr( $item_linked_view ); ?>" 
            style=" <?php if ( $number_products > 1 ) { echo 'display:none;'; } ?> "
            <?php
				if ( $fx == 'random' ) {
					echo WC_Product_Slider_Functions::get_transition_random( $slider_settings );
				}
			?>
            />
        <?php } ?>
        </div>
    
    </div>
    
    <?php if ( $title_position == 'bellow' ) self::get_title_widget_skin( $unique_id ); ?>
    
    <div id="cycle-widget-skin-overlay-<?php echo $unique_id; ?>" class="cycle-widget-skin-product-linked-container"></div>
    
    <?php if ( $enable_category_link == 1 && trim( $category_link ) != '' ) { ?>
    <div class="cycle-widget-skin-category-linked-container"><a class="cycle-category-linked" href="<?php echo esc_attr( $category_link ); ?>"><?php echo trim( $category_link_text ); ?></a></div>
    <?php } ?>
    
    <?php if ( $enable_tag_link == 1 && trim( $tag_link ) != '' ) { ?>
    <div class="cycle-widget-skin-tag-linked-container"><a class="cycle-tag-linked" href="<?php echo esc_attr( $tag_link ); ?>"><?php echo trim( $tag_link_text ); ?></a></div>
    <?php } ?>
    
    </div>
    <div style="clear:both;"></div>
    <?php
		$slider_output = ob_get_clean();
		
		return $slider_output;
		
	}
		
	public static function get_title_widget_skin( $unique_id = 1 ) {
	?>
		<div id="cycle-widget-skin-caption-<?php echo $unique_id; ?>" class="cycle-widget-skin-product-name-container"></div>
    <?php	
	}
				
}
?>
