<?php
namespace Web_Disrupt_Funnelmentals {

	class Web_Disrupt_Funnelmental_Base_Actions {
		private $db_data;
		private $Mailchimp_API_KEY;
		/**
		 * Init Actions
		 */
		public function __construct(){
	
			$this->db_data = get_option("funnelmentals-settings-data"); // Grab all funnelmentals settings from db
			$this->Mailchimp_API_KEY = htmlspecialchars($this->db_data['mc-key']); // Isolate API key
			/* Add logged in and anon ajax calls */
			add_action( "wp_ajax_send_to_mailchimp_api", array( $this, 'send_to_mailchimp_api' ));
			add_action( "wp_ajax_nopriv_send_to_mailchimp_api", array( $this, 'send_to_mailchimp_api' ));
			/* Remove Bottom Margin */
			add_action( "wp_head", array( $this, "remove_20_px_bottom_margin_not_last"));
	
		}
	
		/**
		 * Send Data to Mail Chimp
		 */
		public function send_to_mailchimp_api(){
			/* SEND DATA TO MAILCHIMP API */	
			$data = $_POST['data'];
			print_r($data);
			//$this->redirect_to();
			wp_die();
		}
	
		/**
		 * Redirect to desired page
		 */
		public function redirect_to(){
			wp_redirect("", 301);
		}

		/**
		 * Remove forced Elementor default 20px forced bottom margin
		 */
		public function remove_20_px_bottom_margin_not_last(){
			$wdf_settings = get_option(WDF_Core::$plugin_data['settings-id']);
			if($wdf_settings['remove-elementor-bottom-margin'] == 'true' || $wdf_settings['remove-elementor-bottom-margin'] == ''){
				?> <style> .elementor-widget:not(:last-child) { margin-bottom: 0px !important; } </style> <?php
			}
		}
	
	}
		new Web_Disrupt_Funnelmental_Base_Actions();
}