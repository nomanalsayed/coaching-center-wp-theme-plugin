<?php
/**
 * Helper functions, defaults and sanitizers.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default value for every theme mod used by the theme.
 *
 * @return array
 */
function cc_defaults() {
	return array(
		/* General */
		'cc_logo_text'  => '🎓 জ্ঞানদীপ একাডেমিক কেয়ার',
		'cc_phone'      => '০১XXX-XXXXXX',
		'cc_phone_link' => '+8801000000000',
		'cc_whatsapp'   => '8801000000000',
		'cc_email'      => 'info@example.com',
		'cc_address'    => 'বাড়ি-০০, রোড-০০, ঢাকা',
		'cc_map_embed'  => '',
		'cc_dark_mode'  => false,
		'cc_open_hours' => "শনি – বৃহস্পতিবার|সকাল ৯টা – রাত ৮টা\nশুক্রবার|সকাল ১০টা – দুপুর ১টা",

		/* Home */
		'cc_hero_image'    => 0,
		'cc_hero_tag'      => '৬ষ্ঠ–১০ম শ্রেণি • JSC • PSC • SSC • ক্যাডেট',
		'cc_hero_title'    => "সঠিক গাইডলাইনে\nসেরা প্রস্তুতি, সেরা ফলাফল",
		'cc_hero_text'     => 'অভিজ্ঞ শিক্ষক, কনসেপ্ট-বেইজড ক্লাস, নিয়মিত পরীক্ষা ও সার্বক্ষণিক Q&A সাপোর্ট — সব ক্লাস সরাসরি ক্লাসরুমে।',
		'cc_hero_btn1_txt' => 'এখনই ভর্তি হোন',
		'cc_hero_btn2_txt' => 'সাপ্তাহিক পরীক্ষায় অংশ নিন',

		'cc_stats' => array(
			array(
				'value' => '১০,০০০+',
				'label' => 'শিক্ষার্থী',
			),
			array(
				'value' => '৫০+',
				'label' => 'অভিজ্ঞ শিক্ষক',
			),
			array(
				'value' => '৯৮%',
				'label' => 'GPA-5 সাফল্য',
			),
			array(
				'value' => '১২+',
				'label' => 'বছরের অভিজ্ঞতা',
			),
		),

		'cc_features_title' => 'কেন আমরা আলাদা?',
		'cc_features_sub'   => 'শুধু ক্লাস নয় — পূর্ণাঙ্গ একাডেমিক কেয়ার।',
		'cc_features'       => array(
			array(
				'ico'   => '👨‍🏫',
				'title' => 'মেধাবী শিক্ষক',
				'text'  => 'দেশসেরা বিশ্ববিদ্যালয়ের অভিজ্ঞ শিক্ষকদের ক্লাস।',
			),
			array(
				'ico'   => '💡',
				'title' => 'কনসেপ্ট বেইজড ক্লাস',
				'text'  => 'মুখস্থ নয়, বুঝে শেখার সহজ পদ্ধতি।',
			),
			array(
				'ico'   => '📝',
				'title' => 'নিয়মিত পরীক্ষা',
				'text'  => 'ক্লাস টেস্ট, অধ্যায়ভিত্তিক ও মডেল টেস্ট।',
			),
			array(
				'ico'   => '💬',
				'title' => 'সার্বক্ষণিক Q&A',
				'text'  => 'যেকোনো সময় ডাউট সলভিংয়ের সুযোগ।',
			),
			array(
				'ico'   => '📊',
				'title' => 'পারফরম্যান্স রিপোর্ট',
				'text'  => 'পরীক্ষার পর বিশ্লেষণ ও মেধাতালিকা।',
			),
			array(
				'ico'   => '📱',
				'title' => 'SMS-এ রেজাল্ট',
				'text'  => 'অভিভাবকের মোবাইলে সরাসরি ফল ও উপস্থিতি।',
			),
			array(
				'ico'   => '📚',
				'title' => 'স্টাডি ম্যাটেরিয়াল',
				'text'  => 'প্রিন্টেড নোট, প্রশ্নব্যাংক ও সলভ শিট।',
			),
			array(
				'ico'   => '🏫',
				'title' => 'সরাসরি ক্লাসরুম',
				'text'  => 'স্মার্টবোর্ড রুম, ছোট গ্রুপে ব্যক্তিগত মনোযোগ।',
			),
		),

		'cc_programs_title' => 'আমাদের কোর্সসমূহ',
		'cc_programs_sub'   => 'শ্রেণি ও লক্ষ্য অনুযায়ী বেছে নিন আপনার উপযোগী প্রোগ্রাম।',

		'cc_exam_image'     => 0,
		'cc_exam_title'     => 'সাপ্তাহিক মডেল পরীক্ষা',
		'cc_exam_text'      => 'আমাদের শিক্ষার্থী হওয়া জরুরি নয় — রেজিস্ট্রেশন করে যে কেউ অংশ নিতে পারবে।',
		'cc_exam_points'    => "প্রতি সপ্তাহে নির্ধারিত দিনে MCQ মডেল পরীক্ষা\n৬ষ্ঠ থেকে ১০ম, JSC, PSC ও ক্যাডেট প্রস্তুতির আলাদা সেট\nপরীক্ষা শেষে তাৎক্ষণিক ফলাফল ও সলভ শিট\nসারাদেশের মেধাতালিকায় নিজের অবস্থান জানুন",
		'cc_exam_price'     => '৫০',
		'cc_exam_payment'   => 'bKash / Nagad / কার্ড',
		'cc_exam_class_opt' => "৫ম (PSC)\n৬ষ্ঠ\n৭ম\n৮ম (JSC)\n৯ম\n১০ম (SSC)\nক্যাডেট ভর্তি প্রস্তুতি",

		'cc_cadet_image'  => 0,
		'cc_cadet_tag'    => 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি',
		'cc_cadet_title'  => 'ক্যাডেট কোচিং',
		'cc_cadet_text'   => 'ক্যাডেট কলেজে চান্স পাওয়ার স্বপ্ন পূরণে বিশেষ প্রস্তুতি।',
		'cc_cadet_points' => "এক্স-ক্যাডেট শিক্ষকদের ইন্টারেক্টিভ ক্লাস\nবাংলা, ইংরেজি, গণিত ও সাধারণ জ্ঞানের পূর্ণ প্রস্তুতি\nলিখিত, মৌখিক ও ইন্টারভিউ প্রস্তুতি\nমডেল টেস্ট, প্রশ্নব্যাংক ও সলভ ক্লাস\nবাংলা ও ইংরেজি ভার্সনে আলাদা ব্যাচ",

		'cc_teachers_title' => 'আমাদের শিক্ষকমণ্ডলী',
		'cc_teachers_sub'   => 'অভিজ্ঞ ও আন্তরিক শিক্ষকদের সান্নিধ্যে শিখুন।',

		'cc_quotes_title' => 'শিক্ষার্থী ও অভিভাবকদের মতামত',
		'cc_quotes_sub'   => 'আমাদের সাফল্যের গল্প।',

		'cc_cta_title' => 'আজই ভর্তি হোন, প্রস্তুতি শুরু করুন',
		'cc_cta_text'  => 'সীমিত আসন। সরাসরি শাখায় আসুন অথবা ফোন করুন।',
		'cc_cta_link'  => 'tel',

		'cc_faq_title' => 'সাধারণ জিজ্ঞাসা',

		/* About */
		'cc_about_heading' => 'শেখাকে আনন্দের, সাফল্যকে নিশ্চিত করাই আমাদের লক্ষ্য',
		'cc_about_intro'   => '৫ম থেকে ১০ম শ্রেণি, JSC, PSC, SSC ও ক্যাডেট প্রস্তুতিতে বছরের পর বছর ধরে আমরা শিক্ষার্থীদের পাশে আছি।',
		'cc_about_image'   => 0,
		'cc_about_story_1' => 'একটি ছোট কক্ষ আর হাতে গোনা কয়েকজন শিক্ষার্থী নিয়ে আমাদের যাত্রা শুরু। লক্ষ্য ছিল একটাই — মুখস্থ নয়, বুঝে শেখার সংস্কৃতি তৈরি করা।',
		'cc_about_story_2' => 'আজ আমরা সরাসরি ক্লাসরুমে হাজারো শিক্ষার্থীকে সহায়তা করছি। প্রতিটি শিক্ষার্থীর প্রতি ব্যক্তিগত মনোযোগ আমাদের শক্তি।',
		'cc_about_stats'   => array(
			array(
				'value' => '১২+',
				'label' => 'বছরের অভিজ্ঞতা',
			),
			array(
				'value' => '১০,০০০+',
				'label' => 'শিক্ষার্থী',
			),
			array(
				'value' => '৫০+',
				'label' => 'অভিজ্ঞ শিক্ষক',
			),
			array(
				'value' => '৩টি',
				'label' => 'শাখা',
			),
			array(
				'value' => '৯৮%',
				'label' => 'GPA-5 সাফল্য',
			),
		),
		'cc_mv' => array(
			array(
				'ico'   => '🎯',
				'title' => 'আমাদের লক্ষ্য',
				'text'  => 'মানসম্মত শিক্ষা সবার কাছে সহজলভ্য করা এবং প্রতিটি শিক্ষার্থীর সম্ভাবনা বিকশিত করা।',
			),
			array(
				'ico'   => '🔭',
				'title' => 'আমাদের দৃষ্টিভঙ্গি',
				'text'  => 'দেশের অন্যতম বিশ্বস্ত একাডেমিক কেয়ার প্রতিষ্ঠান হিসেবে নিজেদের গড়ে তোলা।',
			),
			array(
				'ico'   => '💎',
				'title' => 'আমাদের মূল্যবোধ',
				'text'  => 'সততা, নিষ্ঠা, স্বচ্ছতা এবং শিক্ষার্থীর কল্যাণকে সবার আগে রাখা।',
			),
		),
		'cc_timeline' => array(
			array(
				'year' => '২০১৪',
				'text' => 'প্রথম ব্যাচ নিয়ে যাত্রা শুরু।',
			),
			array(
				'year' => '২০১৭',
				'text' => 'JSC ও PSC বৃত্তি প্রস্তুতি কোর্স চালু।',
			),
			array(
				'year' => '২০২০',
				'text' => 'ডিজিটাল ফলাফল ব্যবস্থা ও মডেল টেস্ট চালু।',
			),
			array(
				'year' => '২০২৩',
				'text' => 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি কোর্স চালু।',
			),
			array(
				'year' => '২০২৬',
				'text' => 'সবার জন্য উন্মুক্ত সাপ্তাহিক মডেল পরীক্ষা শুরু।',
			),
		),
		'cc_method' => array(
			array(
				'ico'   => '💡',
				'title' => 'কনসেপ্ট বেইজড ক্লাস',
				'text'  => 'মূল ধারণা পরিষ্কার করে পড়ানো হয়।',
			),
			array(
				'ico'   => '📝',
				'title' => 'নিয়মিত মূল্যায়ন',
				'text'  => 'ক্লাস টেস্ট, মডেল টেস্ট ও সাপ্তাহিক পরীক্ষা।',
			),
			array(
				'ico'   => '📊',
				'title' => 'পারফরম্যান্স বিশ্লেষণ',
				'text'  => 'দুর্বল জায়গা চিহ্নিত করে সমাধান।',
			),
			array(
				'ico'   => '💬',
				'title' => 'সার্বক্ষণিক Q&A',
				'text'  => 'ডাউট সলভিংয়ে যেকোনো সময় সহায়তা।',
			),
		),
		'cc_chair_image'  => 0,
		'cc_chair_name'   => 'নাম এখানে',
		'cc_chair_role'   => 'অধ্যক্ষ ও প্রতিষ্ঠাতা',
		'cc_chair_quote'  => 'প্রতিটি শিক্ষার্থীর মধ্যে অসীম সম্ভাবনা লুকিয়ে আছে। আমাদের কাজ সেই সম্ভাবনাকে সঠিক পথে এগিয়ে নেওয়া। আপনার সন্তানের ভবিষ্যৎ গড়ার পথে আমরা আপনার বিশ্বস্ত সঙ্গী।',
		'cc_facilities'   => array(
			'আধুনিক স্মার্টবোর্ড ক্লাসরুম',
			'স্মার্টবোর্ড ও মাল্টিমিডিয়া ক্লাসরুম',
			'ছেলে ও মেয়েদের জন্য আলাদা ব্যবস্থা',
			'অভিভাবকের মোবাইলে SMS রেজাল্ট',
			'প্রিন্টেড স্টাডি ম্যাটেরিয়ালস',
		),
		'cc_achievements' => array(
			'বছরের পর বছর GPA-5 সাফল্যের ধারা',
			'বৃত্তি পরীক্ষায় উল্লেখযোগ্য ফলাফল',
			'ক্যাডেট কলেজে ধারাবাহিক চান্স',
			'অভিভাবকদের আস্থা ও সন্তুষ্টি',
		),

		/* Contact */
		'cc_contact_heading'  => 'আমাদের সাথে যোগাযোগ করুন',
		'cc_contact_intro'    => 'ভর্তি, কোর্স বা পরীক্ষা সংক্রান্ত যেকোনো প্রশ্নে আমরা আছি আপনার পাশে।',
		'cc_contact_topics'   => "ভর্তি সংক্রান্ত\nকোর্স ও ফি\nসাপ্তাহিক মডেল পরীক্ষা\nক্যাডেট কোচিং\nঅভিযোগ / পরামর্শ\nঅন্যান্য",
		'cc_branch_label'     => 'আমাদের শাখাসমূহ',
		'cc_map_title'        => 'ম্যাপে খুঁজুন',
		'cc_branches'         => array(
			array(
				'name'    => 'ধানমন্ডি শাখা',
				'address' => 'রোড-০০, ধানমন্ডি, ঢাকা',
				'phone'   => '০১XXX-XXXXXX',
				'map'     => '',
			),
			array(
				'name'    => 'মিরপুর শাখা',
				'address' => 'সেকশন-০০, মিরপুর, ঢাকা',
				'phone'   => '০১XXX-XXXXXX',
				'map'     => '',
			),
			array(
				'name'    => 'উত্তরা শাখা',
				'address' => 'সেক্টর-০০, উত্তরা, ঢাকা',
				'phone'   => '০১XXX-XXXXXX',
				'map'     => '',
			),
		),

		/* Registration */
		'cc_reg_heading'         => 'ভর্তি ফর্ম',
		'cc_reg_sub'             => 'নিচের ফর্মটি পূরণ করে জমা দিন। আমাদের প্রতিনিধি আপনার সাথে ফোনে যোগাযোগ করে ভর্তি নিশ্চিত করবেন।',
		'cc_reg_steps'           => "ফর্ম পূরণ করুন\nআমরা ফোন করি\nসেশন ফি পরিশোধ\nভর্তি ও প্রথম ক্লাস",
		'cc_reg_documents'       => "শিক্ষার্থীর ১টি ছবি (পাসপোর্ট সাইজ)\nসর্বশেষ পরীক্ষার রিপোর্ট কার্ড\nঅভিভাবকের পরিচয়পত্রের ছবি\nটাকার ১ মাসের ফি (পেমেন্ট করলে)",
		'cc_reg_payment_methods' => "পেমেন্ট ওআরপি ব্যাংক বা বিকাশ/নগদ\nক্যাশে সরাসরি শাখায়",
		'cc_reg_versions'        => "বাংলা\nইংরেজি",
		'cc_reg_groups'          => "বিজ্ঞান\nব্যবসায় শিক্ষা\nমানবিক",
		'cc_reg_sources'         => "ফেসবুক\nহোয়াটসঅ্যাপ\nবন্ধুর পরামর্শ\nফেসবুক গ্রুপ\nপথে দেখে\nঅন্যান্য",
		'cc_reg_terms'           => 'আমি এই ফর্মের তথ্য সঠিক বলে নিশ্চিত করছি এবং কোচিং সেন্টারের নিয়মাবলী মেনে চলিতে সম্মত।',

		/* Footer & social */
		'cc_footer_about'  => 'ঠাকুরগাঁও জেলার নির্ভরযোগ্য কোচিং সেন্টার। ৬ষ্ঠ–১০ম, JSC, PSC, SSC ও ক্যাডেট কোচিংয়ে মানসম্মত শিক্ষা ও যত্নশীল পাঠদান।',
		'cc_copyright'     => 'জ্ঞানদীপ একাডেমিক কেয়ার। সর্বস্বত্ব সংরক্ষিত।',
		'cc_social'        => array(
			'facebook'  => '',
			'youtube'   => '',
			'instagram' => '',
			'telegram'  => '',
		),
	);
}

