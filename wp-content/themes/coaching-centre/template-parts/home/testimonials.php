<?php
/**
 * Home: testimonials.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_quotes = get_posts(
	array(
		'post_type'      => 'cc_testimonial',
		'posts_per_page' => 9,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);

if ( ! $cc_quotes ) {
	return;
}
?>
<section id="testimonials" class="alt cc-section">
	<div class="wrap">
		<h2 data-cc="quotes_title"><?php echo esc_html( cc_hp( '_hp_quotes_title', 'cc_quotes_title' ) ); ?></h2>
		<p class="sub" data-cc="quotes_sub"><?php echo esc_html( cc_hp( '_hp_quotes_sub', 'cc_quotes_sub' ) ); ?></p>


		<div class="grid g3">
			<?php foreach ( $cc_quotes as $cc_quote ) : ?>
				<?php $cc_role = cc_course_field( $cc_quote->ID, '_cc_role' ); ?>
				<figure class="card testimonial">
					<blockquote>“<?php echo esc_html( cc_short_excerpt( 24 ) ); ?>”</blockquote>
					<figcaption>
						<b><?php echo esc_html( get_the_title( $cc_quote ) ); ?></b>
						<?php if ( $cc_role ) : ?>
							<br><small class="mute"><?php echo esc_html( $cc_role ); ?></small>
						<?php endif; ?>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>