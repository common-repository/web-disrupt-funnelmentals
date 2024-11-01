<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.



class Widget_Web_Disrupt_Funnelmentals_Trigger_External_Tracking extends Widget_Base {

	public function get_name() {
		return 'web-disrupt-funnelmentals-trigger-external-tracking';
	}

	public function get_title() {
		return esc_html__( 'WDF - Trigger Tracking', 'web-disrupt-funnelmentals' );
	}

	public function get_icon() {
		return 'fa fa-line-chart web-disrupt-funnelmentals-icon';
	}

   public function get_categories() {
		return [ 'web-disrupt-funnelmentals' ];
	}
	
	protected function _register_controls() {


  		$this->start_controls_section(
  			'section_title_WDF_global_options',
  			[
  				'label' => esc_html__( 'Tracking Actions', 'web-disrupt-funnelmentals' )
  			]
		  );
		 
		/* Get settings data */
		$db_data = get_option("funnelmentals-settings-data");
		$pixel_active = htmlspecialchars($db_data['fb-pixel']);
		$ga_active = htmlspecialchars($db_data['google-analytics']);
		$admin_url = admin_url('admin.php?page=funnelmentals-settings');

		if(strlen($pixel_active) < 1){
			$this->add_control(
			  'web_disrupt_funnelmentals_tracking_pixel_notice',
			  [
					  'type'    => Controls_Manager::RAW_HTML,
					  'raw' => __( 'Activate pixel tracking number. <a href="'.$admin_url.'"> Click Here </a>', 'web-disrupt-funnelmentals'),
			  ]
			);
		}
		if(strlen($ga_active) < 1){
		  $this->add_control(
			  'web_disrupt_funnelmentals_tracking_GA_notice',
			  [	  
				'type'    => Controls_Manager::RAW_HTML,
				'raw' => __( 'Activate google Analytics tracking number. <a href="'.$admin_url.'"> Click Here </a>', 'web-disrupt-funnelmentals'),
			  ]
			);
		}


		$this->add_control(
			'web_disrupt_funnelmentals_tracking_repeater',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'web_disrupt_funnelmentals_tracking_repeater_platform' => esc_html__( 'Facebook Pixel', 'web-disrupt-funnelmentals' ),
						'web_disrupt_funnelmentals_tracking_repeater_event_type' => esc_html__( 'Purchase', 'web-disrupt-funnelmentals' ),
						'web_disrupt_funnelmentals_tracking_repeater_custom_event_name' => esc_html__( 'CustomEvent', 'web-disrupt-funnelmentals' ),
					]
				],
				'fields' => [
					[ /* Select Tracking Platform */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_platform',
						'label' => esc_html__( 'Platform', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'Facebook Pixel',
						'options' => [
							'Facebook Pixel'   => esc_html__( 'Facebook Pixel', 'web-disrupt-funnelmentals' ),
							'Google Analytics' => esc_html__( 'Google Analytics', 'web-disrupt-funnelmentals' ),
						],
						'label_block' => true,
					],
					[ /* Facebook Pixel Events */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_event_type',
						'label' => esc_html__( 'Tracking Event Type', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'Purchase',
						'options' => [
							'PageView'               => esc_html__( 'PageView', 'web-disrupt-funnelmentals' ),
							'ViewContent'            => esc_html__( 'ViewContent', 'web-disrupt-funnelmentals' ),
							'AddToCart'              => esc_html__( 'AddToCart', 'web-disrupt-funnelmentals' ),
							'AddToWishlist'          => esc_html__( 'AddToWishlist', 'web-disrupt-funnelmentals' ),
							'Purchase'               => esc_html__( 'Purchase', 'web-disrupt-funnelmentals' ),
							'InitiateCheckout'       => esc_html__( 'InitiateCheckout', 'web-disrupt-funnelmentals' ),
							'AddPaymentInfo'         => esc_html__( 'AddPaymentInfo', 'web-disrupt-funnelmentals' ),
							'Lead'                   => esc_html__( 'Lead', 'web-disrupt-funnelmentals' ),
							'CompleteRegistration'   => esc_html__( 'CompleteRegistration', 'web-disrupt-funnelmentals' ),
							'Custom'                 => esc_html__( 'Custom', 'web-disrupt-funnelmentals' ),
						],
						'label_block' => true,
						'condition' => [
							'web_disrupt_funnelmentals_tracking_repeater_platform' => 'Facebook Pixel',
						],
					],
					[
						'type'    => Controls_Manager::RAW_HTML,
						'raw' => __( '<b>PageView</b> is called by default. Check the funnelmentals settings before using it.', 'web-disrupt-funnelmentals' ),
						'condition' => [
							'web_disrupt_funnelmentals_tracking_repeater_platform' => 'Facebook Pixel',
						],
					],
					[ /* Google Analytics Events */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_event_type',
						'label' => esc_html__( 'Tracking Event Type', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'purchase',
						'options' => [
							'add_payment_info'       => esc_html__( 'add_payment_info', 'web-disrupt-funnelmentals' ),
							'add_to_cart'            => esc_html__( 'add_to_cart', 'web-disrupt-funnelmentals' ),
							'add_to_wishlist'        => esc_html__( 'add_to_wishlist', 'web-disrupt-funnelmentals' ),
							'begin_checkout'         => esc_html__( 'begin_checkout', 'web-disrupt-funnelmentals' ),
							'checkout_progress'      => esc_html__( 'checkout_progress', 'web-disrupt-funnelmentals' ),
							'generate_lead'          => esc_html__( 'generate_lead', 'web-disrupt-funnelmentals' ),
							'login'                  => esc_html__( 'login', 'web-disrupt-funnelmentals' ),
							'purchase'               => esc_html__( 'purchase', 'web-disrupt-funnelmentals' ),
							'refund'   				 => esc_html__( 'refund', 'web-disrupt-funnelmentals' ),
							'remove_from_cart'       => esc_html__( 'remove_from_cart', 'web-disrupt-funnelmentals' ),
							'search'                 => esc_html__( 'search', 'web-disrupt-funnelmentals' ),
							'select_content'         => esc_html__( 'select_content', 'web-disrupt-funnelmentals' ),
							'set_checkout_option'    => esc_html__( 'set_checkout_option', 'web-disrupt-funnelmentals' ),
							'share'                  => esc_html__( 'share', 'web-disrupt-funnelmentals' ),
							'sign_up'                => esc_html__( 'sign_up', 'web-disrupt-funnelmentals' ),
							'view_item'              => esc_html__( 'view_item', 'web-disrupt-funnelmentals' ),
							'view_item_list'         => esc_html__( 'view_item_list', 'web-disrupt-funnelmentals' ),
							'view_promotion'   	     => esc_html__( 'view_promotion', 'web-disrupt-funnelmentals' ),
							'view_search_results'    => esc_html__( 'view_search_results', 'web-disrupt-funnelmentals' ),
							'custom_event'           => esc_html__( 'custom_event', 'web-disrupt-funnelmentals' ),
						],
						'label_block' => true,
						'condition' => [
							'web_disrupt_funnelmentals_tracking_repeater_platform' => 'Google Analytics',
						],
					],
					[ /* Input Custom Event Name */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_custom_event_name',
						'label' => esc_html__( 'Custom Event Name', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::TEXT,
						'default' => 'CustomEvent',
						'label_block' => true,
						'condition' => [
							'web_disrupt_funnelmentals_tracking_repeater_event_type' => ['custom_event', 'Custom'],
						],
					],
					[ /* Event Trigger Type */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_event_trigger_type',
						'label' => esc_html__( 'Tracking Event Trigger Type', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'On Page Load',
						'options' => [
							'On Page Load'              => esc_html__( 'On Page Load', 'web-disrupt-funnelmentals' ),
							'On Page Load With Delay'   => esc_html__( 'On Page Load With Delay', 'web-disrupt-funnelmentals' ),
							'On Class Clicked'          => esc_html__( 'On Class Clicked', 'web-disrupt-funnelmentals' ),
							'On ID Clicked'             => esc_html__( 'On ID Clicked', 'web-disrupt-funnelmentals' ),
						],
						'label_block' => true,
					],
					[ /* Trigger Delay */
						'name' => 'web_disrupt_funnelmentals_tracking_repeater_trigger_delay',
						'label' => esc_html__( 'Delay Amount (seconds)', 'web-disrupt-funnelmentals' ),
						'type' => Controls_Manager::NUMBER,
						'default' => 10,
						'min'     => 0,
						'max'     => 10000,
						'step'    => 1,
						'label_block' => true,
						'condition' => [
							'web_disrupt_funnelmentals_tracking_repeater_event_trigger_type' => ['On Page Load With Delay'],
						],
					],
					[ /* Trigger Target ID or Class */
					'name' => 'web_disrupt_funnelmentals_tracking_repeater_trigger_target',
					'label' => esc_html__( 'Trigger Target Name', 'web-disrupt-funnelmentals' ),
					'type' => Controls_Manager::TEXT,
					'default' => 'targetName',
					'label_block' => true,
					'condition' => [
						'web_disrupt_funnelmentals_tracking_repeater_event_trigger_type' => ['On Class Clicked', 'On ID Clicked'],
					],
				],
			],
				'title_field'        => '{{{ web_disrupt_funnelmentals_tracking_repeater_platform }}} - {{{ web_disrupt_funnelmentals_tracking_repeater_event_type }}}',
			]
		);
		

		$this->end_controls_section();	

	}


	protected function render( ) {
		
		$settings = $this->get_settings();
		
		/* Loop through tracking */
		for ($i=0; $i < count($settings['web_disrupt_funnelmentals_tracking_repeater']); $i++) { 

			/* Setup Magic Strings */
			$t_platform 		  = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_platform'];
			$t_event 			  = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_event_type'];
			$t_event_custom_name  = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_custom_event_name'];
			$t_trigger_type       = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_event_trigger_type'];
			$t_trigger_delay      = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_trigger_delay'] * 1000;
			$t_trigger_target     = $settings['web_disrupt_funnelmentals_tracking_repeater'][$i]['web_disrupt_funnelmentals_tracking_repeater_trigger_target'];
			
			/* Generate Script */
			if( current_user_can('editor') || current_user_can('administrator') ) {
				
				
				// If is admin then console.log event for testing
				$print_tracking = "console.log('Fired ".$t_platform." -. Event ".$t_event."')";
				
				
				
			} else {  // Don't Track WordPress Admin -> SMART /\
				

				if ($t_platform == 'Facebook Pixel'){

					/* Pixel */	
					if($t_event == "Custom"){
						$print_tracking = "fbq('trackCustom', '".$t_event."'";
					} else {
						$print_tracking = "fbq('track', '".$t_event."'";
					}
					/* TODO Add Params */
					$print_tracking .= ");";

				} else {

					/* GA */	
					$print_tracking = "gtag('event', '".$t_event."'";
					/* TODO Add Params */
					$print_tracking .= ");";

				}

				

			}


			/* Add Execution */

			if ($t_trigger_type === 'On Page Load With Delay'){

				$print_tracking = "setTimeout(function(){" . $print_tracking . "}, " . $t_trigger_delay . ");";		

			} else if ($t_trigger_type === 'On Class Clicked'){

				$print_tracking = "var x = document.getElementsByClassName('" . $t_trigger_target . "'); for(var i = 0;i < x.length; i++){ x[i].addEventListener('click', function() {" . $print_tracking . "}); }";

			} else if ($t_trigger_type === 'On ID Clicked'){
				
				$print_tracking = "document.getElementById('" . $t_trigger_target . "').addEventListener('click', function() {" . $print_tracking . "});";				

			}


			/* Final Output */
			
			echo "<script> document.addEventListener('DOMContentLoaded', function(event) { ".$print_tracking.' }); </script>';


		} /* Loop */
	
	}

	protected function content_template() {
		
		?>
		
	
		<?php
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Web_Disrupt_Funnelmentals_Trigger_External_Tracking() );