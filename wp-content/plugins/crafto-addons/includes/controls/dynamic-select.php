<?php
namespace CraftoAddons\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dynamic select control.
 *
 * A base control for creating Dynamic_Select control. Displays a select box control
 * based on select on elementor select2 control .
 * It accepts an array in which the `key` is the value and the `value` is the
 * option name. Set `multiple` to `true` to allow multiple value selection.
 *
 * @package Crafto
 *
 * @since 1.0
 */
class Dynamic_Select extends Base_Data_Control {

	const TYPE = 'crafto-dynamic-select';

	/**
	 * Get control type.
	 *
	 * Retrieve the control type.
	 *
	 * @since 5.8.0
	 * @access public
	 */
	public function get_type() {
		return self::TYPE;
	}

	/**
	 * Get select2 control default settings.
	 *
	 * Retrieve the default settings of the select2 control. Used to return the
	 * default settings while initializing the select2 control.
	 *
	 * @return array Control default settings.
	 * @since 5.8.0
	 * @access protected
	 */
	protected function get_default_settings() {
		return [
			'options'        => [],
			'multiple'       => false,
			// Select2 library options.
			'select2options' => [],
			// the lockedOptions array can be passed option keys. The passed option keys will be non-deletable.
			'lockedOptions'  => [],
			// the query arguments array can be passed.
			'query_args'     => array(),

		];
	}

	/**
	 * Render select2 control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 5.8.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-select2" type="select2" {{ multiple }}
						data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
					var value = data.controlValue;
					if ( typeof value == 'string' ) {
					var selected = ( option_value === value ) ? 'selected' : '';
					} else if ( null !== value ) {
					var value = _.values( value );
					var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
					}
					#>
					<option {{ selected }} value="{{ option_value }}">{{{option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Enqueue control scripts and styles.
	 * Used to register and enqueue custom scripts and styles used by the control.
	 *
	 * @access public
	 */
	public function enqueue() {
		$prefix = \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/assets/js/crafto-dynamic-select.min.js' ) ? '.min' : '';

		wp_enqueue_script(
			'crafto-dynamic-select',
			CRAFTO_ADDONS_INCLUDES_URI . '/assets/js/crafto-dynamic-select' . $prefix . '.js',
			[
				'jquery',
			],
			CRAFTO_ADDONS_PLUGIN_VERSION,
			false
		);

		wp_localize_script(
			'crafto-dynamic-select',
			'crafto_dynamic_select',
			[
				'nonce'    => wp_create_nonce( 'crafto_dynamic_select' ),
				'action'   => 'crafto_dynamic_select_input_data',
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			]
		);
	}
}
