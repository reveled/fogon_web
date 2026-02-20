<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;  // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 *
 * Crafto widget for AI Assistant.
 *
 * @package Crafto
 */

// If class `Ai_Assistant` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Ai_Assistant' ) ) {
	/**
	 * Define `Ai_Assistant` class.
	 */
	class Ai_Assistant extends Widget_Base {

		/**
		 * Retrieve the list of scripts the AI Assistant widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if (  \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-ai-assistant-widget' ];
			}
		}

		/**
		 * Retrieve the list of styles the AI Assistant widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$ai_assistant_styles        = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$ai_assistant_styles[] = 'crafto-widgets-rtl';
				} else {
					$ai_assistant_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$ai_assistant_styles[] = 'crafto-ai-assistant-rtl';
				}
				$ai_assistant_styles[] = 'crafto-ai-assistant-widget';
			}
			return $ai_assistant_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve AI Assistant widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-ai-assistant';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve AI Assistant widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto AI Assistant', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve AI Assistant widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-text crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/ai-assistant/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return string Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto',
			];
		}

		/**
		 * Get widget keywords.
		 *
		 * Retrieve the list of keywords the widget belongs to.
		 *
		 * @access public
		 *
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'AI chat',
				'AI bot',
				'chatbot',
				'automated',
				'helper',
				'content',
				'intelligent',
				'smart chat',
				'chatGPT',
				'live chat',
			];
		}

		/**
		 * Register AI Assistant widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_assistant_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_assistant_image',
				[
					'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-assistant.svg' ),
					],
				]
			);

			$this->add_control(
				'crafto_assistant_start_new_chat',
				[
					'label'       => esc_html__( 'New Chat Text', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'New Chat', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_assistant_button_text',
				[
					'label'       => esc_html__( 'Button Text', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Send', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_assistant_placeholder_text',
				[
					'label'       => esc_html__( 'Placeholder', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Type your message ...', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_assistant_image',
				[
					'label' => esc_html__( 'Logo', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_assistant_image_width',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'size_units'     => [
						'px',
						'%',
					],
					'range'          => [
						'%'  => [
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
					'selectors'      => [
						'{{WRAPPER}} .ai-assistant-header img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_assistant_image_space',
				[
					'label'          => esc_html__( 'Max Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'size_units'     => [
						'px',
						'%',
					],
					'range'          => [
						'%'  => [
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
					'selectors'      => [
						'{{WRAPPER}} .ai-assistant-header img' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_assistant_image_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
						'vh' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .ai-assistant-header img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render AI Assistant widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'ai-assistant-wrap',
						],
					],
				],
			);
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="ai-assistant-header">
					<?php
					if ( ! empty( $settings['crafto_assistant_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_assistant_image']['id'] ) ) {
						$settings['crafto_assistant_image']['id'] = '';
					}
					if ( isset( $settings['crafto_assistant_image'] ) && isset( $settings['crafto_assistant_image']['id'] ) && ! empty( $settings['crafto_assistant_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_assistant_image']['id'], $settings['crafto_assistant_image']['url'], '' ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_assistant_image'] ) && isset( $settings['crafto_assistant_image']['url'] ) && ! empty( $settings['crafto_assistant_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_assistant_image']['id'], $settings['crafto_assistant_image']['url'], '' ); // phpcs:ignore
					}
					?>
					<a href="javascript:void(0);" class="chat-form-start-new start-new-hidden"><i class="bi bi-plus"></i><?php echo esc_html( $settings['crafto_assistant_start_new_chat'] ); ?></a>
				</div>
				<div class="ai-assistant-body">
					<div class="chat-result">
						<ul class="chat-list"></ul>
					</div>
					<form id="openai-chat-form" class="openai-chat-form">
						<input name="chat" type="text" class="chat-textbox" placeholder="<?php echo esc_html( $settings['crafto_assistant_placeholder_text'] ); ?>">
						<button id="generate-openai-chat"><?php echo esc_html( $settings['crafto_assistant_button_text'] ); ?></button>
					</form>
				</div>
			</div>
			<?php
		}
	}
}
