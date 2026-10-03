<?php
/**
 * Template for regular pages that do not have a dedicated template.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$cc_body = trim( get_the_content() );
	?>
	<div class="top">
		<div class="wrap">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="wrap">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb26"><?php the_post_thumbnail( 'large' ); ?></div>
		<?php endif; ?>

		<?php if ( $cc_body ) : ?>
			<div class="card entry-content">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>

		<div class="cta mt26">
			<h2><?php esc_html_e( 'আমাদের সাথে যুক্ত হোন', 'coaching-centre' ); ?></h2>
			<p class="op9 mt0"><?php esc_html_e( 'কোর্স, ফি বা ভর্তি — যেকোনো প্রশ্নে আমরা আছি।', 'coaching-centre' ); ?></p>
			<a class="btn acc" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'ভর্তি হোন', 'coaching-centre' ); ?></a>
			<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'যোগাযোগ করুন', 'coaching-centre' ); ?></a>
		</div>
	</div>
	<?php
endwhile;

get_footer();