<?php
/**
 * Sample Data Seeder for Coaching Centre.
 *
 * Seeds initial courses, teachers, testimonials, and FAQs
 * when the plugin is activated, or via manual call.
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CC_Manager_Sample_Data {

    public static function seed() {
        if ( get_option( 'cc_manager_sample_data_version' ) ) {
            return;
        }

        self::seed_categories();
        self::seed_courses();
        self::seed_teachers();
        self::seed_testimonials();
        self::seed_faqs();
        self::seed_front_page_meta();

        update_option( 'cc_manager_sample_data_version', '1.0' );
    }

    /* ─── 1. Course Categories ─── */

    private static function seed_categories() {
        $terms = [
            'acad'    => 'একাডেমিক',
            'scholar' => 'বৃত্তি',
            'ssc'     => 'SSC',
            'cadet'   => 'ক্যাডেট',
        ];

        foreach ( $terms as $slug => $name ) {
            if ( taxonomy_exists( 'cc_course_cat' ) && ! term_exists( $slug, 'cc_course_cat' ) ) {
                wp_insert_term( $name, 'cc_course_cat', [ 'slug' => $slug ] );
            }
        }
    }

    /* ─── 2. Courses ─── */

    private static function seed_courses() {
        $courses = [
            [
                'title'    => '৬ষ্ঠ শ্রেণি একাডেমিক প্রোগ্রাম',
                'class'    => '৬ষ্ঠ শ্রেণি',
                'cat'      => 'acad',
                'fee'      => 3000,
                'badge'    => 'অফলাইন',
                'features' => "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A",
            ],
            [
                'title'    => '৭ম শ্রেণি একাডেমিক প্রোগ্রাম',
                'class'    => '৭ম শ্রেণি',
                'cat'      => 'acad',
                'fee'      => 3000,
                'badge'    => 'অফলাইন',
                'features' => "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A",
            ],
            [
                'title'    => '৮ম শ্রেণি একাডেমিক প্রোগ্রাম',
                'class'    => '৮ম শ্রেণি',
                'cat'      => 'acad',
                'fee'      => 3200,
                'badge'    => 'অফলাইন',
                'features' => "সব বিষয়ের নিয়মিত ক্লাস\nপ্রিন্টেড স্টাডি নোট\nনিয়মিত পরীক্ষা ও Q&A",
            ],
            [
                'title'    => '৯ম শ্রেণি একাডেমিক প্রোগ্রাম',
                'class'    => '৯ম শ্রেণি',
                'cat'      => 'acad',
                'fee'      => 3500,
                'badge'    => 'অফলাইন',
                'group'    => 'বিজ্ঞান',
                'features' => "বিজ্ঞান/ব্যবসায়/মানবিক গ্রুপ\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস ও বই",
            ],
            [
                'title'    => '১০ম শ্রেণি একাডেমিক প্রোগ্রাম',
                'class'    => '১০ম শ্রেণি (SSC)',
                'cat'      => 'acad',
                'fee'      => 3500,
                'badge'    => 'অফলাইন',
                'group'    => 'বিজ্ঞান',
                'features' => "বোর্ড স্ট্যান্ডার্ড পরীক্ষার প্রস্তুতি\nপ্রশ্নব্যাংক ও সলভ শিট\nরিভিশন ক্লাস",
            ],
            [
                'title'    => 'PSC বৃত্তি প্রস্তুতি (প্রশ্নব্যাংক ও মডেল টেস্ট)',
                'class'    => '৫ম শ্রেণি',
                'cat'      => 'scholar',
                'fee'      => 1500,
                'badge'    => 'বৃত্তি',
                'features' => "প্রশ্নব্যাংক ও মডেল টেস্ট\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস",
            ],
            [
                'title'    => 'JSC বৃত্তি প্রস্তুতি (প্রশ্নব্যাংক ও মডেল টেস্ট)',
                'class'    => '৮ম শ্রেণি',
                'cat'      => 'scholar',
                'fee'      => 1800,
                'badge'    => 'বৃত্তি',
                'features' => "প্রশ্নব্যাংক ও মডেল টেস্ট\nঅধ্যায়ভিত্তিক পরীক্ষা\nসলভ ক্লাস",
            ],
            [
                'title'    => 'SSC মডেল টেস্ট',
                'class'    => '১০ম শ্রেণি (SSC)',
                'cat'      => 'ssc',
                'fee'      => 1800,
                'badge'    => 'মডেল টেস্ট',
                'features' => "বোর্ড অনুরূপ মডেল টেস্ট\nপ্রিন্টেড প্রশ্নব্যাংক\nএনালাইসিস রিপোর্ট",
            ],
            [
                'title'    => 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি',
                'class'    => 'ক্যাডেট প্রস্তুতি',
                'cat'      => 'cadet',
                'fee'      => 4000,
                'badge'    => 'ক্যাডেট',
                'features' => "এক্স-ক্যাডেট শিক্ষক\nলিখিত, মৌখিক ও ইন্টারভিউ\nবাংলা ও ইংরেজি ভার্সন",
            ],
            [
                'title'    => 'ক্যাডেট SSC স্পেশাল মডেল টেস্ট',
                'class'    => 'ক্যাডেট প্রস্তুতি',
                'cat'      => 'cadet',
                'fee'      => 1500,
                'badge'    => 'ক্যাডেট',
                'features' => "বিশেষায়িত প্রশ্নব্যাংক\nমডেল টেস্ট ও বিশ্লেষণ\nমক ইন্টারভিউ",
            ],
        ];

        $order = 0;
        foreach ( $courses as $course ) {
            $order += 10;
            $existing = get_posts( [
                'post_type'      => 'cc_course',
                'post_status'    => 'any',
                'title'          => $course['title'],
                'posts_per_page' => 1,
                'fields'         => 'ids',
            ] );

            if ( $existing ) {
                continue;
            }

            $post_id = wp_insert_post( [
                'post_type'   => 'cc_course',
                'post_status' => 'publish',
                'post_title'  => $course['title'],
                'menu_order'  => $order,
            ] );

            if ( ! $post_id || is_wp_error( $post_id ) ) {
                continue;
            }

            update_post_meta( $post_id, '_cc_class', $course['class'] );
            update_post_meta( $post_id, '_cc_fee', $course['fee'] );
            update_post_meta( $post_id, '_cc_modes', 'অফলাইন' );
            update_post_meta( $post_id, '_cc_badge', $course['badge'] );
            update_post_meta( $post_id, '_cc_features', $course['features'] );

            if ( ! empty( $course['group'] ) ) {
                update_post_meta( $post_id, '_cc_group', $course['group'] );
            }

            if ( taxonomy_exists( 'cc_course_cat' ) ) {
                wp_set_object_terms( $post_id, $course['cat'], 'cc_course_cat', false );
            }
        }
    }

    /* ─── 3. Teachers ─── */

    private static function seed_teachers() {
        $teachers = [
            [ 'মোঃ শাহেদুর রহমান', 'গণিত বিভাগ', 'সহকারী অধ্যাপক' ],
            [ 'সালমা খাতুন', 'ইংরেজি বিভাগ', 'সহকারী অধ্যাপক' ],
            [ 'ড. মোহাম্মদ হাসিব', 'বিজ্ঞান বিভাগ', 'অধ্যাপক' ],
            [ 'জান্নাতুল ফেরদৌস', 'বাংলা বিভাগ', 'সহকারী অধ্যাপক' ],
        ];

        $order = 0;
        foreach ( $teachers as $t ) {
            $order += 10;
            $existing = get_posts( [
                'post_type'      => 'cc_teacher',
                'post_status'    => 'any',
                'title'          => $t[0],
                'posts_per_page' => 1,
                'fields'         => 'ids',
            ] );

            if ( $existing ) {
                continue;
            }

            $post_id = wp_insert_post( [
                'post_type'   => 'cc_teacher',
                'post_status' => 'publish',
                'post_title'  => $t[0],
                'menu_order'  => $order,
            ] );

            if ( ! $post_id || is_wp_error( $post_id ) ) {
                continue;
            }

            update_post_meta( $post_id, '_cc_subject', $t[1] );
            update_post_meta( $post_id, '_cc_designation', $t[2] );
        }
    }

    /* ─── 4. Testimonials ─── */

    private static function seed_testimonials() {
        $quotes = [
            [
                'নিয়মিত পরীক্ষা আর Q&A সাপোর্টের কারণে গণিত নিয়ে ভয় কেটে গেছে।',
                'রাফিউল ইসলাম',
                'শিক্ষার্থী, SSC',
            ],
            [
                'প্রতিটি পরীক্ষার ফল SMS-এ পাই, তাই সন্তানের অগ্রগতি সহজে বুঝি।',
                'আব্দুল করিম',
                'অভিভাবক',
            ],
            [
                'সাপ্তাহিক পরীক্ষায় অংশ নিয়ে প্রস্তুতির ঘাটতি ধরতে পেরেছি।',
                'জান্নাতুল ফেরদৌস',
                'শিক্ষার্থী, JSC',
            ],
        ];

        $order = 0;
        foreach ( $quotes as $q ) {
            $order += 10;
            $existing = get_posts( [
                'post_type'      => 'cc_testimonial',
                'post_status'    => 'any',
                'title'          => $q[1],
                'posts_per_page' => 1,
                'fields'         => 'ids',
            ] );

            if ( $existing ) {
                continue;
            }

            $post_id = wp_insert_post( [
                'post_type'    => 'cc_testimonial',
                'post_status'  => 'publish',
                'post_title'   => $q[1],
                'post_content' => $q[0],
                'menu_order'   => $order,
            ] );

            if ( ! $post_id || is_wp_error( $post_id ) ) {
                continue;
            }

            update_post_meta( $post_id, '_cc_role', $q[2] );
        }
    }

    /* ─── 5. FAQs ─── */

    private static function seed_faqs() {
        $faqs = [
            [
                'সাপ্তাহিক পরীক্ষায় কারা অংশ নিতে পারবে?',
                'যে কেউ রেজিস্ট্রেশন ও নির্ধারিত ফি প্রদান করে অংশ নিতে পারবে; আমাদের শিক্ষার্থী হওয়া আবশ্যক নয়।',
            ],
            [
                'পরীক্ষার ফলাফল কখন পাওয়া যাবে?',
                'পরীক্ষা শেষে সঙ্গে সঙ্গে স্কোর এবং পরে মেধাতালিকা ও সলভ শিট পাওয়া যাবে।',
            ],
            [
                'ভর্তি কীভাবে হবে?',
                'ওয়েবসাইটের এই ফর্মটি পূরণ করতে পারেন, অথবা সরাসরি শাখায় এসে ফর্ম পূরণ করে অফলাইন ভর্তির সুযোগ আছে।',
            ],
            [
                'ফ্রি ট্রায়াল ক্লাস আছে কি?',
                'নির্বাচিত শ্রেণিতে ট্রায়াল ক্লাসের সুযোগ রয়েছে। বিস্তারিত জানতে যোগাযোগ করুন।',
            ],
        ];

        $order = 0;
        foreach ( $faqs as $f ) {
            $order += 10;
            $existing = get_posts( [
                'post_type'      => 'cc_faq',
                'post_status'    => 'any',
                'title'          => $f[0],
                'posts_per_page' => 1,
                'fields'         => 'ids',
            ] );

            if ( $existing ) {
                continue;
            }

            wp_insert_post( [
                'post_type'    => 'cc_faq',
                'post_status'  => 'publish',
                'post_title'   => $f[0],
                'post_content' => $f[1],
                'menu_order'   => $order,
            ] );
        }
    }

    /* ─── 6. Front Page Meta ─── */

    private static function seed_front_page_meta() {
        $front_page_id = (int) get_option( 'page_on_front' );
        if ( ! $front_page_id ) {
            return;
        }

        $meta = [
            '_hp_hero_tag'      => '৬ষ্ঠ–১০ম শ্রেণি • JSC • PSC • SSC • ক্যাডেট',
            '_hp_hero_title'    => "সঠিক গাইডলাইনে\nসেরা প্রস্তুতি, সেরা ফলাফল",
            '_hp_hero_text'     => 'অভিজ্ঞ শিক্ষক, কনসেপ্ট-বেইজড ক্লাস, নিয়মিত পরীক্ষা ও সার্বক্ষণিক Q&A সাপোর্ট — সব ক্লাস সরাসরি ক্লাসরুমে।',
            '_hp_hero_btn1_txt' => 'এখনই ভর্তি হোন',
            '_hp_hero_btn2_txt' => 'সাপ্তাহিক পরীক্ষায় অংশ নিন',
            '_hp_stats'         => [
                [ 'value' => '১০,০০০+', 'label' => 'শিক্ষার্থী' ],
                [ 'value' => '৫০+',     'label' => 'অভিজ্ঞ শিক্ষক' ],
                [ 'value' => '৯৮%',     'label' => 'GPA-5 সাফল্য' ],
                [ 'value' => '১২+',     'label' => 'বছরের অভিজ্ঞতা' ],
            ],
            '_hp_programs_title' => 'আমাদের কোর্সসমূহ',
            '_hp_programs_sub'   => 'শ্রেণি ও লক্ষ্য অনুযায়ী বেছে নিন আপনার উপযোগী প্রোগ্রাম।',
            '_hp_features_title' => 'কেন আমরা আলাদা?',
            '_hp_features_sub'   => 'শুধু ক্লাস নয় — পূর্ণাঙ্গ একাডেমিক কেয়ার।',
            '_hp_features'       => [
                [ 'ico' => '👨‍🏫', 'title' => 'মেধাবী শিক্ষক',       'text' => 'দেশসেরা বিশ্ববিদ্যালয়ের অভিজ্ঞ শিক্ষকদের ক্লাস।' ],
                [ 'ico' => '💡',   'title' => 'কনসেপ্ট বেইজড ক্লাস', 'text' => 'মুখস্থ নয়, বুঝে শেখার সহজ পদ্ধতি।' ],
                [ 'ico' => '📝',   'title' => 'নিয়মিত পরীক্ষা',      'text' => 'ক্লাস টেস্ট, অধ্যায়ভিত্তিক ও মডেল টেস্ট।' ],
                [ 'ico' => '💬',   'title' => 'সার্বক্ষণিক Q&A',     'text' => 'যেকোনো সময় ডাউট সলভিংয়ের সুযোগ।' ],
            ],
            '_hp_exam_title'     => 'সাপ্তাহিক মডেল পরীক্ষা',
            '_hp_exam_price'     => '৫০',
            '_hp_exam_text'      => 'আমাদের শিক্ষার্থী হওয়া জরুরি নয় — রেজিস্ট্রেশন করে যে কেউ অংশ নিতে পারবে।',
            '_hp_exam_payment'   => 'bKash / Nagad / কার্ড',
            '_hp_cadet_tag'      => 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি',
            '_hp_cadet_title'    => 'ক্যাডেট কোচিং',
            '_hp_cadet_text'     => 'ক্যাডেট কলেজে চান্স পাওয়ার স্বপ্ন পূরণে বিশেষ প্রস্তুতি।',
            '_hp_teachers_title' => 'আমাদের শিক্ষকমণ্ডলী',
            '_hp_teachers_sub'   => 'অভিজ্ঞ ও আন্তরিক শিক্ষকদের সান্নিধ্যে শিখুন।',
            '_hp_quotes_title'   => 'শিক্ষার্থী ও অভিভাবকদের মতামত',
            '_hp_quotes_sub'     => 'আমাদের সাফল্যের গল্প।',
            '_hp_cta_title'      => 'আজই ভর্তি হোন, প্রস্তুতি শুরু করুন',
            '_hp_cta_text'       => 'সীমিত আসন। সরাসরি শাখায় আসুন অথবা ফোন করুন।',
            '_hp_faq_title'      => 'সাধারণ জিজ্ঞাসা',
        ];

        foreach ( $meta as $key => $val ) {
            if ( ! get_post_meta( $front_page_id, $key, true ) ) {
                update_post_meta( $front_page_id, $key, $val );
            }
        }
    }
}

// Backward compatibility alias
class_alias( 'CC_Manager_Sample_Data', 'XYZ_School_Sample_Data' );
