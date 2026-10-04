<?php
/**
 * Contact details, form and map.
 *
 * @package racc
 */

$racc_status = racc_contact_status();
$racc_phone  = racc_company( 'phone' );
$racc_email  = racc_company( 'email' );
$racc_map    = racc_company( 'map_query' );
$racc_scheme = is_ssl() ? 'https://' : 'http://';
$racc_host   = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
$racc_uri    = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
$racc_back   = add_query_arg( 'lang', racc_lang(), remove_query_arg( array( 'sent', 'error' ), $racc_scheme . $racc_host . $racc_uri ) );
?>
<section class="section contact" id="contact">
	<div class="container">
		<header class="section-head reveal">
			<p class="section-kicker"><?php racc_e( 'Contact us', 'تواصل معنا' ); ?></p>
			<h2 class="section-title"><?php racc_e( 'Let’s build something lasting together', 'لنبنِ معاً ما يدوم' ); ?></h2>
		</header>

		<div class="contact-grid">
			<div class="contact-info reveal">
				<ul class="contact-list">
					<li>
						<span class="ci-icon"><?php echo racc_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div><span class="ci-label"><?php racc_e( 'Phone', 'الهاتف' ); ?></span><a href="tel:<?php echo esc_attr( racc_tel( $racc_phone ) ); ?>" dir="ltr"><?php echo esc_html( $racc_phone ); ?></a></div>
					</li>
					<li>
						<span class="ci-icon"><?php echo racc_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div><span class="ci-label"><?php racc_e( 'Email', 'البريد الإلكتروني' ); ?></span><a href="mailto:<?php echo esc_attr( $racc_email ); ?>"><?php echo esc_html( $racc_email ); ?></a></div>
					</li>
					<li>
						<span class="ci-icon"><?php echo racc_icon( 'pin' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div><span class="ci-label"><?php racc_e( 'Office', 'المقر' ); ?></span><span><?php echo esc_html( racc_company( 'address' ) ); ?></span></div>
					</li>
					<li>
						<span class="ci-icon"><?php echo racc_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div><span class="ci-label"><?php racc_e( 'Working hours', 'ساعات العمل' ); ?></span><span><?php echo esc_html( racc_company( 'hours' ) ); ?></span></div>
					</li>
				</ul>
				<?php if ( $racc_map ) : ?>
					<div class="map">
						<iframe title="<?php echo esc_attr( racc_t( 'RACC office location', 'موقع مقر الشركة' ) ); ?>" src="<?php echo esc_url( 'https://www.google.com/maps?q=' . rawurlencode( $racc_map ) . '&hl=' . racc_lang() . '&z=15&output=embed' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
					</div>
				<?php endif; ?>
			</div>

			<?php $racc_cf7 = racc_cf7_current_form(); ?>
			<?php if ( $racc_cf7 ) : ?>
				<div class="contact-form contact-form-cf7 reveal">
					<?php echo do_shortcode( '[contact-form-7 id="' . (int) $racc_cf7 . '" html_class="racc-cf7"]' ); ?>
				</div>
			<?php else : ?>
				<form class="contact-form reveal" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php if ( $racc_status ) : ?>
						<p class="form-status is-<?php echo esc_attr( $racc_status['type'] ); ?>" role="status"><?php echo esc_html( $racc_status['text'] ); ?></p>
					<?php endif; ?>
					<input type="hidden" name="action" value="racc_contact">
					<input type="hidden" name="racc_back" value="<?php echo esc_url( $racc_back ); ?>">
					<?php wp_nonce_field( 'racc_contact', 'racc_contact_nonce' ); ?>
					<div class="hp" aria-hidden="true"><label>Website <input type="text" name="racc_company_website" tabindex="-1" autocomplete="off"></label></div>

					<div class="field-row">
						<label class="field">
							<span><?php racc_e( 'Full name', 'الاسم الكامل' ); ?> *</span>
							<input type="text" name="racc_name" required autocomplete="name">
						</label>
						<label class="field">
							<span><?php racc_e( 'Phone', 'رقم الجوال' ); ?></span>
							<input type="tel" name="racc_phone" autocomplete="tel" dir="ltr" placeholder="+966 5x xxx xxxx">
						</label>
					</div>
					<label class="field">
						<span><?php racc_e( 'Email', 'البريد الإلكتروني' ); ?> *</span>
						<input type="email" name="racc_email" required autocomplete="email" dir="ltr">
					</label>
					<label class="field">
						<span><?php racc_e( 'Service needed', 'الخدمة المطلوبة' ); ?></span>
						<select name="racc_service">
							<option value=""><?php racc_e( 'Select a sector', 'اختر القطاع' ); ?></option>
							<?php foreach ( racc_get_sectors() as $racc_s ) : ?>
								<option><?php echo esc_html( $racc_s['title'] ); ?></option>
							<?php endforeach; ?>
							<option><?php racc_e( 'Other', 'أخرى' ); ?></option>
						</select>
					</label>
					<label class="field">
						<span><?php racc_e( 'Project details', 'تفاصيل المشروع' ); ?> *</span>
						<textarea name="racc_message" rows="5" required></textarea>
					</label>
					<button class="btn btn-copper btn-block" type="submit"><?php racc_e( 'Send message', 'إرسال الرسالة' ); ?><?php echo racc_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>
