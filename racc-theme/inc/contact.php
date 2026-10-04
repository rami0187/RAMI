<?php
/**
 * Built-in contact form handler, used only when Contact Form 7 is not active.
 * Messages are emailed to the address set in Customizer → RACC Theme → Contact form.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle submission.
 */
function racc_handle_contact() {
	$back = isset( $_POST['racc_back'] ) ? esc_url_raw( wp_unslash( $_POST['racc_back'] ) ) : home_url( '/' );
	$back = wp_validate_redirect( $back, home_url( '/' ) );
	$back = remove_query_arg( array( 'sent', 'error' ), $back );

	$fail = function ( $code ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'error', $code, $back ) . '#contact' );
		exit;
	};

	if ( ! isset( $_POST['racc_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['racc_contact_nonce'] ) ), 'racc_contact' ) ) {
		$fail( 'expired' );
	}
	// Honeypot: real visitors never see or fill this field.
	if ( ! empty( $_POST['racc_company_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact' );
		exit;
	}

	$name    = isset( $_POST['racc_name'] ) ? sanitize_text_field( wp_unslash( $_POST['racc_name'] ) ) : '';
	$email   = isset( $_POST['racc_email'] ) ? sanitize_email( wp_unslash( $_POST['racc_email'] ) ) : '';
	$phone   = isset( $_POST['racc_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['racc_phone'] ) ) : '';
	$service = isset( $_POST['racc_service'] ) ? sanitize_text_field( wp_unslash( $_POST['racc_service'] ) ) : '';
	$message = isset( $_POST['racc_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['racc_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		$fail( 'invalid' );
	}

	$to      = racc_form_recipient();
	$subject = sprintf( '[RACC website] %s — %s', $service ? $service : 'Enquiry', $name );
	$body    = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nService: {$service}\n\n{$message}\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	if ( ! wp_mail( $to, $subject, $body, $headers ) ) {
		$fail( 'mail' );
	}

	wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact' );
	exit;
}
add_action( 'admin_post_nopriv_racc_contact', 'racc_handle_contact' );
add_action( 'admin_post_racc_contact', 'racc_handle_contact' );

/**
 * Status message after submit.
 *
 * @return array|null { type, text }
 */
function racc_contact_status() {
	// phpcs:disable WordPress.Security.NonceVerification
	if ( isset( $_GET['sent'] ) ) {
		return array(
			'type' => 'success',
			'text' => racc_t( 'Thank you — your message has been sent. We will get back to you shortly.', 'شكراً لتواصلك — تم إرسال رسالتك وسنعاود الاتصال بك قريباً.' ),
		);
	}
	if ( isset( $_GET['error'] ) ) {
		$code = sanitize_key( wp_unslash( $_GET['error'] ) );
		if ( 'invalid' === $code ) {
			return array(
				'type' => 'error',
				'text' => racc_t( 'Please fill in your name, a valid email and your message.', 'يرجى إدخال الاسم وبريد إلكتروني صحيح ونص الرسالة.' ),
			);
		}
		return array(
			'type' => 'error',
			'text' => racc_t( 'Sorry, the message could not be sent. Please call or email us directly.', 'عذراً، تعذر إرسال الرسالة. يرجى الاتصال بنا أو مراسلتنا مباشرة.' ),
		);
	}
	// phpcs:enable
	return null;
}
