<?php
/**
 * Customizer Control: Custom Switch Control
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `WP_Customize_Control` exists.
if ( class_exists( '\WP_Customize_Control' ) ) {
	// If class `Crafto_Customize_Switch_Control` doesn't exists yet.
	if ( ! class_exists( 'Crafto_Customize_Switch_Control' ) ) {

		/**
		 * Define Crafto_Customize_Switch_Control class
		 */
		class Crafto_Customize_Switch_Control extends \WP_Customize_Control {

			/**
			 * Customize control type.
			 *
			 * @var string
			 */
			public $type = 'crafto_switch';

			/**
			 * Renders the control's content.
			 */
			public function render_content() {

				if ( empty( $this->choices ) ) {
					return;
				}

				$name = '_customize-radio-' . $this->id;

				if ( ! empty( $this->label ) ) :
					?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php
				endif;
				if ( ! empty( $this->description ) ) :
					?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
					<?php
				endif;
				?>
				<ul class="crafto-switch-option">
					<?php
					$crafto_switch_class = '';
					foreach ( $this->choices as $value => $label ) :

						$crafto_switch_class  = ( 1 === $value ) ? 'crafto-switch-option switch-option-enable' : 'crafto-switch-option switch-option-disable';
						$crafto_switch_class .= ( (int) $this->value() === $value ) ? ' active' : '';
						?>
						<li class="<?php echo esc_attr( $crafto_switch_class ); ?>">
						<label>
							<?php echo esc_html( $label ); ?>
							<input type="radio" class="display-none" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); // phpcs:ignore ?> />
						</label>
						</li>
						<?php
					endforeach;
					?>
				</ul>
				<?php
			}
		}
	}
}
