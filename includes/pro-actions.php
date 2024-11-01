<?php
namespace Web_Disrupt_Funnelmentals;

class Web_Disrupt_Funnelmental_Actions{

    /**
	 * Main Constructor that sets up all actions
	 *
	 *
	 * @since  1.0.0
	 *
	 */
	public function __construct() {

		// WooCommerce ONE Page Checkout Options
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			/* Filter the right fields out of WooCommerce */
			add_filter( 'woocommerce_checkout_fields' , array($this, 'wdf_woo_override_checkout_customize' ), 9999);
			add_filter( 'woocommerce_billing_fields' , array($this, 'wdf_woo_override_billing_customize' ), 9998);
			add_filter( 'woocommerce_order_button_text', array($this, 'wdf_woo_override_place_order_btn'), 9998);

			// woocommerce_thankyou
			// woocommerce_before_checkout_process woocommerce_cart_is_empty
			add_action('wp', array($this, 'add_product_to_avoid_redirect_to_empty_cart_page'));
			add_action( 'woocommerce_thankyou', array($this, 'so_payment_complete_time_wdf_to_redirect'), 10, 1);
			add_action( "wp_ajax_save_data_funnelmental_dev_checkout_template", array( $this, 'save_data_funnelmental_dev_checkout_template' ));

			// Upsell Pro Ajax calls
			add_action( 'wp_ajax_wdf_toggle_upsell_product', array($this, 'toggle_upsell_product_to_cart'));
			add_action( 'wp_ajax_nopriv_wdf_toggle_upsell_product', array($this, 'toggle_upsell_product_to_cart'));

			// Advanced Button Upsell Pro Feature Ajax calls
			add_action( 'wp_ajax_wdf_add_upsell_then_redirect', array($this, 'add_upsell_then_redirect'));
			add_action( 'wp_ajax_nopriv_wdf_add_upsell_then_redirect', array($this, 'add_upsell_then_redirect'));
		}
	
		// Save checkboxes when changed
		add_action( 'wp_ajax_wdf_toggle_tasker_save', array($this, 'wdf_toggle_tasker_save'));
		add_action( 'wp_ajax_wdf_get_task_completion_pecentage', array($this, 'wdf_get_task_completion_pecentage'));

