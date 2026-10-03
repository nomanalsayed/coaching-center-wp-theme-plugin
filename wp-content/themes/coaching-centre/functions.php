<?php
/**
 * Coaching Centre theme bootstrap.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

define( 'CC_VERSION', '1.0.0' );
define( 'CC_DIR', trailingslashit( get_template_directory() ) );
define( 'CC_URI', trailingslashit( get_template_directory_uri() ) );

/**
 * Load theme modules.
 */
$cc_modules = array(
	'helpers',
	'post-types',
	'meta-boxes',
	'template-functions',
	'forms',
	'customizer',
	'admin',
	'demo-content',
);

foreach ( $cc_modules as $cc_module ) {
	$cc_module_path = CC_DIR . 'inc/' . $cc_module . '.php';

	if ( is_readable( $cc_module_path ) ) {
		require_once $cc_module_path;
	}
}

unset( $cc_modules, $cc_module, $cc_module_path );

/**
 * Theme supports and menus.
 */
function cc_setup() {
	load_theme_textdomain( 'coaching-centre', CC_DIR . 'languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'cc-card', 600, 400, true );
	add_image_size( 'cc-hero', 1200, 800, true );
	add_image_size( 'cc-avatar', 300, 300, true );

	register_nav_menus(
		array(
			'primary' => __( 'প্রধান মেনু', 'coaching-centre' ),
			'footer'  => __( 'ফুটার মেনু', 'coaching-centre' ),
		)
	);
}
add_action( 'after_setup_theme', 'cc_setup' );

/**
 * Content width for embeds.
 */
function cc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cc_content_width', 1140 );
}
add_action( 'after_setup_theme', 'cc_content_width', 0 );

/**
 * Front-end assets.
 */
function cc_scripts() {
	$css_file = CC_DIR . 'style.css';
	$js_file  = CC_DIR . 'assets/js/theme.js';

	wp_enqueue_style(
		'coaching-centre',
		get_stylesheet_uri(),
		array(),
		file_exists( $css_file ) ? (string) filemtime( $css_file ) : CC_VERSION
	);

	wp_enqueue_style(
		'coaching-centre-fonts',
		'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- external URL, let Google cache it.
	);

	wp_enqueue_script(
		'coaching-centre',
		CC_URI . 'assets/js/theme.js',
		array(),
		file_exists( $js_file ) ? (string) filemtime( $js_file ) : CC_VERSION,
		true
	);

	wp_localize_script(
		'coaching-centre',
		'ccTheme',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'ajaxNonce'    => wp_create_nonce( 'cc_admin' ),
			'confirmClose' => __( 'সত্যিই মুছে ফেলবেন?', 'coaching-centre' ),
			'confirmAll'   => __( 'সব আবেদন মুছে ফেলবেন? এটি ফেরানো যাবে না।', 'coaching-centre' ),
			'programs'     => cc_program_json(),
			'i18n'         => array(
				'all'        => __( 'সব কোর্স', 'coaching-centre' ),
				'pickClass'  => __( '-- প্রোগ্রাম বেছে নিন --', 'coaching-centre' ),
				'pickProg'   => __( '-- আগে শ্রেণি বেছে নিন --', 'coaching-centre' ),
				'noProgram'  => __( 'এই শ্রেণিতে কোনো প্রোগ্রাম নেই।', 'coaching-centre' ),
				'sending'    => __( 'পাঠানো হচ্ছে…', 'coaching-centre' ),
				'sent'       => __( 'ধন্যবাদ! আপনার বার্তা পেয়েছি।', 'coaching-centre' ),
				'networkErr' => __( 'একটি সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'coaching-centre' ),
				'printing'   => __( 'রসিদ প্রিন্ট হচ্ছে…', 'coaching-centre' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cc_scripts' );

/**
 * Preconnect to Google Fonts for a faster first paint.
 *
 * @param array  $urls          Resource hint URLs.
 * @param string $relation_type Hint type.
 * @return array
 */
function cc_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin' => '',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'cc_resource_hints', 10, 2 );

/**
 * Extra body classes.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function cc_body_classes( $classes ) {
	$classes[] = 'cc-theme';

	if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_singular() ) {
		$classes[] = 'no-sidebar';
	}

	if ( cc_opt( 'cc_dark_mode' ) ) {
		$classes[] = 'cc-dark';
	}

	return $classes;
}
add_filter( 'body_class', 'cc_body_classes' );

/**
 * Map the pages created on activation to their dedicated templates.
 *
 * @param string $template Template resolved by WordPress.
 * @return string
 */
function cc_template_include( $template ) {
	if ( is_page() && ! is_front_page() ) {
		$post_id  = get_queried_object_id();
		$slug     = get_post_field( 'post_name', $post_id );
		$assigned = get_post_meta( $post_id, '_wp_page_template', true );

		if ( 'default' === $assigned || '' === $assigned ) {
			$map = array(
				'about-us'     => 'page-about.php',
				'contact'      => 'page-contact.php',
				'registration' => 'page-registration.php',
			);

			if ( isset( $map[ $slug ] ) && file_exists( CC_DIR . $map[ $slug ] ) ) {
				return CC_DIR . $map[ $slug ];
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'cc_template_include' );

/**
 * Load the theme stylesheet inside the editor so blocks look like the front end.
 */
function cc_editor_assets() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'cc_editor_assets' );

/**
 * Excerpt length tuned for the card layouts.
 *
 * @return int
 */
function cc_excerpt_length() {
	return 26;
}
add_filter( 'excerpt_length', 'cc_excerpt_length' );

/**
 * Excerpt ellipsis in Bengali typography.
 *
 * @return string
 */
function cc_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cc_excerpt_more' );

/**
 * Flush rewrite rules once after the theme is activated.
 */
function cc_after_switch_theme() {
	cc_register_post_types();
	cc_register_post_statuses();
	cc_seed_terms();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cc_after_switch_theme' );