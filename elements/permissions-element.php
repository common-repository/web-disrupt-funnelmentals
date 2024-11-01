<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_Web_Disrupt_Funnelmentals_Permissions extends Widget_Base {


	public function get_name() {
		return 'web-disrupt-funnelmentals-permissions';
	}

	public function get_title() {
		return esc_html__( 'WDF - Permissions', 'web-disrupt-funnelmentals' );
	}

	public function get_icon() {
		return 'fa fa-lock web-disrupt-funnelmentals-icon';
	}

   public function get_categories() {
		return [ 'web-disrupt-funnelmentals' ];
	}
	
	protected function _register_controls() {


  		$this->start_controls_section(
  			'section_wd_permissions_settings',
  			[
  				'label' => esc_html__( 'Permissions Settings', 'web-disrupt-funnelmentals' )
  			]
		  );
		 

		// Check to see which permissions system is installed  
		$permissions_type_options = 
		array(
			"logged out" => esc_html__( 'Logged Out', 'web-disrupt-funnelmentals' ), 
			"logged in" => esc_html__( 'Logged In', 'web-disrupt-funnelmentals' ) 
		);
		$product_list = array();

		// Get all the Elementor Templates
		$templates_query = new \WP_Query(
			[
				'post_type' => 'elementor_library',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
			]
		);
		$template_list = [];

		if ( $templates_query->have_posts() ) {
			foreach ( $templates_query->get_posts() as $post ) {
				$template_list[$post->ID] = $post->post_title;
			}
		}

		// If WooCommerce installed and Active
		if( function_exists( 'WC' ) ) {

			$product_list = $this->get_woocommerce_product_list();

			$permissions_type_options['bought product(s)'] = esc_html__( 'bought product(s)', 'web-disrupt-funnelmentals' );
			$permissions_type_options['did not buy product(s)'] = esc_html__( 'did not buy product(s)', 'web-disrupt-funnelmentals' );
		} 

			// Get pages fo reasy selection
			$page_ids = get_all_page_ids();
			$page_list = array();
			foreach($page_ids as $id)
			{
				$page_list[get_permalink($id)] = get_the_title($id)." - /".basename(get_permalink($id));
			} 
			$page_list["**Custom**"] = "Custom URL";


			// WooCommerce Fields 
			$this->add_control(
				'web_disrupt_funnelmentals_permissions',
				[
					'label' => 'Select Fields',
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'web_disrupt_funnelmentals_perm_type' => esc_html__( 'logged out', 'web-disrupt-funnelmentals' ),
						]
					],
					'fields' => [
						[ // Fields Select
							'name' => 'web_disrupt_funnelmentals_perm_type',
							'label' => esc_html__( 'Select Type', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::SELECT,
							'default' => 'logged out',
							'options' => $permissions_type_options,
							'label_block' => true,
						],
						[ // Woo Products Selection
							'name' => 'web_disrupt_funnelmentals_woo_products',
							'label' => esc_html__( 'Select Required Products', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::SELECT2,
							'default' => '',
							'multiple' => true,
							'options' => $product_list,
							'label_block' => true,
							'condition' => [
								'web_disrupt_funnelmentals_perm_type' => array('did not buy product(s)', 'bought product(s)'),
							]
						],
						[ // Action to take
							'name' => 'web_disrupt_funnelmentals_perm_action',
							'label' => esc_html__( 'Select Triggered Action', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::SELECT,
							'options' => array(
								'Redirect Page' => esc_html__( 'Redirect Page', 'web-disrupt-funnelmentals' ),
								'Hide by class' => esc_html__( 'Hide by class', 'web-disrupt-funnelmentals' ),
								'Hide by ID' => esc_html__( 'Hide by ID', 'web-disrupt-funnelmentals' ),
								'Render Elementor Template' => esc_html__( 'Render Elementor Template', 'web-disrupt-funnelmentals' ),
							),
							'label_block' => true,
						],
						[ // Find Class & Hide
							'name' => 'web_disrupt_funnelmentals_perm_class',
							'label'       => __( 'Class Name', 'web-disrupt-funnelmentals' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => __( '', 'web-disrupt-funnelmentals' ),
							'condition' => [
								'web_disrupt_funnelmentals_perm_action' => 'Hide by class',
							]
						],
						[ // Find ID & Hide
							'name' => 'web_disrupt_funnelmentals_perm_id',
							'label'       => __( 'ID Name', 'web-disrupt-funnelmentals' ),
							'type'        => Controls_Manager::TEXT,
							'default'     => __( '', 'web-disrupt-funnelmentals' ),
							'condition' => [
								'web_disrupt_funnelmentals_perm_action' => 'Hide by ID',
							]
						],	
						[ // Reder Template
							'name' => 'web_disrupt_funnelmentals_perm_show_template',
							'label' => esc_html__( 'Select Elementor Template', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::SELECT2,
							'options' => $template_list,
							'label_block' => true,
							'condition' => [
								'web_disrupt_funnelmentals_perm_action' => 'Render Elementor Template',
							]
						],		
						[ // Redirect Location
							'name' => 'web_disrupt_funnelmentals_perm_redirect_url',
							'label' => esc_html__( 'Select Redirect Location', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::SELECT2,
							'options' => $page_list,
							'label_block' => true,
							'condition' => [
								'web_disrupt_funnelmentals_perm_action' => 'Redirect Page',
							]
						],
						[ // Redirect Custom Location
							'name' => 'web_disrupt_funnelmentals_perm_redirect_url_custom',
							'label' => esc_html__( 'Select Redirect Location', 'web-disrupt-funnelmentals' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => 'https://webdisrupt.com',
							'label_block' => true,
							'condition' => [
								'web_disrupt_funnelmentals_perm_action' => 'Redirect Page',
								'web_disrupt_funnelmentals_perm_redirect_url' => '**Custom**',
							]
						],
				],
				'title_field' => 'If {{{ web_disrupt_funnelmentals_perm_type }}} then trigger action.',
				]
			);

			$this->add_control(
				'web_disrupt_funnelmentals_downloads_woo_product_desc',
				[
				   'type'    => Controls_Manager::RAW_HTML,
				   'raw' => __( 'The permissions will not work on admin or in the editor. ', 'web-disrupt-funnelmentals' ),
				]
			  );

		$this->end_controls_section();	
		


	}
	
    /* Main UI Area */
	protected function render( ) {

		$settings = $this->get_settings();
		$c_permission = $settings['web_disrupt_funnelmentals_permissions'];
		$c_type = "web_disrupt_funnelmentals_perm_type";
		$c_url = "web_disrupt_funnelmentals_perm_redirect_url";
		$c_url_custom = "web_disrupt_funnelmentals_perm_redirect_url_custom";
		$c_woo_products = 'web_disrupt_funnelmentals_woo_products';
		$c_class = "web_disrupt_funnelmentals_perm_class";
		$c_id = "web_disrupt_funnelmentals_perm_id";
		$c_action = "web_disrupt_funnelmentals_perm_action";
		$c_template = "web_disrupt_funnelmentals_perm_show_template";
		$current_user = wp_get_current_user();	
		$override = false;

		/* check to see if template is used and overide everything else */
		for($i = 0; $i < count($c_permission); $i++){
			if($c_permission[$i][$c_action] == 'Render Elementor Template'){ $override = true; }
		}

		
		// Disable for Elementor Edit Mode
		if(\Elementor\Plugin::$instance->editor->is_edit_mode() != 1 && ! current_user_can('administrator') || $override == true){

			for($i = 0; $i < count($c_permission); $i++){

				/* Fill Empty fields with empty strings */
				if(!isset($c_permission[$i][$c_url])){
					$c_permission[$i][$c_url] = "";
				}
				if($c_permission[$i][$c_url] == "**Custom**"){
					$c_permission[$i][$c_url] = $c_permission[$i][$c_url_custom];
				}
				if(!isset($c_permission[$i][$c_class])){
					$c_permission[$i][$c_class] = "";
				}
				if(!isset($c_permission[$i][$c_id])){
					$c_permission[$i][$c_id] = "";
				}
						

				if($c_permission[$i][$c_type] == "logged out"){

					if ( ! is_user_logged_in() ) {

						$this->fire_the_correct_action($c_permission[$i][$c_action], $c_permission[$i][$c_url], $c_permission[$i][$c_class], $c_permission[$i][$c_id], $c_permission[$i][$c_template], $override);

					}
					
				} else if($c_permission[$i][$c_type] == "logged in"){
					
					if ( is_user_logged_in() ) {

						$this->fire_the_correct_action($c_permission[$i][$c_action], $c_permission[$i][$c_url], $c_permission[$i][$c_class], $c_permission[$i][$c_id], $c_permission[$i][$c_template], $override);

					}
						
				} 
				else if($c_permission[$i][$c_type] == "bought product(s)" || $c_permission[$i][$c_type] == "did not buy product(s)"){

					if ( ! is_user_logged_in() ) {

						/* Do not fire for a logged out user */

					} else {

						/* Loop through multiple bought products */
						if($c_permission[$i][$c_type] == "bought product(s)"){  /* If they Bought it then Trigger Action */

							$check_needs_one = false;
							for($t=0; $t < count($c_permission[$i][$c_woo_products]); $t++){

								if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $c_permission[$i][$c_woo_products][$t] ) ){

									$check_needs_one = true;

								} 

							} /* Loop */

						}

						/* Loop through Multiple product that havent been bought */
						if($c_permission[$i][$c_type] == "did not buy product(s)"){ /* If they didn't Buy it then Trigger Action */

							$check_needs_one = true;
							for($t=0; $t < count($c_permission[$i][$c_woo_products]); $t++){

								if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $c_permission[$i][$c_woo_products][$t] ) ){

									$check_needs_one = false;

								} 

							}/* Loop */

						} 
							
						

						if($check_needs_one == true){

							$this->fire_the_correct_action($c_permission[$i][$c_action], $c_permission[$i][$c_url], $c_permission[$i][$c_class], $c_permission[$i][$c_id], $c_permission[$i][$c_template], $override);

						}

					}

				} // WooCommerce check if bought or did not buy products

			} /* Loop through permission items */

		} /* Dont fire in editor or for admin unless overridden */

	} // Render




	/**
	 * Fire correct action for all cases
	 *
	 * @param [type] $action
	 * @param [type] $url
	 * @param [type] $class
	 * @param [type] $id
	 * @param [type] $template - Template to display
	 * @param [type] $override - Overrides system to only work for template
	 * @return void
	 * 
	 */
	public function fire_the_correct_action($action, $url, $class, $id, $template, $override){

		if($action == 'Redirect Page' && $override == false){

			wp_redirect( $url, 301 );
			exit;

		} else if($action == 'Hide by class' && $override == false){

			?>
			<style> <?php echo ".".$class; ?> { display:none !important; } </style>
			<script>
			jQuery(document).ready( function($) {		
				$('<?php echo ".".$class; ?>').replaceWith("");
			});
			</script><?php

		} else if($action == 'Hide by ID' && $override == false){

			?>
			<style> <?php echo "#".$id; ?> { display:none !important; } </style>
			<script>
			jQuery(document).ready( function($) {		
				$('<?php echo "#".$id; ?>').replaceWith("");
			});
			</script><?php

		} else if($action == 'Render Elementor Template'){
			
			echo '<div class="elementor-shortcode">'.do_shortcode(shortcode_unautop('[elementor-template id="'.$template.'"]')).'</div>';

		}


	}


	/**
	 * Get All WooCommerce products
	 *
	 * @return void
	 */
	public function get_woocommerce_product_list() {

		global $wpdb;
		$full_product_list = $wpdb->get_results("SELECT ID,post_title FROM `" . $wpdb->prefix . "posts` where post_type='product' and post_status = 'publish'");
		
		$final_product_list = array();
		for ($i=0; $i < count($full_product_list); $i++) { 
			$final_product_list[$full_product_list[$i]->ID]  = $full_product_list[$i]->post_title;
		} 

		return $final_product_list; 

	}

	
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Web_Disrupt_Funnelmentals_Permissions() );