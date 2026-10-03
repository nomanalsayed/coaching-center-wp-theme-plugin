<?php
/**
 * Meta Box Field Registrations: Page Templates & Settings
 *
 * Registers meta boxes for:
 *   - About Page (page-about.php / 'about-us')
 *   - Contact Page (page-contact.php / 'contact')
 *   - Site Information (Settings Page)
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$boxes = [];

/* ── 1. About Us Page ── */
$boxes[] = [
    'title'      => 'আমাদের সম্পর্কে — পরিচিতি ও গল্প',
    'id'         => 'cc_about_intro_story',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => [
        'template' => [ 'page-about.php' ],
    ],
    'fields'     => [
        [
            'name'        => 'পেজের প্রধান শিরোনাম',
            'id'          => '_about_heading',
            'type'        => 'text',
            'placeholder' => 'শেখাকে আনন্দের, সাফল্যকে নিশ্চিত করাই আমাদের লক্ষ্য',
            'columns'     => 12,
        ],
        [
            'name'        => 'পরিচিতি সাব-টেক্সট',
            'id'          => '_about_intro',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => '৫ম থেকে ১০ম শ্রেণি, JSC, PSC, SSC ও ক্যাডেট প্রস্তুতিতে বছরের পর বছর ধরে আমরা শিক্ষার্থীদের পাশে আছি।',
            'columns'     => 12,
        ],
        [
            'name'             => 'ক্যাম্পাস ছবি (About Image)',
            'id'               => '_about_image',
            'type'             => 'single_image',
            'columns'          => 12,
        ],
        [
            'name'        => 'আমাদের গল্প — ১ম প্যারা',
            'id'          => '_about_story_1',
            'type'        => 'textarea',
            'rows'        => 3,
            'placeholder' => 'একটি ছোট কক্ষ আর হাতে গোনা কয়েকজন শিক্ষার্থী নিয়ে আমাদের যাত্রা শুরু...',
            'columns'     => 6,
        ],
        [
            'name'        => 'আমাদের গল্প — ২য় প্যারা',
            'id'          => '_about_story_2',
            'type'        => 'textarea',
            'rows'        => 3,
            'placeholder' => 'আজ আমরা সরাসরি ক্লাসরুমে হাজারো শিক্ষার্থীকে সহায়তা করছি...',
            'columns'     => 6,
        ],
    ],
];

$boxes[] = [
    'title'      => 'আমাদের সম্পর্কে — পরিসংখ্যান ও মিশন/ভিশন',
    'id'         => 'cc_about_stats_mv',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'template' => [ 'page-about.php' ],
    ],
    'fields'     => [
        [
            'name'       => 'পরিসংখ্যান আইটেম (Stats)',
            'id'         => '_about_stats',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ পরিসংখ্যান যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'সংখ্যা / মান',
                    'id'          => 'value',
                    'type'        => 'text',
                    'placeholder' => '১২+',
                    'columns'     => 6,
                ],
                [
                    'name'        => 'লেবেল',
                    'id'          => 'label',
                    'type'        => 'text',
                    'placeholder' => 'বছরের অভিজ্ঞতা',
                    'columns'     => 6,
                ],
            ],
        ],
        [
            'name'       => 'মিশন, ভিশন ও মূল্যবোধ কার্ডসমূহ (MV Cards)',
            'id'         => '_about_mv',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ কার্ড যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'ইমোজি / আইকন',
                    'id'          => 'ico',
                    'type'        => 'text',
                    'placeholder' => '🎯',
                    'columns'     => 3,
                ],
                [
                    'name'        => 'কার্ডের শিরোনাম',
                    'id'          => 'title',
                    'type'        => 'text',
                    'placeholder' => 'আমাদের মিশন',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'বিবরণ',
                    'id'          => 'text',
                    'type'        => 'textarea',
                    'rows'        => 2,
                    'placeholder' => 'প্রতিটি শিক্ষার্থীকে স্বাবলম্বী ও আত্মবিশ্বাসী করে তোলা...',
                    'columns'     => 5,
                ],
            ],
        ],
    ],
];

