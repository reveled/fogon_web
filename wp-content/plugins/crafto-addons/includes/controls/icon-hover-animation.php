<?php
namespace CraftoAddons\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto icon hover animation control.
 *
 * @package Crafto
 */

if ( ! class_exists( 'CraftoAddons\Controls\Icon_Hover_Animation' ) ) {

	/**
	 * Define Icon_Hover_Animation class
	 */
	class Icon_Hover_Animation extends Base_Data_Control {

		/**
		 * Animations.
		 *
		 * Holds all the available hover animation effects of the control.
		 *
		 * @access private
		 * @static
		 *
		 * @var array
		 */
		private static $crafto_animations;

		/**
		 * Get icon hover animation control type.
		 *
		 * Retrieve the control type, in this case `icon-hover-animation`.
		 *
		 * @access public
		 *
		 * @return string Control type.
		 */
		public function get_type() {
			return 'icon-hover-animation';
		}

		/**
		 * Get animations.
		 *
		 * Retrieve the available hover animation effects.
		 *
		 * @access public
		 * @static
		 *
		 * @return array Available hover animation.
		 */
		public static function get_animations() {

			if ( is_null( self::$crafto_animations ) ) {

				self::$crafto_animations = [
					'icon-back'              => esc_html__( 'Icon Back', 'crafto-addons' ),
					'icon-forward'           => esc_html__( 'Icon Forward', 'crafto-addons' ),
					'icon-down'              => esc_html__( 'Icon Down', 'crafto-addons' ),
					'icon-up'                => esc_html__( 'Icon Up', 'crafto-addons' ),
					'icon-spin'              => esc_html__( 'Icon Spin', 'crafto-addons' ),
					'icon-drop'              => esc_html__( 'Icon Drop', 'crafto-addons' ),
					'icon-float-away'        => esc_html__( 'Icon Float Away', 'crafto-addons' ),
					'icon-sink-away'         => esc_html__( 'Icon Sink Away', 'crafto-addons' ),
					'icon-grow'              => esc_html__( 'Icon Grow', 'crafto-addons' ),
					'icon-shrink'            => esc_html__( 'Icon Shrink', 'crafto-addons' ),
					'icon-pulse'             => esc_html__( 'Icon Pulse', 'crafto-addons' ),
					'icon-pulse-grow'        => esc_html__( 'Icon Pulse Grow', 'crafto-addons' ),
					'icon-pulse-shrink'      => esc_html__( 'Icon Pulse Shrink', 'crafto-addons' ),
					'icon-push'              => esc_html__( 'Icon Push', 'crafto-addons' ),
					'icon-pop'               => esc_html__( 'Icon Pop', 'crafto-addons' ),
					'icon-bounce'            => esc_html__( 'Icon Bounce', 'crafto-addons' ),
					'icon-rotate'            => esc_html__( 'Icon Rotate', 'crafto-addons' ),
					'icon-grow-rotate'       => esc_html__( 'Icon Grow Rotate', 'crafto-addons' ),
					'icon-float'             => esc_html__( 'Icon Float', 'crafto-addons' ),
					'icon-sink'              => esc_html__( 'Icon Sink', 'crafto-addons' ),
					'icon-bob'               => esc_html__( 'Icon Bob', 'crafto-addons' ),
					'icon-hang'              => esc_html__( 'Icon Hang', 'crafto-addons' ),
					'icon-wobble-horizontal' => esc_html__( 'Icon Wobble Horizontal', 'crafto-addons' ),
					'icon-wobble-vertical'   => esc_html__( 'Icon Wobble Vertical', 'crafto-addons' ),
					'icon-buzz'              => esc_html__( 'Icon Buzz', 'crafto-addons' ),
					'icon-buzz-out'          => esc_html__( 'Icon Buzz Out', 'crafto-addons' ),
					'icon-sweep-bottom'      => esc_html__( 'Crafto Icon Sweep To Bottom', 'crafto-addons' ),
				];

				$crafto_additional_animations = [];
				/**
				 * Apply filters to load element hover animations list.
				 *
				 * @param array $crafto_additional_animations Additional Animations array.
				 */
				$crafto_additional_animations = apply_filters( 'crafto_icon_hover_animations', $crafto_additional_animations ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				self::$crafto_animations      = array_merge( self::$crafto_animations, $crafto_additional_animations );
			}

			return self::$crafto_animations;
		}

		/**
		 * Render icon hover animation control output in the editor.
		 *
		 * Used to generate the control HTML in the editor using Underscore JS
		 * template. The variables for the class are available using `data` JS
		 * object.
		 *
		 * @access public
		 */
		public function content_template() {
			$control_uid = $this->get_control_uid();
			?>
			<div class="elementor-control-field">
				<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
				<div class="elementor-control-input-wrapper">
					<select id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-select2" type="select2" data-setting="{{ data.name }}">
						<option value=""><?php echo esc_html__( 'None', 'crafto-addons' ); ?></option>
						<?php
						foreach ( self::get_animations() as $animation_name => $animation_title ) :
							?>
							<option value="<?php echo esc_attr( $animation_name ); ?>">
							<?php echo esc_html( $animation_title ); ?>
							</option>
							<?php
						endforeach;
						?>
					</select>
				</div>
			</div>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
			<?php
		}

		/**
		 * Get icon hover animation control default settings.
		 *
		 * Retrieve the default settings of the icon hover animation control. Used to return
		 * the default settings while initializing the icon hover animation control.
		 *
		 * @access protected
		 *
		 * @return array Control default settings.
		 */
		protected function get_default_settings() {
			return [
				'label_block' => true,
			];
		}
	}
}
