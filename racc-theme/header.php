<?php
/**
 * Site header.
 *
 * @package racc
 */

$racc_anchor = is_front_page() ? '' : racc_home_url();
$racc_nav    = array(
	'about'          => racc_t( 'About', 'من نحن' ),
	'sectors'        => racc_t( 'Services', 'خدماتنا' ),
	'projects'       => racc_t( 'Projects', 'مشاريعنا' ),
	'team'           => racc_t( 'Leadership', 'القيادة' ),
	'accreditations' => racc_t( 'Accreditations', 'الاعتمادات' ),
	'contact'        => racc_t( 'Contact', 'تواصل معنا' ),
);
$racc_menu_location = racc_is_ar() && has_nav_menu( 'primary_ar' ) ? 'primary_ar' : 'primary';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1c3249">
<?php wp_head(); ?>
</head>
<body <?php body_class( is_front_page() ? 'has-hero' : 'no-hero' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php racc_e( 'Skip to content', 'انتقل إلى المحتوى' ); ?></a>

<header class="site-header" data-header>
	<div class="container header-inner">
		<?php racc_logo( 'light' ); ?>

		<nav class="primary-nav" id="primary-nav" aria-label="<?php echo esc_attr( racc_t( 'Main', 'الرئيسية' ) ); ?>" data-nav>
			<?php
			if ( has_nav_menu( $racc_menu_location ) ) {
				wp_nav_menu(
					array(
						'theme_location' => $racc_menu_location,
						'container'      => false,
						'menu_class'     => 'nav-list',
						'depth'          => 1,
					)
				);
			} else {
				echo '<ul class="nav-list">';
				foreach ( $racc_nav as $racc_id => $racc_label ) {
					printf( '<li><a href="%s#%s">%s</a></li>', esc_url( $racc_anchor ), esc_attr( $racc_id ), esc_html( $racc_label ) );
				}
				echo '</ul>';
			}
			?>
			<div class="nav-extra">
				<?php racc_lang_switcher(); ?>
				<a class="btn btn-copper btn-sm" href="<?php echo esc_url( $racc_anchor ); ?>#contact"><?php racc_e( 'Request a consultation', 'اطلب استشارة' ); ?></a>
			</div>
		</nav>

		<button class="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false" data-nav-toggle>
			<span class="nav-toggle-open"><?php echo racc_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<span class="nav-toggle-close"><?php echo racc_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<span class="screen-reader-text"><?php racc_e( 'Menu', 'القائمة' ); ?></span>
		</button>
	</div>
</header>

<main id="main" class="site-main">
