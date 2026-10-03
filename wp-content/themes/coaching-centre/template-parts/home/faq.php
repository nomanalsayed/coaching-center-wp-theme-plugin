<?php
/**
 * Home: FAQ accordion.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_faqs = get_posts(
	array(
		'post_type'      => 'cc_faq',
		'posts_per_page' => 12,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);

if ( ! $cc_faqs ) {
	return;
}
?>
<section id="faq" class="cc-section pad-t0">
	<div class="wrap">
		<h2 data-cc="faq_title"><?php echo esc_html( cc_hp( '_hp_faq_title', 'cc_faq_title' ) ); ?></h2>


		<?php foreach ( $cc_faqs as $cc_faq ) : ?>
			<details>
				<summary><?php echo esc_html( get_the_title( $cc_faq ) ); ?></summary>
				<div class="entry-content"><?php echo wp_kses_post( wpautop( wp_strip_all_tags( $cc_faq->post_content ) ) ); ?></div>
			</details>
		<?php endforeach; ?>
	</div>
</section>