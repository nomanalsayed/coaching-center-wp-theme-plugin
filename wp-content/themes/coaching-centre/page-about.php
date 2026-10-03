<?php
/**
 * Template Name: About — জ্ঞানদীপ সম্পর্কে
 *
 * Replaces the static about-us.html prototype.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

$cc_about_id = get_queried_object_id();
$cc_stats    = cc_page_meta( '_about_stats', 'cc_about_stats', array(), $cc_about_id );
$cc_mv       = (array) cc_page_meta( '_about_mv', 'cc_mv', array(), $cc_about_id );
$cc_timeline = (array) cc_page_meta( '_about_timeline', 'cc_timeline', array(), $cc_about_id );
$cc_method   = (array) cc_page_meta( '_about_method', 'cc_method', array(), $cc_about_id );
?>

<div class="top">
	<div class="wrap">
		<h1><?php echo esc_html( cc_page_meta( '_about_heading', 'cc_about_heading', '', $cc_about_id ) ); ?></h1>
		<p><?php echo esc_html( cc_page_meta( '_about_intro', 'cc_about_intro', '', $cc_about_id ) ); ?></p>
	</div>
</div>

<div class="wrap">
	<?php if ( $cc_stats && is_array( $cc_stats ) ) : ?>
		<div class="stats">
			<?php foreach ( $cc_stats as $cc_stat ) : ?>
				<?php if ( ! empty( $cc_stat['value'] ) || ! empty( $cc_stat['label'] ) ) : ?>
					<div class="card stat">
						<b><?php echo esc_html( isset( $cc_stat['value'] ) ? $cc_stat['value'] : '' ); ?></b>
						<?php echo esc_html( isset( $cc_stat['label'] ) ? $cc_stat['label'] : '' ); ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<section>
		<div class="story">
			<?php
			echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
				(int) cc_page_meta( '_about_image', 'cc_about_image', 0, $cc_about_id ),
				__( 'আমাদের ক্যাম্পাসের ছবি', 'coaching-centre' ),
				'about-media',
				'cc-hero',
				'height:300px'
			);
			?>
			<div>
				<h2><?php esc_html_e( 'আমাদের গল্প', 'coaching-centre' ); ?></h2>
				<?php if ( cc_page_meta( '_about_story_1', 'cc_about_story_1', '', $cc_about_id ) ) : ?>
					<p><?php echo esc_html( cc_page_meta( '_about_story_1', 'cc_about_story_1', '', $cc_about_id ) ); ?></p>
				<?php endif; ?>
				<?php if ( cc_page_meta( '_about_story_2', 'cc_about_story_2', '', $cc_about_id ) ) : ?>
					<p><?php echo esc_html( cc_page_meta( '_about_story_2', 'cc_about_story_2', '', $cc_about_id ) ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ( $cc_mv ) : ?>
		<section class="pad-t0">
			<div class="grid g3 mv">
				<?php foreach ( $cc_mv as $cc_item ) : ?>
					<div class="card">
						<?php if ( ! empty( $cc_item['ico'] ) ) : ?>
							<div class="ico"><?php echo esc_html( $cc_item['ico'] ); ?></div>
						<?php endif; ?>
						<h3><?php echo esc_html( isset( $cc_item['title'] ) ? $cc_item['title'] : '' ); ?></h3>
						<?php echo esc_html( isset( $cc_item['text'] ) ? $cc_item['text'] : '' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $cc_timeline ) : ?>
		<section class="pad-t0">
			<h2><?php esc_html_e( 'আমাদের পথচলা', 'coaching-centre' ); ?></h2>
			<p class="sub"><?php esc_html_e( 'ছোট শুরু থেকে আজকের অবস্থান পর্যন্ত।', 'coaching-centre' ); ?></p>

			<div class="tl">
				<?php foreach ( $cc_timeline as $cc_item ) : ?>
					<div>
						<b><?php echo esc_html( isset( $cc_item['year'] ) ? $cc_item['year'] : '' ); ?></b><br>
						<?php echo esc_html( isset( $cc_item['text'] ) ? $cc_item['text'] : '' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $cc_method ) : ?>
		<section class="pad-t0">
			<h2><?php esc_html_e( 'আমাদের শিক্ষা পদ্ধতি', 'coaching-centre' ); ?></h2>
			<p class="sub"><?php esc_html_e( 'ক্লাসরুম থেকে ফলাফল — প্রতিটি ধাপে যত্ন।', 'coaching-centre' ); ?></p>

			<div class="grid g4">
				<?php foreach ( $cc_method as $cc_item ) : ?>
					<div class="card">
						<?php if ( ! empty( $cc_item['ico'] ) ) : ?>
							<div class="ico"><?php echo esc_html( $cc_item['ico'] ); ?></div>
						<?php endif; ?>
						<b><?php echo esc_html( isset( $cc_item['title'] ) ? $cc_item['title'] : '' ); ?></b><br>
						<?php echo esc_html( isset( $cc_item['text'] ) ? $cc_item['text'] : '' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="pad-t0">
		<div class="card quote">
			<?php
			echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
				(int) cc_page_meta( '_about_chair_image', 'cc_chair_image', 0, $cc_about_id ),
				__( 'অধ্যক্ষের ছবি', 'coaching-centre' ),
				'about-media',
				'cc-card',
				'min-height:200px'
			);
			?>
			<div>
				<h2><?php esc_html_e( 'অধ্যক্ষের বার্তা', 'coaching-centre' ); ?></h2>
				<blockquote><?php echo esc_html( cc_page_meta( '_about_chair_quote', 'cc_chair_quote', '', $cc_about_id ) ); ?></blockquote>
				<p class="mb0">
					<b><?php echo esc_html( cc_page_meta( '_about_chair_name', 'cc_chair_name', '', $cc_about_id ) ); ?></b><br>
					<small class="mute"><?php echo esc_html( cc_page_meta( '_about_chair_role', 'cc_chair_role', '', $cc_about_id ) ); ?></small>
				</p>
			</div>
		</div>
	</section>

	<?php
	$cc_teachers = get_posts(
		array(
			'post_type'      => 'cc_teacher',
			'posts_per_page' => 8,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'  => true,
		)
	);

	if ( $cc_teachers ) :
		?>
		<section class="pad-t0">
			<h2><?php esc_html_e( 'আমাদের শিক্ষকমণ্ডলী', 'coaching-centre' ); ?></h2>
			<p class="sub"><?php esc_html_e( 'অভিজ্ঞ, আন্তরিক ও শিক্ষার্থীদেরবান্ধব।', 'coaching-centre' ); ?></p>

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
						<?php if ( $cc_subject ) : ?>
							<br><small class="mute"><?php echo esc_html( $cc_subject ); ?></small>
						<?php endif; ?>
						<?php if ( $cc_designation ) : ?>
							<br><small class="mute"><?php echo esc_html( $cc_designation ); ?></small>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	endif;
	?>

	<section class="pad-t0">
		<div class="grid g2">
			<div class="card">
				<h2><?php esc_html_e( 'আমাদের সুবিধাসমূহ', 'coaching-centre' ); ?></h2>
				<?php cc_checklist( cc_page_meta( '_about_facilities', 'cc_facilities', '', $cc_about_id ) ); ?>
			</div>
			<div class="card">
				<h2><?php esc_html_e( 'স্বীকৃতি ও অর্জন', 'coaching-centre' ); ?></h2>
				<?php cc_checklist( cc_page_meta( '_about_achievements', 'cc_achievements', '', $cc_about_id ) ); ?>
			</div>
		</div>
	</section>

	<?php
	/* Any extra content written in the page editor is rendered here. */
	while ( have_posts() ) :
		the_post();

		if ( trim( get_the_content() ) ) :
			?>
			<section class="pad-t0">
				<div class="entry-content"><?php the_content(); ?></div>
			</section>
			<?php
		endif;
	endwhile;
	?>

	<div class="cta mb20">
		<h2><?php esc_html_e( 'আমাদের পরিবারের অংশ হোন', 'coaching-centre' ); ?></h2>
		<p class="op9 mt0"><?php esc_html_e( 'আজই ভর্তি হোন অথবা যোগাযোগ করে বিস্তারিত জেনে নিন।', 'coaching-centre' ); ?></p>
		<a class="btn acc" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'ভর্তি হোন', 'coaching-centre' ); ?></a>
		<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'যোগাযোগ করুন', 'coaching-centre' ); ?></a>
	</div>
</div>

<?php
get_footer();