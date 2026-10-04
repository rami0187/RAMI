<?php
/**
 * Polylang integration.
 *
 * With Polylang active, Sectors, Projects and Team are translatable post
 * types: create the English post, then add its Arabic translation with the
 * "+" in the Languages box. The theme reads the current language from
 * Polylang, uses its language switcher URLs, and lets Polylang print the
 * <html lang/dir> attributes and hreflang links.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Polylang is running.
 *
 * @return bool
 */
function racc_has_polylang() {
	return function_exists( 'pll_current_language' );
}

/**
 * Make the theme's post types translatable (pre-ticked in Languages → Settings → Custom post types).
 *
 * @param array $types      Post types.
 * @param bool  $is_settings Whether this is the settings screen.
 * @return array
 */
function racc_pll_post_types( $types, $is_settings ) {
	unset( $is_settings );
	$ours = array( 'racc_sector', 'racc_project', 'racc_member' );
	return array_merge( $types, array_combine( $ours, $ours ) );
}
add_filter( 'pll_get_post_types', 'racc_pll_post_types', 10, 2 );

/**
 * Copy the language-neutral fields (sector, icon, year, …) when Polylang
 * creates a translation, so only text needs filling in.
 *
 * @param array $keys Meta keys to copy.
 * @return array
 */
function racc_pll_copy_meta( $keys ) {
	return array_merge( $keys, array( '_racc_key', '_racc_icon', '_racc_sector', '_racc_year', '_racc_email', '_racc_linkedin', '_thumbnail_id' ) );
}
add_filter( 'pll_copy_post_metas', 'racc_pll_copy_meta' );
