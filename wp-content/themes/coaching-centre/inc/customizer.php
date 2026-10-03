<?php
/**
 * Customizer panels that map 1:1 onto the theme mods used by the templates.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register a theme mod with a control in one call.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @param string               $section      Section id.
 * @param string               $key          Theme mod key.
 * @param string               $label        Control label.
 * @param array                $args         Extra args (type, description, sanitize, input_attrs).
 */
function cc_add_control( $wp_customize, $section, $key, $label, $args = array() ) {
	$defaults = cc_defaults();
	$args     = wp_parse_args(
		$args,
		array(
			'type'        => 'text',
			'description' => '',
			'sanitize'    => 'cc_sanitize_text',
			'input_attrs' => array(),
		)
	);

	$wp_customize->add_setting(
		$key,
		array(
			'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
			'sanitize_callback' => $args['sanitize'],
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		$key,
		array(
			'label'       => $label,
			'section'     => $section,
			'type'        => $args['type'],
			'description' => $args['description'],
			'input_attrs' => $args['input_attrs'],
		)
	);
}

/**
 * Register a section inside the theme panel.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @param string               $id     Section id.
 * @param string               $title  Section title.
 * @param string               $priority Section priority.
 */
function cc_add_section( $wp_customize, $id, $title, $priority = 10 ) {
	$wp_customize->add_section(
		$id,
		array(
			'title'    => $title,
			'panel'    => 'cc_panel',
			'priority' => $priority,
		)
	);
}

/**
 * Customizer registration.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function cc_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'cc_panel',
		array(
			'title'       => __( 'কোচিং থিম সেটিংস', 'coaching-centre' ),
			'description' => __( 'সাইটের সব লেখা, ছবি ও যোগাযোগের তথ্য এখান থেকে বদলাতে পারবেন।', 'coaching-centre' ),
			'priority'    => 20,
		)
	);

	/* General. */
	cc_add_section( $wp_customize, 'cc_general', __( 'সাধারণ তথ্য', 'coaching-centre' ), 10 );

	cc_add_control( $wp_customize, 'cc_general', 'cc_logo_text', __( 'লোগোর লেখা', 'coaching-centre' ), array( 'description' => __( 'কাস্টম লোগো ছবি যোগ করলে এটি আর দেখানো হবে না।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_phone', __( 'ফোন (দেখানোর জন্য)', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_phone_link', __( 'ফোন (লিংকের জন্য, +৮৮০ দিয়ে)', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_whatsapp', __( 'হোয়াটসঅ্যাপ নম্বর (দেশের কোডসহ)', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_email', __( 'ইমেইল', 'coaching-centre' ), array( 'sanitize' => 'sanitize_email' ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_address', __( 'প্রধান কার্যালয়ের ঠিকানা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_open_hours', __( 'অফিস সময়', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে `দিন|সময়` ফরম্যাটে লিখুন।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_map_embed', __( 'গুগল ম্যাপ লিংক', 'coaching-centre' ), array( 'sanitize' => 'cc_sanitize_url', 'description' => __( 'গুগল ম্যাপের share লিংক বসালেই ম্যাপ এমবেড হবে।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_general', 'cc_dark_mode', __( 'গাঢ় থিম (dark mode)', 'coaching-centre' ), array( 'type' => 'checkbox', 'sanitize' => 'cc_sanitize_checkbox' ) );

	/* Home: hero. */
	cc_add_section( $wp_customize, 'cc_hero', __( 'হোম — হিরো', 'coaching-centre' ), 20 );

	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_image', __( 'হিরো ছবি', 'coaching-centre' ), array( 'type' => 'image', 'sanitize' => 'absint' ) );
	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_tag', __( 'হিরো ব্যাজ', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_title', __( 'হিরো শিরোনাম', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_text', __( 'হিরো বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_btn1_txt', __( 'প্রথম বাটনের লেখা', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_hero', 'cc_hero_btn2_txt', __( 'দ্বিতীয় বাটনের লেখা', 'coaching-centre' ) );

	/* Home: stats. */
	cc_add_section( $wp_customize, 'cc_stats', __( 'হোম — পরিসংখ্যান', 'coaching-centre' ), 30 );

	$stat_defaults = cc_defaults();
	$stats         = isset( $stat_defaults['cc_stats'] ) ? $stat_defaults['cc_stats'] : array();

	$wp_customize->add_setting(
		'cc_stats',
		array(
			'default'           => $stats,
			'sanitize_callback' => 'cc_sanitize_value_label_lines',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_control(
		'cc_stats',
		array(
			'label'       => __( 'সংখ্যা ও লেবেল', 'coaching-centre' ),
			'section'     => 'cc_stats',
			'type'        => 'textarea',
			'description' => __( 'প্রতি লাইনে `সংখ্যা|লেবেল` ফরম্যাটে লিখুন (সর্বোচ্চ ৬টি)।', 'coaching-centre' ),
			'input_attrs' => array(
				'rows' => 5,
			),
		)
	);

	/* Home: programs & exam. */
	cc_add_section( $wp_customize, 'cc_programs', __( 'হোম — কোর্স ও পরীক্ষা', 'coaching-centre' ), 40 );

	cc_add_control( $wp_customize, 'cc_programs', 'cc_features_title', __( 'সুবিধা শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_features_sub', __( 'সুবিধা বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_features', __( 'সুবিধাসমূহ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_cards_lines', 'description' => __( 'প্রতি লাইনে `আইকন|শিরোনাম|বিবরণ`।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_programs_title', __( 'কোর্সসমূহ শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_programs_sub', __( 'কোর্সসমূহ বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_price', __( 'পরীক্ষার ফি', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_title', __( 'পরীক্ষার শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_text', __( 'পরীক্ষার বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_points', __( 'পরীক্ষার বৈশিষ্ট্য', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি আইটেম।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_payment', __( 'পেমেন্ট মাধ্যম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_programs', 'cc_exam_class_opt', __( 'পরীক্ষার শ্রেণির তালিকা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি শ্রেণি।', 'coaching-centre' ) ) );

	/* Home: cadet & CTA. */
	cc_add_section( $wp_customize, 'cc_cadet', __( 'হোম — ক্যাডেট ও ভর্তি', 'coaching-centre' ), 50 );

	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cadet_image', __( 'ক্যাডেট ছবি', 'coaching-centre' ), array( 'type' => 'image', 'sanitize' => 'absint' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cadet_tag', __( 'ক্যাডেট ব্যাজ', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cadet_title', __( 'ক্যাডেট শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cadet_text', __( 'ক্যাডেট বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cadet_points', __( 'ক্যাডেট বৈশিষ্ট্য', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি আইটেম।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cta_title', __( 'ভর্তি ব্যানার শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cta_text', __( 'ভর্তি ব্যানার বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_cadet', 'cc_cta_link', __( 'ফোন বাটন লিংক', 'coaching-centre' ), array( 'sanitize' => 'cc_sanitize_url', 'description' => __( '`tel` লিখলে ফোন কল বাটন হবে।', 'coaching-centre' ) ) );

	/* Home: teachers, quotes, FAQ. */
	cc_add_section( $wp_customize, 'cc_people', __( 'হোম — শিক্ষক ও মতামত', 'coaching-centre' ), 60 );

	cc_add_control( $wp_customize, 'cc_people', 'cc_teachers_title', __( 'শিক্ষকমণ্ডলী শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_people', 'cc_teachers_sub', __( 'শিক্ষকমণ্ডলী বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_people', 'cc_quotes_title', __( 'মতামত শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_people', 'cc_quotes_sub', __( 'মতামত বিবরণ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_people', 'cc_faq_title', __( 'প্রশ্নোত্তর শিরোনাম', 'coaching-centre' ) );

	/* About page. */
	cc_add_section( $wp_customize, 'cc_about', __( 'আমাদের সম্পর্কে পেজ', 'coaching-centre' ), 70 );

	cc_add_control( $wp_customize, 'cc_about', 'cc_about_heading', __( 'শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_about_intro', __( 'ভূমিকা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_about_image', __( 'আমাদের গল্পের ছবি', 'coaching-centre' ), array( 'type' => 'image', 'sanitize' => 'absint' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_about_story_1', __( 'গল্প — অংশ ১', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_about_story_2', __( 'গল্প — অংশ ২', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_about_stats', __( 'সংখ্যা ও লেবেল', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_value_label_lines', 'description' => __( 'প্রতি লাইনে `সংখ্যা|লেবেল`।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_mv', __( 'লক্ষ্য, দৃষ্টিভঙ্গি ও মূল্যবোধ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_cards_lines', 'description' => __( 'প্রতি লাইনে `আইকন|শিরোনাম|বিবরণ`।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_timeline', __( 'পথচলা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_timeline_lines', 'description' => __( 'প্রতি লাইনে `বছর|বিবরণ`।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_method', __( 'শিক্ষা পদ্ধতি', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_cards_lines', 'description' => __( 'প্রতি লাইনে `আইকন|শিরোনাম|বিবরণ`।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_chair_image', __( 'অধ্যক্ষের ছবি', 'coaching-centre' ), array( 'type' => 'image', 'sanitize' => 'absint' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_chair_quote', __( 'অধ্যক্ষের বার্তা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_chair_name', __( 'অধ্যক্ষের নাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_chair_role', __( 'অধ্যক্ষের পদবি', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_facilities', __( 'সুবিধাসমূহ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list' ) );
	cc_add_control( $wp_customize, 'cc_about', 'cc_achievements', __( 'স্বীকৃতি ও অর্জন', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list' ) );

	/* Contact page. */
	cc_add_section( $wp_customize, 'cc_contact', __( 'যোগাযোগ পেজ', 'coaching-centre' ), 80 );

	cc_add_control( $wp_customize, 'cc_contact', 'cc_contact_heading', __( 'শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_contact', 'cc_contact_intro', __( 'ভূমিকা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_contact', 'cc_contact_topics', __( 'বার্তার বিষয়সমূহ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি বিষয়।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_contact', 'cc_branch_label', __( 'শাখা শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_contact', 'cc_map_title', __( 'ম্যাপ শিরোনাম', 'coaching-centre' ) );

	$branch_defaults = cc_defaults();
	$branches        = isset( $branch_defaults['cc_branches'] ) ? $branch_defaults['cc_branches'] : array();

	$wp_customize->add_setting(
		'cc_branches',
		array(
			'default'           => $branches,
			'sanitize_callback' => 'cc_sanitize_branches_lines',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_control(
		'cc_branches',
		array(
			'label'       => __( 'শাখাসমূহ', 'coaching-centre' ),
			'section'     => 'cc_contact',
			'type'        => 'textarea',
			'description' => __( 'প্রতি লাইনে `নাম|ঠিকানা|ফোন|ম্যাপ লিংক`।', 'coaching-centre' ),
			'input_attrs' => array(
				'rows' => 5,
			),
		)
	);

	/* Registration page. */
	cc_add_section( $wp_customize, 'cc_registration', __( 'ভর্তি ফর্ম পেজ', 'coaching-centre' ), 85 );

	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_heading', __( 'শিরোনাম', 'coaching-centre' ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_sub', __( 'ভূমিকা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_steps', __( 'ভর্তির ধাপ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি ধাপ।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_documents', __( 'সঙ্গে আনতে হবে', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি আইটেম।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_payment_methods', __( 'পেমেন্ট পদ্ধতি', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list' ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_versions', __( 'ভার্সন', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি অপশন।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_groups', __( 'গ্রুপ', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি অপশন।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_sources', __( 'কীভাবে জানলেন', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_list', 'description' => __( 'প্রতি লাইনে একটি অপশন।', 'coaching-centre' ) ) );
	cc_add_control( $wp_customize, 'cc_registration', 'cc_reg_terms', __( 'শর্তাবলীর লেখা', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );

	/* Footer & social. */
	cc_add_section( $wp_customize, 'cc_footer', __( 'ফুটার ও সোশ্যাল', 'coaching-centre' ), 90 );

	cc_add_control( $wp_customize, 'cc_footer', 'cc_footer_about', __( 'ফুটারের পরিচিতি', 'coaching-centre' ), array( 'type' => 'textarea', 'sanitize' => 'cc_sanitize_textarea' ) );
	cc_add_control( $wp_customize, 'cc_footer', 'cc_copyright', __( 'কপিরাইট লেখা', 'coaching-centre' ) );

	$social_defaults = cc_defaults();
	$social          = isset( $social_defaults['cc_social'] ) ? $social_defaults['cc_social'] : array();

	$wp_customize->add_setting(
		'cc_social',
		array(
			'default'           => $social,
			'sanitize_callback' => 'cc_sanitize_social_lines',
			'capability'        => 'edit_theme_options',
		)
	);
	$wp_customize->add_control(
		'cc_social',
		array(
			'label'       => __( 'সোশ্যাল লিংক', 'coaching-centre' ),
			'section'     => 'cc_footer',
			'type'        => 'textarea',
			'description' => __( 'প্রতি লাইনে `facebook|youtube|instagram|telegram` লিংক (খালি রাখলে লিংক দেখানো হবে না)।', 'coaching-centre' ),
			'input_attrs' => array(
				'rows' => 4,
			),
		)
	);

	/* Selective refresh for the post title / excerpt. */
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	}
}
add_action( 'customize_register', 'cc_customize_register' );

/**
 * Live preview script for the selective refresh settings.
 */
function cc_customize_preview_js() {
	wp_enqueue_script(
		'cc-customizer-preview',
		CC_URI . 'assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		CC_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'cc_customize_preview_js' );