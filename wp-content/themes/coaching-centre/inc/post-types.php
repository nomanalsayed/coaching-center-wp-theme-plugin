<?php
/**
 * Custom post types, taxonomies and post statuses.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bengali labels for the registration workflow statuses.
 *
 * @return array
 */
function cc_statuses() {
	return array(
		'cc-pending'   => __( 'অপেক্ষমাণ', 'coaching-centre' ),
		'cc-confirmed' => __( 'নিশ্চিত', 'coaching-centre' ),
		'cc-completed' => __( 'সম্পন্ন', 'coaching-centre' ),
		'cc-cancelled' => __( 'বাতিল', 'coaching-centre' ),
	);
}

/**
 * A slug of an assignment kind.
 *
 * @return array
 */
function cc_kinds() {
	return array(
		'admission' => __( 'ভর্তি', 'coaching-centre' ),
		'exam'      => __( 'মডেল পরীক্ষা', 'coaching-centre' ),
	);
}

/**
 * Register the custom post statuses used by registrations.
 */
function cc_register_post_statuses() {
	foreach ( cc_statuses() as $status => $label ) {
		register_post_status(
			$status,
			array(
				'label'                     => $label,
				'public'                    => false,
				'internal'                  => true,
				'protected'                 => true,
				'private'                   => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
			)
		);
	}
}
add_action( 'init', 'cc_register_post_statuses' );

/**
 * Register post types and taxonomies.
 */
