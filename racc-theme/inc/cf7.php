<?php
/**
 * Contact Form 7 integration.
 *
 * When Contact Form 7 is active the theme creates two ready-styled forms
 * ("RACC Contact — English" and "RACC Contact — Arabic") that send to
 * info@romoz-alfekr.sa, and shows the right one for the visitor's language.
 * Both can be edited under Contact → Contact Forms like any CF7 form; pick
 * different forms in Customizer → RACC Theme → Contact form.
 *
 * Without Contact Form 7 the built-in form in inc/contact.php is used.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Contact Form 7 is available.
 *
 * @return bool
 */
function racc_has_cf7() {
	return class_exists( 'WPCF7_ContactForm' );
}

/**
 * Address that receives enquiries.
 *
 * @return string
 */
function racc_form_recipient() {
	$to = get_theme_mod( 'racc_form_email', racc_company_defaults()['form_email'] );
	return is_email( $to ) ? $to : racc_company_defaults()['form_email'];
}

/**
 * CF7 form markup for one language. Field names match the theme styles.
 *
 * @param string $lang en|ar.
 * @return string
 */
function racc_cf7_form_markup( $lang ) {
	$ar = 'ar' === $lang;
	$t  = function ( $en, $arabic ) use ( $ar ) {
		return $ar ? $arabic : $en;
	};

	$options = array();
	foreach ( racc_default_sectors() as $s ) {
		$options[] = '"' . str_replace( '"', '', $ar ? $s['title_ar'] : $s['title_en'] ) . '"';
	}
	$options[] = '"' . $t( 'Other', 'أخرى' ) . '"';

	return implode(
		"\n",
		array(
			'<div class="field-row">',
			'<label class="field"><span>' . $t( 'Full name', 'الاسم الكامل' ) . ' *</span>[text* your-name autocomplete:name]</label>',
			'<label class="field"><span>' . $t( 'Phone', 'رقم الجوال' ) . '</span>[tel your-phone autocomplete:tel placeholder "+966 5x xxx xxxx"]</label>',
			'</div>',
			'<label class="field"><span>' . $t( 'Email', 'البريد الإلكتروني' ) . ' *</span>[email* your-email autocomplete:email]</label>',
			'<label class="field"><span>' . $t( 'Service needed', 'الخدمة المطلوبة' ) . '</span>[select your-service first_as_label "' . $t( 'Select a sector', 'اختر القطاع' ) . '" ' . implode( ' ', $options ) . ']</label>',
			'<label class="field"><span>' . $t( 'Project details', 'تفاصيل المشروع' ) . ' *</span>[textarea* your-message x5]</label>',
			'[submit class:btn class:btn-copper class:btn-block "' . $t( 'Send message', 'إرسال الرسالة' ) . '"]',
		)
	);
}

/**
 * Mail settings for one language.
 *
 * @param string $lang en|ar.
 * @return array
 */
function racc_cf7_mail( $lang ) {
	$label = 'ar' === $lang ? 'Arabic site' : 'English site';
	return array(
		'active'             => true,
		'subject'            => '[RACC website] [your-service] — [your-name]',
		'sender'             => '[_site_title] <wordpress@[_site_domain]>',
		'recipient'          => racc_form_recipient(),
		'body'               => "New enquiry from the {$label}\n\nName: [your-name]\nEmail: [your-email]\nPhone: [your-phone]\nService: [your-service]\n\nProject details:\n[your-message]\n\n-- \nSent from [_site_url]",
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'attachments'        => '',
		'use_html'           => false,
		'exclude_blank'      => false,
	);
}

/**
 * Arabic validation / status messages.
 *
 * @return array
 */
function racc_cf7_messages_ar() {
	return array(
		'mail_sent_ok'             => 'شكراً لتواصلك — تم إرسال رسالتك وسنعاود الاتصال بك قريباً.',
		'mail_sent_ng'             => 'عذراً، تعذر إرسال الرسالة. يرجى المحاولة لاحقاً أو الاتصال بنا مباشرة.',
		'validation_error'         => 'يوجد خطأ في حقل أو أكثر. يرجى المراجعة والمحاولة مرة أخرى.',
		'spam'                     => 'عذراً، تعذر إرسال الرسالة. يرجى المحاولة لاحقاً.',
		'accept_terms'             => 'يجب الموافقة على الشروط والأحكام قبل الإرسال.',
		'invalid_required'         => 'يرجى تعبئة هذا الحقل.',
		'invalid_too_long'         => 'النص المدخل أطول من المسموح.',
		'invalid_too_short'        => 'النص المدخل أقصر من المسموح.',
		'invalid_email'            => 'يرجى إدخال بريد إلكتروني صحيح.',
		'invalid_tel'              => 'يرجى إدخال رقم هاتف صحيح.',
		'upload_failed'            => 'حدث خطأ أثناء رفع الملف.',
	);
}

