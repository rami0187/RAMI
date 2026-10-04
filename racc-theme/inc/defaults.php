<?php
/**
 * Default company content (from the RACC brochure). Everything here can be
 * overridden from the WordPress admin: Customizer for company details, and the
 * Sectors / Projects / Team post types for listings.
 *
 * @package racc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inspirational stock photo (Unsplash, free licence) by photo id.
 * Replace any of these from Appearance → Customize → RACC Images, or by
 * setting a featured image on a Project.
 *
 * @param string $id    Unsplash photo id.
 * @param int    $width Requested width.
 * @return string
 */
function racc_stock( $id, $width = 1600 ) {
	return 'https://unsplash.com/photos/' . rawurlencode( $id ) . '/download?force=true&w=' . (int) $width;
}

/**
 * Stock photo ids used by default.
 *
 * @return array
 */
function racc_stock_ids() {
	return array(
		'jeddah_skyline'  => 'XBRJXgXYJY4', // Jeddah skyline with palm trees.
		'jeddah_sign'     => 'dBgLXxob7NQ', // Jeddah sign and palms.
		'island_mosque'   => '1DN4FB82tPs', // Island Mosque, Jeddah corniche.
		'tower_palm'      => 'jQTV--UWOzY', // Tall building with palm tree.
		'site_blueprint'  => '4PGQsAD0HoE', // Engineers reviewing blueprints on site.
		'site_blueprint2' => '4HklYcc9XMU', // Engineers in hard hats with plans.
		'engineer_plans'  => 'ECX60n_E934', // Engineer holding blueprint.
		'crane'           => 'PV6p4Lbt8rA', // Building under construction with crane.
	);
}

/**
 * Company contact details.
 *
 * @return array
 */
function racc_company_defaults() {
	return array(
		'name_en'    => 'RACC Engineering Consulting',
		'name_ar'    => 'شركة رموز الفكر للاستشارات الهندسية',
		'phone'      => '+966 53 129 1030',
		'whatsapp'   => '966531291030',
		'email'      => 'info@romoz-alfekr.sa',
		'form_email' => 'info@romoz-alfekr.sa',
		'website'    => 'www.romoz-alfekr.sa',
		'address_en' => 'Prince Mutaib Street, Al Safa District, Jeddah, Saudi Arabia',
		'address_ar' => 'جدة، حي الصفا، شارع الأمير متعب',
		'hours_en'   => 'Sunday – Thursday, 8:00 AM – 5:00 PM',
		'hours_ar'   => 'من الأحد إلى الخميس، 8:00 ص – 5:00 م',
		'map_query'  => 'Prince Mutaib Street, Al Safa, Jeddah, Saudi Arabia',
	);
}

/**
 * The six engineering sectors and their services.
 *
 * @return array
 */