/**
 * Read a theme mod with its default fallback.
 *
 * @param string $key Theme mod key.
 * @return mixed
 */
function cc_opt( $key ) {
	$defaults = cc_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	return get_theme_mod( $key, $default );
}

if ( ! function_exists( 'cc_hp' ) ) {
	/**
	 * Read front page Meta Box meta with fallback to Customizer theme mod.
	 *
	 * @param string $meta_key Meta Box key (e.g. '_hp_hero_title').
	 * @param string $mod_key  Optional theme mod fallback key (e.g. 'cc_hero_title').
	 * @param mixed  $default  Optional fallback if both are empty.
	 * @return mixed
	 */
	function cc_hp( $meta_key, $mod_key = '', $default = '' ) {
		$front_id = (int) get_option( 'page_on_front' );
		$val      = '';

		if ( $front_id && function_exists( 'rwmb_meta' ) ) {
			$val = rwmb_meta( $meta_key, array(), $front_id );
		}

		if ( ( '' === $val || null === $val || false === $val || array() === $val ) && $front_id ) {
			$val = get_post_meta( $front_id, $meta_key, true );
		}

		if ( '' !== $val && null !== $val && false !== $val && array() !== $val ) {
			return $val;
		}

		if ( $mod_key ) {
			return cc_opt( $mod_key );
		}

		// Try stripping leading _hp_ to find matching cc_* mod key if not specified.
		if ( 0 === strpos( $meta_key, '_hp_' ) ) {
			$auto_mod_key = 'cc_' . substr( $meta_key, 4 );
			$mod_val      = cc_opt( $auto_mod_key );
			if ( '' !== $mod_val && null !== $mod_val && false !== $mod_val && array() !== $mod_val ) {
				return $mod_val;
			}
		}

		return $default;
	}
}

