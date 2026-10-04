<?php
/**
 * Hero.
 *
 * @package racc
 */

$racc_c = racc_copy_defaults();
?>
<section class="hero" id="top">
	<div class="hero-media" aria-hidden="true">
		<?php racc_img( racc_image( 'hero', 'jeddah_skyline', 2200 ), '', 'hero-img', '', true ); ?>
	</div>
	<div class="hero-skyline" aria-hidden="true"><?php get_template_part( 'template-parts/skyline' ); ?></div>

	<div class="container hero-inner">
		<p class="eyebrow"><span class="rule"></span><?php echo esc_html( racc_mod( 'racc_hero_eyebrow', $racc_c['hero_eyebrow'] ) ); ?></p>
		<h1 class="hero-title"><?php echo esc_html( racc_mod( 'racc_hero_title', $racc_c['hero_title'] ) ); ?></h1>
		<p class="hero-text"><?php echo esc_html( racc_mod( 'racc_hero_text', $racc_c['hero_text'] ) ); ?></p>
		<div class="hero-actions">
			<a class="btn btn-copper" href="#contact"><?php racc_e( 'Request a consultation', 'اطلب استشارة' ); ?><?php echo racc_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<a class="btn btn-ghost" href="#sectors"><?php racc_e( 'Explore our services', 'استكشف خدماتنا' ); ?></a>
		</div>
	</div>

	<div class="container">
		<ul class="stats" aria-label="<?php echo esc_attr( racc_t( 'Key facts', 'حقائق رئيسية' ) ); ?>">
			<?php foreach ( racc_default_stats() as $racc_s ) : ?>
				<li class="stat">
					<span class="stat-value"><?php racc_e( $racc_s['value_en'], $racc_s['value_ar'] ); ?></span>
					<span class="stat-label"><?php racc_e( $racc_s['label_en'], $racc_s['label_ar'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
