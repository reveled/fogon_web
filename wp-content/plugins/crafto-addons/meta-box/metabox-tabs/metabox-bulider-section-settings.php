<?php
/**
 * Metabox For Builder Page Settings
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_mini_header_sticky_type              = crafto_get_mini_header_sticky_type_by_key();
$crafto_type_of_template_array               = Crafto_Builder_Helper::crafto_get_template_type_by_key();
$crafto_section_sticky_type                  = Crafto_Builder_Helper::crafto_get_header_sticky_type_by_key();
$crafto_template_header_style                = Crafto_Builder_Helper::crafto_get_header_style_by_key();
$crafto_footer_sticky_type                   = Crafto_Builder_Helper::crafto_get_footer_sticky_type_by_key();
$crafto_template_archive_style               = Crafto_Builder_Helper::crafto_get_archive_style_by_key();
$crafto_template_archive_portfolio_style     = Crafto_Builder_Helper::crafto_get_archive_portfolio_style_by_key();
$crafto_template_archive_property_style      = Crafto_Builder_Helper::crafto_get_archive_property_style_by_key();
$crafto_template_archive_tours_style         = Crafto_Builder_Helper::crafto_get_archive_tours_style_by_key();
$crafto_template_specific_post               = Crafto_Builder_Helper::crafto_get_all_posts_list( 'post' );
$crafto_template_specific_exclude_post       = Crafto_Builder_Helper::crafto_get_all_posts_list_exclude( 'post' );
$crafto_template_specific_portfolio          = Crafto_Builder_Helper::crafto_get_all_posts_list( 'portfolio' );
$crafto_template_specific_exclude_portfolio  = Crafto_Builder_Helper::crafto_get_all_posts_list_exclude( 'portfolio' );
$crafto_template_specific_properties         = Crafto_Builder_Helper::crafto_get_all_posts_list( 'properties' );
$crafto_template_specific_exclude_properties = Crafto_Builder_Helper::crafto_get_all_posts_list_exclude( 'properties' );
$crafto_template_specific_tours              = Crafto_Builder_Helper::crafto_get_all_posts_list( 'tours' );
$crafto_template_specific_exclude_tours      = Crafto_Builder_Helper::crafto_get_all_posts_list_exclude( 'tours' );
$crafto_header_display_type                  = Crafto_Builder_Helper::crafto_get_header_display_type_by_key();
$crafto_footer_display_type                  = Crafto_Builder_Helper::crafto_get_footer_display_type_by_key();
$crafto_mini_header_display_type             = Crafto_Builder_Helper::crafto_get_mini_header_display_type_by_key();
$crafto_custom_title_display_type            = Crafto_Builder_Helper::crafto_get_custom_title_display_type_by_key();

if ( \Crafto_Builder_Helper::is_themebuilder_screen() ) {

	$crafto_theme_builder_template = crafto_post_meta_by_id( get_the_ID(), 'crafto_theme_builder_template' );
	if ( ! empty( $crafto_theme_builder_template ) ) {
		$header_class            = ' hidden';
		$footer_class            = ' hidden';
		$archive_class           = ' hidden';
		$archive_portfolio_class = ' hidden';
		$custom_title_class      = ' hidden';
		$promo_popup_class       = ' hidden';
		$side_icon_class         = ' hidden';

		switch ( $crafto_theme_builder_template ) {
			case 'mini-header':
			case 'header':
			default:
				$header_class = '';
				break;
			case 'footer':
				$footer_class = '';
				break;
			case 'archive':
				$archive_class = '';
				break;
			case 'archive-portfolio':
				$archive_portfolio_class = '';
				break;
			case 'custom-title':
				$custom_title_class = '';
				break;
			case 'promo_popup':
				$promo_popup_class = '';
				break;
			case 'side_icon':
				$side_icon_class = '';
				break;
		}
	}
}

/**
 * Section Settings
 */
crafto_meta_box_separator(
	'crafto_theme_builder_template_settings',
	esc_html__( 'General Settings', 'crafto-addons' ),
	''
);