if ( ! function_exists( 'cc_page_meta' ) ) {
	/**
	 * Read page-specific Meta Box meta with fallback to Customizer theme mod.
	 *
	 * @param string $meta_key     Meta Box key (e.g. '_about_heading').
	 * @param string $fallback_opt Customizer theme mod fallback (e.g. 'cc_about_heading').
	 * @param mixed  $default      Default fallback.
	 * @param int    $post_id      Post ID (defaults to current queried object).
	 * @return mixed
	 */
	function cc_page_meta( $meta_key, $fallback_opt = '', $default = '', $post_id = 0 ) {
		if ( ! $post_id ) {
			$post_id = get_queried_object_id();
		}

		$val = '';
		if ( $post_id && function_exists( 'rwmb_meta' ) ) {
			$val = rwmb_meta( $meta_key, array(), $post_id );
		}

		if ( ( '' === $val || null === $val || false === $val || array() === $val ) && $post_id ) {
			$val = get_post_meta( $post_id, $meta_key, true );
		}

		if ( '' !== $val && null !== $val && false !== $val && array() !== $val ) {
			return $val;
		}

		if ( $fallback_opt ) {
			return cc_opt( $fallback_opt );
		}

		return $default;
	}
}




/**
 * Convert Latin digits to Bengali numerals.
 *
 * @param mixed $value Value to convert.
 * @return string
 */
