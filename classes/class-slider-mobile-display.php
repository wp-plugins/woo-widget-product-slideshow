<?php
class WC_Product_Slider_Mobile_Display
{	
	public static function mobile_dispay_slider( $slide_items = array(), $is_used_mobile_skin = false , $slider_settings = array(), $category_link = '', $tag_link = '' ) {
					
		global $wc_product_slider_a3_mobile_skin_title_settings;
		global $wc_product_slider_a3_mobile_skin_category_tag_link_settings;
		
		$woocommerce_db_version = get_option( 'woocommerce_db_version', null );
		
		add_action( 'wp_footer', array( 'WC_Product_Slider_Hook_Filter', 'include_slider_mobile_scripts' ) );
		
		extract( $wc_product_slider_a3_mobile_skin_title_settings );
		extract( $wc_product_slider_a3_mobile_skin_category_tag_link_settings );
		
		// Return empty if it does not have any slides
		if ( ! is_array( $slide_items ) || count( $slide_items ) < 1 ) return '';
				
		$caption_fx_out = 'fadeOut';
		$caption_fx_in = 'fadeIn';
		
		$unique_id = rand( 100, 1000 );
				
		$overlay_class = '#cycle-mobile-skin-overlay-' . $unique_id;
		
		$fx 							= 'scrollHorz';
						
		ob_start();
	?>
    <div style="clear:both;"></div>
    <div class="wc-product-slider-mobile-skin-container wc-product-slider-basic-mobile-skin-container">
    
    <div id="wc-product-slider-container-<?php echo $unique_id; ?>" class="wc-product-slider-container wc-product-slider-mobile-skin">
    	<div id="wc-product-slider-<?php echo $unique_id; ?>" class="cycle-slideshow wc-product-slider"
        	data-cycle-fx="<?php echo $fx; ?>"
            data-cycle-paused=true
            data-cycle-auto-height=container
            
            data-cycle-center-horz=true
            
            data-cycle-swipe=true
            
            data-cycle-caption="> .cycle-caption-container .cycle-caption"
            data-cycle-caption-template="{{slideNum}} / {{slideCount}}"
            data-cycle-caption-plugin="caption2"
            
            data-cycle-loader=true
        >

        	<div class="cycle-caption-container">
            	<div class="cycle-caption-inside">
            		<div class="cycle-caption-overlay"></div>
                	<div class="cycle-caption"></div>
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
				
				$category_tag_link = '';
				if ( $enable_category_link == 1 && trim( $category_link ) != '' ) {
					$category_tag_link = '<div class="cycle-mobile-skin-category-linked-container"><a class="cycle-category-linked" href="'.esc_attr( $category_link ).'">'. trim( $category_link_text ).'</a></div>';
				} elseif ( $enable_tag_link == 1 && trim( $tag_link ) != '' ) {
					$category_tag_link = '<div class="cycle-mobile-skin-tag-linked-container"><a class="cycle-tag-linked" href="'.esc_attr( $tag_link ).'">'. trim( $tag_link_text ).'</a></div>';
				}
				
		?>
                <img src="<?php echo esc_attr( $item['img_url'] ); ?>" title="<?php echo esc_attr( $item_title ); ?>" alt="" style=" <?php if ( $number_products > 1 ) { echo 'display:none;'; } ?> " />
            
        <?php } ?>
        </div>
    	<div class="wc-product-slider-bg"></div>
    </div>
    
    </div>
    
    <?php
		$slider_output = ob_get_clean();
		
		return $slider_output;
		
	}
	
	public static function get_caption_mobile_template( $unique_id = 1 ) {
	?>
		<div id="cycle-mobile-skin-overlay-<?php echo $unique_id; ?>" class="cycle-mobile-skin-overlay"></div>
    <?php	
	}
	
}
?>