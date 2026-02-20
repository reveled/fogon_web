<?php
/**
 * Customizer Import Export settings control
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `WP_Customize_Control` exists.
if ( class_exists( 'WP_Customize_Control' ) ) {

	// If class `Crafto_Customize_Import_Export` doesn't exists yet.
	if ( ! class_exists( 'Crafto_Customize_Import_Export' ) ) {

		/**
		 * Define Import Export class
		 */
		class Crafto_Customize_Import_Export extends WP_Customize_Control {

			/**
			 * Enqueue script
			 */
			public function enqueue() {

				$blank_file_error = esc_html__( 'Please select settings file', 'crafto-addons' );
				$valid_file_error = esc_html__( 'Please select valid file type', 'crafto-addons' );

				wp_enqueue_script(
					'crafto-addons-customizer-import',
					CRAFTO_ADDONS_JS_URI . '/admin/customizer-import-control.js',
					array( 'jquery' ),
					CRAFTO_ADDONS_PLUGIN_VERSION,
					false
				);

				wp_localize_script(
					'crafto-addons-customizer-import',
					'craftoImportExport',
					array(
						'customizeurl'   => admin_url( 'customize.php' ),
						'exportnonce'    => wp_create_nonce( 'crafto-exporting' ),
						'blankFileError' => $blank_file_error,
						'validFileError' => $valid_file_error,
					)
				);
			}

			/**
			 * Renders the control's content.
			 */
			public function render_content() {
				?>
				<div class="export">
					<label>
						<h2 class="customize-control-title">
							<?php echo esc_html__( 'Export', 'crafto-addons' ); ?>
						</h2>
					</label>
					<span class="description customize-control-description">
						<?php echo esc_html__( 'Click below button to export the customization settings.', 'crafto-addons' ); ?>
					</span>
					<input type="button" class="button button-primary" name="crafto-export-button" value="<?php echo esc_attr__( 'Export', 'crafto-addons' ); ?>" />
					</div>
				<div class="import">
					<label>
						<h2 class="customize-control-title">
							<?php echo esc_html__( 'Import', 'crafto-addons' ); ?>
						</h2>
					</label>
					<span class="description customize-control-description">
						<?php echo esc_html__( 'Upload exported file to import customization settings.', 'crafto-addons' ); ?>
					</span>
					<div class="crafto-import-controls">
						<input type="file" name="crafto-import-file" class="crafto-import-file" />
						<?php wp_nonce_field( 'crafto-importing', 'crafto-import' ); ?>
					</div>
					<div class="crafto-uploading display-none"><?php echo esc_html__( 'Importing...', 'crafto-addons' ); ?></div>
					<input type="button" class="button button-primary" name="crafto-import-button" value="<?php echo esc_attr__( 'Import', 'crafto-addons' ); ?>" />
				</div>
				<?php
			}
		}
	}
}