function cc_bn( $value ) {
	return str_replace(
		array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ),
		array( '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' ),
		(string) $value
	);
}

/**
 * Convert Bengali numerals back to Latin digits (for tel: links and CSV).
 *
 * @param mixed $value Value to convert.
 * @return string
 */
function cc_latin( $value ) {
	return strtr(
		(string) $value,
		array(
			'০' => '0',
			'১' => '1',
			'২' => '2',
			'৩' => '3',
			'৪' => '4',
			'৫' => '5',
			'৬' => '6',
			'৭' => '7',
			'৮' => '8',
			'৯' => '9',
		)
	);
}

/**
 * Sanitize a `tel:` href.
 *
 * @param string $value Raw phone value.
 * @return string
 */
function cc_tel_href( $value = '' ) {
	if ( '' === $value ) {
		$value = cc_opt( 'cc_phone_link' );
	}

	$digits = preg_replace( '/[^0-9+]/', '', cc_latin( $value ) );

	return $digits ? 'tel:' . $digits : '#';
}

/**
 * Sanitize a WhatsApp number (digits only, country code without +).
 *
 * @return string
 */
function cc_whatsapp_href() {
	$digits = preg_replace( '/[^0-9]/', '', cc_latin( cc_opt( 'cc_whatsapp' ) ) );

	return $digits ? 'https://wa.me/' . $digits : '#';
}

