<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Web Disrupt Funnelmentals widget.
 *
 * Web Disrupt Funnelmentals widget that displays a floating image and icon into the page.
 *
 * @since 1.0.0
 */
class Widget_Web_Disrupt_Funnelmentals_Floating_Image extends Widget_Base {


	public function get_name() {
		return 'web-disrupt-funnelmentals-floating-image';
	}

	public function get_title() {
		return __( 'Floating Image', 'web-disrupt-funnelmentals' );
	}

	public function get_icon() {
		return 'fa fa-image web-disrupt-funnelmentals-icon';
	}

	public function get_categories() {
		return [ 'web-disrupt-funnelmentals' ];
	}

	public function get_keywords() {
		return [ 'image', 'icon', 'floating', 'animated', 'photo', 'visual' ];
	}

	/**
	 * Register image widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_image_icon',
			[
				'label' => __( 'Image/Icon', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->start_controls_tabs(
			'image_and_icon_tabs'
		);

		$this->start_controls_tab(
			'image_tab',
			[
				'label' => __( 'Image', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'icon_tab',
			[
				'label' => __( 'Icon', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'web-disrupt-funnelmentals' ),
					'stacked' => __( 'Stacked', 'web-disrupt-funnelmentals' ),
					'framed' => __( 'Framed', 'web-disrupt-funnelmentals' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'web-disrupt-funnelmentals' ),
					'square' => __( 'Square', 'web-disrupt-funnelmentals' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'web-disrupt-funnelmentals' ),
					'file' => __( 'Media File', 'web-disrupt-funnelmentals' ),
					'custom' => __( 'Custom URL', 'web-disrupt-funnelmentals' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'web-disrupt-funnelmentals' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => __( 'Lightbox', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'web-disrupt-funnelmentals' ),
					'yes' => __( 'Yes', 'web-disrupt-funnelmentals' ),
					'no' => __( 'No', 'web-disrupt-funnelmentals' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_icon_position',
			[
				'label' => __( 'Position/Orientation', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->add_responsive_control(
			'Position',
			[
				'label' => __( 'Position Type', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'fixed' => [
						'title' => __( 'Fixed', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-lock',
					],
					'absolute' => [
						'title' => __( 'Absolute', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-arrows',
					],
					'relative' => [
						'title' => __( 'Relative', 'web-disrupt-funnelmentals' ),
						'icon' => 'fa fa-clone',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'position: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_left',
			[
				'label' => __( 'Position Left', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%'=>[
						'min' => 0,
						'max' => 100
					],
					'px'=>[
						'min' => -600,
						'max' => 600
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_top',
			[
				'label' => __( 'Position Top', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%'=>[
						'min' => 0,
						'max' => 100
					],
					'px'=>[
						'min' => -600,
						'max' => 600
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_right',
			[
				'label' => __( 'Position Right', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%'=>[
						'min' => 0,
						'max' => 100
					],
					'px'=>[
						'min' => -600,
						'max' => 600
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_bottom',
			[
				'label' => __( 'Position Bottom', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%'=>[
						'min' => 0,
						'max' => 100
					],
					'px'=>[
						'min' => -600,
						'max' => 600
					]
				],
				'selectors' => [
					'{{WRAPPER}}' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_angle',
			[
				'label' => __( 'Rotate', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px'=>[
						'min' => -360,
						'max' => 360
					]
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);
		$this->add_responsive_control(
			'image_depth',
			[
				'label' => __( 'Depth (z-index)', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}' => 'z-index: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'web-disrupt-funnelmentals' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 200,
					],
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => [
					'image' => ['url'=>'','id'=>''],
				],
				'selectors' => [
					'{{WRAPPER}} .wdf-i' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'image!' => ['url'=>'','id'=>''],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => __( 'Max Width', 'web-disrupt-funnelmentals' ) . ' (%)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);


		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-image img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-image img',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_icon_animation',
			[
				'label' => __( 'Animation', 'web-disrupt-funnelmentals' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .elementor-image .wdf-i' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selectors' => [
					'{{WRAPPER}} .elementor-image img',
					'{{WRAPPER}} .elementor-image .wdf-i',
				]
			]
		);
		$this->add_control(
			'animation_type',
			[
				'label' => __( 'Animation', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SELECT2,		
				'options' => [
						'elementor-animation-pulse' => 'Pulse',
						'elementor-animation-pulse-grow' => 'Pulse Grow',
						'elementor-animation-pulse-shrink' => 'Pulse Shrink',
						'elementor-animation-push' => 'Push',
						'elementor-animation-pop' => 'Pop',
						'bounceIn' => 'Bounce In',
						'bounceOut' => 'Bounce Out',
						'flash' => 'Flash',
						'elementor-animation-bob-float' => 'Float',
						'elementor-animation-hang-sink' => 'Sink',
						'elementor-animation-bob' => 'Bob',
						'elementor-animation-hang' => 'Hang',
						'headShake' => 'Head Shake',
						'tada' => 'Tada',
						'rubberBand' => 'Rubber Band',
						'shake' => 'Shake',
						'jello' => 'Jello',
						'bounce' => 'Bounce',
						'zoomIn' => 'Zoom',
						'elementor-animation-wobble-vertical' => 'Wobble Vertical',
						'elementor-animation-wobble-horizontal' => 'Wobble Horizontal',
						'elementor-animation-wobble-to-bottom-right' => 'Wobble To Bottom Right',
						'elementor-animation-wobble-to-top-right' => 'Wobble To Top Right',
						'elementor-animation-wobble-top' => 'Wobble Top',
						'elementor-animation-wobble-bottom' => 'Wobble Bottom',
						'elementor-animation-wobble-skew' => 'Wobble Skew',
						'elementor-animation-buzz' => 'Buzz',
						'elementor-animation-buzz-out' => 'Buzz Out',
				]
			]
			);
			$this->add_control(
				'animation_time',
				[
					'label' => __( 'Animation Duration', 'web-disrupt-funnelmentals' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 0,
					'mix' => 10,	
					'step' => .050	
				]
			);
			$this->add_control(
				'animation_delay_time',
				[
					'label' => __( 'Animation Delay', 'web-disrupt-funnelmentals' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 0,
					'mix' => 10,	
					'step' => .050	
				]
			);
			$this->add_control(
				'animation_motion',
				[
					'label' => __( 'Animation Tween', 'web-disrupt-funnelmentals' ),
					'type' => Controls_Manager::SELECT,
					'options' => [ 
						'ease' => 'Ease',
						'linear' => 'Linear',
						'ease-in' => 'Ease In',
						'ease-out' => 'Ease Out',
						'ease-in-out' => 'Ease In Out' ]
				]
			);
			$this->add_responsive_control(
				'animation_count',
				[
					'label' => __( 'Animation Count', 'web-disrupt-funnelmentals' ),
					'type' => Controls_Manager::TEXT,
					'default' => 'infinite',
					'description'=> 'Can be a number or infinite.'
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'web-disrupt-funnelmentals' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => __( 'Opacity', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image:hover img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .elementor-image:hover .wdf-i' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selectors' => [
					'{{WRAPPER}} .elementor-image:hover img',
					'{{WRAPPER}} .elementor-image:hover .wdf-i',
				]
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image img' => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .elementor-image .wdf-i' => 'transition-duration: {{SIZE}}s'
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'web-disrupt-funnelmentals' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Helper to generate Animation CSS
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	private function anicss($p, $v){
		if(empty($v)) return;
		if(strlen(str_replace("s", "", $v)) > 0)
		{
			return $p.":".$v.";";
		} 
		return '';
	}

	protected function render() {


		$settings = $this->get_settings_for_display();

		$animation_apply = 
		$this->anicss('animation-name', $settings['animation_type']).
		$this->anicss('animation-delay', $settings['animation_delay_time']).
		$this->anicss("animation-duration", $settings['animation_time']."s").
		$this->anicss('animation-timing-function', $settings['animation_motion']).
		$this->anicss("animation-iteration-count", $settings['animation_count']);

		$this_classname = ".elementor-element-".$this->get_id();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-image' );

		if ( ! empty( $settings['shape'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-image-shape-' . $settings['shape'] );
		}

		$link = $this->get_link_url( $settings );
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-wrapper' );
		$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

		if ( $link ) {
			$this->add_render_attribute( 'link', [
				'href' => $link['url'],
				'data-elementor-open-lightbox' => $settings['open_lightbox'],
			] );

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			}

			if ( ! empty( $link['is_external'] ) ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}

			if ( ! empty( $link['nofollow'] ) ) {
				$this->add_render_attribute( 'link', 'rel', 'nofollow' );
			}
		} ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

			<?php if ( $link ) : ?>
					<a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

			<?php
			if( strlen($settings['image']['url']) > 3 ) { ?>
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
			<?php } else { ?>
				<div <?php echo $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
					<i class="<?php echo $settings['icon']; ?> wdf-i"></i>
				</div>
			<?php } ?>

			<?php if ( $link ) : ?>
					</a>
			<?php endif; ?>

		</div>
		<script>
			jQuery(document).ready(function($){
				$('<?php echo $this_classname; ?> img, <?php echo $this_classname; ?> .wdf-i').attr("style", "<?php echo $animation_apply; ?>");
				// TODO repeat delay for a cool Effect of occasionally playing an animation
				// $('<?php // echo $this_classname; ?> img, <?php // echo $this_classname; ?> .wdf-i').removeClass().addClass();
			});
		</script> 
		<?php
	}

	/**
	 * Render image widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			var link_url;

			if ( 'custom' === settings.link_to ) {
				link_url = settings.link.url;
			}

			if ( 'file' === settings.link_to ) {
				link_url = settings.image.url;
			}

			#><div class="elementor-image elementor-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }} elementor-icon-wrapper"><#
			var imgClass = '', imgSyle = '';

			if ( '' !== settings.hover_animation ) {
				imgClass = 'elementor-animation-' + settings.hover_animation;
			}
			if ( '' !== settings.animation_type ) {
				imgSyle = "animation-name: " + settings.animation_type + "; animation-delay: " + settings.animation_delay_time + "s; animation-duration:" + settings.animation_time + "s;animation-timing-function:" + settings.animation_motion + ";animation-iteration-count:" + settings.animation_count;
			}
			if ( link_url ) {
					#><a class="elementor-clickable" data-elementor-open-lightbox="{{ settings.open_lightbox }}" href="{{ link_url }}"><#
			}
			if ( image_url != '' ) {
				#><img src="{{ image_url }}" class="{{ imgClass }}" style="{{ imgSyle }}" /><#
			} else {
				#><div class="elementor-icon">
					 <i class="{{ settings.icon }} wdf-i {{ imgClass }}" style="{{ imgSyle }}"></i>
				  </div><#
			}
			if ( link_url ) {
					#></a><#
			}

			#></div><#
		 #>
		<?php
	}

	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Web_Disrupt_Funnelmentals_Floating_Image() );
