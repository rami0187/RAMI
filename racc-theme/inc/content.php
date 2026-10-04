<?php
/**
 * Content getters. Each returns admin-entered posts when there are any,
 * otherwise the brochure defaults, already resolved to the current language.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post meta shortcut.
 *
 * @param int    $id  Post ID.
 * @param string $key Field key.
 * @return string
 */
function racc_meta( $id, $key ) {
	return (string) get_post_meta( $id, '_racc_' . $key, true );
}

/**
 * Split a textarea into non-empty lines.
 *
 * @param string $text Text.
 * @return array
 */
function racc_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\R/u', (string) $text ) ) ) );
}

/**
 * Published posts of a type, ordered by menu order.
 *
 * @param string $type Post type.
 * @param int    $num  Limit.
 * @return WP_Post[]
 */
function racc_posts( $type, $num = -1 ) {
	return get_posts(
		array(
			'post_type'      => $type,
			'posts_per_page' => $num,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'  => true,
		)
	);
}

/**
 * Sectors.
 *
 * @return array[] { key, icon, title, desc, items[] }
 */
function racc_get_sectors() {
	$out   = array();
	$posts = racc_posts( 'racc_sector' );
	if ( $posts ) {
		foreach ( $posts as $p ) {
			$out[] = array(
				'key'   => racc_meta( $p->ID, 'key' ) ? racc_meta( $p->ID, 'key' ) : 'sector-' . $p->ID,
				'icon'  => racc_meta( $p->ID, 'icon' ) ? racc_meta( $p->ID, 'icon' ) : 'building',
				'title' => racc_t( get_the_title( $p ), racc_meta( $p->ID, 'title_ar' ) ),
				'desc'  => racc_t( wp_strip_all_tags( $p->post_content ), racc_meta( $p->ID, 'desc_ar' ) ),
				'items' => racc_is_ar() && racc_meta( $p->ID, 'items_ar' ) ? racc_lines( racc_meta( $p->ID, 'items_ar' ) ) : racc_lines( racc_meta( $p->ID, 'items_en' ) ),
			);
		}
		return $out;
	}
	foreach ( racc_default_sectors() as $s ) {
		$out[] = array(
			'key'   => $s['key'],
			'icon'  => $s['icon'],
			'title' => racc_t( $s['title_en'], $s['title_ar'] ),
			'desc'  => racc_t( $s['desc_en'], $s['desc_ar'] ),
			'items' => racc_is_ar() ? $s['items_ar'] : $s['items_en'],
		);
	}
	return $out;
}

/**
 * Sector key => title map in the current language.
 *
 * @return array
 */
function racc_sector_names() {
	$names = array();
	foreach ( racc_get_sectors() as $s ) {
		$names[ $s['key'] ] = $s['title'];
	}
	// Projects may still reference a built-in key even after sectors are customised.
	foreach ( racc_default_sectors() as $s ) {
		if ( ! isset( $names[ $s['key'] ] ) ) {
			$names[ $s['key'] ] = racc_t( $s['title_en'], $s['title_ar'] );
		}
	}
	return $names;
}

/**
 * Projects.
 *
 * @param int $num Limit.
 * @return array[] { title, sector, location, image, url, excerpt, sample }
 */
function racc_get_projects( $num = 9 ) {
	$out   = array();
	$posts = racc_posts( 'racc_project', $num );
	if ( $posts ) {
		foreach ( $posts as $p ) {
			$out[] = array(
				'title'    => racc_t( get_the_title( $p ), racc_meta( $p->ID, 'title_ar' ) ),
				'sector'   => racc_meta( $p->ID, 'sector' ),
				'location' => racc_t( racc_meta( $p->ID, 'location_en' ), racc_meta( $p->ID, 'location_ar' ) ),
				'image'    => get_the_post_thumbnail_url( $p, 'racc-card' ),
				'url'      => get_permalink( $p ),
				'excerpt'  => racc_t( get_the_excerpt( $p ), racc_meta( $p->ID, 'excerpt_ar' ) ),
				'sample'   => false,
			);
		}
		return $out;
	}
	foreach ( array_slice( racc_default_projects(), 0, $num ) as $d ) {
		$out[] = array(
			'title'    => racc_t( $d['title_en'], $d['title_ar'] ),
			'sector'   => $d['sector'],
			'location' => racc_t( $d['location_en'], $d['location_ar'] ),
			'image'    => $d['image'],
			'url'      => '',
			'excerpt'  => '',
			'sample'   => true,
		);
	}
	return $out;
}

/**
 * Team members.
 *
 * @return array[] { name, role, bio, photo, email, linkedin }
 */
function racc_get_team() {
	$out   = array();
	$posts = racc_posts( 'racc_member' );
	if ( $posts ) {
		foreach ( $posts as $p ) {
			$out[] = array(
				'name'     => racc_t( get_the_title( $p ), racc_meta( $p->ID, 'name_ar' ) ),
				'role'     => racc_t( racc_meta( $p->ID, 'role_en' ), racc_meta( $p->ID, 'role_ar' ) ),
				'bio'      => racc_t( wp_strip_all_tags( $p->post_content ), racc_meta( $p->ID, 'bio_ar' ) ),
				'photo'    => get_the_post_thumbnail_url( $p, 'racc-card' ),
				'email'    => racc_meta( $p->ID, 'email' ),
				'linkedin' => racc_meta( $p->ID, 'linkedin' ),
			);
		}
		return $out;
	}
	foreach ( racc_default_team() as $m ) {
		$out[] = array(
			'name'     => racc_t( $m['name_en'], $m['name_ar'] ),
			'role'     => racc_t( $m['role_en'], $m['role_ar'] ),
			'bio'      => racc_t( $m['bio_en'], $m['bio_ar'] ),
			'photo'    => $m['photo'],
			'email'    => $m['email'],
			'linkedin' => $m['linkedin'],
		);
	}
	return $out;
}

/**
 * Company detail from the Customizer, falling back to the brochure.
 *
 * @param string $key Detail key (phone, email, address, …). Bilingual keys omit the _en/_ar suffix.
 * @return string
 */
function racc_company( $key ) {
	$d = racc_company_defaults();
	if ( isset( $d[ $key . '_en' ] ) ) {
		return racc_mod( 'racc_' . $key, array( 'en' => $d[ $key . '_en' ], 'ar' => $d[ $key . '_ar' ] ) );
	}
	return (string) get_theme_mod( 'racc_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
}

/**
 * Customizer image, falling back to a stock photo.
 *
 * @param string $key      Setting key.
 * @param string $stock_id Stock id key from racc_stock_ids().
 * @param int    $width    Width.
 * @return string
 */
function racc_image( $key, $stock_id, $width = 1600 ) {
	$custom = get_theme_mod( 'racc_img_' . $key );
	if ( $custom ) {
		return $custom;
	}
	$ids = racc_stock_ids();
	return racc_stock( $ids[ $stock_id ], $width );
}

/**
 * Phone number formatted for tel: links.
 *
 * @param string $phone Phone.
 * @return string
 */
function racc_tel( $phone ) {
	return preg_replace( '/[^0-9+]/', '', $phone );
}