/**
 * Permalink of a theme page by slug, falling back to a sensible URL.
 *
 * @param string $slug     Page slug.
 * @param string $fallback Fallback URL.
 * @return string
 */
function cc_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );

	if ( $page instanceof WP_Post ) {
		$url = get_permalink( $page );

		if ( $url ) {
			return $url;
		}
	}

	if ( $fallback ) {
		return $fallback;
	}

	return home_url( '/' );
}

/**
 * URL of the registration page.
 *
 * @return string
 */
function cc_registration_url() {
	return cc_page_url( 'registration', home_url( '/registration/' ) );
}

/**
 * Split a multi-line theme mod into a clean array.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_lines( $value ) {
	if ( is_array( $value ) ) {
		return array_values( array_filter( array_map( 'trim', $value ), 'strlen' ) );
	}

	$lines = preg_split( '/\r\n|\r|\n/', (string) $value );

	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/**
 * Format money as `৳ ৩,৫০০` using Bengali numerals.
 *
 * @param mixed $amount Numeric amount.
 * @return string
 */
function cc_money( $amount ) {
	$amount = (float) $amount;

	return '৳ ' . cc_bn( number_format( $amount, 0, '.', ',' ) );
}

/**
 * Render an image when one is set, otherwise the styled placeholder box.
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $fallback      Placeholder caption.
 * @param string $classes       Extra classes for the wrapper.
 * @param string $size          Registered image size.
 * @param string $style         Inline style for the wrapper.
 * @return string
 */