crafto_after_inner_separator_start(
	'separator_main_start',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_theme_builder_template',
	esc_html__( 'Template Type', 'crafto-addons' ),
	$crafto_type_of_template_array,
	esc_html__( 'Choose template type for layout (header, footer, etc.).', 'crafto-addons' ),
	''
);
crafto_meta_box_dropdown(
	'crafto_template_header_style',
	esc_html__( 'Header Style', 'crafto-addons' ),
	$crafto_template_header_style,
	esc_html__( 'Select the style for the your header layout.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_header_sticky_type',
	esc_html__( 'Sticky Type', 'crafto-addons' ),
	$crafto_section_sticky_type,
	esc_html__( 'Choose sticky behavior for the header (fixed, reverse, etc.).', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	],
	[
		'parent-element' => 'crafto_template_header_style',
		'value'          => [
			'standard',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_header_display_type',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_header_display_type,
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_mini_header_sticky_type',
	esc_html__( 'Sticky Type', 'crafto-addons' ),
	$crafto_mini_header_sticky_type,
	esc_html__( 'Choose sticky behavior for the top bar (fixed, reverse, etc.).', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'mini-header',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_mini_header_display_type',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_mini_header_display_type,
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'mini-header',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_footer_sticky_type',
	esc_html__( 'Sticky Type', 'crafto-addons' ),
	$crafto_footer_sticky_type,
	esc_html__( 'Choose sticky behavior for the footer (sticky, overlap, etc.).', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'footer',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_footer_display_type',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_footer_display_type,
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'footer',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_custom_title_display_type',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_custom_title_display_type,
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'custom-title',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_post',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_specific_post,
	esc_html__( 'Select all or specific single posts this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_exclude_post',
	esc_html__( 'Hide On', 'crafto-addons' ),
	$crafto_template_specific_exclude_post,
	esc_html__( 'Select all or specific single posts this template applies exclude to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_portfolio',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_specific_portfolio,
	esc_html__( 'Select all or specific single portfolio this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-portfolio',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_exclude_portfolio',
	esc_html__( 'Hide On', 'crafto-addons' ),
	$crafto_template_specific_exclude_portfolio,
	esc_html__( 'Select all or specific single portfolio this template applies exclude to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-portfolio',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_properties',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_specific_properties,
	esc_html__( 'Select all or specific single properties this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-properties',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_exclude_properties',
	esc_html__( 'Hide On', 'crafto-addons' ),
	$crafto_template_specific_exclude_properties,
	esc_html__( 'Select all or specific single properties this template applies exclude to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-properties',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_tours',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_specific_tours,
	esc_html__( 'Select all or specific single tours this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-tours',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_specific_exclude_tours',
	esc_html__( 'Hide On', 'crafto-addons' ),
	$crafto_template_specific_exclude_tours,
	esc_html__( 'Select all or specific single tours this template applies exclude to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'single-tours',
		],
	]
);

crafto_meta_box_dropdown_multiple(
	'crafto_template_archive_style',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_archive_style,
	esc_html__( 'Select which archive types this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'archive',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_template_archive_portfolio_style',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_archive_portfolio_style,
	esc_html__( 'Select which archive portfolio types this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'archive-portfolio',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_template_archive_property_style',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_archive_property_style,
	esc_html__( 'Select which archive properties types this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'archive-property',
		],
	]
);
crafto_meta_box_dropdown_multiple(
	'crafto_template_archive_tours_style',
	esc_html__( 'Display On', 'crafto-addons' ),
	$crafto_template_archive_tours_style,
	esc_html__( 'Select which archive tours types this template applies to.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'archive-tours',
		],
	]
);

crafto_meta_box_dropdown(
	'crafto_glass_effect',
	esc_html__( 'Glass Effect', 'crafto-addons' ),
	[
		''  => esc_html__( 'Select', 'crafto-addons' ),
		'1' => esc_html__( 'On', 'crafto-addons' ),
		'0' => esc_html__( 'Off', 'crafto-addons' ),
	],
	esc_html__( 'Apply glass effect to the sticky header view.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	],
	[
		'parent-element' => 'crafto_template_header_style',
		'value'          => [
			'standard',
		],
	]
);
crafto_before_inner_separator_end(
	'separator_main_end',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
/**
 * Header Settings
 */
crafto_meta_box_separator(
	'crafto_header_color',
	esc_html__( 'Mobile Navigation', 'crafto-addons' ),
	'',
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_after_inner_separator_start(
	'separator_main_start',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);


// Header Mobile Menu Color.
crafto_meta_box_dropdown(
	'crafto_header_mobile_menu_style',
	esc_html__( 'Menu Style', 'crafto-addons' ),
	[
		'classic'          => esc_html__( 'Classic', 'crafto-addons' ),
		'modern'           => esc_html__( 'Modern', 'crafto-addons' ),
		'full-screen-menu' => esc_html__( 'Full Screen', 'crafto-addons' ),
	],
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_header_mobile_menu_trigger_alignment',
	esc_html__( 'Trigger Alignment', 'crafto-addons' ),
	[
		'left'  => esc_html__( 'Left', 'crafto-addons' ),
		'right' => esc_html__( 'Right', 'crafto-addons' ),
	],
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	],
	[
		'parent-element' => 'crafto_header_mobile_menu_style',
		'value'          => [
			'modern',
		],
	]
);
crafto_meta_box_dropdown(
	'crafto_header_mobile_top_space_style',
	esc_html__( 'Content Top Space', 'crafto-addons' ),
	[
		'1' => esc_html__( 'Yes', 'crafto-addons' ),
		'0' => esc_html__( 'No', 'crafto-addons' ),
	],
	esc_html__( 'Adds top padding equal to header height to prevent content overlap.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);
crafto_meta_box_colorpicker(
	'crafto_header_mobile_menu_navbar_bg_color',
	esc_html__( 'Header Background Color', 'crafto-addons' ),
	esc_html__( 'Set background color for the header on mobile devices.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);

crafto_meta_box_colorpicker(
	'crafto_header_mobile_menu_bg_color',
	esc_html__( 'Menu Background Color', 'crafto-addons' ),
	esc_html__( 'Set background color for the menu on mobile devices.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);

crafto_meta_box_upload(
	'crafto_header_mobile_menu_bg_image',
	esc_html__( 'Menu Background Image', 'crafto-addons' ),
	esc_html__( 'Set background image for the menu on mobile devices.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	],
	[
		'parent-element' => 'crafto_header_mobile_menu_style',
		'value'          => [
			'full-screen-menu',
		],
	]
);
crafto_before_inner_separator_end(
	'separator_end',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'header',
		],
	]
);


/**
 * Popup Settings
 */

crafto_meta_box_dropdown(
	'crafto_display_promo_popup_after',
	esc_html__( 'Show Popup Based on', 'crafto-addons' ),
	[
		''                    => esc_html__( 'Select', 'crafto-addons' ),
		'some-time'           => esc_html__( 'Time Delay', 'crafto-addons' ),
		'user-scroll'         => esc_html__( 'Scroll Position', 'crafto-addons' ),
		'on-page-exit-intent' => esc_html__( 'On Page Exit Intent', 'crafto-addons' ),
	],
	esc_html__( 'Show popup after specified time or scroll action.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'promo_popup',
		],
	]
);
crafto_meta_box_text(
	'crafto_delay_time_promo_popup',
	esc_html__( 'Time Delay', 'crafto-addons' ),
	esc_html__( 'Display popup after a delay (in milliseconds).', 'crafto-addons' ),
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'promo_popup',
		],
	],
	'',
	[
		'parent-element' => 'crafto_display_promo_popup_after',
		'value'          => [
			'some-time',
		],
	],
);
crafto_meta_box_text(
	'crafto_scroll_promo_popup',
	esc_html__( 'Scroll Position', 'crafto-addons' ),
	esc_html__( 'Set scroll distance in pixels to trigger popup.', 'crafto-addons' ),
	'',
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'promo_popup',
		],
	],
	'',
	[
		'parent-element' => 'crafto_display_promo_popup_after',
		'value'          => [
			'user-scroll',
		],
	],
);

crafto_meta_box_dropdown(
	'crafto_enable_mobile_promo_popup',
	esc_html__( 'Display in Mobile', 'crafto-addons' ),
	[
		''  => esc_html__( 'Select', 'crafto-addons' ),
		'0' => esc_html__( 'On', 'crafto-addons' ),
		'1' => esc_html__( 'Off', 'crafto-addons' ),
	],
	esc_html__( 'Enable popup display on mobile devices.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'promo_popup',
		],
	]
);
crafto_meta_box_colorpicker(
	'crafto_promo_popup_bg_color',
	esc_html__( 'Popup Overlay Color', 'crafto-addons' ),
	esc_html__( 'Set overlay color for the popup.', 'crafto-addons' ),
	[
		'element' => 'crafto_theme_builder_template',
		'value'   => [
			'promo_popup',
		],
	]
);

