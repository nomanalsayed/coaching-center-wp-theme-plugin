<?php
/**
 * Demo content: pages, courses, teachers, testimonials, FAQs and a few
 * sample registrations so the theme looks alive right after activation.
 *
 * Everything is tagged with `_cc_demo` so it can be removed again in one go.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Should the demo content be inserted?
 *
 * @return bool
 */
function cc_needs_demo() {
	return '1' !== get_option( 'cc_demo_seeded' );
}

/**
 * Mark a post as theme demo content.
 *
 * @param int $post_id Post ID.
 */
function cc_tag_demo( $post_id ) {
	update_post_meta( $post_id, '_cc_demo', '1' );
}

/**
 * The pages the theme templates key off.
 *
 * @return array
 */
function cc_demo_pages() {
	return array(
		'about-us'     => array(
			'title'   => __( 'আমাদের সম্পর্কে', 'coaching-centre' ),
			'content' => __( 'এই পেজটি থিমের টেমপ্লেট দ্বারা স্বয়ংক্রিয়ভাবে রেন্ডার হয়। কনটেন্ট বদলাতে চাইলে কাস্টমাইজারের "আমাদের সম্পর্কে পেজ" সেকশন ব্যবহার করুন।', 'coaching-centre' ),
		),
		'contact'      => array(
			'title'   => __( 'যোগাযোগ', 'coaching-centre' ),
			'content' => __( 'এই পেজটি থিমের যোগাযোগ টেমপ্লেট দ্বারা স্বয়ংক্রিয়ভাবে রেন্ডার হয়।', 'coaching-centre' ),
		),
		'registration' => array(
			'title'   => __( 'ভর্তি ফর্ম', 'coaching-centre' ),
			'content' => __( 'এই পেজটি থিমের ভর্তি টেমপ্লেট দ্বারা স্বয়ংক্রিয়ভাবে রেন্ডার হয়।', 'coaching-centre' ),
		),
	);
}

/**
 * Insert the demo pages when they are missing.
 */
function cc_seed_pages() {
	$parent = (int) get_option( 'page_on_front' );

	foreach ( cc_demo_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug );

		if ( $existing instanceof WP_Post ) {
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $page['content'],
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			cc_tag_demo( $page_id );
		}
	}
}

/**
 * The demo course catalogue.
 *
 * @return array
 */