function cc_media( $attachment_id, $fallback = '', $classes = '', $size = 'cc-card', $style = '' ) {
	$classes = trim( 'media ' . $classes );
	$style   = $style ? ' style="' . esc_attr( $style ) . '"' : '';

	$image = $attachment_id ? wp_get_attachment_image( $attachment_id, $size, false, array( 'loading' => 'lazy' ) ) : '';

	if ( $image ) {
		return '<div class="' . esc_attr( $classes ) . '"' . $style . '>' . $image . '</div>';
	}

	return '<div class="' . esc_attr( $classes . ' ph' ) . '"' . $style . '>' . esc_html( $fallback ) . '</div>';
}

/**
 * Statistics rows coming from a theme mod, with blanks removed.
 *
 * @param string $key Theme mod key.
 * @return array
 */
function cc_stat_rows( $key ) {
	$rows = ( 'cc_stats' === $key ) ? cc_hp( '_hp_stats', 'cc_stats' ) : cc_opt( $key );
	$out  = array();


	foreach ( (array) $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$value = isset( $row['value'] ) ? trim( (string) $row['value'] ) : '';
		$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';

		if ( '' !== $value || '' !== $label ) {
			$out[] = array(
				'value' => $value,
				'label' => $label,
			);
		}
	}

	return $out;
}

/**
 * Branch rows coming from the theme mod.
 *
 * @return array
 */
