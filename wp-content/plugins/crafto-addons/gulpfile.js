// Variables
const { src, dest, watch, parallel } = require('gulp');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const dartSass = require('gulp-dart-sass');
const header = require('gulp-header'); // keep if you use it elsewhere

// Compile widgets styles
function widgetsTask() {
	return src([
		'includes/widgets/assets/css/nav-pagination.css',
		'includes/widgets/assets/css/accordion.css',
		'includes/widgets/assets/css/ai-assistant.css',
		'includes/widgets/assets/css/author.css',
		'includes/widgets/assets/css/back-to-top.css',
		'includes/widgets/assets/css/blog-list.css',
		'includes/widgets/assets/css/blog-slider.css',
		'includes/widgets/assets/css/contact-form.css',
		'includes/widgets/assets/css/content-box.css',
		'includes/widgets/assets/css/client-image-carousel.css',
		'includes/widgets/assets/css/content-carousel.css',
		'includes/widgets/assets/css/countdown-timer.css',
		'includes/widgets/assets/css/counter.css',
		'includes/widgets/assets/css/brand-logo.css',
		'includes/widgets/assets/css/breadcrumb.css',
		'includes/widgets/assets/css/dynamic-slider.css',
		'includes/widgets/assets/css/fancy-text-box.css',
		'includes/widgets/assets/css/feature-box-carousel.css',
		'includes/widgets/assets/css/feature-box.css',
		'includes/widgets/assets/css/flip-box.css',
		'includes/widgets/assets/css/heading.css',
		'includes/widgets/assets/css/horizontal-portfolio.css',
		'includes/widgets/assets/css/icon-box.css',
		'includes/widgets/assets/css/image-carousel.css',
		'includes/widgets/assets/css/image-gallery.css',
		'includes/widgets/assets/css/image.css',
		'includes/widgets/assets/css/instagram.css',
		'includes/widgets/assets/css/interactive-banner.css',
		'includes/widgets/assets/css/interactive-portfolio.css',
		'includes/widgets/assets/css/lists.css',
		'includes/widgets/assets/css/looping-animation.css',
		'includes/widgets/assets/css/lottie.css',
		'includes/widgets/assets/css/marquee-slider.css',
		'includes/widgets/assets/css/media-gallery.css',
		'includes/widgets/assets/css/minimal-portfolio.css',
		'includes/widgets/assets/css/newsletter.css',
		'includes/widgets/assets/css/page-title.css',
		'includes/widgets/assets/css/particle-effect.css',
		'includes/widgets/assets/css/pie-chart.css',
		'includes/widgets/assets/css/popup.css',
		'includes/widgets/assets/css/portfolio-list.css',
		'includes/widgets/assets/css/post-taxonomy.css',
		'includes/widgets/assets/css/price-table.css',
		'includes/widgets/assets/css/process-step.css',
		'includes/widgets/assets/css/product-taxonomy.css',
		'includes/widgets/assets/css/product-list.css',
		'includes/widgets/assets/css/progress-bar.css',
		'includes/widgets/assets/css/product-slider.css',
		'includes/widgets/assets/css/property-list.css',
		'includes/widgets/assets/css/property-gallery-carousel.css',
		'includes/widgets/assets/css/property-meta.css',
		'includes/widgets/assets/css/property-title.css',
		'includes/widgets/assets/css/slider.css',
		'includes/widgets/assets/css/sliding-box.css',
		'includes/widgets/assets/css/social-icons.css',
		'includes/widgets/assets/css/social-share.css',
		'includes/widgets/assets/css/stack-section.css',
		'includes/widgets/assets/css/star-rating.css',
		'includes/widgets/assets/css/table.css',
		'includes/widgets/assets/css/tabs.css',
		'includes/widgets/assets/css/team-member.css',
		'includes/widgets/assets/css/testimonial-carousel.css',
		'includes/widgets/assets/css/testimonial.css',
		'includes/widgets/assets/css/text-slider.css',
		'includes/widgets/assets/css/three-d-parallax-hover.css',
		'includes/widgets/assets/css/tilt-box.css',
		'includes/widgets/assets/css/timeline.css',
		'includes/widgets/assets/css/tour.css',
		'includes/widgets/assets/css/tour-header.css',
		'includes/widgets/assets/css/tour-meta.css',
		'includes/widgets/assets/css/vertical-portfolio.css',
		'includes/widgets/assets/css/video-button.css',
		'includes/widgets/assets/css/video.css',
		'includes/widgets/assets/css/images-comparison.css',
	])
		.pipe(concat('crafto-widgets.min.css'))
		.pipe(dest('includes/widgets/assets'))
}

