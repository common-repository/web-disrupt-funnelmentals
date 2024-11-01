<?php
namespace Elementor {

	if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

	class Widget_Web_Disrupt_Funnelmentals_Forms extends Widget_Base {

		public function get_name() {
			return 'web-disrupt-funnelmentals-forms';
		}

		public function get_title() {
			return esc_html__( 'WDF - Forms', 'web-disrupt-funnelmentals' );
		}

		public function get_icon() {
			return 'eicon-form-horizontal web-disrupt-funnelmentals-icon';
		}

		public function get_categories() {
			return [ 'web-disrupt-funnelmentals' ];
		}
		
		protected function _register_controls() {


			$this->start_controls_section(
				'WDF_section_global',
				[
					'label' => esc_html__( 'Form Details', 'web-disrupt-funnelmentals' )
				]
			);
			
			/* Get settings data **I will Implement**   */
			$db_data = get_option("funnelmentals-settings-data"); // Grab all funnelmentals settings from db
			$Mailchimp_API_KEY = htmlspecialchars($db_data['mc-key']); // Isolate API key
			$admin_url = admin_url('admin.php?page=funnelmentals-settings'); // Link to change Key

			$this->add_control(
				'WDF_forms_admin_settings',
				[
						'type'    => Controls_Manager::RAW_HTML,
						'raw' => __( 'Add API keys for maximum reuse. <a href="'.$admin_url.'"> Click Here </a>', 'web-disrupt-funnelmentals'),
				]
			);

			
			$repeater = new Repeater();
			$repeater->add_control(
				'form_label',[
				'label' => esc_html__( 'Label', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]);
			$repeater->add_control(
				'form_map_id',[
				'label' => esc_html__( 'Map ID', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT,
				'options' => [""=>""],
				'label_block' => true,
			]);	
			$repeater->add_responsive_control(
				'form_size', [
				'label' => __( 'Size', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%'=>[
						'min' => 0,
						'max' => 100
					],
					'px'=>[
						'min' => 0,
						'max' => 1200
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_control(
				'WDF_form_fields_repeater',
				[
					'label' => '',
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'form_label' => esc_html__( 'Email', 'web-disrupt-funnelmentals' ),
							'form_map_id' => esc_html__( 'email', 'web-disrupt-funnelmentals' ),					
						]
					],
					'fields' => $repeater->get_controls()
				]
			);
			

			$this->end_controls_section();	

		}


		protected function render( ) {
			
			$settings = $this->get_settings();
			$fields = $settings['WDF_form_fields_repeater'];
			/* Loop through tracking */
			for ($i=0; $i < count($fields); $i++) { 

				/* Setup Magic Strings */
				$form_label = $fields[$i]['form_label'];
				$form_id = $fields[$i]['form_map_id'];
				$form_size 	= $fields[$i]['form_size'];

				?>
				<input class="wdf-data-input" type="text" data-map-name="<?php echo $form_id; ?>" />
				<?php

			} /* Loop */

			?>

			<div id="submit-btn" > Submit <!-- Replace with variable --> </div>

			<script> 

				jQuery('document').ready(function($){
					    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
						$('#submit-btn').click(function(){
							var data = [];
							$('.wdf-data-input').each(function(){
								thisKey = $(this).attr("data-map-name").trim().replace(/ /g, "-");
								thisValue = $(this).val();
								data.push({ [thisKey] : thisValue });
							});
							$.post(ajaxurl, { action : 'send_to_mailchimp_api', data: data }, function(data) { 
								console.log(data);
							});
					});
				});			
			</script>
			<?php
		
		}

		protected function content_template() {
			/* Optional Only if needed for editor live updating of elements */
		}
	}


	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Web_Disrupt_Funnelmentals_Forms() );

}