function racc_default_sectors() {
	return array(
		array(
			'key'      => 'architecture',
			'icon'     => 'compass',
			'title_en' => 'Architectural & Urban Engineering',
			'title_ar' => 'قطاع الهندسة المعمارية والتخطيط الحضري',
			'desc_en'  => 'Distinctive architecture and liveable urban environments, from concept to construction documents.',
			'desc_ar'  => 'عمارة متميزة وبيئات عمرانية نابضة بالحياة، من الفكرة الأولى حتى مستندات التنفيذ.',
			'items_en' => array( 'Innovative architectural design', 'Urban planning', 'Interior design & landscape' ),
			'items_ar' => array( 'التصميم المعماري المبتكر', 'التخطيط العمراني', 'التصميم الداخلي واللاندسكيب' ),
		),
		array(
			'key'      => 'structural',
			'icon'     => 'layers',
			'title_en' => 'Structural & Geotechnical Engineering',
			'title_ar' => 'قطاع الهندسة الإنشائية والجيوتقنية',
			'desc_en'  => 'Safe, efficient structures engineered for Saudi conditions and the Saudi Building Code.',
			'desc_ar'  => 'منشآت آمنة وفعّالة مصممة لظروف المملكة ووفق كود البناء السعودي.',
			'items_en' => array( 'Structural design for major projects', 'Structural analysis & rehabilitation', 'Infrastructure engineering' ),
			'items_ar' => array( 'التصميم الإنشائي للمشاريع الكبرى', 'التحليل الإنشائي وإعادة التأهيل', 'هندسة البنية التحتية' ),
		),
		array(
			'key'      => 'fire',
			'icon'     => 'flame',
			'title_en' => 'Fire Safety & Security Engineering',
			'title_ar' => 'قطاع هندسة الأمن والسلامة ومكافحة الحريق',
			'desc_en'  => 'Life-safety and fire-protection design that protects people and passes Civil Defense approval.',
			'desc_ar'  => 'تصميم أنظمة السلامة والحماية من الحريق لحماية الأرواح واعتمادها من الدفاع المدني.',
			'items_en' => array( 'Fire-fighting systems design', 'Emergency plans & drawings approval' ),
			'items_ar' => array( 'تصميم أنظمة مكافحة الحريق', 'خطط الطوارئ واعتماد المخططات' ),
		),
		array(
			'key'      => 'survey',
			'icon'     => 'map',
			'title_en' => 'Surveying & GIS Engineering',
			'title_ar' => 'قطاع الهندسة المساحية ونظم المعلومات الجغرافية',
			'desc_en'  => 'Accurate land data and geographic intelligence that every sound project starts from.',
			'desc_ar'  => 'بيانات مساحية دقيقة ومعلومات جغرافية يبدأ منها كل مشروع ناجح.',
			'items_en' => array( 'Precise land surveying', 'Geographic Information Systems (GIS)', 'Certified plot subdivision & merging' ),
			'items_ar' => array( 'الرفع المساحي الدقيق', 'نظم المعلومات الجغرافية (GIS)', 'أعمال الفرز والدمج المعتمدة' ),
		),
		array(
			'key'      => 'pm',
			'icon'     => 'clipboard',
			'title_en' => 'Project Management & Construction Supervision',
			'title_ar' => 'قطاع الإشراف الهندسي وإدارة المشاريع',
			'desc_en'  => 'On-site control of quality, cost and schedule from groundbreaking to handover.',
			'desc_ar'  => 'رقابة ميدانية على الجودة والتكلفة والجدول الزمني من بدء التنفيذ حتى التسليم.',
			'items_en' => array( 'Technical supervision & construction control', 'Professional project management (PMO)', 'Quality assurance & control (QA/QC)' ),
			'items_ar' => array( 'الإشراف الفني والرقابة على التنفيذ', 'إدارة المشاريع الاحترافية (PMO)', 'ضبط وتأكيد الجودة (QA/QC)' ),
		),
		array(
			'key'      => 'arbitration',
			'icon'     => 'gavel',
			'title_en' => 'Engineering Arbitration & Dispute Resolution',
			'title_ar' => 'قطاع التحكيم الهندسي',
			'desc_en'  => 'Independent expert opinion and arbitration trusted by the courts of the Kingdom.',
			'desc_ar'  => 'رأي فني مستقل وتحكيم هندسي موثوق لدى محاكم المملكة.',
			'items_en' => array(
				'Engineering arbitration, dispute resolution and expert technical opinion',
				'Accredited on the Khebra platform and by the Administrative Courts',
				'Extensive record of cases assigned by courts across the Kingdom',
				'Classification certificates from the Saudi Council of Engineers and the International Arbitration Center',
			),
			'items_ar' => array(
				'خبرة في التحكيم الهندسي والفصل في النزاعات وإبداء الرأي الفني والهندسي',
				'معتمدون لدى منصة خبرة ومعتمدون لدى المحاكم الإدارية',
				'سجل كبير من القضايا التي كلفنا بها من قبل محاكم المملكة',
				'شهادات تصنيف من الهيئة السعودية للمهندسين والمركز الدولي للتحكيم',
			),
		),
	);
}

/**
 * Headline figures.
 *
 * @return array
 */
function racc_default_stats() {
	return array(
		array(
			'value_en' => '1st',
			'value_ar' => 'الأولى',
			'label_en' => 'Grade classification in the Kingdom of Saudi Arabia',
			'label_ar' => 'درجة التصنيف في المملكة العربية السعودية',
		),
		array(
			'value_en' => '6',
			'value_ar' => '6',
			'label_en' => 'Integrated engineering sectors',
			'label_ar' => 'قطاعات هندسية متكاملة',
		),
		array(
			'value_en' => '3',
			'value_ar' => '3',
			'label_en' => 'Sectors served: government, semi-government & private',
			'label_ar' => 'قطاعات نخدمها: حكومي، شبه حكومي، وخاص',
		),
		array(
			'value_en' => 'SBC',
			'value_ar' => 'SBC',
			'label_en' => 'Compliant with the Saudi Building Code & international standards',
			'label_ar' => 'الامتثال لكود البناء السعودي والمعايير العالمية',
		),
	);
}

/**
 * Leadership / team.
 *
 * @return array
 */
function racc_default_team() {
	return array(
		array(
			'name_en'  => 'Eng. Hussain bin Rajeh Al-Zahrani',
			'name_ar'  => 'المستشار م. حسين بن راجح الزهراني',
			'role_en'  => 'Consultant · Engineering Expert & Arbitrator',
			'role_ar'  => 'خبير هندسي ومحكم',
			'bio_en'   => 'Leads RACC\'s consulting practice and its engineering arbitration work, accredited on the Khebra platform and by the Administrative Courts, with a long record of court-assigned technical cases across the Kingdom.',
			'bio_ar'   => 'يقود الممارسة الاستشارية للشركة وأعمال التحكيم الهندسي، معتمد لدى منصة خبرة والمحاكم الإدارية، ولديه سجل طويل من القضايا الفنية المكلف بها من محاكم المملكة.',
			'photo'    => RACC_URI . '/assets/images/consultant-hussain-alzahrani.jpg',
			'email'    => 'hrz@romoz-alfekr.sa',
			'linkedin' => '',
		),
	);
}

