<?php
/**
 * About us.
 *
 * @package racc
 */

$racc_c     = racc_copy_defaults();
$racc_paras = racc_lines( racc_mod( 'racc_about_text', $racc_c['about_text'] ) );
$racc_pts   = array(
	array( 'compass', 'Architectural innovation', 'الابتكار المعماري' ),
	array( 'layers', 'Structural integrity', 'المتانة الإنشائية' ),
	array( 'shield', 'Uncompromising safety', 'الأمان المطلق' ),
	array( 'building', 'Operational efficiency', 'الكفاءة التشغيلية' ),
);
?>
<section class="section about" id="about">
	<div class="container about-grid">
		<div class="about-media reveal">
			<div class="frame">
				<?php racc_img( racc_image( 'about', 'site_blueprint', 1200 ), racc_t( 'RACC engineers reviewing drawings on site', 'مهندسو الشركة يراجعون المخططات في الموقع' ) ); ?>
			</div>
			<div class="about-badge">
				<span class="about-badge-value"><?php racc_e( '1st', 'الأولى' ); ?></span>
				<span class="about-badge-label"><?php racc_e( 'Grade classification in KSA', 'درجة التصنيف في المملكة' ); ?></span>
			</div>
		</div>

		<div class="about-body reveal">
			<p class="section-kicker"><?php racc_e( 'Who we are', 'من نحن؟' ); ?></p>
			<h2 class="section-title"><?php echo esc_html( racc_mod( 'racc_about_title', $racc_c['about_title'] ) ); ?></h2>
			<?php foreach ( $racc_paras as $racc_p ) : ?>
				<p><?php echo esc_html( $racc_p ); ?></p>
			<?php endforeach; ?>

			<ul class="pillars">
				<?php foreach ( $racc_pts as $racc_pt ) : ?>
					<li><span class="pillar-icon"><?php echo racc_icon( $racc_pt[0] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span><?php racc_e( $racc_pt[1], $racc_pt[2] ); ?></li>
				<?php endforeach; ?>
			</ul>

			<p class="clients-served">
				<strong><?php racc_e( 'We serve:', 'نخدم:' ); ?></strong>
				<span class="chip"><?php racc_e( 'Government', 'القطاع الحكومي' ); ?></span>
				<span class="chip"><?php racc_e( 'Semi-government', 'القطاع شبه الحكومي' ); ?></span>
				<span class="chip"><?php racc_e( 'Private sector', 'القطاع الخاص' ); ?></span>
			</p>
		</div>
	</div>
</section>
