<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

$flag = false;
if ( class_exists( 'Crafto_Builder_Helper' ) ) {
	if ( \Crafto_Builder_Helper::is_theme_builder_archive_template() ) {
		$flag = true;
	} elseif ( \Crafto_Builder_Helper::is_theme_builder_archive_portfolio_template() ) {
		$flag = true;
	} elseif ( \Crafto_Builder_Helper::is_theme_builder_archive_property_template() ) {
		$flag = true;
	} elseif ( \Crafto_Builder_Helper::is_theme_builder_archive_tours_template() ) {
		$flag = true;
	}
}

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && ! $flag ) {
	return;
}
/**
 * Crafto widget for Archive Description.
 *
 * @package Crafto
 */

// If class `Archive_Description` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Archive_Description' ) ) {
	/**
	 * Define `Archive_Description` class.
	 */
	class Archive_Description extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-archive-description';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Archive Description', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-excerpt crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/archive-description/';
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
				'crafto-archive',
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
				'post',
				'blog',
				'term',
				'description',
				'taxonomy',
				'category',
				'Tag Archive',
			];
		}

		/**
		 * Register archives description widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'archive description is dummy, while the original archive description is retrieved from the relevant category, tags, custom terms, etc...', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_title',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .archive-description',
				]
			);

			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .archive-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render archive description widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			?>
			<div class="archive-description">
				<?php
				if ( crafto_is_editor_mode() ) {
					?>
					<p><?php echo esc_html__( 'Lorem ipsum dolor sit amet. Est quia sunt eos dolor voluptas et enim consequatur. Eum tempore molestias aut culpa dolore ea odio libero.', 'crafto-addons' ); ?></p>
					<?php
				} else {
					the_archive_description( '<p>', '</p>' );
				}
				?>
			</div>
			<?php
		}
	}
}
