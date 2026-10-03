<?php
/**
 * Meta Box Field Registrations: Coaching Centre CPTs
 *
 * Registers meta boxes for:
 *   - cc_course      (Courses / Programs)
 *   - cc_teacher     (Instructors)
 *   - cc_testimonial (Testimonials)
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$boxes = [];

/* ── 1. Course Details ── */
$boxes[] = [
    'title'      => 'কোর্সের বিস্তারিত তথ্য',
    'id'         => 'cc_course_details',
    'post_types' => [ 'cc_course' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'fields'     => [
        [
            'name'        => 'শ্রেণি (Class)',
            'id'          => '_cc_class',
            'type'        => 'text',
            'placeholder' => 'যেমন: ৮ম শ্রেণি',
            'desc'        => 'ভর্তি ফর্মে এই কোর্সটি কোন শ্রেণির অধীনে দেখাবে।',
            'columns'     => 6,
        ],
        [
            'name'        => 'কোর্স ফি (৳)',
            'id'          => '_cc_fee',
            'type'        => 'number',
            'placeholder' => 'যেমন: ৩০০০',
            'min'         => 0,
            'desc'        => 'টাকার অংক (সংখ্যায়)।',
            'columns'     => 6,
        ],
        [
            'name'        => 'বিভাগ / গ্রুপ (Group)',
            'id'          => '_cc_group',
            'type'        => 'select',
            'options'     => [
                ''               => '— কোনো গ্রুপ নেই / সাধারণ —',
                'বিজ্ঞান'        => 'বিজ্ঞান',
                'ব্যবসায় শিক্ষা' => 'ব্যবসায় শিক্ষা',
                'মানবিক'        => 'মানবিক',
            ],
            'columns'     => 6,
        ],
        [
            'name'        => 'ব্যাজ (Badge)',
            'id'          => '_cc_badge',
            'type'        => 'text',
            'placeholder' => 'যেমন: অফলাইন, জনপ্রিয়',
            'columns'     => 6,
        ],
        [
            'name'        => 'আসন সংখ্যা (Seat Count)',
            'id'          => '_cc_seats',
            'type'        => 'text',
            'placeholder' => 'যেমন: ৩০ জন',
            'columns'     => 6,
        ],
        [
            'name'        => 'ক্লাসের দিন (Class Schedule / Days)',
            'id'          => '_cc_days',
            'type'        => 'text',
            'placeholder' => 'যেমন: শনি, সোম, বুধ',
            'columns'     => 6,
        ],
        [
            'name'        => 'অংশগ্রহণের মাধ্যম (Modes)',
            'id'          => '_cc_modes',
            'type'        => 'text',
            'placeholder' => 'যেমন: অফলাইন, অনলাইন',
            'desc'        => 'কমা দিয়ে আলাদা করুন (যেমন: অফলাইন, অনলাইন)।',
            'columns'     => 12,
        ],

        [
            'name'        => 'কোর্সের বৈশিষ্ট্যসমূহ (Features)',
            'id'          => '_cc_features',
            'type'        => 'textarea',
            'rows'        => 5,
            'placeholder' => "সব বিষয়ের নিয়মিত ক্লাস\nসাপ্তাহিক মডেল টেস্ট\nপ্রিন্টেড লেকচার শিট",
            'desc'        => 'প্রতি লাইনে একটি করে বৈশিষ্ট্য লিখুন।',
            'columns'     => 12,
        ],
        [
            'name'    => 'হোমপেজে লুকান (Hidden from homepage)',
            'id'      => '_cc_hidden',
            'type'    => 'checkbox',
            'desc'    => 'টিক দিলে এই কোর্সটি হোমপেজের কোর্স তালিকায় দেখাবে না, শুধু সরাসরি বা ভর্তি ফর্মে নির্বাচন করা যাবে।',
            'columns' => 12,
        ],
    ],
];

/* ── 2. Teacher Details ── */
$boxes[] = [
    'title'      => 'শিক্ষকের তথ্য',
    'id'         => 'cc_teacher_details',
    'post_types' => [ 'cc_teacher' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'fields'     => [
        [
            'name'        => 'বিষয় / বিভাগ (Subject/Department)',
            'id'          => '_cc_subject',
            'type'        => 'text',
            'placeholder' => 'যেমন: গণিত বিভাগ',
            'columns'     => 6,
        ],
        [
            'name'        => 'পদবি (Designation)',
            'id'          => '_cc_designation',
            'type'        => 'text',
            'placeholder' => 'যেমন: সহকারী অধ্যাপক',
            'columns'     => 6,
        ],
    ],
];

/* ── 3. Testimonial Details ── */
$boxes[] = [
    'title'      => 'মতামতের বিস্তারিত তথ্য',
    'id'         => 'cc_testimonial_details',
    'post_types' => [ 'cc_testimonial' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'fields'     => [
        [
            'name'        => 'পরিচয় / রোল (Role / Identity)',
            'id'          => '_cc_role',
            'type'        => 'text',
            'placeholder' => 'যেমন: শিক্ষার্থী, SSC ২০২৪ / অভিভাবক',
            'desc'        => 'শিক্ষার্থীর নাম উপরের টাইটেল ফিল্ডে লিখুন এবং মতামত/উদ্ধৃতিটি মূল এডিটর বক্সে লিখুন।',
            'columns'     => 12,
        ],
    ],
];

return $boxes;