function cc_demo_courses() {
	$weekly = array( __( '৫ম শ্রেণি', 'coaching-centre' ), __( '৬ষ্ঠ শ্রেণি', 'coaching-centre' ), __( '৭ম শ্রেণি', 'coaching-centre' ), __( '৮ম শ্রেণি', 'coaching-centre' ), __( '৯ম শ্রেণি', 'coaching-centre' ), __( '১০ম শ্রেণি (SSC)', 'coaching-centre' ) );

	$courses = array(
		array(
			'title'    => __( '৬ষ্ঠ শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
			'class'    => __( '৬ষ্ঠ শ্রেণি', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 3000,
			'badge'    => __( 'অফলাইন', 'coaching-centre' ),
			'features' => __( "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A", 'coaching-centre' ),
		),
		array(
			'title'    => __( '৭ম শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
			'class'    => __( '৭ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 3000,
			'badge'    => __( 'অফলাইন', 'coaching-centre' ),
			'features' => __( "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A", 'coaching-centre' ),
		),
		array(
			'title'    => __( '৮ম শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
			'class'    => __( '৮ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 3200,
			'badge'    => __( 'অফলাইন', 'coaching-centre' ),
			'features' => __( "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A", 'coaching-centre' ),
		),
		array(
			'title'    => __( '৯ম শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
			'class'    => __( '৯ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 3500,
			'badge'    => __( 'অফলাইন', 'coaching-centre' ),
			'group'    => __( 'বিজ্ঞান', 'coaching-centre' ),
			'features' => __( "বিজ্ঞান/ব্যবসায়/মানবিক গ্রুপ\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস ও বই", 'coaching-centre' ),
		),
		array(
			'title'    => __( '১০ম শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
			'class'    => __( '১০ম শ্রেণি (SSC)', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 3500,
			'badge'    => __( 'অফলাইন', 'coaching-centre' ),
			'group'    => __( 'বিজ্ঞান', 'coaching-centre' ),
			'features' => __( "বোর্ড স্ট্যান্ডার্ড পরীক্ষার প্রস্তুতি\nপ্রশ্নব্যাংক ও সলভ শিট\nরিভিশন ক্লাস", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'PSC বৃত্তি প্রস্তুতি (প্রশ্নব্যাংক ও মডেল টেস্ট)', 'coaching-centre' ),
			'class'    => __( '৫ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'scholar',
			'fee'      => 1500,
			'badge'    => __( 'বৃত্তি', 'coaching-centre' ),
			'features' => __( "প্রশ্নব্যাংক ও মডেল টেস্ট\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'JSC বৃত্তি প্রস্তুতি (প্রশ্নব্যাংক ও মডেল টেস্ট)', 'coaching-centre' ),
			'class'    => __( '৮ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'scholar',
			'fee'      => 1800,
			'badge'    => __( 'বৃত্তি', 'coaching-centre' ),
			'features' => __( "প্রশ্নব্যাংক ও মডেল টেস্ট\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'SSC মডেল টেস্ট', 'coaching-centre' ),
			'class'    => __( '১০ম শ্রেণি (SSC)', 'coaching-centre' ),
			'cat'      => 'ssc',
			'fee'      => 1800,
			'badge'    => __( 'মডেল টেস্ট', 'coaching-centre' ),
			'features' => __( "বোর্ড অনুরূপ মডেল টেস্ট\nপ্রিন্টেড প্রশ্নব্যাংক\nএনালাইসিস রিপোর্ট", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'বাংলা-ইংলিশ ফুল কোর্স', 'coaching-centre' ),
			'class'    => __( '৯ম শ্রেণি', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 2000,
			'badge'    => __( 'ফুল কোর্স', 'coaching-centre' ),
			'features' => __( "ইংরেজি ব্যাকরণ ও লেখা\nবাংলা ভাষার শক্তি\nপ্রশ্নোত্তর অনুশীলনী", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'বাংলা-ইংলিশ ফুল কোর্স', 'coaching-centre' ),
			'class'    => __( '১০ম শ্রেণি (SSC)', 'coaching-centre' ),
			'cat'      => 'acad',
			'fee'      => 2000,
			'badge'    => __( 'ফুল কোর্স', 'coaching-centre' ),
			'features' => __( "ইংরেজি ব্যাকরণ ও লেখা\nবাংলা ভাষার শক্তি\nপ্রশ্নোত্তর অনুশীলনী", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি', 'coaching-centre' ),
			'class'    => __( 'ক্যাডেট প্রস্তুতি', 'coaching-centre' ),
			'cat'      => 'cadet',
			'fee'      => 4000,
			'badge'    => __( 'ক্যাডেট', 'coaching-centre' ),
			'features' => __( "এক্স-ক্যাডেট শিক্ষক\nলিখিত, মৌখিক ও ইন্টারভিউ\nবাংলা ও ইংরেজি ভার্সন", 'coaching-centre' ),
		),
		array(
			'title'    => __( 'ক্যাডেট SSC স্পেশাল মডেল টেস্ট', 'coaching-centre' ),
			'class'    => __( 'ক্যাডেট প্রস্তুতি', 'coaching-centre' ),
			'cat'      => 'cadet',
			'fee'      => 1500,
			'badge'    => __( 'ক্যাডেট', 'coaching-centre' ),
			'features' => __( "বিশেষায়িত প্রশ্নব্যাংক\nমডেল টেস্ট ও বিশ্লেষণ\nমক ইন্টারভিউ", 'coaching-centre' ),
		),
	);

	/* The weekly exam is bookable from the home page form, not the grid. */
	foreach ( $weekly as $class ) {
		$courses[] = array(
			'title'    => __( 'সাপ্তাহিক মডেল পরীক্ষা', 'coaching-centre' ),
			'class'    => $class,
			'cat'      => 'acad',
			'fee'      => 50,
			'badge'    => __( 'সাপ্তাহিক পরীক্ষা', 'coaching-centre' ),
			'hidden'   => true,
			'features' => __( "প্রতি সপ্তাহে MCQ মডেল পরীক্ষা\nতাৎক্ষণিক ফলাফল ও সলভ শিট\nমেধাতালিকায় অবস্থান", 'coaching-centre' ),
		);
	}

	return $courses;
}

/**
 * Insert the demo courses.
 */
function cc_seed_courses() {
	$order = 0;

	foreach ( cc_demo_courses() as $course ) {
		$order += 10;

		$existing = get_posts(
			array(
				'post_type'      => 'cc_course',
				'post_status'    => 'any',
				'title'          => $course['title'],
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_query'     => array(
					array(
						'key'   => '_cc_class',
						'value' => $course['class'],
					),
				),
			)
		);

		if ( $existing ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cc_course',
				'post_status'  => 'publish',
				'post_title'   => $course['title'],
				'post_content' => '',
				'menu_order'   => $order,
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		update_post_meta( $post_id, '_cc_class', $course['class'] );
		update_post_meta( $post_id, '_cc_fee', $course['fee'] );
		update_post_meta( $post_id, '_cc_modes', __( 'অফলাইন', 'coaching-centre' ) );
		update_post_meta( $post_id, '_cc_badge', $course['badge'] );
		update_post_meta( $post_id, '_cc_features', $course['features'] );

		if ( ! empty( $course['group'] ) ) {
			update_post_meta( $post_id, '_cc_group', $course['group'] );
		}

		if ( ! empty( $course['hidden'] ) ) {
			update_post_meta( $post_id, '_cc_hidden', '1' );
		}

		wp_set_object_terms( $post_id, $course['cat'], 'cc_course_cat', false );
		cc_tag_demo( $post_id );
	}
}

/**
 * Insert the demo teachers.
 */
function cc_seed_teachers() {
	$teachers = array(
		array( __( 'মোঃ শাহেদুর রহমান', 'coaching-centre' ), __( 'গণিত বিভাগ', 'coaching-centre' ), __( 'সহকারী অধ্যাপক', 'coaching-centre' ) ),
		array( __( 'সালমা খাতুন', 'coaching-centre' ), __( 'ইংরেজি বিভাগ', 'coaching-centre' ), __( 'সহকারী অধ্যাপক', 'coaching-centre' ) ),
		array( __( 'ড. মোহাম্মদ হাসিব', 'coaching-centre' ), __( 'বিজ্ঞান বিভাগ', 'coaching-centre' ), __( 'অধ্যাপক', 'coaching-centre' ) ),
		array( __( 'জান্নাতুল ফেরদৌস', 'coaching-centre' ), __( 'বাংলা বিভাগ', 'coaching-centre' ), __( 'সহকারী অধ্যাপক', 'coaching-centre' ) ),
	);

	$order = 0;

	foreach ( $teachers as $teacher ) {
		$order += 10;

		$exists = get_posts(
			array(
				'post_type'      => 'cc_teacher',
				'post_status'    => 'any',
				'title'          => $teacher[0],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $exists ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => 'cc_teacher',
				'post_status' => 'publish',
				'post_title'  => $teacher[0],
				'menu_order'  => $order,
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		update_post_meta( $post_id, '_cc_subject', $teacher[1] );
		update_post_meta( $post_id, '_cc_designation', $teacher[2] );
		cc_tag_demo( $post_id );
	}
}

/**
 * Insert the demo testimonials.
 */
function cc_seed_testimonials() {
	$quotes = array(
		array(
			__( 'নিয়মিত পরীক্ষা আর Q&A সাপোর্টের কারণে গণিত নিয়ে ভয় কেটে গেছে।', 'coaching-centre' ),
			__( 'রাফিউল ইসলাম', 'coaching-centre' ),
			__( 'শিক্ষার্থী, SSC', 'coaching-centre' ),
		),
		array(
			__( 'প্রতিটি পরীক্ষার ফল SMS-এ পাই, তাই সন্তানের অগ্রগতি সহজে বুঝি।', 'coaching-centre' ),
			__( 'আব্দুল করিম', 'coaching-centre' ),
			__( 'অভিভাবক', 'coaching-centre' ),
		),
		array(
			__( 'সাপ্তাহিক পরীক্ষায় অংশ নিয়ে প্রস্তুতির ঘাটতি ধরতে পেরেছি।', 'coaching-centre' ),
			__( 'জান্নাতুল ফেরদৌস', 'coaching-centre' ),
			__( 'শিক্ষার্থী, JSC', 'coaching-centre' ),
		),
	);

	$order = 0;

	foreach ( $quotes as $quote ) {
		$order += 10;

		$exists = get_posts(
			array(
				'post_type'      => 'cc_testimonial',
				'post_status'    => 'any',
				'title'          => $quote[1],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $exists ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cc_testimonial',
				'post_status'  => 'publish',
				'post_title'   => $quote[1],
				'post_content' => $quote[0],
				'menu_order'   => $order,
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		update_post_meta( $post_id, '_cc_role', $quote[2] );
		cc_tag_demo( $post_id );
	}
}

/**
 * Insert the demo FAQs.
 */
function cc_seed_faqs() {
	$faqs = array(
		array(
			__( 'সাপ্তাহিক পরীক্ষায় কারা অংশ নিতে পারবে?', 'coaching-centre' ),
			__( 'যে কেউ রেজিস্ট্রেশন ও নির্ধারিত ফি প্রদান করে অংশ নিতে পারবে; আমাদের শিক্ণার্থী হওয়া আবশ্যক নয়।', 'coaching-centre' ),
		),
		array(
			__( 'পরীক্ষার ফলাফল কখন পাওয়া যাবে?', 'coaching-centre' ),
			__( 'পরীক্ষা শেষে সঙ্গে সঙ্গে স্কোর এবং পরে মেধাতালিকা ও সলভ শিট পাওয়া যাবে।', 'coaching-centre' ),
		),
		array(
			__( 'ভর্তি কীভাবে হবে?', 'coaching-centre' ),
			__( 'ওয়েবসাইটের এই ফর্মটি পূরণ করতে পারেন, অথবা সরাসরি শাখায় এসে ফর্ম পূরণ করে অফলাইন ভর্তির সুযোগ আছে।', 'coaching-centre' ),
		),
		array(
			__( 'ফ্রি ট্রায়াল ক্লাস আছে কি?', 'coaching-centre' ),
			__( 'নির্বাচিত শ্রেণিতে ট্রায়াল ক্লাসের সুযোগ রয়েছে। বিস্তারিত জানতে যোগাযোগ করুন।', 'coaching-centre' ),
		),
	);

	$order = 0;

	foreach ( $faqs as $faq ) {
		$order += 10;

		$exists = get_posts(
			array(
				'post_type'      => 'cc_faq',
				'post_status'    => 'any',
				'title'          => $faq[0],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $exists ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'cc_faq',
				'post_status'  => 'publish',
				'post_title'   => $faq[0],
				'post_content' => $faq[1],
				'menu_order'   => $order,
			)
		);

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			cc_tag_demo( $post_id );
		}
	}
}

/**
 * Insert a few sample registrations.
 */
function cc_seed_registrations() {
	$samples = array(
		array(
			'code'     => 'GD-2026-48215',
			'date'     => '2026-09-28 10:12:00',
			'status'   => 'cc-confirmed',
			'values'   => array(
				'_cc_kind'           => 'admission',
				'_cc_student_bn'     => __( 'রফিউল ইসলাম', 'coaching-centre' ),
				'_cc_student_en'     => 'Rafiqul Islam',
				'_cc_dob'            => '2015-03-12',
				'_cc_gender'         => __( 'ছেলে', 'coaching-centre' ),
				'_cc_student_mobile' => '01712345678',
				'_cc_email'          => 'rafi@example.com',
				'_cc_school'         => __( 'ঠাকুরগাঁও মডেল হাইস্কুল', 'coaching-centre' ),
				'_cc_address'        => __( 'ঠাকুরগাঁও সদর', 'coaching-centre' ),
				'_cc_class'          => __( '১০ম শ্রেণি (SSC)', 'coaching-centre' ),
				'_cc_program'        => __( '১০ম শ্রেণি একাডেমিক প্রোগ্রাম', 'coaching-centre' ),
				'_cc_group'          => __( 'বিজ্ঞান', 'coaching-centre' ),
				'_cc_version'        => __( 'বাংলা', 'coaching-centre' ),
				'_cc_mode'           => __( 'অফলাইন', 'coaching-centre' ),
				'_cc_branch'         => __( 'মূল শাখা', 'coaching-centre' ),
				'_cc_last_result'    => 'GPA 4.83',
				'_cc_father'         => __( 'আব্দুল করিম', 'coaching-centre' ),
				'_cc_mother'         => __( 'সালমা বেগম', 'coaching-centre' ),
				'_cc_guardian_mobile' => '01798765432',
				'_cc_occupation'     => __( 'কৃষি', 'coaching-centre' ),
				'_cc_source'         => __( 'ফেসবুক', 'coaching-centre' ),
				'_cc_payment'        => 'bKash',
				'_cc_fee'            => 3500,
			),
		),
		array(
			'code'     => 'GD-2026-59307',
			'date'     => '2026-10-01 14:35:00',
			'status'   => 'cc-pending',
			'values'   => array(
				'_cc_kind'           => 'admission',
				'_cc_student_bn'     => __( 'তানভীর আহমেদ', 'coaching-centre' ),
				'_cc_student_en'     => 'Tanvir Ahmed',
				'_cc_dob'            => '2014-07-25',
				'_cc_gender'         => __( 'ছেলে', 'coaching-centre' ),
				'_cc_student_mobile' => '01812345678',
				'_cc_email'          => '',
				'_cc_school'         => __( 'পিপুলস হাইস্কুল', 'coaching-centre' ),
				'_cc_address'        => __( 'ঢাকা মিরপুর', 'coaching-centre' ),
				'_cc_class'          => __( '৯ম শ্রেণি', 'coaching-centre' ),
				'_cc_program'        => __( 'বাংলা-ইংলিশ ফুল কোর্স', 'coaching-centre' ),
				'_cc_group'          => __( 'বিজ্ঞান', 'coaching-centre' ),
				'_cc_version'        => __( 'ইংরেজি', 'coaching-centre' ),
				'_cc_mode'           => __( 'অফলাইন', 'coaching-centre' ),
				'_cc_branch'         => __( 'মিরপুর', 'coaching-centre' ),
				'_cc_last_result'    => 'GPA 4.61',
				'_cc_father'         => __( 'মোঃ নাসিম', 'coaching-centre' ),
				'_cc_mother'         => __( 'রুবিনা ইয়াসমিন', 'coaching-centre' ),
				'_cc_guardian_mobile' => '01898765432',
				'_cc_occupation'     => __( 'ব্যবসা', 'coaching-centre' ),
				'_cc_source'         => __( 'বন্ধু/আত্মীয়', 'coaching-centre' ),
				'_cc_payment'        => 'Nagad',
				'_cc_fee'            => 2000,
			),
		),
		array(
			'code'     => 'GD-2026-61440',
			'date'     => '2026-10-02 09:20:00',
			'status'   => 'cc-completed',
			'values'   => array(
				'_cc_kind'           => 'exam',
				'_cc_student_bn'     => __( 'জান্নাতুল ফেরদৌস', 'coaching-centre' ),
				'_cc_student_en'     => 'Zannatul Ferdous',
				'_cc_dob'            => '2016-01-08',
				'_cc_gender'         => __( 'মেয়ে', 'coaching-centre' ),
				'_cc_student_mobile' => '01912345678',
				'_cc_email'          => 'zf@example.com',
				'_cc_school'         => __( 'আদর্শ সরকারি মহিলা', 'coaching-centre' ),
				'_cc_address'        => __( 'ঠাকুরগাঁও', 'coaching-centre' ),
				'_cc_class'          => __( '৮ম শ্রেণি', 'coaching-centre' ),
				'_cc_program'        => __( 'সাপ্তাহিক মডেল পরীক্ষা', 'coaching-centre' ),
				'_cc_group'          => '',
				'_cc_version'        => __( 'বাংলা', 'coaching-centre' ),
				'_cc_mode'           => __( 'অফলাইন', 'coaching-centre' ),
				'_cc_branch'         => __( 'ধানমন্ডি', 'coaching-centre' ),
				'_cc_last_result'    => 'GPA 4.90',
				'_cc_father'         => __( 'আবুল কালাম', 'coaching-centre' ),
				'_cc_mother'         => __( 'নাজমা সুলতানা', 'coaching-centre' ),
				'_cc_guardian_mobile' => '01998765432',
				'_cc_occupation'     => __( 'শিক্ষক', 'coaching-centre' ),
				'_cc_source'         => __( 'ইউটিউব', 'coaching-centre' ),
				'_cc_payment'        => __( 'কার্ড', 'coaching-centre' ),
				'_cc_fee'            => 50,
			),
		),
	);

	foreach ( $samples as $sample ) {
		$values  = $sample['values'];
		$name    = $values['_cc_student_bn'];
		$class   = $values['_cc_class'];
		$mobile  = $values['_cc_student_mobile'];
		$title   = trim( $name . ' — ' . $class . ' (' . $mobile . ')' );

		$existing = get_posts(
			array(
				'post_type'      => 'cc_registration',
				'post_status'    => 'any',
				'title'          => $title,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $existing ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => 'cc_registration',
				'post_status' => $sample['status'],
				'post_title'  => $title,
				'post_date'   => $sample['date'],
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		$values['_cc_code'] = $sample['code'];

		foreach ( $values as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		cc_tag_demo( $post_id );
	}
}

/**
 * Insert a sample contact message.
 */
function cc_seed_message() {
	if ( get_posts(
		array(
			'post_type'      => 'cc_message',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	) ) {
		return;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'cc_message',
			'post_status' => 'publish',
			'post_title'  => __( 'কামাল হোসেন', 'coaching-centre' ),
		)
	);

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_cc_msg_name', __( 'কামাল হোসেন', 'coaching-centre' ) );
	update_post_meta( $post_id, '_cc_msg_mobile', '01612345678' );
	update_post_meta( $post_id, '_cc_msg_topic', __( 'কোর্স ও ফি', 'coaching-centre' ) );
	update_post_meta( $post_id, '_cc_msg_body', __( 'আসল্পুর ভাই, ৯ম শ্রেণিতে ভর্তির ফি কত এবং কবে ফি কমানো হবে জানাবেন।', 'coaching-centre' ) );
	update_post_meta( $post_id, '_cc_msg_source', wp_parse_url( home_url(), PHP_URL_HOST ) );
	update_post_meta( $post_id, '_cc_msg_read', 0 );
	cc_tag_demo( $post_id );
}

/**
 * Seed the whole demo library.
 */
function cc_seed_demo_content() {
	if ( ! cc_needs_demo() ) {
		return;
	}

	cc_register_post_types();
	cc_register_post_statuses();
	cc_seed_terms();

	cc_seed_pages();
	cc_seed_courses();
	cc_seed_teachers();
	cc_seed_testimonials();
	cc_seed_faqs();
	cc_seed_registrations();
	cc_seed_message();

	update_option( 'cc_demo_seeded', '1' );
}
add_action( 'after_switch_theme', 'cc_seed_demo_content', 5 );

/**
 * Every demo post the theme created.
 *
 * @return int[]
 */
function cc_demo_post_ids() {
	return get_posts(
		array(
			'post_type'   => array( 'cc_course', 'cc_teacher', 'cc_testimonial', 'cc_faq', 'cc_registration', 'cc_message', 'page' ),
			'post_status' => 'any',
			'posts_per_page' => -1,
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'key'   => '_cc_demo',
					'value' => '1',
				),
			),
		)
	);
}

/**
 * Re-insert the demo library.
 */
function cc_admin_seed_demo() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'আপনার এই কাজটি করার অনুমতি নেই।', 'coaching-centre' ) );
	}

	check_admin_referer( 'cc_seed_demo', 'cc_nonce' );

	delete_option( 'cc_demo_seeded' );
	cc_seed_demo_content();

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'         => 'cc-dashboard',
				'cc_notice'    => 'seeded',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_cc_seed_demo', 'cc_admin_seed_demo' );

/**
 * Delete every demo post again.
 */
function cc_admin_remove_demo() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'আপনার এই কাজটি করার অনুমতি নেই।', 'coaching-centre' ) );
	}

	check_admin_referer( 'cc_remove_demo', 'cc_nonce' );

	foreach ( cc_demo_post_ids() as $post_id ) {
		wp_delete_post( $post_id, true );
	}

	update_option( 'cc_demo_seeded', '' );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'      => 'cc-dashboard',
				'cc_notice' => 'removed',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_cc_remove_demo', 'cc_admin_remove_demo' );