<?php
/**
 * Sectors, Projects and Team post types, each with English + Arabic fields.
 *
 * The post title / content hold the English version; the "Arabic" box below
 * the editor holds the Arabic version.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register post types.
 */
function racc_register_post_types() {
	register_post_type(
		'racc_sector',
		array(
			'labels'       => array(
				'name'          => 'Sectors & Services',
				'singular_name' => 'Sector',
				'add_new_item'  => 'Add sector',
				'edit_item'     => 'Edit sector',
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-hammer',
			'menu_position' => 21,
			'supports'     => array( 'title', 'editor', 'page-attributes' ),
		)
	);

	register_post_type(
		'racc_project',
		array(
			'labels'        => array(
				'name'          => 'Projects',
				'singular_name' => 'Project',
				'add_new_item'  => 'Add project',
				'edit_item'     => 'Edit project',
			),
			'public'        => true,
			'has_archive'   => 'projects',
			'rewrite'       => array( 'slug' => 'projects' ),
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-building',
			'menu_position' => 22,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		)
	);

	register_post_type(
		'racc_member',
		array(
			'labels'        => array(
				'name'          => 'Team',
				'singular_name' => 'Team member',
				'add_new_item'  => 'Add team member',
				'edit_item'     => 'Edit team member',
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 23,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'racc_register_post_types' );

/**
 * Field definitions per post type.
 *
 * @return array
 */
function racc_meta_fields() {
	$sector_choices = array();
	foreach ( racc_default_sectors() as $s ) {
		$sector_choices[ $s['key'] ] = $s['title_en'];
	}

	return array(
		'racc_sector'  => array(
			'title_ar' => array( 'label' => 'Title (Arabic)', 'type' => 'text', 'rtl' => true ),
			'desc_ar'  => array( 'label' => 'Description (Arabic)', 'type' => 'textarea', 'rtl' => true ),
			'items_en' => array( 'label' => function_exists( 'pll_current_language' ) ? 'Services list — one per line' : 'Services list (English) — one per line', 'type' => 'textarea' ),
			'items_ar' => array( 'label' => 'Services list (Arabic) — one per line', 'type' => 'textarea', 'rtl' => true ),
			'key'      => array( 'label' => 'Filter key (used by Projects)', 'type' => 'select', 'choices' => $sector_choices ),
			'icon'     => array( 'label' => 'Icon', 'type' => 'select', 'choices' => racc_icon_choices() ),
		),
		'racc_project' => array(
			'title_ar'    => array( 'label' => 'Title (Arabic)', 'type' => 'text', 'rtl' => true ),
			'excerpt_ar'  => array( 'label' => 'Short summary (Arabic)', 'type' => 'textarea', 'rtl' => true ),
			'content_ar'  => array( 'label' => 'Full description (Arabic)', 'type' => 'textarea', 'rtl' => true, 'rows' => 8 ),
			'sector'      => array( 'label' => 'Sector', 'type' => 'select', 'choices' => $sector_choices ),
			'location_en' => array( 'label' => function_exists( 'pll_current_language' ) ? 'Location' : 'Location (English)', 'type' => 'text' ),
			'location_ar' => array( 'label' => 'Location (Arabic)', 'type' => 'text', 'rtl' => true ),
			'client_en'   => array( 'label' => function_exists( 'pll_current_language' ) ? 'Client' : 'Client (English)', 'type' => 'text' ),
			'client_ar'   => array( 'label' => 'Client (Arabic)', 'type' => 'text', 'rtl' => true ),
			'year'        => array( 'label' => 'Year', 'type' => 'text' ),
		),
		'racc_member'  => array(
			'name_ar'  => array( 'label' => 'Name (Arabic)', 'type' => 'text', 'rtl' => true ),
			'role_en'  => array( 'label' => function_exists( 'pll_current_language' ) ? 'Position' : 'Position (English)', 'type' => 'text' ),
			'role_ar'  => array( 'label' => 'Position (Arabic)', 'type' => 'text', 'rtl' => true ),
			'bio_ar'   => array( 'label' => 'Bio (Arabic)', 'type' => 'textarea', 'rtl' => true ),
			'email'    => array( 'label' => 'Email', 'type' => 'email' ),
			'linkedin' => array( 'label' => 'LinkedIn URL', 'type' => 'url' ),
		),
	);
}

/**
 * Add meta boxes.
 */
function racc_add_meta_boxes() {
	foreach ( array_keys( racc_meta_fields() ) as $type ) {
		$title = function_exists( 'pll_current_language' ) ? 'Details — التفاصيل' : 'Arabic version & details — النسخة العربية والتفاصيل';
		add_meta_box( 'racc_fields', $title, 'racc_render_meta_box', $type, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'racc_add_meta_boxes' );

/**
 * Render meta box.
 *
 * @param WP_Post $post Post.
 */
function racc_render_meta_box( $post ) {
	$fields = racc_meta_fields()[ $post->post_type ];
	$pll    = function_exists( 'pll_current_language' );
	wp_nonce_field( 'racc_save_meta', 'racc_meta_nonce' );
	if ( $pll ) {
		// With Polylang each language is its own post, so the Arabic-only fields are not needed.
		$fields = array_filter(
			$fields,
			function ( $f ) {
				return empty( $f['rtl'] );
			}
		);
		echo '<p class="description">Write this post in its own language. Add the other language with the <strong>+</strong> in the Languages box; sector, icon and year are copied across automatically.</p>';
	} else {
		echo '<p class="description">The title and main editor above are the <strong>English</strong> version. Fill in the Arabic version here.</p>';
	}
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields as $key => $f ) {
		$id    = 'racc_' . $key;
		$value = get_post_meta( $post->ID, '_racc_' . $key, true );
		$dir   = ! empty( $f['rtl'] ) ? ' dir="rtl"' : '';
		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $f['label'] ) . '</label></th><td>';
		switch ( $f['type'] ) {
			case 'textarea':
				printf( '<textarea class="large-text" rows="%4$d" id="%1$s" name="%1$s"%3$s>%2$s</textarea>', esc_attr( $id ), esc_textarea( $value ), $dir, isset( $f['rows'] ) ? (int) $f['rows'] : 4 ); // phpcs:ignore WordPress.Security.EscapeOutput
				break;
			case 'select':
				printf( '<select id="%1$s" name="%1$s"><option value="">—</option>', esc_attr( $id ) );
				foreach ( $f['choices'] as $k => $label ) {
					printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $value, $k, false ), esc_html( $label ) );
				}
				echo '</select>';
				break;
			default:
				printf( '<input class="regular-text" type="%4$s" id="%1$s" name="%1$s" value="%2$s"%3$s>', esc_attr( $id ), esc_attr( $value ), $dir, esc_attr( $f['type'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

/**
 * Save meta box.
 *
 * @param int $post_id Post ID.
 */
function racc_save_meta( $post_id ) {
	if ( ! isset( $_POST['racc_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['racc_meta_nonce'] ) ), 'racc_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$type   = get_post_type( $post_id );
	$fields = racc_meta_fields();
	if ( ! isset( $fields[ $type ] ) ) {
		return;
	}
	foreach ( $fields[ $type ] as $key => $f ) {
		$name = 'racc_' . $key;
		if ( ! isset( $_POST[ $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		switch ( $f['type'] ) {
			case 'textarea':
				$clean = sanitize_textarea_field( $raw );
				break;
			case 'email':
				$clean = sanitize_email( $raw );
				break;
			case 'url':
				$clean = esc_url_raw( $raw );
				break;
			default:
				$clean = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, '_racc_' . $key, $clean );
	}
}
add_action( 'save_post', 'racc_save_meta' );

/**
 * Flush rewrite rules once after the theme is activated so /projects/ works.
 */
function racc_flush_rewrites() {
	racc_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'racc_flush_rewrites' );
