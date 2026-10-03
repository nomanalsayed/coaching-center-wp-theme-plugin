<?php
/**
 * Single course.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$cc_id     = get_the_ID();
	$cc_fee    = cc_course_fee( $cc_id );
	$cc_class  = cc_course_field( $cc_id, '_cc_class' );
	$cc_cat    = cc_course_cat_name( $cc_id );
	$cc_badge  = cc_course_field( $cc_id, '_cc_badge' );
	$cc_seats  = cc_course_field( $cc_id, '_cc_seats' );
	$cc_days   = cc_course_field( $cc_id, '_cc_days' );
	$cc_modes  = cc_course_modes( $cc_id );
	$cc_feats  = cc_course_features( $cc_id );
	?>

	<div class="top">
		<div class="wrap">
			<?php if ( $cc_badge ) : ?>
				<span class="tag tag-solid"><?php echo esc_html( $cc_badge ); ?></span>
			<?php endif; ?>

			<h1><?php the_title(); ?></h1>

			<p>
				<?php
				echo esc_html( trim( $cc_cat . ( $cc_class ? ' • ' . $cc_class : '' ) ) );
				?>
			</p>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mt16"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="wrap">
		<div class="cc-layout">
			<div class="card entry-content">
				<?php the_content(); ?>

				<?php if ( $cc_feats ) : ?>
					<h3><?php esc_html_e( 'কোর্সের বৈশিষ্ট্য', 'coaching-centre' ); ?></h3>
					<?php cc_checklist( $cc_feats ); ?>
				<?php endif; ?>
			</div>

			<aside>
				<div class="card sticky">
					<?php if ( $cc_fee ) : ?>
						<div class="price"><?php echo esc_html( cc_money( $cc_fee ) ); ?></div>
						<small class="mute"><?php esc_html_e( 'সেশন ফি', 'coaching-centre' ); ?></small>
					<?php endif; ?>

					<?php if ( $cc_seats ) : ?>
						<p><?php echo esc_html( sprintf( /* translators: %s: seat count */ __( 'আসন: %s জন', 'coaching-centre' ), $cc_seats ) ); ?></p>
					<?php endif; ?>

					<?php if ( $cc_days ) : ?>
						<p><?php echo esc_html( sprintf( /* translators: %s: class days */ __( 'ক্লাসের দিন: %s', 'coaching-centre' ), $cc_days ) ); ?></p>
					<?php endif; ?>

					<?php if ( $cc_modes ) : ?>
						<h4><?php esc_html_e( 'অংশগ্রহণের মাধ্যম', 'coaching-centre' ); ?></h4>
						<?php cc_bullets( $cc_modes ); ?>
					<?php endif; ?>

					<a class="btn lg cc-full" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'এই কোর্সে ভর্তি হোন', 'coaching-centre' ); ?></a>

					<p class="mute sm mt12 mb0">
						<a href="<?php echo esc_url( cc_tel_href() ); ?>">📞 <?php echo esc_html( cc_opt( 'cc_phone' ) ); ?></a>
					</p>
				</div>
			</aside>
		</div>

		<div class="cta mt26">
			<h2><?php esc_html_e( 'অন্য কোর্স দেখুন', 'coaching-centre' ); ?></h2>
			<a class="btn acc" href="<?php echo esc_url( home_url( '/#programs' ) ); ?>"><?php esc_html_e( 'সব কোর্স', 'coaching-centre' ); ?></a>
			<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'আমাদের সম্পর্কে', 'coaching-centre' ); ?></a>
		</div>
	</div>
	<?php
endwhile;

get_footer();