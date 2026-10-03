<?php
/**
 * Meta Box Field Registrations: Front Page
 *
 * Registers front-page section meta boxes for Coaching Centre.
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$boxes = [];

/* ── 1. Hero Section ── */
$boxes[] = [
    'title'      => 'হোমপেজ — হিরো ব্যানার (Hero Section)',
    'id'         => 'cc_hp_hero',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'ট্যাগ ব্যাজ (Tag Badge)',
            'id'          => '_hp_hero_tag',
            'type'        => 'text',
            'placeholder' => '৬ষ্ঠ–১০ম শ্রেণি • JSC • PSC • SSC • ক্যাডেট',
            'columns'     => 12,
        ],
        [
            'name'        => 'মূল শিরোনাম (Main Headline)',
            'id'          => '_hp_hero_title',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => "সঠিক গাইডলাইনে\nসেরা প্রস্তুতি, সেরা ফলাফল",
            'desc'        => 'নতুন লাইনে ভাঙতে এন্টার চাপুন।',
            'columns'     => 12,
        ],
        [
            'name'        => 'সংক্ষিপ্ত বিবরণ (Subheadline Text)',
            'id'          => '_hp_hero_text',
            'type'        => 'textarea',
            'rows'        => 3,
            'placeholder' => 'অভিজ্ঞ শিক্ষক, কনসেপ্ট-বেইজড ক্লাস, নিয়মিত পরীক্ষা ও সার্বক্ষণিক Q&A সাপোর্ট — সব ক্লাস সরাসরি ক্লাসরুমে।',
            'columns'     => 12,
        ],
        [
            'name'        => '১ম বোতামের লেখা (Button 1 Text)',
            'id'          => '_hp_hero_btn1_txt',
            'type'        => 'text',
            'placeholder' => 'এখনই ভর্তি হোন',
            'columns'     => 6,
        ],
        [
            'name'        => '২য় বোতামের লেখা (Button 2 Text)',
            'id'          => '_hp_hero_btn2_txt',
            'type'        => 'text',
            'placeholder' => 'সাপ্তাহিক পরীক্ষায় অংশ নিন',
            'columns'     => 6,
        ],
        [
            'name'             => 'হিরো ছবি (Hero Image)',
            'id'               => '_hp_hero_image',
            'type'             => 'single_image',
            'columns'          => 12,
        ],
    ],
];

/* ── 2. Statistics Bar ── */
$boxes[] = [
    'title'      => 'হোমপেজ — পরিসংখ্যান বার (Headline Statistics)',
    'id'         => 'cc_hp_stats',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'       => 'পরিসংখ্যান আইটেমসমূহ',
            'id'         => '_hp_stats',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ নতুন পরিসংখ্যান যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'মান / সংখ্যা (Value)',
                    'id'          => 'value',
                    'type'        => 'text',
                    'placeholder' => 'যেমন: ১০,০০০+ বা ৯৮%',
                    'columns'     => 6,
                ],
                [
                    'name'        => 'লেবেল (Label)',
                    'id'          => 'label',
                    'type'        => 'text',
                    'placeholder' => 'যেমন: শিক্ষার্থী বা GPA-5 সাফল্য',
                    'columns'     => 6,
                ],
            ],
        ],
    ],
];

/* ── 3. Programs Section Header ── */
$boxes[] = [
    'title'      => 'হোমপেজ — কোর্স সেকশন শিরোনাম',
    'id'         => 'cc_hp_programs',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'সেকশন শিরোনাম',
            'id'          => '_hp_programs_title',
            'type'        => 'text',
            'placeholder' => 'আমাদের কোর্সসমূহ',
            'columns'     => 6,
        ],
        [
            'name'        => 'উপ-শিরোনাম',
            'id'          => '_hp_programs_sub',
            'type'        => 'text',
            'placeholder' => 'শ্রেণি ও লক্ষ্য অনুযায়ী বেছে নিন আপনার উপযোগী প্রোগ্রাম।',
            'columns'     => 6,
        ],
    ],
];