// Compile widgets rtl styles
function widgetsRtlTask() {
	return src([
		'includes/widgets/assets/css/rtl-css/accordion-rtl.css',
		'includes/widgets/assets/css/rtl-css/ai-assistant-rtl.css',
		'includes/widgets/assets/css/rtl-css/blog-list-rtl.css',
		'includes/widgets/assets/css/rtl-css/blog-slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/brand-logo-rtl.css',
		'includes/widgets/assets/css/rtl-css/contact-form-rtl.css',
		'includes/widgets/assets/css/rtl-css/content-box-rtl.css',
		'includes/widgets/assets/css/rtl-css/content-carousel-rtl.css',
		'includes/widgets/assets/css/rtl-css/countdown-timer-rtl.css',
		'includes/widgets/assets/css/rtl-css/counter-rtl.css',
		'includes/widgets/assets/css/rtl-css/dynamic-slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/fancy-text-box-rtl.css',
		'includes/widgets/assets/css/rtl-css/feature-box-carousel-rtl.css',
		'includes/widgets/assets/css/rtl-css/feature-box-rtl.css',
		'includes/widgets/assets/css/rtl-css/heading-rtl.css',
		'includes/widgets/assets/css/rtl-css/horizontal-portfolio-rtl.css',
		'includes/widgets/assets/css/rtl-css/icon-box-rtl.css',
		'includes/widgets/assets/css/rtl-css/image-carousel-rtl.css',
		'includes/widgets/assets/css/rtl-css/images-comparison-rtl.css',
		'includes/widgets/assets/css/rtl-css/interactive-banner-rtl.css',
		'includes/widgets/assets/css/rtl-css/lists-rtl.css',
		'includes/widgets/assets/css/rtl-css/marquee-slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/minimal-portfolio-rtl.css',
		'includes/widgets/assets/css/rtl-css/nav-pagination-rtl.css',
		'includes/widgets/assets/css/rtl-css/newsletter-rtl.css',
		'includes/widgets/assets/css/rtl-css/page-title-rtl.css',
		'includes/widgets/assets/css/rtl-css/portfolio-list-rtl.css',
		'includes/widgets/assets/css/rtl-css/post-taxonomy-rtl.css',
		'includes/widgets/assets/css/rtl-css/process-step-rtl.css',
		'includes/widgets/assets/css/rtl-css/product-list-rtl.css',
		'includes/widgets/assets/css/rtl-css/product-slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/product-taxonomy-rtl.css',
		'includes/widgets/assets/css/rtl-css/progress-bar-rtl.css',
		'includes/widgets/assets/css/rtl-css/property-list-rtl.css',
		'includes/widgets/assets/css/rtl-css/slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/sliding-box-rtl.css',
		'includes/widgets/assets/css/rtl-css/social-icons-rtl.css',
		'includes/widgets/assets/css/rtl-css/social-share-rtl.css',
		'includes/widgets/assets/css/rtl-css/star-rating-rtl.css',
		'includes/widgets/assets/css/rtl-css/table-rtl.css',
		'includes/widgets/assets/css/rtl-css/tabs-rtl.css',
		'includes/widgets/assets/css/rtl-css/team-member-rtl.css',
		'includes/widgets/assets/css/rtl-css/testimonial-carousel-rtl.css',
		'includes/widgets/assets/css/rtl-css/testimonial-rtl.css',
		'includes/widgets/assets/css/rtl-css/text-slider-rtl.css',
		'includes/widgets/assets/css/rtl-css/tour-header-rtl.css',
		'includes/widgets/assets/css/rtl-css/tour-meta-rtl.css',
		'includes/widgets/assets/css/rtl-css/tour-rtl.css',
		'includes/widgets/assets/css/rtl-css/vertical-portfolio-rtl.css',
		'includes/widgets/assets/css/rtl-css/video-button-rtl.css',
	])
		.pipe(concat('crafto-widgets-rtl.min.css'))
		.pipe(dest('includes/widgets/assets'))
}

// Concat + minify widgets JS
function concatWidgetsJSTask() {
	return src('includes/widgets/assets/js/*.js')
		.pipe(concat('crafto-widgets.min.js'))
		.pipe(terser({ output: { comments: /^!/ } }))
		.pipe(dest('includes/widgets/assets'))
}

// Compile vendors styles
function vendorsCssTask() {
	return src([
		'assets/css/vendors/frontend.css',
		'assets/css/vendors/atropos.css',
		'assets/css/vendors/crafto-side-icon.css',
		'assets/css/vendors/hover-min.css',
		'assets/css/vendors/image-compare-viewer.min.css',
		'assets/css/vendors/jquery.mCustomScrollbar.min.css',
		'assets/css/vendors/justified-gallery.min.css',
		'assets/css/vendors/splitting.css',
		'assets/css/vendors/swiper-bundle.min.css',
	])
	.pipe(concat('crafto-addons-vendors.min.css'))
	.pipe(dest('assets/css/vendors'))
}

// Compile vendors rtl styles
function vendorsRtlCssTask() {
	return src([
		'assets/css/vendors/frontend-rtl.css',
		'assets/css/vendors/crafto-side-icon-rtl.css',
		'assets/css/vendors/grid-style-rtl.css',
	])
	.pipe(concat('crafto-addons-vendors-rtl.min.css'))
	.pipe(dest('assets/css/vendors'))
}

