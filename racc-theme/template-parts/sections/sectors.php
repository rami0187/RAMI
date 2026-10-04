<?php
/**
 * Sectors & services.
 *
 * @package racc
 */

?>
<section class="section sectors" id="sectors">
	<div class="container">
		<header class="section-head reveal">
			<p class="section-kicker"><?php racc_e( 'Core sectors & services', 'قطاعاتنا وخدماتنا الرئيسية' ); ?></p>
			<h2 class="section-title"><?php racc_e( 'Six integrated engineering sectors under one roof', 'ستة قطاعات هندسية متكاملة تحت سقف واحد' ); ?></h2>
			<p class="section-lead"><?php racc_e( 'From the first survey line to final handover — and, when needed, independent expert opinion before the courts.', 'من أول خط رفع مساحي حتى التسليم النهائي — وعند الحاجة، رأي فني مستقل أمام المحاكم.' ); ?></p>
		</header>

		<div class="sector-grid">
			<?php foreach ( racc_get_sectors() as $racc_i => $racc_s ) : ?>
				<article class="sector-card reveal">
					<div class="sector-top">
						<span class="sector-icon"><?php echo racc_icon( $racc_s['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<span class="sector-num"><?php echo esc_html( str_pad( (string) ( $racc_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					</div>
					<h3 class="sector-title"><?php echo esc_html( $racc_s['title'] ); ?></h3>
					<?php if ( $racc_s['desc'] ) : ?>
						<p class="sector-desc"><?php echo esc_html( $racc_s['desc'] ); ?></p>
					<?php endif; ?>
					<ul class="sector-list">
						<?php foreach ( $racc_s['items'] as $racc_item ) : ?>
							<li><?php echo esc_html( $racc_item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