/* ── 4. Why Choose Us / Features ── */
$boxes[] = [
    'title'      => 'হোমপেজ — কেন আমরা আলাদা? (Features)',
    'id'         => 'cc_hp_features',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'সেকশন শিরোনাম',
            'id'          => '_hp_features_title',
            'type'        => 'text',
            'placeholder' => 'কেন আমরা আলাদা?',
            'columns'     => 6,
        ],
        [
            'name'        => 'উপ-শিরোনাম',
            'id'          => '_hp_features_sub',
            'type'        => 'text',
            'placeholder' => 'শুধু ক্লাস নয় — পূর্ণাঙ্গ একাডেমিক কেয়ার।',
            'columns'     => 6,
        ],
        [
            'name'       => 'বৈশিষ্ট্য কার্ডসমূহ',
            'id'         => '_hp_features',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ নতুন কার্ড যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'আইকন / ইমোজি',
                    'id'          => 'ico',
                    'type'        => 'text',
                    'placeholder' => '👨‍🏫',
                    'columns'     => 2,
                ],
                [
                    'name'        => 'কার্ড শিরোনাম',
                    'id'          => 'title',
                    'type'        => 'text',
                    'placeholder' => 'মেধাবী শিক্ষক',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'বিবরণ',
                    'id'          => 'text',
                    'type'        => 'textarea',
                    'rows'        => 2,
                    'placeholder' => 'দেশসেরা বিশ্ববিদ্যালয়ের অভিজ্ঞ শিক্ষকদের ক্লাস।',
                    'columns'     => 6,
                ],
            ],
        ],
    ],
];

/* ── 5. Weekly Model Exam ── */
$boxes[] = [
    'title'      => 'হোমপেজ — সাপ্তাহিক মডেল পরীক্ষা (Model Exam Block)',
    'id'         => 'cc_hp_exam',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'পরীক্ষা সেকশন শিরোনাম',
            'id'          => '_hp_exam_title',
            'type'        => 'text',
            'placeholder' => 'সাপ্তাহিক মডেল পরীক্ষা',
            'columns'     => 6,
        ],
        [
            'name'        => 'পরীক্ষার ফি (টাকায়)',
            'id'          => '_hp_exam_price',
            'type'        => 'text',
            'placeholder' => '৫০',
            'columns'     => 6,
        ],
        [
            'name'        => 'সংক্ষিপ্ত বিবরণ',
            'id'          => '_hp_exam_text',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => 'আমাদের শিক্ষার্থী হওয়া জরুরি নয় — রেজিস্ট্রেশন করে যে কেউ অংশ নিতে পারবে।',
            'columns'     => 12,
        ],
        [
            'name'        => 'পরীক্ষার সুবিধাসমূহ (Bullets)',
            'id'          => '_hp_exam_points',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => "প্রতি সপ্তাহে নির্ধারিত দিনে MCQ মডেল পরীক্ষা\n৬ষ্ঠ থেকে ১০ম, JSC, PSC ও ক্যাডেট প্রস্তুতির আলাদা সেট\nপরীক্ষা শেষে তাৎক্ষণিক ফলাফল ও সলভ শিট\nসারাদেশের মেধাতালিকায় নিজের অবস্থান জানুন",
            'desc'        => 'প্রতি লাইনে একটি করে পয়েন্ট লিখুন।',
            'columns'     => 12,
        ],
        [
            'name'        => 'পেমেন্ট মাধ্যম নোট',
            'id'          => '_hp_exam_payment',
            'type'        => 'text',
            'placeholder' => 'bKash / Nagad / কার্ড',
            'columns'     => 6,
        ],
        [
            'name'        => 'পরীক্ষার অপশনসমূহ (ড্রপডাউন লিস্ট)',
            'id'          => '_hp_exam_class_opt',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => "৫ম (PSC)\n৬ষ্ঠ\n৭ম\n৮ম (JSC)\n৯ম\n১০ম (SSC)\nক্যাডেট ভর্তি প্রস্তুতি",
            'desc'        => 'প্রতি লাইনে একটি শ্রেণি/পরীক্ষার নাম লিখুন।',
            'columns'     => 6,
        ],
    ],
];

