<?php
/**
 * Meta Box Field Registrations for XYZ School & College.
 *
 * Uses the Meta Box plugin API (rwmb_meta_boxes filter) to register
 * all custom fields for every CPT, page templates, and the homepage settings.
 *
 * Individual field groups are separated into modular partials in includes/meta-boxes/:
 * - meta-boxes-cpts.php      : CPTs (Teacher, Student, Notice, Gallery, Committee, Exam Results, Alumni)
 * - meta-boxes-pages.php     : Page templates (About, Speech, Academic Info, Contact)
 * - meta-boxes-homepage.php  : Homepage sections & School Information settings page
 *
 * Requires: Meta Box plugin (https://metabox.io) to be active.
 *
 * @package XYZ_School_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class XYZ_School_Meta_Boxes {

    public function __construct() {
        add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
        add_filter( 'rwmb_show', [ $this, 'filter_meta_box_display' ], 10, 2 );
        add_filter( 'mb_settings_pages', [ $this, 'register_settings_pages' ] );
    }

    /**
     * Register Meta Box settings page for Site Info.
     *
     * @param array $settings_pages Existing settings pages.
     * @return array
     */
    public function register_settings_pages( $settings_pages ) {
        if ( ! is_array( $settings_pages ) ) {
            $settings_pages = [];
        }
        $settings_pages[] = [
            'id'          => 'cc-site-info',
            'option_name' => 'cc_site_info',
            'menu_title'  => 'সাইট তথ্য',
            'page_title'  => 'কোচিং সেন্টার সামগ্রিক তথ্য',
            'icon_url'    => 'dashicons-admin-generic',
            'position'    => 30,
        ];
        return $settings_pages;
    }


    /**
     * Register all meta box field groups by combining modular partials.
     *
     * @param array $meta_boxes Existing meta boxes.
     * @return array
     */
    public function register_meta_boxes( $meta_boxes ) {
        if ( ! is_array( $meta_boxes ) ) {
            $meta_boxes = [];
        }

        $cpt_boxes      = require __DIR__ . '/meta-boxes/meta-boxes-cpts.php';
        $page_boxes     = require __DIR__ . '/meta-boxes/meta-boxes-pages.php';
        $homepage_boxes = require __DIR__ . '/meta-boxes/meta-boxes-homepage.php';

        if ( is_array( $cpt_boxes ) ) {
            $meta_boxes = array_merge( $meta_boxes, $cpt_boxes );
        }

        if ( is_array( $page_boxes ) ) {
            $meta_boxes = array_merge( $meta_boxes, $page_boxes );
        }

        if ( is_array( $homepage_boxes ) ) {
            $meta_boxes = array_merge( $meta_boxes, $homepage_boxes );
        }

        return $meta_boxes;
    }

    /**
     * Filter meta box display so page-specific meta boxes only appear on their matching pages/templates.
     *
     * @param bool  $show     Whether to show the meta box.
     * @param array $meta_box Meta box configuration array.
     * @return bool
     */
    public function filter_meta_box_display( $show, $meta_box ) {
        if ( empty( $meta_box['include'] ) ) {
            return $show;
        }

        $post_id = $this->get_current_post_id();

        if ( ! $post_id ) {
            // When creating a new page or outside post context, do not show front-page-only or template-specific boxes
            if ( ! empty( $meta_box['include']['is_front_page'] ) || ! empty( $meta_box['include']['template'] ) ) {
                return false;
            }
            return $show;
        }

        $include = $meta_box['include'];

        // 1. Check is_front_page
        if ( isset( $include['is_front_page'] ) ) {
            $front_page_id = (int) get_option( 'page_on_front' );
            $is_front      = ( $post_id > 0 && $post_id === $front_page_id );

            if ( (bool) $include['is_front_page'] !== $is_front ) {
                return false;
            }
        }

        // 2. Check page template / slug
        if ( ! empty( $include['template'] ) ) {
            $current_template = get_post_meta( $post_id, '_wp_page_template', true );
            $templates        = (array) $include['template'];
            $matched          = in_array( $current_template, $templates, true );

            // Also match if slug is one of the recognized slugs
            if ( ! $matched ) {
                $post = get_post( $post_id );
                $slug = $post ? $post->post_name : '';

                if ( ( in_array( 'page-about.php', $templates, true ) || in_array( 'about', $templates, true ) ) && in_array( $slug, [ 'about-us', 'about' ], true ) ) {
                    $matched = true;
                } elseif ( ( in_array( 'page-contact.php', $templates, true ) || in_array( 'contact', $templates, true ) ) && in_array( $slug, [ 'contact', 'contact-us' ], true ) ) {
                    $matched = true;
                } elseif ( ( in_array( 'page-registration.php', $templates, true ) || in_array( 'registration', $templates, true ) ) && in_array( $slug, [ 'registration', 'admission', 'apply' ], true ) ) {
                    $matched = true;
                }

            }

            if ( ! $matched ) {
                return false;
            }
        }

        return $show;
    }

    /**
     * Get current post ID across edit screen, AJAX, and REST requests.
     *
     * @return int
     */
    private function get_current_post_id() {
        if ( isset( $_GET['post'] ) ) {
            return (int) $_GET['post'];
        }
        if ( isset( $_POST['post_ID'] ) ) {
            return (int) $_POST['post_ID'];
        }
        if ( isset( $_POST['post_id'] ) ) {
            return (int) $_POST['post_id'];
        }
        if ( isset( $_GET['post_id'] ) ) {
            return (int) $_GET['post_id'];
        }
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST && ! empty( $_SERVER['REQUEST_URI'] ) ) {
            if ( preg_match( '#/wp/v2/(?:pages|posts)/(\d+)#', $_SERVER['REQUEST_URI'], $m ) ) {
                return (int) $m[1];
            }
        }
        return 0;
    }
}
