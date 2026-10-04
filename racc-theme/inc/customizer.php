<?php
/**
 * Customizer: Appearance → Customize → RACC Theme.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default hero / about copy.
 *
 * @return array
 */
function racc_copy_defaults() {
	return array(
		'hero_eyebrow' => array(
			'en' => 'First-grade classified engineering consultancy · Jeddah',
			'ar' => 'مكتب استشارات هندسية مصنّف بالدرجة الأولى · جدة',
		),
		'hero_title'   => array(
			'en' => 'Engineering the landmarks of the Kingdom',
			'ar' => 'نصمم ونشرف على معالم المملكة',
		),
		'hero_text'    => array(
			'en' => 'An integrated system of engineering and consulting services — architecture, structures, fire safety, surveying, project management and engineering arbitration — delivered to the Saudi Building Code and the highest international standards.',
			'ar' => 'منظومة متكاملة من الخدمات الهندسية والاستشارية — العمارة، والإنشاءات، والسلامة ومكافحة الحريق، والمساحة، وإدارة المشاريع، والتحكيم الهندسي — وفق كود البناء السعودي وأعلى المعايير العالمية.',
		),
		'about_title'  => array(
			'en' => 'A trusted partner for the Kingdom\'s strategic projects',
			'ar' => 'الشريك الموثوق لمشاريع المملكة الإستراتيجية',
		),
		'about_text'   => array(
			'en' => "We are a leading engineering firm holding first-grade classification in the Kingdom of Saudi Arabia. Over decades we have successfully led and developed major strategic projects by providing an integrated system of engineering and consulting services.\n\nWe combine architectural innovation, structural integrity, uncompromising safety and operational efficiency for industrial facilities — complying with the highest international standards and the Saudi Building Code (SBC) — to be the trusted partner of the government, semi-government and private sectors.",
			'ar' => "نحن شركة هندسية رائدة حاصلة على تصنيف الدرجة الأولى في المملكة العربية السعودية. على مدار عقود، نجحنا في قيادة وتطوير أضخم المشاريع الإستراتيجية عبر تقديم منظومة متكاملة من الخدمات الهندسية والاستشارية.\n\nنجمع بين الابتكار المعماري، والمتانة الإنشائية، والأمان المطلق، والكفاءة التشغيلية للمنشآت الصناعية، ممتثلين لأعلى المعايير العالمية وكود البناء السعودي (SBC)، لنكون الشريك الموثوق للقطاعات الحكومية، شبه الحكومية، والخاصة.",
		),
		'vision_quote' => array(
			'en' => 'Building with innovation, integrity and safety — in step with Saudi Vision 2030.',
			'ar' => 'نبني بالابتكار والمتانة والأمان — بما يواكب رؤية المملكة 2030.',
		),
	);
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function racc_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'racc',
		array(
			'title'    => 'RACC Theme',
			'priority' => 30,
		)
	);

	// --- General.
	$wp_customize->add_section( 'racc_general', array( 'title' => 'General & colours', 'panel' => 'racc' ) );
	$wp_customize->add_setting( 'racc_default_lang', array( 'default' => 'en', 'sanitize_callback' => 'racc_sanitize_lang' ) );
	$wp_customize->add_control(
		'racc_default_lang',
		array(
			'label'   => 'Default language for first-time visitors',
			'section' => 'racc_general',
			'type'    => 'radio',
			'choices' => array(
				'en' => 'English',
				'ar' => 'العربية (Arabic)',
			),
		)
	);
	foreach ( array(
		'racc_color_primary' => array( 'Primary (navy)', '#1c3249' ),
		'racc_color_accent'  => array( 'Accent (copper)', '#c08e74' ),
	) as $id => $c ) {
		$wp_customize->add_setting( $id, array( 'default' => $c[1], 'sanitize_callback' => 'sanitize_hex_color' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $c[0], 'section' => 'racc_general' ) ) );
	}

	// --- Company details.
	$wp_customize->add_section( 'racc_company', array( 'title' => 'Company & contact details', 'panel' => 'racc' ) );
	$d      = racc_company_defaults();
	$fields = array(
		'phone'      => 'Phone',
		'whatsapp'   => 'WhatsApp number (digits only, with country code)',
		'email'      => 'Email shown on the site',
		'address_en' => 'Address (English)',
		'address_ar' => 'Address (Arabic)',
		'hours_en'   => 'Working hours (English)',
		'hours_ar'   => 'Working hours (Arabic)',
		'map_query'  => 'Google Maps location (address or "lat,lng")',
		'linkedin'   => 'LinkedIn URL',
		'x'          => 'X (Twitter) URL',
		'instagram'  => 'Instagram URL',
	);
	foreach ( $fields as $key => $label ) {
		$id = 'racc_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => isset( $d[ $key ] ) ? $d[ $key ] : '', 'sanitize_callback' => 'email' === $key ? 'sanitize_email' : ( in_array( $key, array( 'linkedin', 'x', 'instagram' ), true ) ? 'esc_url_raw' : 'sanitize_text_field' ) ) );
		$wp_customize->add_control( $id, array( 'label' => $label, 'section' => 'racc_company', 'type' => 'email' === $key ? 'email' : 'text' ) );
	}

	// --- Text content.
	$wp_customize->add_section( 'racc_copy', array( 'title' => 'Hero & About text', 'panel' => 'racc' ) );
	$labels = array(
		'hero_eyebrow' => 'Hero small line',
		'hero_title'   => 'Hero headline',
		'hero_text'    => 'Hero paragraph',
		'about_title'  => 'About headline',
		'about_text'   => 'About text',
		'vision_quote' => 'Vision band quote',
	);
	foreach ( racc_copy_defaults() as $key => $def ) {
		foreach ( array( 'en' => 'English', 'ar' => 'Arabic' ) as $lang => $lname ) {
			$id = 'racc_' . $key . '_' . $lang;
			$wp_customize->add_setting( $id, array( 'default' => $def[ $lang ], 'sanitize_callback' => 'sanitize_textarea_field' ) );
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $labels[ $key ] . ' (' . $lname . ')',
					'section' => 'racc_copy',
					'type'    => in_array( $key, array( 'hero_text', 'about_text' ), true ) ? 'textarea' : 'text',
				)
			);
		}
	}

	// --- Images.
	$wp_customize->add_section(
		'racc_images',
		array(
			'title'       => 'Images',
			'panel'       => 'racc',
			'description' => 'Default photos are inspirational stock images from Unsplash. Upload your own project photography here to replace them.',
		)
	);
	foreach ( array(
		'hero'   => 'Hero background',
		'about'  => 'About section photo',
		'vision' => 'Vision band background',
		'cta'    => 'Call-to-action background',
	) as $key => $label ) {
		$id = 'racc_img_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array( 'label' => $label, 'section' => 'racc_images' ) ) );
	}

	// --- Sections on/off.
	$wp_customize->add_section( 'racc_sections', array( 'title' => 'Home page sections', 'panel' => 'racc' ) );
	foreach ( racc_front_sections() as $slug => $label ) {
		$id = 'racc_show_' . $slug;
		$wp_customize->add_setting( $id, array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
		$wp_customize->add_control( $id, array( 'label' => 'Show: ' . $label, 'section' => 'racc_sections', 'type' => 'checkbox' ) );
	}
}
add_action( 'customize_register', 'racc_customize_register' );

/**
 * Home page sections in order.
 *
 * @return array
 */
function racc_front_sections() {
	return array(
		'hero'           => 'Hero',
		'about'          => 'About us',
		'sectors'        => 'Sectors & services',
		'vision'         => 'Vision band',
		'projects'       => 'Projects',
		'team'           => 'Leadership',
		'accreditations' => 'Accreditations',
		'cta'            => 'Call to action',
		'contact'        => 'Contact',
	);
}

/**
 * Sanitize language choice.
 *
 * @param string $v Value.
 * @return string
 */
function racc_sanitize_lang( $v ) {
	return 'ar' === $v ? 'ar' : 'en';
}

/**
 * CSS variables from Customizer colours.
 *
 * @return string
 */
function racc_customizer_css() {
	$primary = get_theme_mod( 'racc_color_primary', '#1c3249' );
	$accent  = get_theme_mod( 'racc_color_accent', '#c08e74' );
	if ( '#1c3249' === strtolower( $primary ) && '#c08e74' === strtolower( $accent ) ) {
		return '';
	}
	return sprintf( ':root{--navy:%s;--copper:%s;}', esc_html( $primary ), esc_html( $accent ) );
}
