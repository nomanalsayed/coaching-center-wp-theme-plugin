<?php
/**
 * Home: teachers.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_teachers = get_posts(
	array(
		'post_type'      => 'cc_teacher',
		'posts_per_page' => 12,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);

if ( ! $cc_teachers ) {
	return;
}
?>
<section id="teachers" class="cc-section">
	<div class="wrap">
		<h2 data-cc="teachers_title"><?php echo esc_html( cc_hp( '_hp_teachers_title', 'cc_teachers_title' ) ); ?></h2>
		<p class="sub" data-cc="teachers_sub"><?php echo esc_html( cc_hp( '_hp_teachers_sub', 'cc_teachers_sub' ) ); ?></p>


		<div class="grid g4">
			<?php foreach ( $cc_teachers as $cc_teacher ) : ?>
				<?php
				$cc_subject     = cc_course_field( $cc_teacher->ID, '_cc_subject' );
				$cc_designation = cc_course_field( $cc_teacher->ID, '_cc_designation' );
				?>
				<article class="card t">
					<?php
					echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
						get_post_thumbnail_id( $cc_teacher ),
						__( 'ছবি', 'coaching-centre' ),
						'teacher-media rounded',
						'cc-avatar',
						'height:150px;width:150px;margin:0 auto 10px'
					);
					?>
					<b><?php echo esc_html( get_the_title( $cc_teacher ) ); ?></b>

					<?php if ( $cc_designation ) : ?>
						<br><small class="mute"><?php echo esc_html( $cc_designation ); ?></small>
					<?php endif; ?>
					<?php if ( $cc_subject ) : ?>
						<br><small><?php echo esc_html( $cc_subject ); ?></small>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>