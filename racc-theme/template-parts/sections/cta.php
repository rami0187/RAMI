<?php
/**
 * Call to action.
 *
 * @package racc
 */

$racc_phone = racc_company( 'phone' );
?>
<section class="cta">
	<div class="cta-media" aria-hidden="true">
		<?php racc_img( racc_image( 'cta', 'crane', 2000 ), '' ); ?>
	</div>
	<div class="container cta-inner reveal">
		<div>
			<h2 class="cta-title"><?php racc_e( 'Have a project in mind?', 'لديك مشروع؟' ); ?></h2>
			<p class="cta-text"><?php racc_e( 'Talk to our engineers about design, supervision, fire safety approvals or an expert technical opinion.', 'تحدث مع مهندسينا حول التصميم أو الإشراف أو اعتماد مخططات السلامة أو الرأي الفني المتخصص.' ); ?></p>
		</div>
		<div class="cta-actions">
			<a class="btn btn-copper" href="#contact"><?php racc_e( 'Send us your enquiry', 'أرسل استفسارك' ); ?></a>
			<a class="btn btn-ghost" href="tel:<?php echo esc_attr( racc_tel( $racc_phone ) ); ?>" dir="ltr"><?php echo racc_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $racc_phone ); ?></a>
		</div>
	</div>
</section>
