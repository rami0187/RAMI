<?php
/**
 * Built-in English / Arabic switching.
 *
 * Works with no plugin: the visitor's choice comes from ?lang=en|ar and is kept
 * in a cookie. If Polylang is active, its current language is used instead and
 * its language switcher links replace ours.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const RACC_LANG_COOKIE = 'racc_lang';

/**
 * Current language code: 'en' or 'ar'.
 *
 * @return string
 */
function racc_lang() {
	// Polylang decides the language itself; ask it every time (it is only known once the request is parsed).
	if ( function_exists( 'pll_current_language' ) && pll_current_language( 'slug' ) ) {
		return 'ar' === pll_current_language( 'slug' ) ? 'ar' : 'en';
	}

	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}

	$requested = isset( $_GET['lang'] ) ? sanitize_key( wp_unslash( $_GET['lang'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$cookie    = isset( $_COOKIE[ RACC_LANG_COOKIE ] ) ? sanitize_key( wp_unslash( $_COOKIE[ RACC_LANG_COOKIE ] ) ) : '';

	if ( in_array( $requested, array( 'en', 'ar' ), true ) ) {
		$lang = $requested;
	} elseif ( in_array( $cookie, array( 'en', 'ar' ), true ) ) {
		$lang = $cookie;
	} else {
		$lang = 'ar' === get_theme_mod( 'racc_default_lang', 'en' ) ? 'ar' : 'en';
	}
	return $lang;
}

/**
 * Whether the current language is Arabic.
 *
 * @return bool
 */
function racc_is_ar() {
	return 'ar' === racc_lang();
}

/**
 * Pick the string for the current language. Falls back to English when the
 * Arabic value is empty, and vice versa.
 *
 * @param string $en English.
 * @param string $ar Arabic.
 * @return string
 */
function racc_t( $en, $ar ) {
	if ( racc_is_ar() ) {
		return '' !== (string) $ar ? $ar : $en;
	}
	return '' !== (string) $en ? $en : $ar;
}

/**
 * Echo an escaped translated string.
 *
 * @param string $en English.
 * @param string $ar Arabic.
 */
function racc_e( $en, $ar ) {
	echo esc_html( racc_t( $en, $ar ) );
}

/**
 * Translated theme mod: reads "{$key}_en" or "{$key}_ar".
 *
 * @param string $key     Base setting key.
 * @param array  $default Array( 'en' => ..., 'ar' => ... ).
 * @return string
 */
function racc_mod( $key, $default = array( 'en' => '', 'ar' => '' ) ) {
	$en = get_theme_mod( $key . '_en', $default['en'] );
	$ar = get_theme_mod( $key . '_ar', $default['ar'] );
	return racc_t( $en, $ar );
}

/**
 * Home URL in the current language.
 *
 * @return string
 */
function racc_home_url() {
	if ( function_exists( 'pll_home_url' ) ) {
		return pll_home_url();
	}
	return home_url( '/' );
}

/**
 * Persist an explicit ?lang= choice and switch direction for Arabic.
 */
function racc_lang_init() {
	if ( function_exists( 'pll_current_language' ) ) {
		return;
	}
	if ( isset( $_GET['lang'] ) && ! headers_sent() ) { // phpcs:ignore WordPress.Security.NonceVerification
		$lang = racc_lang();
		setcookie( RACC_LANG_COOKIE, $lang, time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
		$_COOKIE[ RACC_LANG_COOKIE ] = $lang;
	}
}
add_action( 'init', 'racc_lang_init' );

/**
 * Front-end only: flip text direction for Arabic so is_rtl() and core RTL
 * styles behave. Leaves wp-admin untouched.
 */
function racc_lang_direction() {
	if ( is_admin() || function_exists( 'pll_current_language' ) ) {
		return;
	}
	global $wp_locale;
	if ( $wp_locale instanceof WP_Locale ) {
		$wp_locale->text_direction = racc_is_ar() ? 'rtl' : 'ltr';
	}
}
add_action( 'wp', 'racc_lang_direction' );

/**
 * <html lang dir> attributes.
 *
 * @param string $output Default attributes.
 * @return string
 */
function racc_language_attributes( $output ) {
	if ( is_admin() || function_exists( 'pll_current_language' ) ) {
		return $output;
	}
	return racc_is_ar() ? 'lang="ar" dir="rtl"' : 'lang="en" dir="ltr"';
}
add_filter( 'language_attributes', 'racc_language_attributes' );

/**
 * Body classes for language-specific styling.
 *
 * @param array $classes Classes.
 * @return array
 */
function racc_body_lang_class( $classes ) {
	$classes[] = 'lang-' . racc_lang();
	return $classes;
}
add_filter( 'body_class', 'racc_body_lang_class' );

/**
 * URL of the current page in the other language.
 *
 * @param string $lang Target language.
 * @return string
 */
function racc_lang_url( $lang ) {
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages( array( 'raw' => 1 ) );
		if ( is_array( $langs ) && isset( $langs[ $lang ]['url'] ) ) {
			return $langs[ $lang ]['url'];
		}
	}
	$scheme  = is_ssl() ? 'https://' : 'http://';
	$host    = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : wp_parse_url( home_url(), PHP_URL_HOST );
	$uri     = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
	$current = remove_query_arg( array( 'lang', 'sent', 'error' ), $scheme . $host . $uri );
	return add_query_arg( 'lang', $lang, $current );
}

/**
 * Language toggle button (shows the language you can switch to).
 */
function racc_lang_switcher() {
	$target = racc_is_ar() ? 'en' : 'ar';
	$label  = racc_is_ar() ? 'English' : 'العربية';
	printf(
		'<a class="lang-switch" href="%1$s" hreflang="%2$s" lang="%2$s">%3$s<span>%4$s</span></a>',
		esc_url( racc_lang_url( $target ) ),
		esc_attr( $target ),
		racc_icon( 'globe' ), // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
		esc_html( $label )
	);
}

/**
 * hreflang alternates for search engines.
 */
function racc_hreflang() {
	if ( function_exists( 'pll_current_language' ) ) {
		return;
	}
	printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( racc_lang_url( 'en' ) ) );
	printf( '<link rel="alternate" hreflang="ar" href="%s">' . "\n", esc_url( racc_lang_url( 'ar' ) ) );
}
add_action( 'wp_head', 'racc_hreflang' );

/**
 * The page cache must vary by language when the cookie switcher is used.
 */
function racc_vary_header() {
	if ( ! is_admin() && ! function_exists( 'pll_current_language' ) ) {
		header( 'Vary: Cookie', false );
	}
}
add_action( 'send_headers', 'racc_vary_header' );
