<?php

/**
 * Plugin Name: Funnelmentals
 * Description: Powerful funnel creation add-ons for the popular page builder Elementor.
 * Plugin URI: https://www.webdisrupt.com/funnelmentals/
 * Version: 1.2.6
 * Author: Web Disrupt
 * Author URI: https://webdisrupt.com
 * Text Domain: web-disrupt-funnelmentals
 * License: GNU General Public License v3.0
 *
*/
namespace Web_Disrupt_Funnelmentals;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly

if ( !class_exists( 'Web_Disrupt_Funnelmentals\\WDF_Core' ) ) {
    class WDF_Core
    {
        /**
         * Creates a single Instance of self
         *
         * @var Static data - Define menu main menu name
         * @since 1.0.0
         */
        private static  $_instance = null ;
        /**
         * Settings plugin details
         *
         * @var Static data - Define all important magic strings
         * @since 1.0.0
         */
        static  $plugin_data = null ;
        /**
         * Define All Actions
         *
         * @var Static data - Define all actions
         * @since 1.0.0
         */
        static  $element_pro_actions = null ;
        /**
         * Creates and returns the main object for this plugin
         *
         *
         * @since  1.0.0
         * @return Web_Disrupt_Funnelmentals
         */
        public static function init()
        {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        /**
         * Main Constructor that sets up all static data associated with this plugin.
         *
         *
         * @since  1.0.0
         *
         */
        private function __construct()
        {
            // Setup static plugin_data
            self::$plugin_data = array(
                "name"        => "Web Disrupt Funnelmentals",
                "slug"        => "web-disrupt-funnelmentals",
                "version"     => "1.2.5",
                "author"      => "Web Disrupt",
                "description" => "Funnelmentals is a very powerful funnel creation add-on for elementor.",
                "logo"        => plugins_url( 'assets/images/logo.png', __FILE__ ),
                "style"       => plugins_url( 'templates/style.css', __FILE__ ),
                "images"      => plugins_url( 'assets/images/', __FILE__ ),
                "resources"   => plugins_url( 'assets/resources/', __FILE__ ),
                "url-author"  => "https://www.webdisrupt.com/",
                "this-root"   => plugins_url( '', __FILE__ ) . "/",
                "this-dir"    => plugin_dir_path( __FILE__ ),
                "this-file"   => __FILE__,
                "settings-id" => "funnelmentals-settings-data",
                "plugin-menu" => "elementor",
            );
            // Init Freemius.
            self::wdf_updater();
            // Signal that SDK was initiated.
            do_action( 'wdf_updater_loaded' );
            /* Frontend Scripts */
            require __DIR__ . '/includes/helper-functions.php';
            /* Freemius */
            add_action( 'wp_ajax_upgrade_funnelmentals', array( $this, 'upgrade_funnelmentals' ) );
            /* WordPress Action Hooks */
            add_action( 'admin_menu', array( $this, 'Register_Settings_Menu' ), 999 );
            add_action( "wp_ajax_save_data_funnelmental_settings", array( $this, 'save_data_funnelmental_settings' ) );
            add_action( "wp_footer", array( $this, "load_funnelmentals_custom_scripts" ) );
            add_action( 'init', array( $this, 'do_output_buffer_catch_late_redirects' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'web_disrupt_funnelmentals_enqueue' ), 20 );
            add_action( "wp_loaded", function () {
                require_once __DIR__ . '/includes/actions.php';
            } );
            /* WordPress Filters */
            add_filter( 'upload_mimes', array( $this, 'wdf_mime_types' ) );
            /* Elementor Action Hooks */
            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_elementor_editor_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_elementor_preview_scripts' ) );
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'web_disrupt_funnelmentals_on_widgets_registered' ) );
            add_action( 'elementor/init', array( $this, 'web_disrupt_funnelmentals_register_widgets' ) );
            add_action( 'elementor/element/section/section_advanced/before_section_end', [ $this, 'add_elementor_page_settings_controls' ] );
            add_action( 'elementor/element/common/section_advanced/before_section_end', [ $this, 'add_elementor_page_settings_controls' ] );
            /* Elementor PRO Action Hooks */
            if ( file_exists( WP_PLUGIN_DIR . "/elementor-pro" ) ) {
            }
        }
        
        //ctor
        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         *
         * @since 1.0.0
         * @return void
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-pro' ), '1.0.0' );
        }
        
        /**
         * Disable unserializing of the class
         *
         * @since 1.0.0
         * @return void
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-pro' ), '1.0.0' );
        }
        
        /**
         * Create a helper function for easy SDK access.
         */
        public function wdf_updater()
        {
            global  $wdf_updater ;
            
            if ( !isset( $wdf_updater ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/includes/wordpress-sdk-master/start.php';
                $wdf_updater = fs_dynamic_init( array(
                    'id'               => '1705',
                    'slug'             => 'web-disrupt-funnelmentals',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_7d61acafce3d2e4069c3233f5e72c',
                    'is_premium'       => false,
                    'is_premium_only'  => false,
                    'has_addons'       => false,
                    'has_paid_plans'   => true,
                    'is_org_compliant' => true,
                    'is_live'          => true,
                ) );
            }
            
            return $wdf_updater;
        }
        
        public function upgrade_funnelmentals()
        {
            echo  self::wdf_updater()->get_upgrade_url() ;
            wp_die();
        }
        
        /**
         * Allow the browser to redirect at anytime during execute with worrying about headers already being sent
         */
        public function do_output_buffer_catch_late_redirects()
        {
            ob_start();
        }
        
        /**
         * Frontend Enqueue Styles + JS
         */
        public function web_disrupt_funnelmentals_enqueue()
        {
            //Frontend Custom CSS
            wp_register_style( 'web-disrupt-funnelmentals-frontend-styles', plugins_url( '/assets/css/frontend.min.css', self::$plugin_data['this-file'] ) );
            wp_enqueue_style( 'web-disrupt-funnelmentals-frontend-styles' );
            //Register JS for elements
            wp_register_script(
                'web_disrupt_funnelmentals_js',
                plugins_url( '/assets/js/funnelmentals.js', self::$plugin_data['this-file'] ),
                [ 'jquery' ],
                '1.0.0',
                true
            );
            wp_enqueue_script( 'web_disrupt_funnelmentals_js' );
            // Register Deprecated JS for elements
            // wp_register_script( 'web_disrupt_funnelmentals_deprecated_js',  plugins_url( '/assets/js/funnelmentals.deprecated.js', self::$plugin_data['this-file'] ), ['jquery'], '1.0.0', true);
            // wp_enqueue_script( 'web_disrupt_funnelmentals_deprecated_js');
        }
        
        /**
         * CSS THAT DISPLAYS ON EDITOR PANEL
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function enqueue_elementor_editor_scripts()
        {
            wp_register_style( 'web-disrupt-funnelmentals-admin-styles', plugins_url( '/assets/css/backend.css', self::$plugin_data['this-file'] ) );
            wp_enqueue_style( 'web-disrupt-funnelmentals-admin-styles' );
            //Disables Pro Templates in Admin Area
            
            if ( !function_exists( 'elementor_pro_load_plugin' ) ) {
                wp_register_style( 'web-disrupt-funnelmentals-admin-hide-pro-templates', plugins_url( '/assets/css/backend-hide-pro-elements.css', self::$plugin_data['this-file'] ) );
                wp_enqueue_style( 'web-disrupt-funnelmentals-admin-hide-pro-templates' );
            }
        
        }
        
        /**
         * CSS THAT DISPLAYS ONLY WHEN EDITOR IS OPEN ON IFRAME
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function enqueue_elementor_preview_scripts()
        {
            wp_register_style( 'web-disrupt-funnelmentals-editor-styles', plugins_url( '/assets/css/editor-preview.css', self::$plugin_data['this-file'] ) );
            wp_enqueue_style( 'web-disrupt-funnelmentals-editor-styles' );
        }
        
        /**
         * Register sub-menu in elementor menu
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function Register_Settings_Menu()
        {
            add_submenu_page(
                self::$plugin_data['plugin-menu'],
                'Funnelmentals Settings',
                '<i class="dashicons-before dashicons-admin-plugins "></i> Funnelmentals',
                'administrator',
                'funnelmentals-settings',
                array( $this, 'Load_Funnelmentals_Settings_Page' )
            );
        }
        
        /**
         * Load settings template
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function Load_Funnelmentals_Settings_Page()
        {
            $db_data = get_option( self::$plugin_data['settings-id'] );
            $data = array(
                'version'          => self::$plugin_data["version"],
                'path'             => self::$plugin_data["this-dir"],
                'logo'             => self::$plugin_data['logo'],
                'style'            => self::$plugin_data['style'],
                'images'           => self::$plugin_data['images'],
                'get_pro_link'     => self::wdf_updater()->get_upgrade_url(),
                'is_free'          => self::wdf_updater()->is_free_plan(),
                'nonce'            => wp_create_nonce( self::$plugin_data['settings-id'] . "_ajax" ),
                'inputs_list'      => array( array(
                "icon"  => "icon-pixel.png",
                "label" => "FB Pixel Tracking Code",
                "id"    => "fb-pixel",
                "value" => self::clean_db_data( $db_data['fb-pixel'] ),
                "style" => "height: 400px;",
            ), array(
                "icon"  => "icon-ga.png",
                "label" => "Google Analytic's Tracking",
                "id"    => "google-analytics",
                "value" => self::clean_db_data( $db_data['google-analytics'] ),
                "style" => "height: 260px;",
            ) ),
                "is-full-checkout" => self::clean_db_data( $db_data['is-full-checkout'] ),
            );
            $this->load_template( 'templates/settings', $data );
        }
        
        /**
         * Save Settings for global use
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function save_data_funnelmental_settings()
        {
            /* Check if is admin */
            if ( !is_admin() ) {
                die;
            }
            if ( !current_user_can( 'administrator' ) ) {
                die;
            }
            // Check the nonce
            $nonce = $_POST['request']['nonce'];
            if ( !wp_verify_nonce( $nonce, self::$plugin_data['settings-id'] . "_ajax" ) ) {
                die;
            }
            // Escape Data
            $_POST['request']['data']['fb-pixel'] = esc_js( $_POST['request']['data']['fb-pixel'] );
            $_POST['request']['data']['google-analytics'] = esc_js( $_POST['request']['data']['google-analytics'] );
            $_POST['request']['data']['is-full-checkout'] = sanitize_text_field( $_POST['request']['data']['is-full-checkout'] );
            // Save
            update_option( self::$plugin_data['settings-id'], $_POST['request']['data'] );
            wp_die();
        }
        
        /**
         * On Widgets Registered
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function web_disrupt_funnelmentals_on_widgets_registered()
        {
            $this->web_disrupt_funnelmentals_includes();
        }
        
        /**
         * Includes
         *
         * @since 1.0.0
         *
         * @access private
         */
        private function web_disrupt_funnelmentals_includes()
        {
            // Elements
            require __DIR__ . '/elements/advanced-button.php';
            require __DIR__ . '/elements/trigger-external-tracking.php';
            require __DIR__ . '/elements/permissions-element.php';
            require __DIR__ . '/elements/floating-image.php';
            /* Premium Only */
        }
        
        /**
         * Register Myme types
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function wdf_mime_types( $mime_types )
        {
            $mime_types['tsv'] = 'text/tab-separated-values';
            return $mime_types;
        }
        
        /**
         * Register Elementor Pro Extensions
         *
         * @since 1.2.3
         *
         * @access public
         */
        public function web_disrupt_funnelmentals_register_pro_extensions()
        {
        }
        
        /**
         * Register Elementor Page Extensions - Hide Empty styles and icons always
         *
         * @since 1.2.4
         *
         * @access public
         */
        public function add_elementor_page_settings_controls( \Elementor\Element_Base $element )
        {
            $element->add_control( 'wdf_global_editor_hide_empty_widgets', [
                'label'        => 'Hide Empty Widgets',
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'none',
                'label_on'     => 'Yes',
                'label_off'    => 'No',
                'default'      => 'No',
                'selectors'    => [
                '{{WRAPPER}} .elementor-element.elementor-widget-empty' => 'background: {{VALUE}}',
                '{{WRAPPER}} .elementor-widget-empty-icon'              => 'display: {{VALUE}}',
            ],
            ] );
        }
        
        /**
         * Register Widget
         *
         * @since 1.0.0
         *
         * @access private
         */
        public function web_disrupt_funnelmentals_register_widgets()
        {
            \Elementor\Plugin::instance()->elements_manager->add_category( 'web-disrupt-funnelmentals', [
                'title' => esc_html__( 'Web Disrupt Funnelmentals', 'web-disrupt-funnelmentals' ),
                'icon'  => 'fa fa-cog',
            ], 1 );
        }
        
        /**
         * Load extra scripts into the footer of every front-end page
         * 
         * @since 1.0.0
         * @access public
         * 
         */
        public function load_funnelmentals_custom_scripts()
        {
            $db_data = get_option( self::$plugin_data['settings-id'] );
            $db_data = $db_data['fb-pixel'] . $db_data['google-analytics'];
            echo  self::clean_db_data( htmlspecialchars_decode( $db_data, ENT_QUOTES ) ) ;
        }
        
        /**
         * Clean database data
         *
         * @since 1.0.0
         * @param [type] $data 
         * @return filtered data
         * 
         */
        public function clean_db_data( $data )
        {
            $data = str_replace( '\\"', '"', $data );
            $data = str_replace( "\\'", "'", $data );
            $data = str_replace( '\\n', PHP_EOL, $data );
            return $data;
        }
        
        /**
         * Loads a PHP Rendered Template
         *
         * The filename is the full path Directory path without the ".php"
         * Use the $data parameter to pass data into each template as needed
         *
         * @since  1.0.0
         * @param  string $name is the template name.
         * @param  array  $data extracted into variables & passed into the template. Must be key value pairs!
         *
         */
        private function load_template( $filename, $data = array() )
        {
            
            if ( isset( $filename ) ) {
                extract( $data );
                require $filename . ".php";
            }
        
        }
    
    }
    // Initialize the Web Disrupt Funnelmentals settings page
    WDF_Core::init();
}

// Make sure class doesn't already exist