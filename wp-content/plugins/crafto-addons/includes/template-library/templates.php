<?php
/**
 * Template library templates
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script type="text/template" id="template-crafto-templateLibrary-header-logo">
	<img src="<?php echo esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/crafto-collections.svg' ); ?>" alt="<?php echo esc_attr__( 'Crafto Collections', 'crafto-addons' ); ?>"><span class="heading-collection"><?php echo esc_html__( 'crafto', 'crafto-addons' ); ?></span><span class="separator-collection">|</span><span class="subheading-collection"><?php echo esc_html__( 'Collections', 'crafto-addons' ); ?></span>
</script>

<script type="text/template" id="template-crafto-templateLibrary-header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo esc_html__( 'Back to Library', 'crafto-addons' ); ?></span>
</script>

<script type="text/template" id="template-crafto-TemplateLibrary_header-menu">
	<# _.each( tabs, function( args, tab ) { var activeClass = args.active ? 'elementor-active' : ''; #>
		<div class="elementor-component-tab elementor-template-library-menu-item {{activeClass}}" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="template-crafto-templateLibrary-header-actions">
	<div id="crafto-templateLibrary-header-sync" class="elementor-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php echo esc_attr__( 'Sync Library', 'crafto-addons' ); ?>"></i>
		<span class="elementor-screen-only"><?php echo esc_html__( 'Sync Library', 'crafto-addons' ); ?></span>
	</div>
</script>

<script type="text/template" id="template-crafto-templateLibrary-preview">
<iframe></iframe>
</script>

<script type="text/template" id="template-crafto-templateLibrary-header-insert">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ crafto.library.getModal().getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="template-crafto-templateLibrary-insert-button">
	<a class="elementor-template-library-template-action elementor-button crafto-templateLibrary-insert-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php echo esc_html__( 'Insert', 'crafto-addons' ); ?></span>
	</a>
</script>

<script type="text/template" id="template-crafto-templateLibrary-loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div>
		</div>
		<div class="elementor-loading-title"><?php echo esc_html__( 'Loading', 'crafto-addons' ); ?></div>
	</div>
</script>

<script type="text/template" id="template-crafto-templateLibrary-templates">
	<div id="crafto-templateLibrary-toolbar">
		<div id="crafto-templateLibrary-toolbar-filter" class="crafto-templateLibrary-toolbar-filter">
			<# if ( crafto.library.getTypeCategory() ) { #>
				<select id="crafto-templateLibrary-filter-category" class="crafto-templateLibrary-filter-category">
					<option class="crafto-templateLibrary-category-filter-item active" value="" data-tag=""><?php echo esc_html__( 'Filter', 'crafto-addons' ); ?></option>
					<# _.each( crafto.library.getTypeCategory(), function( slug ) { #>
						<option class="crafto-templateLibrary-category-filter-item" value="{{ slug }}" data-tag="{{ slug }}">{{{ crafto.library.getCategory()[slug] }}}</option>
					<# } ); #>
				</select>
			<# } #>
		</div>

		<div id="crafto-templateLibrary-toolbar-search">
			<label for="crafto-templateLibrary-search" class="elementor-screen-only"><?php echo esc_html__( 'Search Templates:', 'crafto-addons' ); ?></label>
			<input id="crafto-templateLibrary-search" placeholder="<?php echo esc_attr__( 'Search', 'crafto-addons' ); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>

	<div class="crafto-templateLibrary-templates-window">
		<div id="crafto-templateLibrary-templates-list"></div>
	</div>
</script>

<script type="text/template" id="template-crafto-templateLibrary-template">
	<div class="crafto-templateLibrary-template-body" id="crafto-template-{{ template_id }}">
		<div class="crafto-templateLibrary-template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
		<# if ( alert ) { #>
			<div class="elementor-template-library-expanded-template">{{{ alert }}}</div>
		<# } #>
		<img class="crafto-templateLibrary-template-thumbnail" src="{{ thumbnail }}">
		<div class="crafto-templateLibrary-template-title">
			<span>{{{ title }}}</span>
		</div>
	</div>
	<div class="crafto-templateLibrary-template-footer">
		{{{ crafto.library.getModal().getTemplateActionButton( obj ) }}}
		<a href="#" class="elementor-button crafto-templateLibrary-preview-button">
			<i class="eicon-device-desktop" aria-hidden="true"></i>
			<?php echo esc_html__( 'Preview', 'crafto-addons' ); ?>
		</a>
	</div>
</script>

<script type="text/template" id="template-crafto-templateLibrary-empty">
	<div class="elementor-template-library-blank-icon">
		<i class="eicon-search-results"></i>
	</div>
	<div class="elementor-template-library-blank-title"></div>
	<div class="elementor-template-library-blank-message"></div>
	<div class="elementor-template-library-blank-footer">
		<?php echo esc_html__( 'Want to learn more about the Crafto Addons?', 'crafto-addons' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="https://crafto.themezaa.com/documentation" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Click here', 'crafto-addons' ); ?></a>
	</div>
</script>