$boxes[] = [
    'title'      => 'আমাদের সম্পর্কে — পথচলা ও শিক্ষা পদ্ধতি',
    'id'         => 'cc_about_timeline_method',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'template' => [ 'page-about.php' ],
    ],
    'fields'     => [
        [
            'name'       => 'আমাদের পথচলা (Timeline)',
            'id'         => '_about_timeline',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ টাইমলাইন ধাপ যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'সাল / বছর',
                    'id'          => 'year',
                    'type'        => 'text',
                    'placeholder' => '২০১২',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'বিবরণ',
                    'id'          => 'text',
                    'type'        => 'textarea',
                    'rows'        => 2,
                    'placeholder' => 'মাত্র ২০ জন শিক্ষার্থী নিয়ে শুভ সূচনা...',
                    'columns'     => 8,
                ],
            ],
        ],
        [
            'name'       => 'আমাদের শিক্ষা পদ্ধতি (Methodology)',
            'id'         => '_about_method',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ পদ্ধতি যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'ইমোজি / আইকন',
                    'id'          => 'ico',
                    'type'        => 'text',
                    'placeholder' => '📖',
                    'columns'     => 3,
                ],
                [
                    'name'        => 'শিরোনাম',
                    'id'          => 'title',
                    'type'        => 'text',
                    'placeholder' => 'অধ্যায়ভিত্তিক লেকচার',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'বিবরণ',
                    'id'          => 'text',
                    'type'        => 'textarea',
                    'rows'        => 2,
                    'placeholder' => 'বোর্ড বইয়ের প্রতিটি অধ্যায় পুঙ্খানুপুঙ্খ ব্যাখ্যা...',
                    'columns'     => 5,
                ],
            ],
        ],
    ],
];

$boxes[] = [
    'title'      => 'আমাদের সম্পর্কে — পরিচালকের বার্তা ও সুবিধাসমূহ',
    'id'         => 'cc_about_chair_facil',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'include'    => [
        'template' => [ 'page-about.php' ],
    ],
    'fields'     => [
        [
            'name'             => 'অধ্যক্ষ / পরিচালকের ছবি',
            'id'               => '_about_chair_image',
            'type'             => 'single_image',
            'columns'          => 12,
        ],
        [
            'name'        => 'পরিচালকের নাম',
            'id'          => '_about_chair_name',
            'type'        => 'text',
            'placeholder' => 'যেমন: প্রফেসর আব্দুল্লাহ আল মামুন',
            'columns'     => 6,
        ],
        [
            'name'        => 'পরিচালকের পদবি',
            'id'          => '_about_chair_role',
            'type'        => 'text',
            'placeholder' => 'প্রতিষ্ঠাতা ও পরিচালক',
            'columns'     => 6,
        ],
        [
            'name'        => 'পরিচালকের বাণী / উদ্ধৃতি',
            'id'          => '_about_chair_quote',
            'type'        => 'textarea',
            'rows'        => 3,
            'placeholder' => 'শিক্ষা কোনো ব্যবসা নয়, এটি একটি আমানত...',
            'columns'     => 12,
        ],
        [
            'name'        => 'আমাদের সুবিধাসমূহ (প্রতি লাইনে একটি)',
            'id'          => '_about_facilities',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => "স্মার্ট ক্লাসরুম ও প্রজেক্টর সুবিধা\nশীতাতপ নিয়ন্ত্রিত ক্যাস্পাস\nসার্বক্ষণিক সিসিটিভি নিরাপত্তা",
            'columns'     => 6,
        ],
        [
            'name'        => 'স্বীকৃতি ও অর্জন (প্রতি লাইনে একটি)',
            'id'          => '_about_achievements',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => "২০২৩ সালে ৯৮% GPA-5\nক্যাডেট কলেজে ১২ জন চান্সপ্রাপ্ত\nশ্রেষ্ঠ কোচিং সম্মাননা ২০২২",
            'columns'     => 6,
        ],
    ],
];