function cc_branches() {
	$branches = cc_opt( 'cc_branches' );
	$out      = array();

	foreach ( (array) $branches as $branch ) {
		if ( ! is_array( $branch ) || '' === trim( (string) ( isset( $branch['name'] ) ? $branch['name'] : '' ) ) ) {
			continue;
		}

		$out[] = array(
			'name'    => (string) $branch['name'],
			'address' => isset( $branch['address'] ) ? (string) $branch['address'] : '',
			'phone'   => isset( $branch['phone'] ) ? (string) $branch['phone'] : '',
			'map'     => isset( $branch['map'] ) ? (string) $branch['map'] : '',
		);
	}

	return $out;
}

/**
 * Social links that actually have a URL.
 *
 * @return array
 */
function cc_social_links() {
	$social  = (array) cc_opt( 'cc_social' );
	$labels  = array(
		'facebook'  => array( '📘', 'Facebook' ),
		'youtube'   => array( '▶️', 'YouTube' ),
		'instagram' => array( '📸', 'Instagram' ),
		'telegram'  => array( '✈️', 'Telegram' ),
	);
	$links   = array();

	foreach ( $labels as $key => $meta ) {
		if ( empty( $social[ $key ] ) ) {
			continue;
		}

		$links[ $key ] = array(
			'url'   => $social[ $key ],
			'icon'  => $meta[0],
			'label' => $meta[1],
		);
	}

	return $links;
}

/**
 * Fallback primary navigation used until a menu is assigned.
 */
function cc_nav_fallback() {
	$home  = home_url( '/' );

	$items = array(
		$home . '#programs'                => __( 'কোর্সসমূহ', 'coaching-centre' ),
		$home . '#exam'                     => __( 'সাপ্তাহিক পরীক্ষা', 'coaching-centre' ),
		$home . '#cadet'                    => __( 'ক্যাডেট', 'coaching-centre' ),
		cc_page_url( 'about-us', $home )    => __( 'আমাদের সম্পর্কে', 'coaching-centre' ),
		$home . '#faq'                      => __( 'প্রশ্নোত্তর', 'coaching-centre' ),
		cc_page_url( 'contact', $home )     => __( 'যোগাযোগ', 'coaching-centre' ),
	);

	echo '<ul>';

	foreach ( $items as $url => $label ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}

	echo '</ul>';
}

/**
 * Sanitize helpers for Customizer controls.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function cc_sanitize_text( $value ) {
	return sanitize_text_field( (string) $value );
}

/**
 * Allow the line based settings to keep newlines.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function cc_sanitize_textarea( $value ) {
	return sanitize_textarea_field( (string) $value );
}

/**
 * Sanitize a comma separated list.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function cc_sanitize_list( $value ) {
	if ( is_array( $value ) ) {
		$value = implode( "\n", $value );
	}

	return cc_sanitize_textarea( $value );
}

/**
 * Absolute URL sanitiser that also accepts relative paths.
 *
 * @param string $value Raw value.
 * @return string
 */
function cc_sanitize_url( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	return esc_url_raw( $value, array( 'http', 'https', 'tel', 'mailto' ) );
}

