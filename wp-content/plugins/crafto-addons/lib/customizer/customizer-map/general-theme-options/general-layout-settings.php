<?php
/**
 * Crafto Export Import option - Customize
 *
 * @package Crafto
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Customizer import export settings */

$wp_customize->add_setting(
	'crafto_import_export_setting',
	array(
		'default' => '',
		'type'    => 'none',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Import_Export(
		$wp_customize,
		'crafto_import_export_setting',
		array(
			'type'     => 'crafto_import_export',
			'section'  => 'crafto_import_export',
			'settings' => 'crafto_import_export_setting',
		)
	)
);

/* Customizer import export settings */