/**
 * Accreditations & certifications.
 *
 * @return array
 */
function racc_default_accreditations() {
	return array(
		array(
			'icon'     => 'award',
			'title_en' => 'First-Grade Classification',
			'title_ar' => 'تصنيف الدرجة الأولى',
			'text_en'  => 'Top-tier engineering consultancy classification in the Kingdom of Saudi Arabia.',
			'text_ar'  => 'أعلى درجات تصنيف المكاتب الاستشارية الهندسية في المملكة العربية السعودية.',
		),
		array(
			'icon'     => 'shield',
			'title_en' => 'Saudi Council of Engineers',
			'title_ar' => 'الهيئة السعودية للمهندسين',
			'text_en'  => 'Classification certificates issued by the Saudi Council of Engineers (SCE).',
			'text_ar'  => 'شهادات تصنيف صادرة من الهيئة السعودية للمهندسين.',
		),
		array(
			'icon'     => 'gavel',
			'title_en' => 'International Arbitration Center',
			'title_ar' => 'المركز الدولي للتحكيم',
			'text_en'  => 'Certified engineering arbitration and dispute resolution.',
			'text_ar'  => 'شهادات معتمدة في التحكيم الهندسي وفض النزاعات.',
		),
		array(
			'icon'     => 'check',
			'title_en' => 'Khebra Platform & Administrative Courts',
			'title_ar' => 'منصة خبرة والمحاكم الإدارية',
			'text_en'  => 'Accredited engineering experts for the courts of the Kingdom.',
			'text_ar'  => 'خبراء هندسيون معتمدون لدى محاكم المملكة.',
		),
		array(
			'icon'     => 'building',
			'title_en' => 'Saudi Building Code (SBC)',
			'title_ar' => 'كود البناء السعودي (SBC)',
			'text_en'  => 'Every design and review is delivered in full compliance with the SBC and international standards.',
			'text_ar'  => 'جميع التصاميم والمراجعات ممتثلة لكود البناء السعودي والمعايير العالمية.',
		),
	);
}

/**
 * Sample projects shown until real ones are added under Projects in the admin.
 * These are placeholders — replace them with RACC's actual project portfolio.
 *
 * @return array
 */
function racc_default_projects() {
	$ids = racc_stock_ids();
	return array(
		array(
			'sector'      => 'architecture',
			'title_en'    => 'Mixed-Use Waterfront Tower',
			'title_ar'    => 'برج متعدد الاستخدامات على الواجهة البحرية',
			'location_en' => 'Jeddah',
			'location_ar' => 'جدة',
			'image'       => racc_stock( $ids['tower_palm'], 1000 ),
		),
		array(
			'sector'      => 'structural',
			'title_en'    => 'High-Rise Structural Design',
			'title_ar'    => 'التصميم الإنشائي لمبنى شاهق',
			'location_en' => 'Jeddah',
			'location_ar' => 'جدة',
			'image'       => racc_stock( $ids['crane'], 1000 ),
		),
		array(
			'sector'      => 'pm',
			'title_en'    => 'Construction Supervision — Government Complex',
			'title_ar'    => 'الإشراف على تنفيذ مجمع حكومي',
			'location_en' => 'Makkah Region',
			'location_ar' => 'منطقة مكة المكرمة',
			'image'       => racc_stock( $ids['site_blueprint'], 1000 ),
		),
		array(
			'sector'      => 'survey',
			'title_en'    => 'Urban Survey & GIS Mapping',
			'title_ar'    => 'الرفع المساحي ونظم المعلومات الجغرافية لمخطط عمراني',
			'location_en' => 'Jeddah',
			'location_ar' => 'جدة',
			'image'       => racc_stock( $ids['jeddah_sign'], 1000 ),
		),
		array(
			'sector'      => 'fire',
			'title_en'    => 'Fire & Life Safety Design — Commercial Center',
			'title_ar'    => 'تصميم أنظمة الحريق والسلامة لمركز تجاري',
			'location_en' => 'Jeddah',
			'location_ar' => 'جدة',
			'image'       => racc_stock( $ids['site_blueprint2'], 1000 ),
		),
		array(
			'sector'      => 'arbitration',
			'title_en'    => 'Court-Appointed Technical Expertise',
			'title_ar'    => 'خبرة فنية بتكليف من المحكمة',
			'location_en' => 'Kingdom-wide',
			'location_ar' => 'على مستوى المملكة',
			'image'       => racc_stock( $ids['engineer_plans'], 1000 ),
		),
	);
}