function cc_register_post_types() {
	$slug = get_template_directory();

	if ( ! post_type_exists( 'cc_course' ) ) {
		register_post_type(
			'cc_course',
			array(
				'labels'              => array(
					'name'               => __( 'কোর্স', 'coaching-centre' ),
					'singular_name'      => __( 'কোর্স', 'coaching-centre' ),
					'add_new'            => __( 'নতুন কোর্স', 'coaching-centre' ),
					'add_new_item'       => __( 'নতুন কোর্স যোগ করুন', 'coaching-centre' ),
					'edit_item'          => __( 'কোর্স সম্পাদনা', 'coaching-centre' ),
					'new_item'           => __( 'নতুন কোর্স', 'coaching-centre' ),
					'view_item'          => __( 'কোর্স দেখুন', 'coaching-centre' ),
					'search_items'       => __( 'কোর্স খুঁজুন', 'coaching-centre' ),
					'not_found'          => __( 'কোনো কোর্স পাওয়া যায়নি।', 'coaching-centre' ),
					'not_found_in_trash' => __( 'ট্র্যাশে কোনো কোর্স নেই।', 'coaching-centre' ),
					'all_items'          => __( 'সব কোর্স', 'coaching-centre' ),
					'menu_name'          => __( 'কোর্স', 'coaching-centre' ),
				),
				'public'             => true,
				'has_archive'        => 'courses',
				'rewrite'            => array(
					'slug'       => 'course',
					'with_front' => false,
				),
				'menu_icon'          => 'dashicons-welcome-learn-more',
				'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
				'show_in_rest'       => true,
				'menu_position'      => 26,
				'capability_type'    => 'post',
				'exclude_from_search' => false,
			)
		);
	}

	if ( ! taxonomy_exists( 'cc_course_cat' ) ) {
		register_taxonomy(
			'cc_course_cat',
			'cc_course',
			array(
				'labels'            => array(
					'name'          => __( 'কোর্স বিভাগ', 'coaching-centre' ),
					'singular_name' => __( 'কোর্স বিভাগ', 'coaching-centre' ),
					'search_items'  => __( 'বিভাগ খুঁজুন', 'coaching-centre' ),
					'all_items'     => __( 'সব বিভাগ', 'coaching-centre' ),
					'edit_item'     => __( 'বিভাগ সম্পাদনা', 'coaching-centre' ),
					'add_new_item'  => __( 'নতুন বিভাগ যোগ করুন', 'coaching-centre' ),
					'menu_name'     => __( 'বিভাগসমূহ', 'coaching-centre' ),
				),
				'hierarchical'      => true,
				'public'            => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'       => 'course-cat',
					'with_front' => false,
				),
			)
		);
	}

	if ( ! post_type_exists( 'cc_teacher' ) ) {
		register_post_type(
			'cc_teacher',
			array(
				'labels'        => array(
					'name'          => __( 'শিক্ষকমণ্ডলী', 'coaching-centre' ),
					'singular_name' => __( 'শিক্ষক', 'coaching-centre' ),
					'add_new'       => __( 'নতুন শিক্ষক', 'coaching-centre' ),
					'add_new_item'  => __( 'নতুন শিক্ষক যোগ করুন', 'coaching-centre' ),
					'edit_item'     => __( 'শিক্ষক সম্পাদনা', 'coaching-centre' ),
					'all_items'     => __( 'সব শিক্ষক', 'coaching-centre' ),
					'not_found'     => __( 'কোনো শিক্ষক পাওয়া যায়নি।', 'coaching-centre' ),
					'menu_name'     => __( 'শিক্ষকমণ্ডলী', 'coaching-centre' ),
				),
				'public'       => true,
				'has_archive'  => 'teachers',
				'menu_icon'    => 'dashicons-groups',
				'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
				'show_in_rest' => true,
				'rewrite'      => array(
					'slug'       => 'teacher',
					'with_front' => false,
				),
			)
		);
	}

	if ( ! post_type_exists( 'cc_testimonial' ) ) {
		register_post_type(
			'cc_testimonial',
			array(
				'labels'        => array(
					'name'          => __( 'মতামত', 'coaching-centre' ),
					'singular_name' => __( 'মতামত', 'coaching-centre' ),
					'add_new'       => __( 'নতুন মতামত', 'coaching-centre' ),
					'add_new_item'  => __( 'নতুন মতামত যোগ করুন', 'coaching-centre' ),
					'edit_item'     => __( 'মতামত সম্পাদনা', 'coaching-centre' ),
					'all_items'     => __( 'সব মতামত', 'coaching-centre' ),
					'not_found'     => __( 'কোনো মতামত পাওয়া যায়নি।', 'coaching-centre' ),
					'menu_name'     => __( 'মতামত', 'coaching-centre' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'has_archive'  => false,
				'menu_icon'    => 'dashicons-format-quote',
				'supports'     => array( 'title', 'editor', 'page-attributes' ),
				'show_in_rest' => true,
			)
		);
	}

	if ( ! post_type_exists( 'cc_faq' ) ) {
		register_post_type(
			'cc_faq',
			array(
				'labels'        => array(
					'name'          => __( 'প্রশ্নোত্তর', 'coaching-centre' ),
					'singular_name' => __( 'প্রশ্নোত্তর', 'coaching-centre' ),
					'add_new'       => __( 'নতুন প্রশ্নোত্তর', 'coaching-centre' ),
					'add_new_item'  => __( 'নতুন প্রশ্নোত্তর যোগ করুন', 'coaching-centre' ),
					'edit_item'     => __( 'প্রশ্নোত্তর সম্পাদনা', 'coaching-centre' ),
					'all_items'     => __( 'সব প্রশ্নোত্তর', 'coaching-centre' ),
					'not_found'     => __( 'কোনো প্রশ্নোত্তর পাওয়া যায়নি।', 'coaching-centre' ),
					'menu_name'     => __( 'প্রশ্নোত্তর', 'coaching-centre' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'has_archive'  => false,
				'menu_icon'    => 'dashicons-editor-help',
				'supports'     => array( 'title', 'editor', 'page-attributes' ),
				'show_in_rest' => true,
			)
		);
	}


	register_post_type(
		'cc_registration',
		array(
			'labels'              => array(
				'name'          => __( 'ভর্তি আবেদন', 'coaching-centre' ),
				'singular_name' => __( 'আবেদন', 'coaching-centre' ),
				'all_items'     => __( 'সব আবেদন', 'coaching-centre' ),
				'not_found'     => __( 'কোনো আবেদন পাওয়া যায়নি।', 'coaching-centre' ),
				'menu_name'     => __( 'আবেদন', 'coaching-centre' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => 'cc-dashboard',
			'show_in_rest'        => false,
			'menu_icon'           => 'dashicons-list-view',
			'supports'            => array( 'title' ),
			'capabilities'        => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'        => true,
		)
	);

	register_post_type(
		'cc_message',
		array(
			'labels'              => array(
				'name'          => __( 'বার্তা', 'coaching-centre' ),
				'singular_name' => __( 'বার্তা', 'coaching-centre' ),
				'all_items'     => __( 'সব বার্তা', 'coaching-centre' ),
				'not_found'     => __( 'কোনো বার্তা পাওয়া যায়নি।', 'coaching-centre' ),
				'menu_name'     => __( 'বার্তা', 'coaching-centre' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => 'cc-dashboard',
			'show_in_rest'        => false,
			'menu_icon'           => 'dashicons-email',
			'supports'            => array( 'title' ),
			'capabilities'        => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'cc_register_post_types' );

/**
 * Seed the course categories that power the homepage tabs.
 */
function cc_seed_terms() {
	$terms = array(
		'acad'    => __( 'একাডেমিক', 'coaching-centre' ),
		'scholar' => __( 'বৃত্তি', 'coaching-centre' ),
		'ssc'     => __( 'SSC', 'coaching-centre' ),
		'cadet'   => __( 'ক্যাডেট', 'coaching-centre' ),
	);

	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, 'cc_course_cat' ) ) {
			wp_insert_term( $name, 'cc_course_cat', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'init', 'cc_seed_terms', 20 );

/**
 * Default taxonomy selections in the course editor.
 *
 * @param int $post_id Course ID.
 * @return string[]
 */
function cc_course_classes() {
	global $wpdb;

	$rows = $wpdb->get_col( "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_cc_class' AND meta_value <> '' ORDER BY meta_value ASC" );

	return $rows ? $rows : array();
}

/**
 * Published courses, ordered by the manual menu order.
 *
 * @param array $args Optional overrides for get_posts().
 * @return WP_Post[]
 */
function cc_get_courses( $args = array() ) {
	$defaults = array(
		'post_type'              => 'cc_course',
		'posts_per_page'         => -1,
		'orderby'                => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'          => true,
		'suppress_filters'       => false,
	);

	$query = new WP_Query( wp_parse_args( $args, $defaults ) );

	return $query->posts;
}

/**
 * Courses that should appear in the public grid.
 *
 * @param int $limit Maximum number of courses.
 * @return WP_Post[]
 */
function cc_visible_courses( $limit = -1 ) {
	return cc_get_courses(
		array(
			'posts_per_page' => $limit,
			'meta_query'     => array(
				array(
					'key'     => '_cc_hidden',
					'compare' => 'NOT EXISTS',
				),
			),
		)
	);
}

/**
 * Primary term slug of a course, used for the homepage tab filter.
 *
 * @param int $post_id Course ID.
 * @return string
 */
function cc_course_cat_slug( $post_id ) {
	$terms = get_the_terms( $post_id, 'cc_course_cat' );

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return 'acad';
	}

	return $terms[0]->slug;
}

/**
 * Human readable name of a course's primary term.
 *
 * @param int $post_id Course ID.
 * @return string
 */
function cc_course_cat_name( $post_id ) {
	$terms = get_the_terms( $post_id, 'cc_course_cat' );

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return '';
	}

	return $terms[0]->name;
}