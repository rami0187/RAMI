<?php
/**
 * Home page: all sections in order (toggle them in Customizer → RACC Theme → Home page sections).
 *
 * @package racc
 */

get_header();
foreach ( array_keys( racc_front_sections() ) as $racc_slug ) {
	racc_section( $racc_slug );
}
get_footer();
