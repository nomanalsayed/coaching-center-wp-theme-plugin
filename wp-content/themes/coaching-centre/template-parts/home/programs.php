<?php
/**
 * Home: course grid with tab filtering.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_courses = cc_visible_courses();
$cc_tabs    = cc_course_tabs();
$cc_icons   = array(
	'acad'    => '📘',
	'scholar' => '🏅',
	'ssc'     => '🎓',
	'cadet'   => '🎖️',
);
?>
<section id="programs" class="cc-section">
	<div class="wrap">
		<h2 data-cc="programs_title"><?php echo esc_html( cc_hp( '_hp_programs_title', 'cc_programs_title' ) ); ?></h2>
		<p class="sub" data-cc="programs_sub"><?php echo esc_html( cc_hp( '_hp_programs_sub', 'cc_programs_sub' ) ); ?></p>


		<?php if ( $cc_tabs ) : ?>
			<div class="tabs" id="tabs" role="tablist" aria-label="<?php esc_attr_e( 'কোর্স বিভাগ', 'coaching-centre' ); ?>">
				<button type="button" class="tab on" data-f="all" role="tab" aria-selected="true"><?php esc_html_e( 'সব কোর্স', 'coaching-centre' ); ?></button>
				<?php foreach ( $cc_tabs as $cc_term ) : ?>
					<button type="button" class="tab" data-f="<?php echo esc_attr( $cc_term->slug ); ?>" role="tab" aria-selected="false">
						<?php echo esc_html( ( isset( $cc_icons[ $cc_term->slug ] ) ? $cc_icons[ $cc_term->slug ] . ' ' : '' ) . $cc_term->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $cc_courses ) : ?>
			<div class="grid g3" id="plist">
				<?php foreach ( $cc_courses as $cc_course ) : ?>
					<?php
					$cc_cat     = cc_course_cat_slug( $cc_course->ID );
					$cc_badge   = cc_course_field( $cc_course->ID, '_cc_badge' );
					$cc_fee     = cc_course_fee( $cc_course->ID );
					$cc_class   = cc_course_field( $cc_course->ID, '_cc_class' );
					$cc_feats   = cc_course_features( $cc_course->ID );
					?>
					<article class="card prog" data-cat="<?php echo esc_attr( $cc_cat ); ?>">
						<a href="<?php echo esc_url( get_permalink( $cc_course ) ); ?>" aria-hidden="true" tabindex="-1">
							<?php
							echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
								get_post_thumbnail_id( $cc_course ),
								__( 'কোর্স ইমেজ', 'coaching-centre' ),
								'prog-media',
								'cc-card',
								'height:130px;margin-bottom:12px'
							);
							?>
						</a>

						<div class="row">
							<?php if ( $cc_badge ) : ?>
								<span class="badge"><?php echo esc_html( $cc_badge ); ?></span>
							<?php endif; ?>
							<?php if ( $cc_fee ) : ?>
								<b class="cc-fee"><?php echo esc_html( cc_money( $cc_fee ) ); ?></b>
							<?php endif; ?>
						</div>

						<h3>
							<a href="<?php echo esc_url( get_permalink( $cc_course ) ); ?>"><?php echo esc_html( get_the_title( $cc_course ) ); ?></a>
						</h3>

						<?php if ( $cc_class ) : ?>
							<p class="mute sm mb12"><?php echo esc_html( $cc_class ); ?></p>
						<?php endif; ?>

						<?php cc_bullets( $cc_feats ); ?>

						<a href="<?php echo esc_url( cc_registration_url() ); ?>" class="btn"><?php esc_html_e( 'বিস্তারিত ও ভর্তি', 'coaching-centre' ); ?></a>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="no-results" id="cc-programs-empty" hidden><?php esc_html_e( 'এই বিভাগে কোনো কোর্স নেই।', 'coaching-centre' ); ?></p>
		<?php else : ?>
			<p class="no-results"><?php esc_html_e( 'এখনো কোনো কোর্স যোগ করা হয়নি। অ্যাডমিন → কোচিং সেন্টার → কোর্স থেকে কোর্স যোগ করুন।', 'coaching-centre' ); ?></p>
		<?php endif; ?>
	</div>
</section>