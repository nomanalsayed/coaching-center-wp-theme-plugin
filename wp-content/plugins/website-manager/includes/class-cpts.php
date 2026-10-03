<?php
/**
 * Custom Post Types & Taxonomies for Coaching Centre.
 *
 * Registers coaching centre CPTs:
 *   - cc_course      (Courses / Programs)
 *   - cc_teacher     (Instructors / Teachers)
 *   - cc_testimonial (Student / Guardian Testimonials)
 *   - cc_faq         (Frequently Asked Questions)
 *
 * And relevant taxonomies:
 *   - cc_course_cat  (Course categories / tab filters)
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CC_Manager_CPTs {

    public function __construct() {
        add_action( 'init', [ $this, 'register_post_types' ], 5 );
        add_action( 'init', [ $this, 'register_taxonomies' ], 5 );
        add_action( 'init', [ $this, 'seed_default_terms' ], 20 );

        // Admin column customizations: Courses
        add_filter( 'manage_cc_course_posts_columns',        [ $this, 'add_course_columns' ] );
        add_action( 'manage_cc_course_posts_custom_column',  [ $this, 'render_course_columns' ], 10, 2 );
        add_filter( 'manage_edit-cc_course_sortable_columns', [ $this, 'make_course_columns_sortable' ] );

        // Admin column customizations: Teachers
        add_filter( 'manage_cc_teacher_posts_columns',        [ $this, 'add_teacher_columns' ] );
        add_action( 'manage_cc_teacher_posts_custom_column',  [ $this, 'render_teacher_columns' ], 10, 2 );
        add_filter( 'manage_edit-cc_teacher_sortable_columns', [ $this, 'make_teacher_columns_sortable' ] );

        // Admin column customizations: Testimonials
        add_filter( 'manage_cc_testimonial_posts_columns',        [ $this, 'add_testimonial_columns' ] );
        add_action( 'manage_cc_testimonial_posts_custom_column',  [ $this, 'render_testimonial_columns' ], 10, 2 );
    }

    /* ─── CPT Registration ─── */

    public function register_post_types() {

        // 1. Course
        if ( ! post_type_exists( 'cc_course' ) ) {
            register_post_type( 'cc_course', [
                'labels'              => [
                    'name'               => 'কোর্সসমূহ',
                    'singular_name'      => 'কোর্স',
                    'add_new'            => 'নতুন কোর্স',
                    'add_new_item'       => 'নতুন কোর্স যোগ করুন',
                    'edit_item'          => 'কোর্স সম্পাদনা',
                    'new_item'           => 'নতুন কোর্স',
                    'view_item'          => 'কোর্স দেখুন',
                    'search_items'       => 'কোর্স খুঁজুন',
                    'not_found'          => 'কোনো কোর্স পাওয়া যায়নি',
                    'not_found_in_trash' => 'ট্র্যাশে কোনো কোর্স নেই',
                    'all_items'          => 'সব কোর্স',
                    'menu_name'          => 'কোর্স',
                ],
                'public'              => true,
                'has_archive'         => 'courses',
                'rewrite'             => [ 'slug' => 'course', 'with_front' => false ],
                'menu_icon'           => 'dashicons-welcome-learn-more',
                'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ],
                'show_in_rest'        => true,
                'menu_position'       => 26,
                'capability_type'     => 'post',
                'exclude_from_search' => false,
            ] );
        }

        // 2. Teacher
        if ( ! post_type_exists( 'cc_teacher' ) ) {
            register_post_type( 'cc_teacher', [
                'labels'        => [
                    'name'          => 'শিক্ষকমণ্ডলী',
                    'singular_name' => 'শিক্ষক',
                    'add_new'       => 'নতুন শিক্ষক',
                    'add_new_item'  => 'নতুন শিক্ষক যোগ করুন',
                    'edit_item'     => 'শিক্ষক সম্পাদনা',
                    'all_items'     => 'সব শিক্ষক',
                    'not_found'     => 'কোনো শিক্ষক পাওয়া যায়নি',
                    'menu_name'     => 'শিক্ষকমণ্ডলী',
                ],
                'public'        => true,
                'has_archive'   => 'teachers',
                'menu_icon'     => 'dashicons-groups',
                'supports'      => [ 'title', 'thumbnail', 'page-attributes' ],
                'show_in_rest'  => true,
                'menu_position' => 27,
                'rewrite'       => [ 'slug' => 'teacher', 'with_front' => false ],
            ] );
        }

        // 3. Testimonial
        if ( ! post_type_exists( 'cc_testimonial' ) ) {
            register_post_type( 'cc_testimonial', [
                'labels'        => [
                    'name'          => 'মতামত',
                    'singular_name' => 'মতামত',
                    'add_new'       => 'নতুন মতামত',
                    'add_new_item'  => 'নতুন মতামত যোগ করুন',
                    'edit_item'     => 'মতামত সম্পাদনা',
                    'all_items'     => 'সব মতামত',
                    'not_found'     => 'কোনো মতামত পাওয়া যায়নি',
                    'menu_name'     => 'মতামত',
                ],
                'public'        => false,
                'show_ui'       => true,
                'has_archive'   => false,
                'menu_icon'     => 'dashicons-format-quote',
                'supports'      => [ 'title', 'editor', 'page-attributes' ],
                'show_in_rest'  => true,
                'menu_position' => 28,
            ] );
        }

        // 4. FAQ
        if ( ! post_type_exists( 'cc_faq' ) ) {
            register_post_type( 'cc_faq', [
                'labels'        => [
                    'name'          => 'প্রশ্নোত্তর (FAQ)',
                    'singular_name' => 'প্রশ্নোত্তর',
                    'add_new'       => 'নতুন প্রশ্নোত্তর',
                    'add_new_item'  => 'নতুন প্রশ্নোত্তর যোগ করুন',
                    'edit_item'     => 'প্রশ্নোত্তর সম্পাদনা',
                    'all_items'     => 'সব প্রশ্নোত্তর',
                    'not_found'     => 'কোনো প্রশ্নোত্তর পাওয়া যায়নি',
                    'menu_name'     => 'প্রশ্নোত্তর',
                ],
                'public'        => false,
                'show_ui'       => true,
                'has_archive'   => false,
                'menu_icon'     => 'dashicons-editor-help',
                'supports'      => [ 'title', 'editor', 'page-attributes' ],
                'show_in_rest'  => true,
                'menu_position' => 29,
            ] );
        }
    }

    /* ─── Taxonomy Registration ─── */

    public function register_taxonomies() {
        if ( ! taxonomy_exists( 'cc_course_cat' ) ) {
            register_taxonomy( 'cc_course_cat', 'cc_course', [
                'labels'            => [
                    'name'          => 'কোর্স বিভাগ',
                    'singular_name' => 'কোর্স বিভাগ',
                    'search_items'  => 'বিভাগ খুঁজুন',
                    'all_items'     => 'সব বিভাগ',
                    'edit_item'     => 'বিভাগ সম্পাদনা',
                    'add_new_item'  => 'নতুন বিভাগ যোগ করুন',
                    'menu_name'     => 'বিভাগসমূহ',
                ],
                'hierarchical'      => true,
                'public'            => true,
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'rewrite'           => [ 'slug' => 'course-cat', 'with_front' => false ],
            ] );
        }
    }

    /**
     * Seed initial course category terms.
     */
    public function seed_default_terms() {
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

    /* ─── Admin Columns: Course ─── */

    public function add_course_columns( $columns ) {
        $new = [];
        foreach ( $columns as $key => $title ) {
            $new[ $key ] = $title;
            if ( 'title' === $key ) {
                $new['course_class'] = 'শ্রেণি';
                $new['course_fee']   = 'ফি';
                $new['course_group'] = 'গ্রুপ';
                $new['course_badge'] = 'ব্যাজ';
            }
        }
        $new['menu_order'] = 'অর্ডার';
        return $new;
    }

    public function render_course_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'course_class':
                echo esc_html( get_post_meta( $post_id, '_cc_class', true ) ?: '—' );
                break;
            case 'course_fee':
                $fee = get_post_meta( $post_id, '_cc_fee', true );
                echo $fee ? '৳ ' . esc_html( number_format( (float) $fee ) ) : 'বিনামূল্যে';
                break;
            case 'course_group':
                echo esc_html( get_post_meta( $post_id, '_cc_group', true ) ?: '—' );
                break;
            case 'course_badge':
                $badge = get_post_meta( $post_id, '_cc_badge', true );
                echo $badge ? '<span class="badge" style="background:#e0f2fe;color:#0369a1;padding:2px 6px;border-radius:4px;font-size:12px;">' . esc_html( $badge ) . '</span>' : '—';
                break;
            case 'menu_order':
                $post = get_post( $post_id );
                echo esc_html( $post->menu_order );
                break;
        }
    }

    public function make_course_columns_sortable( $columns ) {
        $columns['menu_order']   = 'menu_order';
        $columns['course_class'] = '_cc_class';
        return $columns;
    }

    /* ─── Admin Columns: Teacher ─── */

    public function add_teacher_columns( $columns ) {
        $new = [];
        foreach ( $columns as $key => $title ) {
            $new[ $key ] = $title;
            if ( 'title' === $key ) {
                $new['subject']     = 'বিষয় / বিভাগ';
                $new['designation'] = 'পদবি';
            }
        }
        $new['menu_order'] = 'অর্ডার';
        return $new;
    }

    public function render_teacher_columns( $column, $post_id ) {
        if ( 'subject' === $column ) {
            echo esc_html( get_post_meta( $post_id, '_cc_subject', true ) ?: '—' );
        } elseif ( 'designation' === $column ) {
            echo esc_html( get_post_meta( $post_id, '_cc_designation', true ) ?: '—' );
        } elseif ( 'menu_order' === $column ) {
            $post = get_post( $post_id );
            echo esc_html( $post->menu_order );
        }
    }

    public function make_teacher_columns_sortable( $columns ) {
        $columns['menu_order'] = 'menu_order';
        return $columns;
    }

    /* ─── Admin Columns: Testimonial ─── */

    public function add_testimonial_columns( $columns ) {
        $new = [];
        foreach ( $columns as $key => $title ) {
            $new[ $key ] = $title;
            if ( 'title' === $key ) {
                $new['role'] = 'পরিচয় / রোল';
            }
        }
        return $new;
    }

    public function render_testimonial_columns( $column, $post_id ) {
        if ( 'role' === $column ) {
            echo esc_html( get_post_meta( $post_id, '_cc_role', true ) ?: '—' );
        }
    }
}

// Backward compatibility alias for the loader
class_alias( 'CC_Manager_CPTs', 'XYZ_School_CPTs' );