/**
 * English status message.
 *
 * @return array
 */
function racc_cf7_messages_en() {
	return array(
		'mail_sent_ok' => 'Thank you — your message has been sent. We will get back to you shortly.',
		'mail_sent_ng' => 'Sorry, the message could not be sent. Please try again later or call us directly.',
	);
}

/**
 * Create the two theme forms the first time an admin loads the dashboard with CF7 active.
 */
function racc_cf7_ensure_forms() {
	if ( ! racc_has_cf7() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	foreach ( array( 'en', 'ar' ) as $lang ) {
		$mod = 'racc_cf7_' . $lang;
		// Create each form only once, so a form the owner deleted or swapped out is not brought back.
		if ( get_option( 'racc_cf7_created_' . $lang ) ) {
			continue;
		}
		$form = WPCF7_ContactForm::get_template(
			array(
				'title'  => 'ar' === $lang ? 'RACC Contact — Arabic' : 'RACC Contact — English',
				'locale' => 'ar' === $lang ? 'ar' : 'en_US',
			)
		);
		$form->set_properties(
			array(
				'form'     => racc_cf7_form_markup( $lang ),
				'mail'     => racc_cf7_mail( $lang ),
				'messages' => array_merge( $form->prop( 'messages' ), 'ar' === $lang ? racc_cf7_messages_ar() : racc_cf7_messages_en() ),
			)
		);
		$new_id = $form->save();
		if ( $new_id ) {
			set_theme_mod( $mod, (int) $new_id );
			update_option( 'racc_cf7_created_' . $lang, (int) $new_id, false );
		}
	}
}
add_action( 'admin_init', 'racc_cf7_ensure_forms' );

/**
 * Contact Form 7 id to show for the current language (0 if none).
 *
 * @return int
 */
function racc_cf7_current_form() {
	if ( ! racc_has_cf7() ) {
		return 0;
	}
	$id = (int) get_theme_mod( 'racc_cf7_' . racc_lang() );
	if ( ! $id ) {
		$id = (int) get_theme_mod( 'racc_cf7_en' );
	}
	return $id && 'wpcf7_contact_form' === get_post_type( $id ) ? $id : 0;
}

/**
 * Keep the theme's own markup — no automatic <p>/<br> inside CF7 forms.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Customizer: choose which CF7 form to show per language, and the recipient.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function racc_cf7_customize( $wp_customize ) {
	$wp_customize->add_section(
		'racc_form',
		array(
			'title'       => 'Contact form',
			'panel'       => 'racc',
			'description' => racc_has_cf7()
				? 'The theme created two Contact Form 7 forms for you. Edit them under Contact → Contact Forms (the recipient is set in each form\'s Mail tab).'
				: 'Install and activate Contact Form 7 to manage the form there. Until then a built-in form is used and sends to the address below.',
		)
	);
	$wp_customize->add_setting( 'racc_form_email', array( 'default' => racc_company_defaults()['form_email'], 'sanitize_callback' => 'sanitize_email' ) );
	$wp_customize->add_control(
		'racc_form_email',
		array(
			'label'       => 'Send enquiries to',
			'description' => 'Used by the built-in form, and as the recipient when the theme creates its Contact Form 7 forms.',
			'section'     => 'racc_form',
			'type'        => 'email',
		)
	);

	if ( ! racc_has_cf7() ) {
		return;
	}
	$choices = array( 0 => '— Built-in theme form —' );
	foreach ( get_posts( array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ) ) as $f ) {
		$choices[ $f->ID ] = $f->post_title;
	}
	foreach ( array( 'en' => 'English', 'ar' => 'Arabic' ) as $lang => $label ) {
		$wp_customize->add_setting( 'racc_cf7_' . $lang, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control(
			'racc_cf7_' . $lang,
			array(
				'label'   => 'Contact Form 7 form (' . $label . ' pages)',
				'section' => 'racc_form',
				'type'    => 'select',
				'choices' => $choices,
			)
		);
	}
}
add_action( 'customize_register', 'racc_cf7_customize', 20 );
