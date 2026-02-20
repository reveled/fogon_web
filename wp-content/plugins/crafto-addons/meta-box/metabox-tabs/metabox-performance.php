<?php
/**
 * Metabox For Performance.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_disable_module_lists = array(
	'swiper'               => esc_html__( 'Swiper', 'crafto-addons' ),
	'justified-gallery'    => esc_html__( 'Justified Gallery', 'crafto-addons' ),
	'mCustomScrollbar'     => esc_html__( 'mCustomScrollbar', 'crafto-addons' ),
	'magnific-popup'       => esc_html__( 'Magnific Popup', 'crafto-addons' ),
	'atropos'              => esc_html__( 'Atropos', 'crafto-addons' ),
	'magic-cursor'         => esc_html__( 'Magic Cursor', 'crafto-addons' ),
	'hover-animation'      => esc_html__( 'Hover Button Effect', 'crafto-addons' ),
	'bootstrap-icons'      => esc_html__( 'Bootstrap Icons', 'crafto-addons' ),
	'et-line'              => esc_html__( 'Et Line Icons', 'crafto-addons' ),
	'feather'              => esc_html__( 'Feather Icons', 'crafto-addons' ),
	'fontawesome'          => esc_html__( 'Font Awesome Icons', 'crafto-addons' ),
	'iconsmind-line'       => esc_html__( 'Iconsmind Line Icons', 'crafto-addons' ),
	'iconsmind-solid'      => esc_html__( 'Iconsmind Solid Icons', 'crafto-addons' ),
	'simple-line'          => esc_html__( 'Simple Icons', 'crafto-addons' ),
	'themify'              => esc_html__( 'Themify Icons', 'crafto-addons' ),
	'appear'               => esc_html__( 'Appear', 'crafto-addons' ),
	'custom-parallax'      => esc_html__( 'Custom Parallax', 'crafto-addons' ),
	'fitvids'              => esc_html__( 'Fitvids', 'crafto-addons' ),
	'infinite-scroll'      => esc_html__( 'Infinite Scroll', 'crafto-addons' ),
	'isotope'              => esc_html__( 'Isotope', 'crafto-addons' ),
	'imagesloaded'         => esc_html__( 'Images Loaded', 'crafto-addons' ),
	'jquery-countdown'     => esc_html__( 'Countdown', 'crafto-addons' ),
	'skrollr'              => esc_html__( 'Skrollr', 'crafto-addons' ),
	'sticky-kit'           => esc_html__( 'Sticky Kit', 'crafto-addons' ),
	'smooth-scroll'        => esc_html__( 'Smooth Scroll', 'crafto-addons' ),
	'parallax-liquid'      => esc_html__( 'Parallax Liquid', 'crafto-addons' ),
	'particles'            => esc_html__( 'Particles Effect', 'crafto-addons' ),
	'google-map'           => esc_html__( 'Google Map', 'crafto-addons' ),
	'image-compare-viewer' => esc_html__( 'Image Compare Viewer', 'crafto-addons' ),
	'lottie'               => esc_html__( 'Lottie Animation', 'crafto-addons' ),
	'page-scroll'          => esc_html__( 'Page Smooth (on Mousewheel Scroll)', 'crafto-addons' ),
	'grid-style'           => esc_html__( 'Grid Style ( Blog, Portfolio, Product, etc... )', 'crafto-addons' ),
);
crafto_after_main_separator_start(
	'separator_main_start',
	''
);
crafto_meta_box_dropdown_multiple(
	'crafto_disable_module_lists_single',
	esc_html__( 'Disable Modules', 'crafto-addons' ),
	$crafto_disable_module_lists,
	esc_html__( 'Disable modules files from loading if they are not used on the current page or post.', 'crafto-addons' ),
);


/** Is_elementor_activated. */
if ( is_elementor_activated() ) {
	crafto_meta_box_dropdown(
		'crafto_elementor_icons_css_file_single',
		esc_html__( 'Disable Elementor Icons Library', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'Yes', 'crafto-addons' ),
			'0'       => esc_html__( 'No', 'crafto-addons' ),
		),
		esc_html__( 'Disable elementor icons library from loading if elementor icons are not used on the current page or post.', 'crafto-addons' ),
	);

	crafto_meta_box_dropdown(
		'crafto_elementor_dialog_js_library_single',
		esc_html__( 'Disable Elementor Dialog JS', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'Yes', 'crafto-addons' ),
			'0'       => esc_html__( 'No', 'crafto-addons' ),
		),
		esc_html__( 'Disable elementor dialog js file from loading if popup or lightbox are not used on the current page or post.', 'crafto-addons' ),
	);
}

crafto_meta_box_preload(
	'crafto_preload_resources',
	esc_html__( 'Preload Resources', 'crafto-addons' ),
	array(
		'document' => esc_html__( 'Document', 'crafto-addons' ),
		'font'     => esc_html__( 'Font', 'crafto-addons' ),
		'image'    => esc_html__( 'Image', 'crafto-addons' ),
		'script'   => esc_html__( 'Script', 'crafto-addons' ),
		'style'    => esc_html__( 'Style', 'crafto-addons' ),
	),
	esc_html__( 'Specify resources to preload for improved page performance.', 'crafto-addons' )
);

crafto_meta_box_dequeue_scripts(
	'crafto_dequeue_scripts',
	esc_html__( 'Dequeue Styles or Scripts', 'crafto-addons' ),
	esc_html__( 'Enter the unique handles of styles or scripts you wish to prevent from loading on this page/post/custom post types.(e.g., jquery-ui-core). This experiment may cause conflicts.', 'crafto-addons' ),
);

crafto_before_main_separator_end(
	'separator_main_end',
	''
);