		// Playlist Pro Ajax calls	
		add_action( 'wp_ajax_wdf_print_playlist_pro', array($this, 'print_playlist'));
		add_action( 'wp_ajax_nopriv_wdf_print_playlist_pro', array($this, 'print_playlist'));

	}
	
	/**
	 * Change Checkout to reset page redirect
	 *
	 * @return void
	 * 
	 */
	public function wdf_woo_override_place_order_btn($btn_text){

		$identifier = $this->get_product_identifier();

		if(get_option($identifier)){
			$text = get_option($identifier);
			$text = $text['place_order_btn'];
			if(strlen($text) > 0){
				$btn_text = $text; 
			}		
		}

		return __( $btn_text , 'woocommerce' );
	}


	/**
	 * Save The Checkout Area for dev
	 *
	 * @return void
	 * 
	 */
	public function save_data_funnelmental_dev_checkout_template(){
		
		update_option($_POST['data']['id'], $_POST['data']['content']);

		wp_die();
		
	}


	/**
	 * Setup the right redirect for WooCommerce based on Checkout pages redirect Cookie
	 *
	 * @param [type] $order_id
	 * 
	 * @return void
	 * 
	 */ 
	public function so_payment_complete_time_wdf_to_redirect( $order_id ){

		/* Get Redirect Link */
		if(isset($_COOKIE['funnelmentals_checkout_redirect'])){
			$redirect_url = $_COOKIE['funnelmentals_checkout_redirect']."?order-id=".$order_id;				
		}
		// Redirect Page 
		if ( $order->status  != 'failed' ) { // If status is good
			wp_redirect($redirect_url, 301);
			exit;
		} 

	}

	/**
	 * Setup the right field scheme for WooCommerce
	 *
	 * @since 1.0.0
	 * @param [type] $fields - Default from WooCommerce
	 * @return void
	 * 
	 */
	public function fetchcookie( $inKey ) { 
		$decode = $_COOKIE[$inKey]; 
		
		for ( $index = 1 ; array_key_exists( $inKey.COOKIE_PORTIONS.$index , $_COOKIE ) ; $index += 1 ) { 
			$decode .= $_COOKIE[$inKey.COOKIE_PORTIONS.$index]; 
		} 
		
		$decode = base64_decode( $decode ); 
		//$decode = gzuncompress( $decode ); 
		
		return unserialize( $decode ); 
	} 
		


	/**
	 * Setup the right field scheme for WooCommerce
	 *
	 * @since 1.0.0
	 * @param [type] $fields - Default from WooCommerce
	 * @return void
	 * 
	 */
	public function wdf_woo_override_checkout_customize( $fields ) {

		$identifier = $this->get_product_identifier();

		/* All Default fields */
		$all_options = array(
			'billing_first_name', 
			'billing_last_name',
			'billing_company', 
			'billing_address_1',
			'billing_address_2',
			'billing_city',
			'billing_postcode',
			'billing_country',
			'billing_state',
			'billing_phone',
			'order_comments',
			'billing_email',
			'shipping_first_name', 
			'shipping_last_name',
			'shipping_company', 
			'shipping_address_1',
			'shipping_address_2',
			'shipping_city',
			'shipping_postcode',
			'shipping_country',
			'shipping_state',
			'shipping_phone',
			'shipping_email'
		);
		$prefix = "web_disrupt_funnelmentals_woofields_";

		// Default - Identifier found
		if(get_option($identifier)){

			$custom_fields = get_option($identifier);
			$custom_fields = $custom_fields['products'];
			$shadow_fields = array();

			// Save shadow temp and remove all fields
			for ($i=0; $i < count($all_options) ; $i++) { 

				$key = $all_options[$i];
				$category = explode("_", $key)[0];
				$shadow_fields[$key] = $fields[$category][$key];
				$shadow_fields[$key]['class'] = array();
				unset($fields[$category][$key]);

			}
			// Add fields back in the right order
			for ($i=0; $i < count($custom_fields) ; $i++) { 

				$name = $custom_fields[$i][$prefix.'name'];
				$required = $custom_fields[$i][$prefix.'required'];
				$label = $custom_fields[$i][$prefix.'label'];
				$category = explode("_", $name)[0];
				$default_label = explode("_", $name);
				$default_label[0] = "";
				$default_label = ucwords(implode(" ", $default_label));

				// Assign New Fields in order & add use data
				$fields[$category][$name] = $shadow_fields[$name];
				$fields[$category][$name]['required'] = $required;

				if($label == ''){

					$fields[$category][$name]['label'] = $default_label;

				} else {

					$fields[$category][$name]['label'] = $label;

				}

			}


		} // Identifier found 
			
		return $fields;
	}


    /**
	 * Setup scheme WooCommerce myAccount - Remove Required Fields to make downloading more easily accessible
	 * 
	 * @since 1.0.0
	 * @param [type] $fields - Default from WooCommerce
	 * @return void
	 * 
	 * 
	 */
	public function wdf_woo_override_billing_customize( $fields ) {

		$all_options = array(
			'billing_first_name', 
			'billing_last_name',
			'billing_company', 
			'billing_address_1',
			'billing_address_2',
			'billing_city',
			'billing_postcode',
			'billing_country',
			'billing_state',
			'billing_phone'
		);
		for ($i=0; $i < count($all_options) ; $i++) { 
			
			$key = $all_options[$i];
			$fields[$key]['required'] = 0;

		}

		return $fields;

	}

    /**
	 * HELPER use page id to retrive unique checkout data
	 * 
	 * @since 1.0.0
	 * @return Identifier
	 * 
	 * 
	 */
	private function get_product_identifier(){

		return "web_disrupt_funnelmentals_".get_the_ID();

	}



    /**
	 * Print Playlist for Playlist Pro
	 * 
	 * @since 1.0.7
	 * @param [type] $data - Data for Playlist
	 * @param [type] $start - Start of Data Block
	 * @param [type] $end - End of Data Block
	 * @param [type] $filters - Keyword
	 * @return void
	 * 
	 * 
	 */
	public function print_playlist(){

		if(isset($_POST['playlist']['data'])){ // Manual input
			$data = json_decode(str_replace("&quot;", '"', $_POST['playlist']['data']), true);
		} else { // File
			$data = $this->tsv_to_array($_POST['playlist']['file'], "\t");
		}
		$start = $_POST['playlist']['start']; 
		$end = $_POST['playlist']['end'];
		$vid_id = $_POST['playlist']['vid'];
		$desc_id = $_POST['playlist']['did'];

		if(strlen($_POST['playlist']['filters']) > 1){
			if(strpos($item['keywords'].$item['description'], " ") !== false){
				$filters = explode(" ", trim($_POST['playlist']['filters']));
			} else {
				$filters[0] = $_POST['playlist']['filters'];
			}

		} else { $filters[0] = " "; }
		$currentCount= 0;
		$isMatched = FALSE;
		$there_is_more = 'no';

		/* Loop through Playlist */
		foreach($data as $item){

			/* Filter out Keywords -> */
			if(strlen($filters[0]) <= 1){
				$isMatched = TRUE;
			} else {
				foreach($filters as $filter){
					if(strpos(strtolower($item['title'].$item['keywords'].htmlspecialchars($item['description']).$item['category']), strtolower($filter)) !== false){
						$isMatched = TRUE;
					}
				}
			}
			/* Filter Out other bad data */
			if(strlen($item['url']) > 0 && $isMatched == TRUE){ // Check URL
				/* Pagging */
				if($currentCount >= $start && $currentCount < $end){
					$video_id = $this->get_youtube_id($item['url']);
					$item['v_id'] = $video_id; 
					$item['thumb'] =  $this->get_youtube_thumb( $video_id );
					?>
					<div class="wdf-va-item" 
						data-target="<?php echo $vid_id ?>" 
						data-target-desc="<?php echo $desc_id; ?>"
						data-description="<?php echo $item['description']; ?>" 
						data-keywords="<?php echo $item['keywords']; ?>"
						data-category="<?php echo $item['category']; ?>"
						data-video="<?php echo $item['v_id']; ?>">
						<?php echo "<div class='wdf-va-title'>".$item['title']."</div>";
							echo "<img src='".$item['thumb']."' style='margin-bottom:-4px;' />";
						?></div>
					<?php
				} 
				else if($currentCount == $end){ /* If more items exists */
					$there_is_more = 'yes';
				}
				$currentCount += 1;// Increase Count / End Paging Filter
			}
			$isMatched = FALSE;

		} /* Loop Items */

		
		echo "<div class='more-items-indicator' data-more='".$there_is_more."'></div>";

		wp_die();

	}

	/**
	 * Checks if URL exists
	 * 
	 * @since 1.0.7
	 * @param [type] $url
	 * @return void
	 */
	protected function url_exists( $url ) {
		$headers = get_headers($url);
		return stripos( $headers[0], "200 OK" ) ? true : false;
	}
	/**
	 * Extracts the YouTube Id from its url
	 * 
	 * @since 1.0.7
	 * @param [type] $url
	 * @return void
	 */
	protected function get_youtube_id( $url ) {
		$youtubeid = explode('v=', $url);
		$youtubeid = explode('&', $youtubeid[1]);
		$youtubeid = $youtubeid[0];
		return $youtubeid;
	}
	/**
	 * Check which browser you are using for compatability
	 * 
	 * @since 1.0.7
	 * @param [type] $user_agent
	 * @return void
	 */
	protected function GetBrowserAgentName($user_agent) {
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
		elseif (strpos($user_agent, 'Edge')) return 'Edge';
		elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
		elseif (strpos($user_agent, 'Safari')) return 'Safari';
		elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
		return 'Other';
	}
	/**
	 * Get thumbnail image for YouTube video
	 *
     * @since 1.0.7
	 * @param [type] $user_agent
	 * @return void
	 */
	protected function get_youtube_thumb( $id ) {
		$BrowserAgentName = $this->GetBrowserAgentName($_SERVER['HTTP_USER_AGENT']);
		If ($BrowserAgentName == 'Chrome' || $BrowserAgentName =='Opera') {
		// webp is supported!
			if ( $this->url_exists( 'https://i.ytimg.com/vi_webp/' .$id . '/maxresdefault.webp' ) ) {
				$image = 'https://i.ytimg.com/vi_webp/' .$id . '/maxresdefault.webp';
			}
			else if ( $this->url_exists( 'https://i.ytimg.com/vi_webp/' .$id . '/mqdefault.webp' ) ) {
				$image = 'https://i.ytimg.com/vi_webp/' .$id . '/mqdefault.webp';
			} 
			else if ( $this->url_exists( 'https://i.ytimg.com/vi/' .$id . '/maxresdefault.jpg' ) ) {
				$image = 'https://i.ytimg.com/vi/' .$id . '/maxresdefault.jpg';
			}
			else if ( $this->url_exists( 'https://i.ytimg.com/vi/' .$id . '/mqdefault.jpg' ) ) {
				$image = 'https://i.ytimg.com/vi/' .$id . '/mqdefault.jpg';
			}
			else {
				$image = false;
			}
		} else {
		// webp is not supported!
			if ( $this->url_exists( 'https://i.ytimg.com/vi/' .$id . '/maxresdefault.jpg' ) ) {
				$image = 'https://i.ytimg.com/vi/' .$id . '/maxresdefault.jpg';
			}
			else if ( $this->url_exists( 'https://i.ytimg.com/vi/' .$id . '/mqdefault.jpg' ) ) {
				$image = 'https://i.ytimg.com/vi/' .$id . '/mqdefault.jpg';
			}
			else {
				$image = false;
			}
		}
		return $image;
	}

	/**
	 * Convert TSV into Array
	 *
     * @since 1.0.7
	 * @param [type] $filename - Name of the file
	 * @param [type] $delimiter - Can be anything
	 * @return void
	 */
	protected function tsv_to_array($filename='', $delimiter=',')
	{
		$filenameExt = explode(".", $filename);
		$filenameExt = $filenameExt[(count($filenameExt)-1)];
		if($filenameExt != "tsv"){
			return false;
		}

		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) != false)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) != false)
			{
				if(!$header){
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}
		return $data;
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

	/**
	 * Adds and removes upsell from woocommerce cart
	 *
	 * @return void
	 */
	public function toggle_upsell_product_to_cart() {
			
		// if no products in cart, add it else remove it
		$cart_contents = WC()->cart->get_cart();	
		if($_POST["is_checked"] == "true"){
			$this->add_product_to_cart_if_not_there($_POST["product_id"], 1);
		} else {
			foreach ($cart_contents as $key => $value) {
				if($value["product_id"] == $_POST["product_id"]){ // Remove correct product
					WC()->cart->remove_cart_item($key);
				}
			}
		}
		echo wc_get_template_html("checkout/review-order.php"); // output pricing template
		wp_die();

	}

	/**
	 * Adds to cart then redirects user
	 *
	 * @return void
	 */
	public function add_upsell_then_redirect(){

		/* Test echo "data: ".$_POST["product_id"]; */
		$this->add_product_to_cart_if_not_there($_POST["product_id"], $_POST["product_quantity"]);
		wp_die();

	}

	/**
	 * Save the checkbox group (Override existing values while keeping all previous values even if not included in this group save)
	 *
	 * @return void
	 */
	public function wdf_toggle_tasker_save(){

		$existingFields = get_user_meta( $_POST["user_id"], $_POST["group_id"], true);
		if($existingFields){
			$newFields = $_POST["data_list"];
			$finalResult = array_merge($existingFields, $newFields);
		} else {
			$finalResult = $_POST["data_list"];
		}
		update_user_meta( $_POST["user_id"], $_POST["group_id"], $finalResult);
		echo "success";
		wp_die();

	}

	/**
	 * Pass in list and return a percentage of completion
	 *
	 * @return percentage
	 */
	public function wdf_get_task_completion_pecentage(){

		$taskGroupSelection = $_POST['selection'];
		$current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;
		$completionAmount = 0;
		$totalAmount = 0;
		for ($i=0; $i < count($taskGroupSelection); $i++) { 
			$tasksGroup = get_user_meta( $current_user_id, 'group-'.md5($current_user_id.'-'.$taskGroupSelection[$i]['wdf_save_name']), true);
			if($tasksGroup){
				foreach ($tasksGroup as $key => $value) {
					if($value == 'true'){
						$completionAmount ++;
					}
					$totalAmount ++;
				}
			}
		}
		echo round(($completionAmount/$totalAmount) * 100);
		wp_die();
	}

	/**
	 * Add product to woocommerce cart and stop redirecting to empty cart
	 *
	 * @return void
	 */
	public function add_product_to_avoid_redirect_to_empty_cart_page(){

		if ( function_exists( 'WC' ) ) {
			if( is_checkout() || is_page('checkout')){
				if ( WC()->cart->get_cart_contents_count() == 0 ) {
					$args = array(
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => '1',
						'orderby' => 'ID',
						'order' => 'ASC',
					);
					$products = get_posts($args);
					WC()->cart->add_to_cart( $products[0]->ID );
					define( 'COOKIEPATH', preg_replace( '|https?://[^/]+|i', '', get_option( 'home' ) . '/' ) );
					setcookie( "funnelmentals_cart_auto_add_product_id", $products[0]->ID, strtotime( '+30 days'), COOKIEPATH, false);			
				} else {
					setcookie( "funnelmentals_cart_auto_add_product_id", -1, strtotime( '+30 days'), COOKIEPATH, false);			
				}
			}
		}
	}

	/**
	 * Add product to woocommerce cart if doesn't exist
	 *
	 * @return void
	 */
	public function add_product_to_cart_if_not_there($product_id, $quantity) {
		
		if ( WC()->cart->get_cart_contents_count() > 0 ) { // Skip to add real quick if empty
			$cart_contents = WC()->cart->get_cart();	
			$cart_item_exists = false;
			/* Check if product is in cart */
			foreach ($cart_contents as $key => $value) {
				if($value["product_id"] == $product_id){ // Remove correct product
					WC()->cart->set_quantity($key, $quantity);
					$cart_item_exists = true;
				}
			}
			/* Add if doesn't exist */
			if($cart_item_exists != true){
				WC()->cart->add_to_cart( $product_id, $quantity);					
			} else {

			}
		} else {
			WC()->cart->add_to_cart( $product_id, $quantity );
		}

	}

}

new Web_Disrupt_Funnelmental_Actions();