// Compile icons styles
function IconsCssTask() {
	return src([
		'assets/css/vendors/fontawesome.min.css',
		'assets/css/vendors/bootstrap-icons.min.css',
		'assets/css/vendors/et-line-icons.css',
		'assets/css/vendors/feather-icons.css',
		'assets/css/vendors/iconsmind-line.css',
		'assets/css/vendors/iconsmind-solid.css',
		'assets/css/vendors/simple-line-icons.css',
		'assets/css/vendors/themify-icons.css',
	])   
	.pipe(concat('crafto-icons.min.css'))
	.pipe(dest('assets/css/vendors'))
}

// Compile includes/assets/css/editor.css
function editorCssTask() {
	return src([
		'includes/assets/css/editor.css',
	])
	.pipe(concat('editor.min.css'))
	.pipe(cleanCSS({ level: 2 }))
	.pipe(dest('includes/assets/css'))
}

// Compile rtl includes/assets/css/editor.css
function editorRtlCssTask() {
	return src([
		'includes/assets/css/editor-rtl.css',
	])
	.pipe(concat('editor-rtl.min.css'))
	.pipe(cleanCSS({ level: 2 }))
	.pipe(dest('includes/assets/css'))
}

// Compile includes/template-library/assets/css/template-library.css
function templateLibraryCssTask() {
	return src([
		'includes/template-library/assets/css/template-library.css',
	])
	.pipe(concat('template-library.min.css'))
	.pipe(cleanCSS({ level: 2 }))
	.pipe(dest('includes/template-library/assets/css'))
}

// Concat + minify vendors JS
function concatVendorsJSTask() {
	return src([
		'assets/js/vendors/skrollr.js',
		'assets/js/vendors/jquery.appear.js',
		'assets/js/vendors/anime.min.js',
		'assets/js/vendors/splitting.js',
		'assets/js/vendors/editor-animation.js',
		'assets/js/vendors/fancy-text-effect.js',
		'assets/js/vendors/parallaxLiquid.js',
		'assets/js/vendors/floating-animation.js',
		'assets/js/vendors/atropos.js',
		'assets/js/vendors/bootstrap-tab.bundle.min.js',
		'assets/js/vendors/image-compare-viewer.min.js',
		'assets/js/vendors/isotope.pkgd.min.js',
		'assets/js/vendors/infinite-scroll.pkgd.min.js',
		'assets/js/vendors/jquery.countdown.min.js',
		'assets/js/vendors/jquery.fitvids.js',
		'assets/js/vendors/jquery.mCustomScrollbar.concat.min.js',
		'assets/js/vendors/justified-gallery.min.js',
		'assets/js/vendors/lottie.min.js',
		'assets/js/vendors/particles.js',
		'assets/js/vendors/swiper-bundle.min.js',
		'assets/js/vendors/custom-parallax.js',
		'assets/js/vendors/jquery.sticky-kit.min.js',
		'assets/js/vendors/jquery.magnific-popup.min.js',

	])
	.pipe(concat('crafto-addons-vendors.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('assets/js/vendors'))
}

// Minify assets/js/mapstyles.js
function minifyMapstylesJSTask() {
	return src([
		'assets/js/vendors/mapstyles.js',
	])
	.pipe(concat('mapstyles.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('assets/js/vendors'))
}

// Minify includes/assets/js/crafto-dynamic-select.js
function minifyDynamicSelectJSTask() {
	return src([
		'includes/assets/js/crafto-dynamic-select.js',
	])
	.pipe(concat('crafto-dynamic-select.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('includes/assets/js'))
}

// Minify includes/assets/js/editor.js
function minifyEditorJSTask() {
	return src([
		'includes/assets/js/editor.js',
	])
	.pipe(concat('editor.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('includes/assets/js'))
}

// Minify includes/assets/js/frontend.js
function minifyFrontendJSTask() {
	return src([
		'includes/assets/js/frontend.js',
	])
	.pipe(concat('frontend.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('includes/assets/js'))
}

// Minify includes/assets/js/frontend-lite.js.
function minifyFrontendliteJSTask() {
	return src([
		'includes/assets/js/frontend-lite.js',
	])
	.pipe(concat('frontend-lite.min.js'))
	.pipe(terser({ output: { comments: /^!/ } }))
	.pipe(dest('includes/assets/js'))
}

// BrowserSync
function browserSyncTask() {
	browserSync.init({
		watch: true,
		online: true,
		server: {
			baseDir: './'
		}
	});
}

// Watch files
function watchTask() {
	watch('includes/widgets/assets/css/*.css', widgetsTask);
	watch('includes/widgets/assets/css/rtl-css/*.css', widgetsRtlTask);
	watch('includes/widgets/assets/js/*.js', concatWidgetsJSTask);
}

// Default task
exports.default = parallel(
	browserSyncTask,
	vendorsCssTask,
	vendorsRtlCssTask,
	widgetsTask,
	widgetsRtlTask,
	concatWidgetsJSTask,
	concatVendorsJSTask,
	minifyMapstylesJSTask,
	minifyDynamicSelectJSTask,
	minifyEditorJSTask,
	minifyFrontendJSTask,
	minifyFrontendliteJSTask,
	editorCssTask,
	editorRtlCssTask,
	templateLibraryCssTask,
	IconsCssTask,
	watchTask
);
