<?php
/**
 * 404 — page not found.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

$cc_courses = cc_visible_courses();
?>
<div class="top">
	<div class="wrap">
		<h1><?php esc_html_e( '৪০৪ — পাতাটি খুঁজে পাওয়া যায়নি', 'coaching-centre' ); ?></h1>
		<p><?php esc_html_e( 'ঠিকানাটি ভুল হয়ে গেছে অথবা পাতাটি সরিয়ে ফেলা হয়েছে। নিচের লিংক থেকে শুরু করুন।', 'coaching-centre' ); ?></p>
	</div>
</div>

<div class="wrap">
	<div class="card">
		<div class="cta">
			<h2 class="mt0"><?php esc_html_e( 'কোথায় যাবেন?', 'coaching-centre' ); ?></h2>

			<a class="btn acc" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'হোমপেজ', 'coaching-centre' ); ?></a>
			<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'আমাদের সম্পর্কে', 'coaching-centre' ); ?></a>
			<a class="btn o ml8" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'ভর্তি ফর্ম', 'coaching-centre' ); ?></a>
			<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'যোগাযোগ', 'coaching-centre' ); ?></a>
		</div>
	</div>

	<?php if ( $cc_courses ) : ?>
		<h2 class="mt26"><?php esc_html_e( 'জনপ্রিয় কোর্স', 'coaching-centre' ); ?></h2>

		<div class="grid g3">
			<?php foreach ( array_slice( $cc_courses, 0, 3 ) as $cc_course ) : ?>
				<article class="card">
					<h3><a href="<?php echo esc_url( get_permalink( $cc_course ) ); ?>"><?php echo esc_html( get_the_title( $cc_course ) ); ?></a></h3>

					<?php if ( cc_course_fee( $cc_course->ID ) ) : ?>
						<p class="mb0"><b class="cc-fee"><?php echo esc_html( cc_money( cc_course_fee( $cc_course->ID ) ) ); ?></b></p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();