/**
 * Sanitize a branch list.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_branches( $value ) {
	$out = array();

	foreach ( (array) $value as $branch ) {
		if ( ! is_array( $branch ) ) {
			continue;
		}

		$out[] = array(
			'name'    => cc_sanitize_text( isset( $branch['name'] ) ? $branch['name'] : '' ),
			'address' => cc_sanitize_text( isset( $branch['address'] ) ? $branch['address'] : '' ),
			'phone'   => cc_sanitize_text( isset( $branch['phone'] ) ? $branch['phone'] : '' ),
			'map'     => cc_sanitize_url( isset( $branch['map'] ) ? $branch['map'] : '' ),
		);
	}

	return $out;
}

/**
 * Sanitize a generic `{value,label}` row list.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_value_label( $value ) {
	$out = array();

	foreach ( (array) $value as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$out[] = array(
			'value' => cc_sanitize_text( isset( $row['value'] ) ? $row['value'] : '' ),
			'label' => cc_sanitize_text( isset( $row['label'] ) ? $row['label'] : '' ),
		);
	}

	return $out;
}

/**
 * Sanitize an `{ico,title,text}` card list.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_cards( $value ) {
	$out = array();

	foreach ( (array) $value as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$out[] = array(
			'ico'   => cc_sanitize_text( isset( $row['ico'] ) ? $row['ico'] : '' ),
			'title' => cc_sanitize_text( isset( $row['title'] ) ? $row['title'] : '' ),
			'text'  => cc_sanitize_text( isset( $row['text'] ) ? $row['text'] : '' ),
		);
	}

	return $out;
}

/**
 * Sanitize a `{year,text}` timeline list.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_timeline( $value ) {
	$out = array();

	foreach ( (array) $value as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$out[] = array(
			'year' => cc_sanitize_text( isset( $row['year'] ) ? $row['year'] : '' ),
			'text' => cc_sanitize_text( isset( $row['text'] ) ? $row['text'] : '' ),
		);
	}

	return $out;
}

/**
 * Sanitize a social link list.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_social( $value ) {
	$out    = array();
	$keys   = array_keys( cc_defaults()['cc_social'] );

	foreach ( $keys as $key ) {
		$out[ $key ] = cc_sanitize_url( isset( $value[ $key ] ) ? $value[ $key ] : '' );
	}

	return $out;
}

/**
 * Sanitize the checkbox toggles.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function cc_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Split a textarea into pipes-per-line rows.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_pipe_rows( $value ) {
	$rows = array();

	foreach ( preg_split( '/\r\n|\r|\n/', (string) $value ) as $line ) {
		$line = trim( $line );

		if ( '' !== $line ) {
			$rows[] = array_map( 'trim', explode( '|', $line ) );
		}
	}

	return $rows;
}

/**
 * Parse `value|label` rows from a textarea.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_value_label_lines( $value ) {
	$out = array();

	foreach ( cc_pipe_rows( $value ) as $parts ) {
		$out[] = array(
			'value' => cc_sanitize_text( isset( $parts[0] ) ? $parts[0] : '' ),
			'label' => cc_sanitize_text( isset( $parts[1] ) ? $parts[1] : '' ),
		);
	}

	return $out;
}

/**
 * Parse `icon|title|text` rows from a textarea.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_cards_lines( $value ) {
	$out = array();

	foreach ( cc_pipe_rows( $value ) as $parts ) {
		$out[] = array(
			'ico'   => cc_sanitize_text( isset( $parts[0] ) ? $parts[0] : '' ),
			'title' => cc_sanitize_text( isset( $parts[1] ) ? $parts[1] : '' ),
			'text'  => cc_sanitize_text( isset( $parts[2] ) ? $parts[2] : '' ),
		);
	}

	return $out;
}

/**
 * Parse `year|text` rows from a textarea.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_timeline_lines( $value ) {
	$out = array();

	foreach ( cc_pipe_rows( $value ) as $parts ) {
		$out[] = array(
			'year' => cc_sanitize_text( isset( $parts[0] ) ? $parts[0] : '' ),
			'text' => cc_sanitize_text( isset( $parts[1] ) ? $parts[1] : '' ),
		);
	}

	return $out;
}

/**
 * Parse `name|address|phone|map` rows from a textarea.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_branches_lines( $value ) {
	$out = array();

	foreach ( cc_pipe_rows( $value ) as $parts ) {
		$out[] = array(
			'name'    => cc_sanitize_text( isset( $parts[0] ) ? $parts[0] : '' ),
			'address' => cc_sanitize_text( isset( $parts[1] ) ? $parts[1] : '' ),
			'phone'   => cc_sanitize_text( isset( $parts[2] ) ? $parts[2] : '' ),
			'map'     => cc_sanitize_url( isset( $parts[3] ) ? $parts[3] : '' ),
		);
	}

	return $out;
}

/**
 * Parse `facebook|youtube|instagram|telegram` rows from a textarea.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function cc_sanitize_social_lines( $value ) {
	$out  = array();
	$keys = array_keys( cc_defaults()['cc_social'] );

	foreach ( cc_pipe_rows( $value ) as $index => $parts ) {
		if ( ! isset( $keys[ $index ] ) ) {
			continue;
		}

		$out[ $keys[ $index ] ] = cc_sanitize_url( isset( $parts[0] ) ? $parts[0] : '' );
	}

	return $out;
}