<?php
/**
 * WooCommerce Product Slider Widget
 *
 * Table Of Contents
 *
 * __construct()
 * widget()
 * update()
 * form()
 */
class WC_Product_Slider_Widget extends WP_Widget 
{
	function WC_Product_Slider_Widget() {
		$widget_ops = array('classname' => 'widget_product_cycle', 'description' => __( 'Use this widget to add Woocommerce Products slider as a widget.', 'wc_product_slider') );
		$this->WP_Widget('widget_product_cycle', __( 'Woo Products Slider', 'wc_product_slider' ), $widget_ops );

	}

	function widget( $args, $instance ) {
		extract($args);
		
		$instance = wp_parse_args( (array) $instance, array( 
			'title' 				=> '', 
			'category_id' 			=> 0, 
			'widget_effect'			=> 'fade',
			'slider_auto_scroll'	=> 'no',
			
		) );
		
		$instance = wp_parse_args( array( 
			'effect_delay'			=> 1,
			'effect_timeout'		=> 4,
			'effect_speed'			=> 2,
			
		), $instance );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo $this->items_cycle( $widget_id, $instance );
		echo $after_widget;
	}
	
	public static function items_cycle( $widget_id, $slider_settings ) {
		
		$output = '';
		
		// slider id
		$slider_id = 'plugin=wc_product_slider';
		
		
		$category_id 		= $slider_settings['category_id'];
		
		$widget_effect 		= $slider_settings['widget_effect'];
		
		$tag_link = '';
		$category_link = '';
		
		$slider_id .= '&show_type=category';
		
		if ( $category_id < 1) return;
		$slider_id .= '&category_id='.$category_id;
		$category_link = get_term_link( (int) $category_id, 'product_cat');
		
		$slider_id .= '&skin_type=widget';
		$slider_id .= '&number_products=6';

		
		if ( $widget_effect == 'random' ) $slider_id .= '&widget_effect='.$widget_effect;
		$slider_id = base64_encode( $slider_id );
		$output = WC_Product_Slider_Display::dispay_slider_widget( $slider_id, $slider_settings, $category_link, $tag_link );
		

		
		return $output;
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = array_merge( $old_instance, $new_instance );
		$instance['title'] 					= esc_attr( $new_instance['title'] );
		
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' 				=> '', 
			'category_id' 			=> 0, 
			'widget_effect'			=> 'fade',
			'slider_auto_scroll'	=> 'no',
		) );
		
		$widget_id = str_replace('widget_product_cycle-','',$this->id);
		
		extract( $instance );
		
		$title = esc_attr( $title );
		
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wc_product_slider' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<fieldset id="wc_product_slider_upgrade_area">
<legend><?php _e('Upgrade to','wc_product_slider'); ?> <a href="<?php echo WC_WIDGET_PRODUCT_SLIDER_VERSION_URI; ?>" target="_blank"><?php _e('Widget Product Slider Version', 'wc_product_slider'); ?></a> <?php _e('to activate', 'wc_product_slider'); ?></legend>
<p>
	<label for="<?php echo $this->get_field_id('show_type'); ?>"><strong><?php _e( 'Show Type:', 'wc_product_slider' ); ?></strong></label>
    <select class="wc_product_slider_show_type" id="<?php echo $this->get_field_id('show_type'); ?>" name="<?php echo $this->get_field_name('show_type'); ?>" >
		<option value="category" selected="selected" ><?php _e( 'Category', 'wc_product_slider' ); ?></option>
        <option value="tag"><?php _e( 'Tag', 'wc_product_slider' ); ?></option>
        <option value="featured"><?php _e( 'Featured', 'wc_product_slider' ); ?></option>
        <option value="onsale"><?php _e( 'On Sale', 'wc_product_slider' ); ?></option>
	</select>
</p>

<p id="<?php echo $this->get_field_id('show_type'); ?>_tag" style="display:none">
<label for="<?php echo $this->get_field_id('tag_id'); ?>"><?php _e('Tag:', 'wc_product_slider'); ?></label> 
<?php wp_dropdown_categories( array('orderby' => 'name', 'name' => $this->get_field_name('tag_id'), 'id' => $this->get_field_id('tag_id'), 'class' => 'widefat', 'depth' => true, 'taxonomy' => 'product_tag') ); ?>
</p>

<p><label><?php _e('Number of products to show:', 'wc_product_slider'); ?> <input class="" name="<?php echo $this->get_field_name('number_products'); ?>" type="text" value="6" size="2" /></label><br />
<span class="description"><?php _e('Important! Set -1 to show all products. Warning - Setting large numbers (unlimited) could / will have an  impact on page load speed on some sites.', 'wc_product_slider'); ?></span>
</p>
</fieldset>

