<?php
/**
 * Accreditations & certifications.
 *
 * @package racc
 */

?>
<section class="section accreditations" id="accreditations">
	<div class="container">
		<header class="section-head reveal">
			<p class="section-kicker"><?php racc_e( 'Accreditations & certifications', 'الاعتمادات والشهادات' ); ?></p>
			<h2 class="section-title"><?php racc_e( 'Classified, certified and court-accredited', 'مصنّفون ومعتمدون لدى الجهات والمحاكم' ); ?></h2>
		</header>

		<ul class="accr-grid">
			<?php foreach ( racc_default_accreditations() as $racc_a ) : ?>
				<li class="accr reveal">
					<span class="accr-icon"><?php echo racc_icon( $racc_a['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
					<h3 class="accr-title"><?php racc_e( $racc_a['title_en'], $racc_a['title_ar'] ); ?></h3>
					<p class="accr-text"><?php racc_e( $racc_a['text_en'], $racc_a['text_ar'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
