<?php
/**
 * Inline SVG icon set (stroke icons, inherit currentColor).
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Icon names offered in the admin for sectors.
 *
 * @return array
 */
function racc_icon_choices() {
	return array(
		'compass'  => 'Compass (architecture)',
		'layers'   => 'Layers (structural)',
		'flame'    => 'Flame (fire safety)',
		'map'      => 'Map pin (surveying / GIS)',
		'clipboard' => 'Clipboard (project management)',
		'gavel'    => 'Gavel (arbitration)',
		'building' => 'Building',
		'shield'   => 'Shield',
	);
}

/**
 * Return SVG markup for an icon.
 *
 * @param string $name Icon name.
 * @return string
 */
function racc_icon( $name ) {
	$paths = array(
		'compass'   => '<path d="M12 3v3"/><circle cx="12" cy="8" r="2"/><path d="M10.8 9.7 5 21"/><path d="m13.2 9.7 5.8 11.3"/><path d="M6.5 16.5a11 11 0 0 0 11 0"/>',
		'layers'    => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 13 9 5 9-5"/><path d="m3 17.5 9 4.5 9-4.5"/>',
		'flame'     => '<path d="M12 22c4 0 7-2.7 7-7 0-3.5-2.4-6.4-4-8-.4 2.4-1.6 3.8-3 4.5C12 8 11 5 8.5 2.5 8.5 7 5 9.5 5 15c0 4.3 3 7 7 7Z"/><path d="M12 22c-1.7 0-3-1.3-3-3.2 0-2 1.6-3.1 3-4.8 1.4 1.7 3 2.8 3 4.8 0 1.9-1.3 3.2-3 3.2Z"/>',
		'map'       => '<path d="M12 21s-6-5.4-6-11a6 6 0 0 1 12 0c0 5.6-6 11-6 11Z"/><circle cx="12" cy="10" r="2.2"/><path d="M4 21h16"/>',
		'clipboard' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1"/><path d="M9 10h6M9 14h6M9 18h3"/>',
		'gavel'     => '<path d="m14 4 6 6"/><path d="m11 7 6 6"/><path d="m12.5 5.5-4 4 6 6 4-4"/><path d="m10.5 11.5-7 7 2 2 7-7"/><path d="M13 21h8"/>',
		'building'  => '<path d="M4 21V5l8-2v18"/><path d="M12 9h8v12"/><path d="M7 8h2M7 12h2M7 16h2M15 13h2M15 17h2"/><path d="M2 21h20"/>',
		'shield'    => '<path d="M12 3 4 6v6c0 5 3.4 8.3 8 9 4.6-.7 8-4 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/>',
		'phone'     => '<rect x="7" y="2.5" width="10" height="19" rx="2"/><path d="M11 18.5h2"/>',
		'pin'       => '<path d="M12 21s-6.5-5.6-6.5-11.2a6.5 6.5 0 0 1 13 0C18.5 15.4 12 21 12 21Z"/><circle cx="12" cy="10" r="2.3"/>',
		'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/>',
		'globe'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3Z"/>',
		'arrow'     => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
		'check'     => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
		'award'     => '<circle cx="12" cy="9" r="6"/><path d="m8.5 14 -1.5 7 5-2.5 5 2.5-1.5-7"/>',
		'menu'      => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'     => '<path d="M6 6l12 12M18 6 6 18"/>',
		'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'linkedin'  => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/>',
		'x'         => '<path d="M4 4l16 16M20 4 4 20"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5v.01"/>',
	);

	if ( 'whatsapp' === $name ) {
		return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12.04 2a9.9 9.9 0 0 0-8.5 15l-1.4 5 5.2-1.36A9.9 9.9 0 1 0 12.04 2Zm0 18.1a8.2 8.2 0 0 1-4.2-1.15l-.3-.18-3.1.8.83-3-.2-.31a8.2 8.2 0 1 1 6.97 3.84Zm4.5-6.14c-.25-.12-1.46-.72-1.69-.8-.23-.08-.39-.12-.55.12-.16.25-.63.8-.78.96-.14.17-.29.19-.53.06a6.7 6.7 0 0 1-3.32-2.9c-.25-.43.25-.4.72-1.33.08-.16.04-.3-.02-.43-.06-.12-.55-1.33-.76-1.82-.2-.48-.4-.41-.55-.42h-.47a.9.9 0 0 0-.65.3 2.74 2.74 0 0 0-.86 2.04c0 1.2.88 2.37 1 2.53.12.17 1.72 2.63 4.18 3.7 1.55.67 2.16.73 2.94.61.47-.07 1.46-.6 1.66-1.17.2-.58.2-1.07.15-1.17-.06-.1-.22-.17-.47-.29Z"/></svg>';
	}

	if ( ! isset( $paths[ $name ] ) ) {
		$name = 'building';
	}
	return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}