<p>
<label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Category:', 'wc_product_slider'); ?></label> 
<?php wp_dropdown_categories( array('orderby' => 'name', 'selected' => $category_id, 'name' => $this->get_field_name('category_id'), 'id' => $this->get_field_id('category_id'), 'class' => 'widefat', 'depth' => true, 'taxonomy' => 'product_cat') ); ?>
</p>

<fieldset id="wc_product_slider_upgrade_area">
<legend><?php _e('Upgrade to','wc_product_slider'); ?> <a href="<?php echo WC_WIDGET_PRODUCT_SLIDER_VERSION_URI; ?>" target="_blank"><?php _e('Widget Product Slider Version', 'wc_product_slider'); ?></a> <?php _e('to activate', 'wc_product_slider'); ?></legend>
<p><label><strong><?php _e( 'Skin Type:', 'wc_product_slider' ); ?></strong></label>
	<label><input type="radio" class="wc_product_slider_skin_type" data-id="<?php echo $this->get_field_id('skin_type'); ?>" name="<?php echo $this->get_field_name('skin_type'); ?>" value="widget" checked="checked" /> <?php _e( 'WIDGET', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
	<label><input type="radio" class="wc_product_slider_skin_type" data-id="<?php echo $this->get_field_id('skin_type'); ?>" name="<?php echo $this->get_field_name('skin_type'); ?>" value="card" /> <?php _e( 'CARD', 'wc_product_slider' ); ?></label>
</p>

<div id="<?php echo $this->get_field_id('skin_type'); ?>_card" style="display:none">
    <p><label><strong><?php _e('Effects Type:', 'wc_product_slider'); ?></strong></label>
        <select>
        <?php
        $transitions_list = WC_Product_Slider_Functions::card_slider_transitions_list();
        foreach ( $transitions_list as $effect_key => $effect_name ) {
        ?>
            <option value="<?php echo $effect_key; ?>"><?php echo $effect_name; ?></option>
        <?php
        }
        ?>
        </select>
    </p>
</div>
</fieldset>

<div id="<?php echo $this->get_field_id('skin_type'); ?>_widget">
    <p><label><strong><?php _e('Effects Type:', 'wc_product_slider'); ?></strong></label>
        <select id="<?php echo $this->get_field_id('widget_effect'); ?>" name="<?php echo $this->get_field_name('widget_effect'); ?>" >
        <?php
        $transitions_list = WC_Product_Slider_Functions::slider_transitions_list();
        foreach ( $transitions_list as $effect_key => $effect_name ) {
        ?>
            <option value="<?php echo $effect_key; ?>" <?php selected( $effect_key, $widget_effect ); ?>><?php echo $effect_name; ?></option>
        <?php
        }
        ?>
        </select>
    </p>
</div>
  
<p><label><strong><?php _e( 'Transition Method:', 'wc_product_slider' ); ?></strong></label>
    <label><input type="radio" class="wc_product_slider_slider_auto_scroll" data-id="<?php echo $this->get_field_id('slider_auto_scroll'); ?>" name="<?php echo $this->get_field_name('slider_auto_scroll'); ?>" value="no" checked="checked" /> <?php _e( 'MANUAL', 'wc_product_slider' ); ?></label> &nbsp;&nbsp;&nbsp;
    <label><input type="radio" class="wc_product_slider_slider_auto_scroll" data-id="<?php echo $this->get_field_id('slider_auto_scroll'); ?>" name="<?php echo $this->get_field_name('slider_auto_scroll'); ?>" value="yes" <?php checked( $slider_auto_scroll, 'yes' ); ?> /> <?php _e( 'AUTO', 'wc_product_slider' ); ?></label>
</p>

<fieldset id="wc_product_slider_upgrade_area">
<legend><?php _e('Upgrade to','wc_product_slider'); ?> <a href="<?php echo WC_WIDGET_PRODUCT_SLIDER_VERSION_URI; ?>" target="_blank"><?php _e('Widget Product Slider Version', 'wc_product_slider'); ?></a> <?php _e('to activate', 'wc_product_slider'); ?></legend>
<div id="<?php echo $this->get_field_id('slider_auto_scroll'); ?>_auto" <?php if ( $slider_auto_scroll != 'yes' ) { echo 'style="display:none"'; } ?>>
    <p><label><?php _e('Auto Start Delay:', 'wc_product_slider'); ?> <input name="<?php echo $this->get_field_name('effect_delay'); ?>" type="text" value="1" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?></label></p>
</div>

<p><label><?php _e('Time Between Transitions:', 'wc_product_slider'); ?> <input name="<?php echo $this->get_field_name('effect_timeout'); ?>" type="text" value="4" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?></label></p>
<p><label><?php _e('Transition Effect Speed:', 'wc_product_slider'); ?> <input name="<?php echo $this->get_field_name('effect_speed'); ?>" type="text" value="2" size="1" /> <?php _e('seconds', 'wc_product_slider'); ?></label></p>

</fieldset>
       
<?php
	}
}
?>
