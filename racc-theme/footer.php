<?php
/**
 * Site footer.
 *
 * @package racc
 */

$racc_anchor = is_front_page() ? '' : racc_home_url();
$racc_phone  = racc_company( 'phone' );
$racc_email  = racc_company( 'email' );
$racc_wa     = preg_replace( '/\D/', '', racc_company( 'whatsapp' ) );
?>
</main>

<footer class="site-footer">
	<div class="footer-skyline" aria-hidden="true"><?php get_template_part( 'template-parts/skyline' ); ?></div>
	<div class="container footer-grid">
		<div class="footer-brand">
			<?php racc_logo( 'light' ); ?>
			<p><?php racc_e( 'A first-grade classified engineering consultancy in Jeddah, delivering integrated engineering and consulting services across the Kingdom.', 'مكتب استشارات هندسية مصنّف بالدرجة الأولى في جدة، يقدم منظومة متكاملة من الخدمات الهندسية والاستشارية في جميع أنحاء المملكة.' ); ?></p>
			<div class="social">
				<?php
				foreach ( array( 'linkedin' => 'LinkedIn', 'x' => 'X', 'instagram' => 'Instagram' ) as $racc_net => $racc_label ) {
					$racc_url = racc_company( $racc_net );
					if ( $racc_url ) {
						printf( '<a href="%1$s" target="_blank" rel="noopener" aria-label="%2$s">%3$s</a>', esc_url( $racc_url ), esc_attr( $racc_label ), racc_icon( $racc_net ) ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
				}
				if ( $racc_wa ) {
					printf( '<a href="https://wa.me/%1$s" target="_blank" rel="noopener" aria-label="WhatsApp">%2$s</a>', esc_attr( $racc_wa ), racc_icon( 'whatsapp' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
				}
				?>
			</div>
		</div>

		<div>
			<h2 class="footer-title"><?php racc_e( 'Quick links', 'روابط سريعة' ); ?></h2>
			<ul class="footer-links">
				<li><a href="<?php echo esc_url( $racc_anchor ); ?>#about"><?php racc_e( 'About us', 'من نحن' ); ?></a></li>
				<li><a href="<?php echo esc_url( $racc_anchor ); ?>#sectors"><?php racc_e( 'Sectors & services', 'قطاعاتنا وخدماتنا' ); ?></a></li>
				<li><a href="<?php echo esc_url( $racc_anchor ); ?>#projects"><?php racc_e( 'Projects', 'مشاريعنا' ); ?></a></li>
				<li><a href="<?php echo esc_url( $racc_anchor ); ?>#team"><?php racc_e( 'Leadership', 'القيادة' ); ?></a></li>
				<li><a href="<?php echo esc_url( $racc_anchor ); ?>#accreditations"><?php racc_e( 'Accreditations', 'الاعتمادات' ); ?></a></li>
			</ul>
		</div>

		<div>
			<h2 class="footer-title"><?php racc_e( 'Our sectors', 'قطاعاتنا' ); ?></h2>
			<ul class="footer-links">
				<?php foreach ( racc_get_sectors() as $racc_s ) : ?>
					<li><a href="<?php echo esc_url( $racc_anchor ); ?>#sectors"><?php echo esc_html( $racc_s['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2 class="footer-title"><?php racc_e( 'Contact', 'تواصل معنا' ); ?></h2>
			<ul class="footer-contact">
				<li><?php echo racc_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html( racc_company( 'address' ) ); ?></span></li>
				<li><?php echo racc_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><a href="tel:<?php echo esc_attr( racc_tel( $racc_phone ) ); ?>" dir="ltr"><?php echo esc_html( $racc_phone ); ?></a></li>
				<li><?php echo racc_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?><a href="mailto:<?php echo esc_attr( $racc_email ); ?>"><?php echo esc_html( $racc_email ); ?></a></li>
			</ul>
		</div>
	</div>

	<div class="container footer-bottom">
		<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( racc_t( racc_company_defaults()['name_en'], racc_company_defaults()['name_ar'] ) ); ?>. <?php racc_e( 'All rights reserved.', 'جميع الحقوق محفوظة.' ); ?></p>
		<p dir="ltr"><?php echo esc_html( racc_company( 'website' ) ); ?></p>
	</div>
</footer>

<?php if ( $racc_wa ) : ?>
	<a class="wa-float" href="https://wa.me/<?php echo esc_attr( $racc_wa ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( racc_t( 'Chat with us on WhatsApp', 'تواصل معنا عبر واتساب' ) ); ?>"><?php echo racc_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