/* ── 2. Contact Page ── */
$boxes[] = [
    'title'      => 'যোগাযোগ পেজ — তথ্য ও শাখা সেটিংস',
    'id'         => 'cc_contact_details',
    'post_types' => [ 'page' ],
    'context'    => 'normal',
    'priority'   => 'high',
    'include'    => [
        'template' => [ 'page-contact.php' ],
    ],
    'fields'     => [
        [
            'name'        => 'যোগাযোগ পেজের শিরোনাম',
            'id'          => '_contact_heading',
            'type'        => 'text',
            'placeholder' => 'যোগাযোগ করুন',
            'columns'     => 6,
        ],
        [
            'name'        => 'যোগাযোগ পেজের উপ-শিরোনাম',
            'id'          => '_contact_intro',
            'type'        => 'text',
            'placeholder' => 'ভর্তি, কোর্স বা যেকোনো তথ্যের জন্য সরাসরি যোগাযোগ করুন।',
            'columns'     => 6,
        ],
        [
            'name'        => 'বার্তা ফর্মের বিষয়সমূহ (Topics)',
            'id'          => '_contact_topics',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => "ভর্তি সংক্রান্ত\nফি ও স্কলারশিপ\nক্যাডেট কোচিং\nমডেল পরীক্ষা\nঅন্যান্য",
            'desc'        => 'প্রতি লাইনে একটি বিষয় লিখুন। ড্রপডাউনে প্রদর্শিত হবে।',
            'columns'     => 6,
        ],
        [
            'name'        => 'গুগল ম্যাপ এম্বেড লিংক (Embed URL or iframe)',
            'id'          => '_contact_map_embed',
            'type'        => 'textarea',
            'rows'        => 4,
            'placeholder' => 'https://www.google.com/maps/embed?pb=...',
            'desc'        => 'Google Maps iframe কোড বা embed URL দিন।',
            'columns'     => 6,
        ],
        [
            'name'       => 'শাখাসমূহ (Branches)',
            'id'         => '_contact_branches',
            'type'       => 'group',
            'clone'      => true,
            'sort_clone' => true,
            'add_button' => '+ নতুন শাখা যোগ করুন',
            'columns'    => 12,
            'fields'     => [
                [
                    'name'        => 'শাখার নাম',
                    'id'          => 'name',
                    'type'        => 'text',
                    'placeholder' => 'যেমন: উত্তরা শাখা',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'শাখার ফোন নম্বর',
                    'id'          => 'phone',
                    'type'        => 'text',
                    'placeholder' => '০১XXXXXXXXX',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'ম্যাপ লিংক (Google Maps Link)',
                    'id'          => 'map',
                    'type'        => 'url',
                    'placeholder' => 'https://maps.google.com/...',
                    'columns'     => 4,
                ],
                [
                    'name'        => 'শাখার পূর্ণ ঠিকানা',
                    'id'          => 'address',
                    'type'        => 'textarea',
                    'rows'        => 2,
                    'placeholder' => 'বাড়ি-০১, সেক্টর-৩, উত্তরা, ঢাকা',
                    'columns'     => 12,
                ],
            ],
        ],
    ],
];

/* ── 3. Site Information Settings Page ── */
$boxes[] = [
    'title'          => 'কোচিং সেন্টার — সামগ্রিক তথ্য (Site Info)',
    'id'             => 'cc_site_info_box',
    'settings_pages' => [ 'cc-site-info' ],
    'fields'         => [
        [
            'name'        => 'কোচিং সেন্টারের নাম / লোগো টেক্সট',
            'id'          => 'cc_logo_text',
            'type'        => 'text',
            'placeholder' => '🎓 জ্ঞানদীপ একাডেমি',
            'columns'     => 6,
        ],
        [
            'name'        => 'হেল্পলাইন ফোন নম্বর',
            'id'          => 'cc_phone',
            'type'        => 'text',
            'placeholder' => '০১XXX-XXXXXX',
            'columns'     => 6,
        ],
        [
            'name'        => 'ই-মেইল ঠিকানা',
            'id'          => 'cc_email',
            'type'        => 'email',
            'placeholder' => 'info@example.com',
            'columns'     => 6,
        ],
        [
            'name'        => 'হোয়াটসঅ্যাপ নম্বর',
            'id'          => 'cc_whatsapp',
            'type'        => 'text',
            'placeholder' => '8801XXXXXXXXX',
            'columns'     => 6,
        ],
        [
            'name'        => 'প্রধান কার্যালয়ের ঠিকানা',
            'id'          => 'cc_address',
            'type'        => 'textarea',
            'rows'        => 2,
            'placeholder' => 'বাড়ি-০০, রোড-০০, ঢাকা',
            'columns'     => 12,
        ],
        [
            'name'        => 'অফিস খোলা থাকার সময় (প্রতি লাইনে: বার|সময়)',
            'id'          => 'cc_open_hours',
            'type'        => 'textarea',
            'rows'        => 3,
            'placeholder' => "শনি – বৃহস্পতিবার|সকাল ৯টা – রাত ৮টা\nশুক্রবার|সকাল ১০টা – দুপুর ১টা",
            'columns'     => 12,
        ],
        [
            'name'        => 'ফেসবুক পেজ লিংক',
            'id'          => 'cc_facebook_url',
            'type'        => 'url',
            'placeholder' => 'https://facebook.com/...',
            'columns'     => 6,
        ],
        [
            'name'        => 'ইউটিউব চ্যানেল লিংক',
            'id'          => 'cc_youtube_url',
            'type'        => 'url',
            'placeholder' => 'https://youtube.com/...',
            'columns'     => 6,
        ],
    ],
];

return $boxes;
