<?php
/**
 * Front page template — the full home page layout.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/stats' );
get_template_part( 'template-parts/home/programs' );
get_template_part( 'template-parts/home/features' );
get_template_part( 'template-parts/home/exam' );
get_template_part( 'template-parts/home/cadet' );
get_template_part( 'template-parts/home/teachers' );
get_template_part( 'template-parts/home/testimonials' );
get_template_part( 'template-parts/home/admission-cta' );
get_template_part( 'template-parts/home/faq' );

get_footer();