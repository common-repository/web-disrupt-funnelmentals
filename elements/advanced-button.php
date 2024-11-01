<?php

namespace Elementor;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// If this file is called directly, abort.
class Widget_Web_Disrupt_Funnelmentals_Advanced_Button extends Widget_Base
{
    public function get_name()
    {
        return 'web-disrupt-funnelmentals-advanced-button';
    }
    
    public function get_title()
    {
        return esc_html__( 'WDF - Advanced Button', 'web-disrupt-funnelmentals' );
    }
    
    public function get_icon()
    {
        return 'eicon-button web-disrupt-funnelmentals-icon';
    }
    
    public function get_categories()
    {
        return [ 'web-disrupt-funnelmentals' ];
    }
    
    protected function _register_controls()
    {
        // Get all pages for redirect
        $page_ids = get_all_page_ids();
        $page_list = array();
        foreach ( $page_ids as $id ) {
            $page_list[get_permalink( $id )] = get_the_title( $id ) . " - /" . basename( get_permalink( $id ) );
        }
        $page_list["**Custom**"] = "Custom URL";
        $this->start_controls_section( 'section_title_WDF_global_options', [
            'label' => esc_html__( 'Button Text', 'web-disrupt-funnelmentals' ),
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_text', [
            'label'   => esc_html__( 'Text', 'web-disrupt-funnelmentals' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'Click me', 'web-disrupt-funnelmentals' ),
        ] );
        $advanced_button_action_options = array(
            'Custom Link'      => esc_html__( 'Custom Link', 'web-disrupt-funnelmentals' ),
            'Custom Action(s)' => esc_html__( 'Custom Action(s)', 'web-disrupt-funnelmentals' ),
            'WordPress Logout' => esc_html__( 'WordPress Logout', 'web-disrupt-funnelmentals' ),
        );
        $this->add_control( 'web_disrupt_funnelmentals_btn_action', [
            'label'       => esc_html__( 'Button Action', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => esc_html__( 'Custom Link', 'web-disrupt-funnelmentals' ),
            'options'     => $advanced_button_action_options,
            'label_block' => true,
        ] );
        /* Trigger Custom Events */
        $this->add_control( 'web_disrupt_funnelmentals_btn_action_event', [
            'label'       => __( 'Custom Trigger Events', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::REPEATER,
            'default'     => [ [
            'type' => __( 'ID', 'web-disrupt-funnelmentals' ),
        ] ],
            'fields'      => [
            [
            'name'    => "wdf_bae_type",
            'label'   => __( 'ID or Class', 'web-disrupt-funnelmentals' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'Class',
            'options' => [
            '#' => __( 'ID', 'web-disrupt-funnelmentals' ),
            '.' => __( 'Class', 'web-disrupt-funnelmentals' ),
        ],
        ],
            [
            'name'        => 'wdf_bae_name',
            'label'       => __( 'Class or ID Name', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'label_block' => true,
        ],
            [
            'name'        => 'wdf_bae_trigger',
            'label'       => __( 'Trigger', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => 'Click',
            'label_block' => true,
            'options'     => [
            'click'      => __( 'Click', 'web-disrupt-funnelmentals' ),
            'hover'      => __( 'Hover', 'web-disrupt-funnelmentals' ),
            'mouseenter' => __( 'Hover Enter', 'web-disrupt-funnelmentals' ),
            'mouseleave' => __( 'Hover Exit', 'web-disrupt-funnelmentals' ),
        ],
        ],
            [
            'name'        => 'wdf_bae_event',
            'label'       => __( 'Event Type', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'label_block' => true,
            'options'     => [
            'hide'        => __( 'Hide', 'web-disrupt-funnelmentals' ),
            'show'        => __( 'Show', 'web-disrupt-funnelmentals' ),
            'toggle'      => __( 'Toggle', 'web-disrupt-funnelmentals' ),
            'addClass'    => __( 'Add Class', 'web-disrupt-funnelmentals' ),
            'removeClass' => __( 'Remove Class', 'web-disrupt-funnelmentals' ),
            'toggleClass' => __( 'Toggle Class', 'web-disrupt-funnelmentals' ),
        ],
        ],
            [
            'name'        => 'wdf_bae_class',
            'label'       => __( 'Target Class', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'label_block' => true,
            'condition'   => [
            'wdf_bae_event' => [ 'addClass', 'removeClass', 'toggleClass' ],
        ],
        ]
        ],
            'title_field' => 'If {{{ wdf_bae_trigger }}} then {{{ wdf_bae_event }}} {{{ wdf_bae_class }}} on {{{ wdf_bae_type }}}{{{ wdf_bae_name }}}',
            'label_block' => true,
            'condition'   => [
            'web_disrupt_funnelmentals_btn_action' => 'Custom Action(s)',
        ],
        ] );
        /* Custom url */
        $this->add_control( 'web_disrupt_funnelmentals_btn_url_easy', [
            'label'       => esc_html__( 'Link to Page', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT2,
            'default'     => '',
            'options'     => $page_list,
            'label_block' => true,
            'condition'   => [
            'web_disrupt_funnelmentals_btn_action' => 'Custom Link',
        ],
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_url_advanced', [
            'label'       => esc_html__( 'Link', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::URL,
            'default'     => [
            'url' => '#!',
        ],
            'placeholder' => 'https://webdisrupt.com',
            'label_block' => true,
            'condition'   => [
            'web_disrupt_funnelmentals_btn_action'   => 'Custom Link',
            'web_disrupt_funnelmentals_btn_url_easy' => '**Custom**',
        ],
        ] );
        /* Logout Redirect url */
        $this->add_control( 'web_disrupt_funnelmentals_btn_logout_redirect_easy', [
            'label'       => esc_html__( 'Redirect to Page', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT2,
            'default'     => '',
            'options'     => $page_list,
            'label_block' => true,
            'condition'   => [
            'web_disrupt_funnelmentals_btn_action' => 'WordPress Logout',
            'web_disrupt_funnelmentals_btn_action' => 'Add Product Redirect',
        ],
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_logout_redirect_advanced', [
            'label'       => esc_html__( 'Custom Redirect After Logout', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::URL,
            'default'     => [
            'url' => '#!',
        ],
            'placeholder' => 'https://webdisrupt.com',
            'label_block' => true,
            'condition'   => [
            'web_disrupt_funnelmentals_btn_action'               => 'WordPress Logout',
            'web_disrupt_funnelmentals_btn_logout_redirect_easy' => '**Custom**',
        ],
        ] );
        
        if ( class_exists( '\\Web_Disrupt_Funnelmentals\\Web_Disrupt_Funnelmental_Actions' ) ) {
            $product_list = \Web_Disrupt_Funnelmentals\Web_Disrupt_Funnelmental_Actions::get_woocommerce_product_list();
            $this->add_control( 'web_disrupt_funnelmentals_product_id', [
                'label'       => esc_html__( 'Product ID', 'web-disrupt-funnelmentals' ),
                'type'        => Controls_Manager::SELECT2,
                'description' => "Works with simple products or products with no additional options.",
                'default'     => '',
                'options'     => $product_list,
                'label_block' => true,
                'condition'   => [
                'web_disrupt_funnelmentals_btn_action' => 'Add Product Redirect',
            ],
            ] );
            $this->add_control( 'web_disrupt_funnelmentals_product_quantity', [
                'label'       => esc_html__( 'Product Quantity', 'web-disrupt-funnelmentals' ),
                'type'        => Controls_Manager::NUMBER,
                'description' => "Product Quantity",
                'default'     => 1,
                'label_block' => true,
                'condition'   => [
                'web_disrupt_funnelmentals_btn_action' => 'Add Product Redirect',
            ],
            ] );
        }
        
        $this->add_responsive_control( 'web_disrupt_funnelmentals_btn_align', [
            'label'       => esc_html__( 'Button Align', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options'     => [
            'text-align:left'              => [
            'title' => esc_html__( 'Left', 'web-disrupt-funnelmentals' ),
            'icon'  => 'fa fa-align-left',
        ],
            'text-align:center'            => [
            'title' => esc_html__( 'Center', 'web-disrupt-funnelmentals' ),
            'icon'  => 'fa fa-align-center',
        ],
            'text-align:right'             => [
            'title' => esc_html__( 'Right', 'web-disrupt-funnelmentals' ),
            'icon'  => 'fa fa-align-right',
        ],
            'width:100%;text-align:center' => [
            'title' => __( 'Justified', 'elementor' ),
            'icon'  => 'fa fa-align-justify',
        ],
        ],
            'default'     => 'left',
            'selectors'   => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container'   => '{{VALUE}}',
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container a' => '{{VALUE}}',
        ],
        ] );
        // Clear cart
        $this->add_control( 'web_disrupt_funnelmentals_btn_width_grow', [
            'label'        => __( 'Maximize Button Width', 'web-disrupt-funnelmentals' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'No',
            'label_on'     => __( 'Yes', 'web-disrupt-funnelmentals' ),
            'label_off'    => __( 'No', 'web-disrupt-funnelmentals' ),
            'return_value' => 'width:100%;',
            'selectors'    => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container'   => '{{VALUE}}',
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container a' => '{{VALUE}}',
        ],
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_icon', [
            'label' => esc_html__( 'Icon', 'web-disrupt-funnelmentals' ),
            'type'  => Controls_Manager::ICON,
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_icon_align', [
            'label'     => esc_html__( 'Icon Position', 'web-disrupt-funnelmentals' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'left',
            'options'   => [
            'left'  => esc_html__( 'Before', 'web-disrupt-funnelmentals' ),
            'right' => esc_html__( 'After', 'web-disrupt-funnelmentals' ),
        ],
            'condition' => [
            'web_disrupt_funnelmentals_btn_icon!' => '',
        ],
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_btn_icon_indent', [
            'label'     => esc_html__( 'Icon Spacing', 'web-disrupt-funnelmentals' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 60,
        ],
        ],
            'condition' => [
            'web_disrupt_funnelmentals_btn_icon!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-icon-animate-default i'        => 'width: {{SIZE}}px;',
            '{{WRAPPER}} .web-disrupt-funnelmentals-icon-animate-on-hover:hover i' => 'width: {{SIZE}}px;',
        ],
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_advanced_icon_animation', [
            'label'       => esc_html__( 'Icon Animation', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'web-disrupt-funnelmentals-icon-animate-default',
            'options'     => [
            'web-disrupt-funnelmentals-icon-animate-default'            => esc_html__( 'Always Display Icon', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-icon-animate-on-hover'           => esc_html__( 'Display Icon on Hover', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-icon-animate-replace-from-left'  => esc_html__( 'Replace Text from Left', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-icon-animate-replace-from-right' => esc_html__( 'Replace Text from Right', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-icon-animate-replace-from-top'   => esc_html__( 'Replace Text from Transparency', 'web-disrupt-funnelmentals' ),
        ],
            'condition'   => [
            'web_disrupt_funnelmentals_btn_icon!' => '',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_WDF_button_styles', [
            'label' => esc_html__( 'Button Styles', 'web-disrupt-funnelmentals' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'section_title_WDF_btn_typography',
            'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button',
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_button_text_color', [
            'label'     => esc_html__( 'Text Color', 'web-disrupt-funnelmentals' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'web_disrupt_funnelmentals_btn_background',
            'types'     => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector'  => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-btn-background',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'web_disrupt_funnelmentals_btn_border',
            'separator' => 'before',
            'selector'  => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button',
        ] );
        $this->add_responsive_control( 'section_title_WDF_btn_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'web-disrupt-funnelmentals' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'advanced_button_box_shadow',
            'selector' => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button',
        ] );
        $this->add_responsive_control( 'section_title_WDF_btn_padding', [
            'label'      => esc_html__( 'Padding', 'web-disrupt-funnelmentals' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'separator'  => 'before',
            'selectors'  => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'     => 'btn_text_shadow',
            'selector' => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_WDF_button_animation_styles', [
            'label' => esc_html__( 'Animation Styles', 'web-disrupt-funnelmentals' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_advanced_bg_transition', [
            'label'       => esc_html__( 'Background Transition', 'web-disrupt-funnelmentals' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'web-disrupt-funnelmentals-btn-animate-opacity',
            'options'     => [
            'web-disrupt-funnelmentals-btn-animate-opacity'           => esc_html__( 'Default', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-transparent'       => esc_html__( 'Transparent Background', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-slide-down'        => esc_html__( 'Slide Down', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-slide-up'          => esc_html__( 'Slide Up', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-slide-left'        => esc_html__( 'Slide Left', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-slide-right'       => esc_html__( 'Slide Right', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-center-horizontal' => esc_html__( 'Fill Center Horizontally', 'web-disrupt-funnelmentals' ),
            'web-disrupt-funnelmentals-btn-animate-center-vertical'   => esc_html__( 'Fill Center Vertically', 'web-disrupt-funnelmentals' ),
        ],
        ] );
        $this->add_control( 'hover_animation', [
            'label'     => __( 'Animation', 'elementor' ),
            'separator' => 'before',
            'type'      => Controls_Manager::HOVER_ANIMATION,
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_title_WDF_button_hover_styles', [
            'label' => esc_html__( 'Button Hover Styles', 'web-disrupt-funnelmentals' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_button_hover_text_color', [
            'label'     => esc_html__( 'Hover Color', 'web-disrupt-funnelmentals' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button:hover .web-disrupt-funnelmentals-advanced-btn-text-inline, {{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button:hover i' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'web_disrupt_funnelmentals_btn_hover_background',
            'types'     => [ 'classic', 'gradient' ],
            'separator' => 'before',
            'selector'  => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-btn-background-hover',
        ] );
        $this->add_control( 'web_disrupt_funnelmentals_button_hover_border_color', [
            'label'     => esc_html__( 'Hover Border Color', 'web-disrupt-funnelmentals' ),
            'type'      => Controls_Manager::COLOR,
            'separator' => 'before',
            'selectors' => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'section_title_WDF_btn_hover_border_radius', [
            'label'      => esc_html__( 'Hover Border Radius', 'web-disrupt-funnelmentals' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [
            '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'advanced_button_hover_box_shadow',
            'selector' => '{{WRAPPER}} .web-disrupt-funnelmentals-advanced-button-container .web-disrupt-funnelmentals-advanced-button:hover',
        ] );
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings();
        ?>

	<div class="web-disrupt-funnelmentals-advanced-button-container" style="line-height:0px;">		
		<a href="<?php 
        /* Perform Logout */
        
        if ( $settings['web_disrupt_funnelmentals_btn_action'] == 'WordPress Logout' ) {
            
            if ( $settings["web_disrupt_funnelmentals_btn_logout_redirect_easy"] == "**Custom**" ) {
                echo  wp_logout_url( $settings['web_disrupt_funnelmentals_btn_logout_redirect_advanced']['url'] ) ;
            } else {
                echo  wp_logout_url( $settings['web_disrupt_funnelmentals_btn_logout_redirect_easy'] ) ;
            }
        
        } else {
            
            if ( $settings['web_disrupt_funnelmentals_btn_action'] == 'Custom Link' ) {
                /* Fire Regular Link */
                
                if ( $settings["web_disrupt_funnelmentals_btn_url_easy"] == "**Custom**" ) {
                    echo  esc_url( $settings['web_disrupt_funnelmentals_btn_url_advanced']['url'] ) ;
                } else {
                    echo  esc_url( $settings['web_disrupt_funnelmentals_btn_url_easy'] ) ;
                }
            
            } else {
                echo  "#" ;
            }
        
        }
        
        ?>" style="outline:none;" <?php 
        if ( !empty($settings['web_disrupt_funnelmentals_btn_url_advanced']['is_external']) ) {
            ?>target="_blank"<?php 
        }
        ?> <?php 
        if ( !empty($settings['web_disrupt_funnelmentals_btn_url_advanced']['nofollow']) ) {
            ?>rel="nofollow"<?php 
        }
        ?> class="web-disrupt-funnelmentals-advanced-button elementor-animation-<?php 
        echo  esc_attr( $settings['hover_animation'] ) ;
        ?> <?php 
        echo  esc_attr( $settings['web_disrupt_funnelmentals_advanced_bg_transition'] ) ;
        ?> <?php 
        echo  esc_attr( $settings['web_disrupt_funnelmentals_advanced_icon_animation'] ) ;
        ?>">
			
			<div class="web-disrupt-funnelmentals-advanced-btn-text">

				<?php 
        
        if ( !empty($settings['web_disrupt_funnelmentals_btn_icon']) && $settings['web_disrupt_funnelmentals_btn_icon_align'] == 'left' ) {
            ?>
				
					<i class="<?php 
            echo  esc_attr( $settings['web_disrupt_funnelmentals_btn_icon'] ) ;
            ?> advanced-btn-icon-spacing-icon-left" aria-hidden="true"></i>
				
				<?php 
        }
        
        ?>

				<span class="web-disrupt-funnelmentals-advanced-btn-text-inline"><?php 
        echo  esc_attr( $settings['web_disrupt_funnelmentals_btn_text'] ) ;
        ?></span>

				<?php 
        
        if ( !empty($settings['web_disrupt_funnelmentals_btn_icon']) && $settings['web_disrupt_funnelmentals_btn_icon_align'] == 'right' ) {
            ?>
				
					<i class="<?php 
            echo  esc_attr( $settings['web_disrupt_funnelmentals_btn_icon'] ) ;
            ?> advanced-btn-icon-spacing-icon-right" aria-hidden="true"></i>

				<?php 
        }
        
        ?>
				
			</div>
			
			<span class="web-disrupt-funnelmentals-advanced-btn-background"></span>

			<span class="web-disrupt-funnelmentals-advanced-btn-background-hover"></span>

		</a>
	</div>
	<script>
		jQuery(document).ready( function($) {
		<?php 
        
        if ( $settings['web_disrupt_funnelmentals_btn_action'] == 'Custom Action(s)' ) {
            /* Make sure its a custom action */
            $special_events = $settings['web_disrupt_funnelmentals_btn_action_event'];
            for ( $i = 0 ;  $i < count( $special_events ) ;  $i++ ) {
                /* Use target class if needed */
                $selector = $special_events[$i]['wdf_bae_type'] . $special_events[$i]['wdf_bae_name'];
                
                if ( $special_events[$i]['wdf_bae_event'] == "addClass" || $special_events[$i]['wdf_bae_event'] == "removeClass" || $special_events[$i]['wdf_bae_event'] == "toggleClass" ) {
                    $target_class = "'" . $special_events[$i]['wdf_bae_class'] . "'";
                } else {
                    $target_class = "";
                }
                
                $triggerSelector = ".elementor-element-" . $this->get_id();
                echo  "\$('" . $triggerSelector . "')." . $special_events[$i]['wdf_bae_trigger'] . "( function(e){ e.preventDefault();  \$('" . $selector . "')." . $special_events[$i]['wdf_bae_event'] . "(" . $target_class . "); \$('" . $triggerSelector . " a').blur(); }); " ;
            }
        } else {
            if ( $settings['web_disrupt_funnelmentals_btn_action'] == 'Add Product Redirect' ) {
                
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() != 1 ) {
                    
                    if ( $settings["web_disrupt_funnelmentals_btn_logout_redirect_easy"] == "**Custom**" ) {
                        $location_redirect = $settings['web_disrupt_funnelmentals_btn_logout_redirect_advanced']['url'];
                    } else {
                        $location_redirect = $settings['web_disrupt_funnelmentals_btn_logout_redirect_easy'];
                    }
                    
                    $triggerSelector = ".elementor-element-" . $this->get_id();
                    echo  "var ajaxurl = '" . admin_url( 'admin-ajax.php' ) . "';" . "\$('" . $triggerSelector . "').click(function(e){" . "e.preventDefault();" . "\$.post(ajaxurl, { action : 'wdf_add_upsell_then_redirect', product_id: '" . $settings['web_disrupt_funnelmentals_product_id'] . "', product_quantity: '" . $settings['web_disrupt_funnelmentals_product_quantity'] . "' }, function(data){ window.location = '" . $location_redirect . "'; });" . "});" ;
                }
            
            }
        }
        
        ?>
		});
	</script>
	<?php 
    }

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Web_Disrupt_Funnelmentals_Advanced_Button() );