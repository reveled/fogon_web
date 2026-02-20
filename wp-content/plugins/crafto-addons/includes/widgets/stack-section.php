<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use CraftoAddons\Classes\Elementor_Templates;

/**
 * Crafto widget for Stack Section.
 *
 * @package Crafto
 */

// If class `Stack Section` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Stack_Section' ) ) {
	/**
	 * Define `Stack Section` class.
	 */
	class Stack_Section extends Widget_Base {
		/**
		 * Retrieve the list of scripts the stack box widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-stack-section' ];
			}
		}

		/**
		 * Retrieve the list of styles the stack box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-stack-section' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve stack section widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-stack-section';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve stack section widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Section Stack Group', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve stack section widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-info-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/section-stack-group/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return array Widget categories.
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
				'overlap',
				'image',
				'stack',
				'fancy',
				'group',
			];
		}

		/**
		 * Register stack section widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_stack_section',
				[
					'label' => esc_html__( 'Stack Content', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_stack_content_type',
				[
					'label'       => esc_html__( 'Content Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'editor',
					'options'     => [
						'template' => esc_html__( 'Template', 'crafto-addons' ),
						'editor'   => esc_html__( 'Editor', 'crafto-addons' ),
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_stack_template_id',
				[
					'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT2,
					'default'     => '0',
					'options'     => Elementor_Templates::get_elementor_templates_options(),
					'condition'   => [
						'crafto_stack_content_type' => 'template',
					],
				]
			);
			$repeater->add_control(
				'crafto_stack_image',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'show_label' => false,
					'type'       => Controls_Manager::MEDIA,
					'dynamic'    => [
						'active' => true,
					],
					'default'    => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition'  => [
						'crafto_stack_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_stack_repeater_data',
				[
					'label'   => esc_html__( 'Stack Items', 'crafto-addons' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => [
						[
							'crafto_stack_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_stack_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_stack_image' => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_stack_section_content_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'crafto_thumbnail',
					'default' => 'full',
					'exclude' => [
						'custom',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render stack section widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings   = $this->get_settings_for_display();
			$countslide = ( isset( $settings['crafto_stack_repeater_data'] ) && $settings['crafto_stack_repeater_data'] ) ? count( $settings['crafto_stack_repeater_data'] ) * 100 . 'vh' : 0;

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						'stack-box',
					],
					'style' => 'height: ' . esc_attr( $countslide ) . ';' // phpcs:ignore
				],
			);
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="stack-box-contain">
				<?php
				if ( isset( $settings['crafto_stack_repeater_data'] ) && ! empty( $settings['crafto_stack_repeater_data'] ) ) {
					foreach ( $settings['crafto_stack_repeater_data'] as $item ) {
						?>
						<div class="stack-item">
							<?php
							if ( 'template' === $item['crafto_stack_content_type'] ) {
								if ( ( '0' !== $item['crafto_stack_template_id'] ) && crafto_post_exists( $item['crafto_stack_template_id'] ) ) {
									$template_content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $item['crafto_stack_template_id'] );
									if ( ! empty( $template_content ) ) {
										if ( Plugin::$instance->editor->is_edit_mode() ) {
											$edit_url = add_query_arg(
												array(
													'elementor' => '',
												),
												get_permalink( $item['crafto_stack_template_id'] )
											);
											echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><a href="' . esc_url( $edit_url ) . '"><i aria-hidden="true" class="eicon-edit"></i></a></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore
										}
										echo sprintf( '%s', $template_content );  // phpcs:ignore
									} else {
										echo sprintf( '%s', no_template_content_message() );  // phpcs:ignore
									}
								} else {
									echo sprintf( '%s',no_template_content_message() );  // phpcs:ignore
								}
							} elseif ( ! empty( $item['crafto_stack_image'] ) ) {
								?>
								<div class="avtar-image">
									<?php $this->get_stack_image( $item ); ?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
				}
				?>
				</div>
			</div>
			<?php
		}

		/**
		 *  Return Stack Image.
		 *
		 * @since 1.0
		 * @param array $item Widget data.
		 * @access public
		 */
		public function get_stack_image( $item ) {
			$has_image = isset( $item['crafto_stack_image'] ) && ! empty( $item['crafto_stack_image'] );
			$settings  = $this->get_settings_for_display();

			if ( ! $has_image && ! empty( $item['crafto_stack_image']['id'] ) ) {
				$has_image = true;
			}

			if ( ! empty( $has_image ) ) {
				if ( ! empty( $item['crafto_stack_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_stack_image']['id'] ) ) {
					$item['crafto_stack_image']['id'] = '';
				}
				if ( isset( $item['crafto_stack_image'] ) && isset( $item['crafto_stack_image']['id'] ) && ! empty( $item['crafto_stack_image']['id'] ) ) {
					crafto_get_attachment_html( $item['crafto_stack_image']['id'], $item['crafto_stack_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
				} elseif ( isset( $item['crafto_stack_image'] ) && isset( $item['crafto_stack_image']['url'] ) && ! empty( $item['crafto_stack_image']['url'] ) ) {
					crafto_get_attachment_html( $item['crafto_stack_image']['id'], $item['crafto_stack_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
				}
			}
		}
	}
}
