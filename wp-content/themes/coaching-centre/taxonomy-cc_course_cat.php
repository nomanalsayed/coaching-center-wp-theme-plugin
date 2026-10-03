<?php
/**
 * Taxonomy archive for course categories (cc_course_cat).
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

$cc_current_term = get_queried_object();
$cc_tabs         = cc_course_tabs();
?>

<div class="top">
	<div class="wrap">
		<h1><?php echo esc_html( $cc_current_term->name ); ?></h1>
		<p><?php echo esc_html( $cc_current_term->description ? $cc_current_term->description : sprintf( /* translators: %s: term name */ __( '%s বিভাগের কোর্স ও প্রোগ্রামসমূহ।', 'coaching-centre' ), $cc_current_term->name ) ); ?></p>
	</div>
</div>

<div class="wrap">
	<?php if ( $cc_tabs ) : ?>
		<div class="tabs" id="tabs" role="tablist" aria-label="<?php esc_attr_e( 'কোর্স বিভাগ', 'coaching-centre' ); ?>">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'cc_course' ) ); ?>" class="tab"><?php esc_html_e( 'সব কোর্স', 'coaching-centre' ); ?></a>
			<?php foreach ( $cc_tabs as $cc_term ) : ?>
				<a href="<?php echo esc_url( get_term_link( $cc_term ) ); ?>" class="tab<?php echo ( $cc_term->term_id === $cc_current_term->term_id ) ? ' on' : ''; ?>"><?php echo esc_html( $cc_term->name ); ?></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="grid g3">
			<?php while ( have_posts() ) : ?>
				<?php
				the_post();
				$cc_id    = get_the_ID();
				$cc_badge = cc_course_field( $cc_id, '_cc_badge' );
				$cc_fee   = cc_course_fee( $cc_id );
				$cc_class = cc_course_field( $cc_id, '_cc_class' );
				$cc_feats = cc_course_features( $cc_id );
				?>
				<article class="card prog">
					<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
						<?php
						echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
							get_post_thumbnail_id( $cc_id ),
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

					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

					<?php if ( $cc_class ) : ?>
						<p class="mute sm mb12"><?php echo esc_html( $cc_class ); ?></p>
					<?php endif; ?>

					<?php cc_bullets( $cc_feats ); ?>

					<a href="<?php echo esc_url( cc_registration_url() ); ?>" class="btn"><?php esc_html_e( 'বিস্তারিত ও ভর্তি', 'coaching-centre' ); ?></a>
				</article>
			<?php endwhile; ?>
		</div>

		<div class="pagination mt26">
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => '← ' . esc_html__( 'আগের', 'coaching-centre' ),
					'next_text' => esc_html__( 'পরের', 'coaching-centre' ) . ' →',
				)
			);
			?>
		</div>
	<?php else : ?>
		<div class="card">
			<h2><?php esc_html_e( 'কোনো কোর্স পাওয়া যায়নি', 'coaching-centre' ); ?></h2>
			<p><?php esc_html_e( 'এই বিভাগে বর্তমানে কোনো কোর্স সক্রিয় নেই।', 'coaching-centre' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
