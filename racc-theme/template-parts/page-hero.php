<?php
/**
 * Compact banner for inner pages.
 *
 * @package racc
 */

$racc_title = isset( $args['title'] ) ? $args['title'] : get_the_title();
$racc_kick  = isset( $args['kicker'] ) ? $args['kicker'] : '';
?>
<section class="page-hero">
	<div class="page-hero-skyline" aria-hidden="true"><?php get_template_part( 'template-parts/skyline' ); ?></div>
	<div class="container">
		<?php if ( $racc_kick ) : ?>
			<p class="section-kicker"><?php echo esc_html( $racc_kick ); ?></p>
		<?php endif; ?>
		<h1 class="page-title"><?php echo esc_html( $racc_title ); ?></h1>
	</div>
</section>
