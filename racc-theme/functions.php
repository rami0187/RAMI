<?php
/**
 * RACC Engineering Consulting theme bootstrap.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RACC_VERSION', '1.0.0' );
define( 'RACC_DIR', get_template_directory() );
define( 'RACC_URI', get_template_directory_uri() );

require RACC_DIR . '/inc/i18n.php';
require RACC_DIR . '/inc/icons.php';
require RACC_DIR . '/inc/defaults.php';
require RACC_DIR . '/inc/post-types.php';
require RACC_DIR . '/inc/content.php';
require RACC_DIR . '/inc/customizer.php';
require RACC_DIR . '/inc/contact.php';
require RACC_DIR . '/inc/cf7.php';
require RACC_DIR . '/inc/polylang.php';

/**
 * Theme supports and menus.
 */
function racc_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'racc-card', 800, 600, true );
	add_image_size( 'racc-wide', 1920, 1080, true );

	// With Polylang, assign one menu per language to "Primary menu" (Appearance → Menus → Manage locations).
	// Without it, the theme offers a separate Arabic menu location.
	$menus = array( 'primary' => 'Primary menu' );
	if ( ! function_exists( 'pll_current_language' ) ) {
		$menus['primary']    = 'Primary menu (English)';
		$menus['primary_ar'] = 'Primary menu (Arabic)';
	}
	register_nav_menus( $menus );
}
add_action( 'after_setup_theme', 'racc_setup' );

/**
 * Styles and scripts.
 */
function racc_assets() {
	wp_enqueue_style( 'racc-main', RACC_URI . '/assets/css/main.css', array(), RACC_VERSION );
	wp_add_inline_style( 'racc-main', racc_customizer_css() );
	wp_enqueue_script( 'racc-main', RACC_URI . '/assets/js/main.js', array(), RACC_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'racc_assets' );

/**
 * Preload the brand font so headings don't flash.
 */
function racc_preload_fonts() {
	printf( '<link rel="preload" href="%s" as="font" type="font/ttf" crossorigin>' . "\n", esc_url( RACC_URI . '/assets/fonts/rb-bold.ttf' ) );
}
add_action( 'wp_head', 'racc_preload_fonts', 1 );

/**
 * Favicon fallback when no Site Icon is set in the Customizer.
 */
function racc_favicon() {
	if ( has_site_icon() ) {
		return;
	}
	printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( RACC_URI . '/assets/images/favicon.svg' ) );
}
add_action( 'wp_head', 'racc_favicon' );

/**
 * Logo markup. Uses the Custom Logo if one is uploaded, otherwise the bundled brand SVG.
 *
 * @param string $variant 'light' for dark backgrounds, 'dark' for light backgrounds.
 */
function racc_logo( $variant = 'light' ) {
	$file = 'light' === $variant ? 'logo-light.svg' : 'logo-dark.svg';
	$alt  = racc_t( 'RACC Engineering Consulting', 'شركة رموز الفكر للاستشارات الهندسية' );
	printf(
		'<a class="brand" href="%1$s" rel="home"><img src="%2$s" alt="%3$s" width="218" height="107"></a>',
		esc_url( racc_home_url() ),
		esc_url( RACC_URI . '/assets/images/' . $file ),
		esc_attr( $alt )
	);
}

/**
 * Render a front-page section from template-parts/sections.
 *
 * @param string $slug Section slug.
 */
function racc_section( $slug ) {
	if ( ! get_theme_mod( 'racc_show_' . $slug, true ) ) {
		return;
	}
	get_template_part( 'template-parts/sections/' . $slug );
}

/**
 * Image with graceful fallback: if the remote photo fails to load the brand
 * navy/blueprint background behind it shows instead.
 *
 * @param string $src   Image URL.
 * @param string $alt   Alt text.
 * @param string $class Extra class.
 * @param string $sizes sizes attribute.
 * @param bool   $eager Load immediately (for the above-the-fold hero).
 */
function racc_img( $src, $alt = '', $class = '', $sizes = '', $eager = false ) {
	if ( ! $src ) {
		return;
	}
	printf(
		'<img class="%1$s" src="%2$s" alt="%3$s" %5$s decoding="async"%4$s onerror="this.classList.add(\'is-broken\')">',
		esc_attr( trim( 'racc-img ' . $class ) ),
		esc_url( $src ),
		esc_attr( $alt ),
		$sizes ? ' sizes="' . esc_attr( $sizes ) . '"' : '',
		$eager ? 'fetchpriority="high"' : 'loading="lazy"'
	);
}

/**
 * Excerpt length.
 */
add_filter(
	'excerpt_length',
	function () {
		return 28;
	}
);