/* ── 6. Cadet Coaching ── */
$boxes[] = [
    'title'      => 'হোমপেজ — ক্যাডেট কোচিং সেকশন (Cadet Coaching Block)',
    'id'         => 'cc_hp_cadet',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'ট্যাগ ব্যাজ',
            'id'          => '_hp_cadet_tag',
            'type'        => 'text',
            'placeholder' => 'ক্যাডেট কলেজ ভর্তি প্রস্তুতি',
            'columns'     => 6,
        ],
        [
            'name'        => 'শিরোনাম',
            'id'          => '_hp_cadet_title',
            'type'        => 'text',
            'placeholder' => 'ক্যাডেট কোচিং',
            'columns'     => 6,
        ],
        [
            'name'        => 'সংক্ষিপ্ত বিবরণ',
            'id'          => '_hp_cadet_text',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => 'ক্যাডেট কলেজে চান্স পাওয়ার স্বপ্ন পূরণে বিশেষ প্রস্তুতি।',
            'columns'     => 12,
        ],
        [
            'name'        => 'ক্যাডেট সুবিধার পয়েন্টসমূহ',
            'id'          => '_hp_cadet_points',
            'type'        => 'textarea',
            'rows'        => 5,
            'placeholder' => "এক্স-ক্যাডেট শিক্ষকদের ইন্টারেক্টিভ ক্লাস\nবাংলা, ইংরেজি, গণিত ও সাধারণ জ্ঞানের পূর্ণ প্রস্তুতি\nলিখিত, মৌখিক ও ইন্টারভিউ প্রস্তুতি\nমডেল টেস্ট, প্রশ্নব্যাংক ও সলভ ক্লাস\nবাংলা ও ইংরেজি ভার্সনে আলাদা ব্যাচ",
            'desc'        => 'প্রতি লাইনে একটি করে পয়েন্ট লিখুন।',
            'columns'     => 12,
        ],
        [
            'name'             => 'ক্যাডেট কোচিং ছবি',
            'id'               => '_hp_cadet_image',
            'type'             => 'single_image',
            'columns'          => 12,
        ],
    ],
];

/* ── 7. Teachers Section Header ── */
$boxes[] = [
    'title'      => 'হোমপেজ — শিক্ষকমণ্ডলী সেকশন শিরোনাম',
    'id'         => 'cc_hp_teachers',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'সেকশন শিরোনাম',
            'id'          => '_hp_teachers_title',
            'type'        => 'text',
            'placeholder' => 'আমাদের শিক্ষকমণ্ডলী',
            'columns'     => 6,
        ],
        [
            'name'        => 'উপ-শিরোনাম',
            'id'          => '_hp_teachers_sub',
            'type'        => 'text',
            'placeholder' => 'অভিজ্ঞ ও আন্তরিক শিক্ষকদের সান্নিধ্যে শিখুন।',
            'columns'     => 6,
        ],
    ],
];

/* ── 8. Testimonials Section Header ── */
$boxes[] = [
    'title'      => 'হোমপেজ — মতামত সেকশন শিরোনাম',
    'id'         => 'cc_hp_testimonials',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'সেকশন শিরোনাম',
            'id'          => '_hp_quotes_title',
            'type'        => 'text',
            'placeholder' => 'শিক্ষার্থী ও অভিভাবকদের মতামত',
            'columns'     => 6,
        ],
        [
            'name'        => 'উপ-শিরোনাম',
            'id'          => '_hp_quotes_sub',
            'type'        => 'text',
            'placeholder' => 'আমাদের সাফল্যের গল্প।',
            'columns'     => 6,
        ],
    ],
];

/* ── 9. Admission CTA ── */
$boxes[] = [
    'title'      => 'হোমপেজ — ভর্তি আহ্বান (CTA Block)',
    'id'         => 'cc_hp_cta',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'CTA শিরোনাম',
            'id'          => '_hp_cta_title',
            'type'        => 'text',
            'placeholder' => 'আজই ভর্তি হোন, প্রস্তুতি শুরু করুন',
            'columns'     => 12,
        ],
        [
            'name'        => 'CTA সাব-টেক্সট',
            'id'          => '_hp_cta_text',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => 'সীমিত আসন। সরাসরি শাখায় আসুন অথবা ফোন করুন।',
            'columns'     => 12,
        ],
    ],
];

/* ── 10. FAQ Section Header ── */
$boxes[] = [
    'title'      => 'হোমপেজ — সাধারণ জিজ্ঞাসা (FAQ Section)',
    'id'         => 'cc_hp_faq',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'is_front_page' => true,
    ],
    'fields'     => [
        [
            'name'        => 'FAQ সেকশন শিরোনাম',
            'id'          => '_hp_faq_title',
            'type'        => 'text',
            'placeholder' => 'সাধারণ জিজ্ঞাসা',
            'columns'     => 12,
        ],
    ],
];

return $boxes;
