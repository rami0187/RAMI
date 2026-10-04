<?php
/**
 * Leadership / team.
 *
 * @package racc
 */

$racc_team = racc_get_team();
if ( ! $racc_team ) {
	return;
}
$racc_lead = array_shift( $racc_team );
?>
<section class="section team" id="team">
	<div class="container">
		<header class="section-head reveal">
			<p class="section-kicker"><?php racc_e( 'Leadership', 'القيادة' ); ?></p>
			<h2 class="section-title"><?php racc_e( 'Expertise trusted by the courts and the industry', 'خبرة موثوقة لدى المحاكم وقطاع الصناعة' ); ?></h2>
		</header>

		<article class="lead-card reveal">
			<div class="lead-photo">
				<?php if ( $racc_lead['photo'] ) : ?>
					<?php racc_img( $racc_lead['photo'], $racc_lead['name'] ); ?>
				<?php endif; ?>
			</div>
			<div class="lead-body">
				<h3 class="lead-name"><?php echo esc_html( $racc_lead['name'] ); ?></h3>
				<p class="lead-role"><?php echo esc_html( $racc_lead['role'] ); ?></p>
				<?php if ( $racc_lead['bio'] ) : ?>
					<p class="lead-bio"><?php echo esc_html( $racc_lead['bio'] ); ?></p>
				<?php endif; ?>
				<div class="lead-links">
					<?php if ( $racc_lead['email'] ) : ?>
						<a href="mailto:<?php echo esc_attr( $racc_lead['email'] ); ?>"><?php echo racc_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo esc_html( $racc_lead['email'] ); ?></a>
					<?php endif; ?>
					<?php if ( $racc_lead['linkedin'] ) : ?>
						<a href="<?php echo esc_url( $racc_lead['linkedin'] ); ?>" target="_blank" rel="noopener"><?php echo racc_icon( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>LinkedIn</a>
					<?php endif; ?>
				</div>
			</div>
		</article>

		<?php if ( $racc_team ) : ?>
			<div class="team-grid">
				<?php foreach ( $racc_team as $racc_m ) : ?>
					<article class="member reveal">
						<div class="member-photo">
							<?php if ( $racc_m['photo'] ) : ?>
								<?php racc_img( $racc_m['photo'], $racc_m['name'] ); ?>
							<?php endif; ?>
						</div>
						<h3 class="member-name"><?php echo esc_html( $racc_m['name'] ); ?></h3>
						<p class="member-role"><?php echo esc_html( $racc_m['role'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
