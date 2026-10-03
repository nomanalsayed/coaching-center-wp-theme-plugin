<?php
/**
 * Helper functions for Coaching Centre Content Manager.
 *
 * Provides query helpers and Meta Box data accessors.
 *
 * @package Coaching_Centre_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ─── Query Helpers ─── */

/**
 * Get published courses ordered by menu_order.
 *
 * @param array $args Additional WP_Query arguments.
 * @return WP_Post[]|WP_Query
 */
if ( ! function_exists( 'cc_manager_get_courses' ) ) {
    function cc_manager_get_courses( $args = [] ) {
        $defaults = [
            'post_type'      => 'cc_course',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ],
        ];
        return new WP_Query( wp_parse_args( $args, $defaults ) );
    }
}

/**
 * Get teachers ordered by menu_order.
 *
 * @param int   $limit Max number of teachers.
 * @param array $args  Additional query args.
 * @return WP_Post[]
 */
if ( ! function_exists( 'cc_manager_get_teachers' ) ) {
    function cc_manager_get_teachers( $limit = -1, $args = [] ) {
        $defaults = [
            'post_type'      => 'cc_teacher',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ],
            'no_found_rows'  => true,
        ];
        $query = new WP_Query( wp_parse_args( $args, $defaults ) );
        return $query->posts;
    }
}

/**
 * Get testimonials ordered by menu_order.
 *
 * @param int   $limit Max number of testimonials.
 * @param array $args  Additional query args.
 * @return WP_Post[]
 */
if ( ! function_exists( 'cc_manager_get_testimonials' ) ) {
    function cc_manager_get_testimonials( $limit = -1, $args = [] ) {
        $defaults = [
            'post_type'      => 'cc_testimonial',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ],
            'no_found_rows'  => true,
        ];
        $query = new WP_Query( wp_parse_args( $args, $defaults ) );
        return $query->posts;
    }
}

/**
 * Get FAQs ordered by menu_order.
 *
 * @param int   $limit Max number of FAQs.
 * @param array $args  Additional query args.
 * @return WP_Post[]
 */
if ( ! function_exists( 'cc_manager_get_faqs' ) ) {
    function cc_manager_get_faqs( $limit = -1, $args = [] ) {
        $defaults = [
            'post_type'      => 'cc_faq',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'orderby'        => [
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ],
            'no_found_rows'  => true,
        ];
        $query = new WP_Query( wp_parse_args( $args, $defaults ) );
        return $query->posts;
    }
}

/* ─── Meta Box Field Accessors ─── */

/**
 * Read front page Meta Box meta with fallback.
 *
 * @param string $meta_key Meta Box key (e.g. '_hp_hero_title').
 * @param string $mod_key  Optional theme mod fallback key.
 * @param mixed  $default  Fallback value if empty.
 * @return mixed
 */
if ( ! function_exists( 'cc_hp' ) ) {
    function cc_hp( $meta_key, $mod_key = '', $default = '' ) {
        $front_page_id = (int) get_option( 'page_on_front' );
        $val           = '';

        if ( $front_page_id && function_exists( 'rwmb_meta' ) ) {
            $val = rwmb_meta( $meta_key, [], $front_page_id );
        }

        if ( ( '' === $val || null === $val || false === $val || [] === $val ) && $front_page_id ) {
            $val = get_post_meta( $front_page_id, $meta_key, true );
        }

        if ( '' !== $val && null !== $val && false !== $val && [] !== $val ) {
            return $val;
        }

        if ( $mod_key && function_exists( 'cc_opt' ) ) {
            return cc_opt( $mod_key );
        }

        if ( 0 === strpos( $meta_key, '_hp_' ) && function_exists( 'cc_opt' ) ) {
            $auto_mod_key = 'cc_' . substr( $meta_key, 4 );
            $mod_val      = cc_opt( $auto_mod_key );
            if ( '' !== $mod_val && null !== $mod_val && false !== $mod_val && [] !== $mod_val ) {
                return $mod_val;
            }
        }

        return $default;
    }
}


/**
 * Read Site Information from Meta Box settings page with fallback.
 *
 * @param string $field_id Settings field ID.
 * @param mixed  $default  Fallback value.
 * @return mixed
 */
if ( ! function_exists( 'cc_site_info' ) ) {
    function cc_site_info( $field_id, $default = '' ) {
        if ( function_exists( 'rwmb_meta' ) ) {
            $val = rwmb_meta( $field_id, [ 'object_type' => 'setting' ], 'cc-site-info' );
            if ( '' !== $val && null !== $val && false !== $val ) {
                return $val;
            }
        }
        $val = get_option( $field_id, '' );
        return ( '' !== $val && null !== $val ) ? $val : $default;
    }
}

/* ─── Backwards Compatibility Aliases ─── */

if ( ! function_exists( 'xyz_school_hp' ) ) {
    function xyz_school_hp( $field_id, $default = '' ) {
        return cc_hp( $field_id, $default );
    }
}

if ( ! function_exists( 'xyz_school_info' ) ) {
    function xyz_school_info( $field_id, $default = '' ) {
        return cc_site_info( $field_id, $default );
    }
}
