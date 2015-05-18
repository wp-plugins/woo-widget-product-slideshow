<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Mobile Skin Pager Settings

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

class WC_Product_Slider_Mobile_Skin_Pager_Settings extends WC_Product_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'pager';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_product_slider_a3_mobile_skin_pager_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_product_slider_a3_mobile_skin_pager_settings';
	
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
				'success_message'	=> __( 'Pager Settings successfully saved.', 'wc_product_slider' ),
				'error_message'		=> __( 'Error: Pager Settings can not save.', 'wc_product_slider' ),
				'reset_message'		=> __( 'Pager Settings successfully reseted.', 'wc_product_slider' ),
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
			'name'				=> 'pager',
			'label'				=> __( 'Pager', 'wc_product_slider' ),
			'callback_function'	=> 'wc_product_slider_mobile_skin_pager_settings_form',
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
				'name'		=> __( 'Pager Settings', 'wc_product_slider' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Slider Pager', 'wc_product_slider' ),
				'id' 		=> 'enable_slider_pager',
				'class'		=> 'enable_slider_pager',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wc_product_slider' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_product_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'slider_pager_container'
           	),
			array(  
				'name' 		=> __( 'Pager Position', 'wc_product_slider' ),
				'id' 		=> 'slider_pager_position',
				'type' 		=> 'select',
				'default'	=> 'bottom-right',
				'options'	=> array(
					'top-left'		=> __( 'Top Left', 'wc_product_slider' ),
					'top-center'	=> __( 'Top Center', 'wc_product_slider' ),
					'top-right'		=> __( 'Top Right', 'wc_product_slider' ),
					'bottom-left'	=> __( 'Bottom Left', 'wc_product_slider' ),
					'bottom-center'	=> __( 'Bottom Center', 'wc_product_slider' ),
					'bottom-right'	=> __( 'Bottom Right', 'wc_product_slider' ),
				),
				'css' 		=> 'width:160px;',
			),
			
			array(  
				'name' 		=> __( 'Pager Container Padding', 'wc_product_slider' ),
				'id' 		=> 'pager_container_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'pager_container_padding_top',
	 										'name' 		=> __( 'Top', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 2 ),
	 
	 								array(  'id' 		=> 'pager_container_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 2 ),
											
									array( 
											'id' 		=> 'pager_container_padding_left',
	 										'name' 		=> __( 'Left', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'pager_container_padding_right',
	 										'name' 		=> __( 'Right', 'wc_product_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 							)
			),
			array(  
				'name' 		=> __( 'Pager Container Background Colour', 'wc_product_slider' ),
				'desc' 		=> __( 'Default', 'wc_product_slider' ) . ' [default_value]',
				'id' 		=> 'pager_background_colour',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Pager Container Background Transparency', 'wc_product_slider' ),
				'desc'		=> __( 'Scale - 0 = 100% transparent - 100 = 100% Solid Colour.', 'wc_product_slider' ),
				'id' 		=> 'pager_background_transparency',
				'type' 		=> 'slider',
				'default'	=> 60,
				'min'		=> 0,
				'max'		=> 100,
				'increment'	=> 10,
			),
			array(  
				'name' 		=> __( 'Pager Container Border', 'wc_product_slider' ),
				'id' 		=> 'pager_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '0px', 'style' => 'solid', 'color' => '#000000', 'corner' => 'rounded' , 'rounded_value' => 10 )
			),
			array(  
				'name' 		=> __( 'Pager Container Shadow', 'wc_product_slider' ),
				'id' 		=> 'pager_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#DBDBDB', 'inset' => '' )
			),
			
			array(  
				'name' 		=> __( 'Pager Font', 'wc_product_slider' ),
				'id' 		=> 'pager_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '11px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' )
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	
	if ( $("input.enable_slider_pager:checked").val() == '1') {
		$(".slider_pager_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_pager_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_pager', function( event, value, status ) {
		$(".slider_pager_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_pager_container").slideDown();
		} else {
			$(".slider_pager_container").slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_product_slider_mobile_skin_pager_settings;
$wc_product_slider_mobile_skin_pager_settings = new WC_Product_Slider_Mobile_Skin_Pager_Settings();

/** 
 * wc_product_slider_mobile_skin_pager_settings_form()
 * Define the callback function to show subtab content
 */
function wc_product_slider_mobile_skin_pager_settings_form() {
	global $wc_product_slider_mobile_skin_pager_settings;
	$wc_product_slider_mobile_skin_pager_settings->settings_form();
}

?>