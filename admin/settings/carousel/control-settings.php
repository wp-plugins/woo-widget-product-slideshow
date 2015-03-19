<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Carousel Controls Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_Product_Slider_Carousel_Control_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'controls';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_carousel_control_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_carousel_control_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Controls Settings successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Controls Settings can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Controls Settings successfully reseted.', 'wc_product_slider' ),
			);
					
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
		
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_product_slider_admin_interface;
		
		$wc_product_slider_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'controls',
			'label'				=> __( 'Controls', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_carousel_control_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_product_slider_admin_interface;
		
		$output = '';
		$output .= $wc_product_slider_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
				
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
				'name'		=> __( 'Controls Settings', 'wc_product_slider' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Slider Control', 'wc_product_slider' ),
				'id' 		=> 'enable_slider_control',
				'class'		=> 'enable_slider_control',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'slider_control_container'
           	),
			array(  
				'name' 		=> __( 'Control Transition', 'wc_product_slider' ),
				'id' 		=> 'slider_control_transition',
				'type' 		=> 'onoff_radio',
				'class'		=> 'slider_control_transition',
				'default' 	=> 'hover',
				'onoff_options' => array(
					array(
						'val' 				=> 'alway',
						'text' 				=> __( 'Alway show when slider loaded', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
					array(
						'val' 				=> 'hover',
						'text' 				=> __( 'Show when hover on slider container', 'wc_product_slider' ),
						'checked_label'		=> __( 'ON', 'wc_product_slider') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_product_slider') ,
					),
				),			
			),
			array(  
				'name' 		=> __( 'Previous Icon', 'wc_product_slider' ),
				'id' 		=> 'control_previous_icon',
				'type' 		=> 'upload',
				'default'	=> WC_PRODUCT_SLIDER_IMAGES_URL.'/small-prev.png',
			),
			array(  
				'name' 		=> __( 'Next Icon', 'wc_product_slider' ),
				'id' 		=> 'control_next_icon',
				'type' 		=> 'upload',
				'default'	=> WC_PRODUCT_SLIDER_IMAGES_URL.'/small-next.png',
			),
			array(  
				'name' 		=> __( 'Play Icon', 'wc_product_slider' ),
				'id' 		=> 'control_play_icon',
				'type' 		=> 'upload',
				'default'	=> WC_PRODUCT_SLIDER_IMAGES_URL.'/small-play.png',
			),
			array(  
				'name' 		=> __( 'Pause Icon', 'wc_product_slider' ),
				'id' 		=> 'control_pause_icon',
				'type' 		=> 'upload',
				'default'	=> WC_PRODUCT_SLIDER_IMAGES_URL.'/small-pause.png',
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.enable_slider_control:checked").val() == '1') {
		$(".slider_control_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_control_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_control', function( event, value, status ) {
		$(".slider_control_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_control_container").slideDown();
		} else {
			$(".slider_control_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_product_slider_carousel_control_settings;
$wc_product_slider_carousel_control_settings = new WC_Product_Slider_Carousel_Control_Settings();

/** 
 * wc_product_slider_carousel_control_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_carousel_control_settings_form() {
	global $wc_product_slider_carousel_control_settings;
	$wc_product_slider_carousel_control_settings->settings_form();
}

?>