<?php
/**
 * Fallback template: the blog/post index.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="top">
	<div class="wrap">
		<h1><?php echo esc_html( cc_opt( 'cc_logo_text' ) ); ?></h1>
		<p><?php echo esc_html( cc_opt( 'cc_footer_about' ) ); ?></p>
	</div>
</div>

<div class="wrap">
	<?php if ( have_posts() ) : ?>
		<div class="grid g3">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class( 'card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
					<?php endif; ?>

					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<small class="mute"><?php echo esc_html( get_the_date() ); ?></small>

					<div class="entry-content mt8">
						<?php the_excerpt(); ?>
					</div>
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
			<h2><?php esc_html_e( 'কিছু পাওয়া যায়নি', 'coaching-centre' ); ?></h2>
			<p><?php esc_html_e( 'এই পাতায় এখনো কোনো লেখা যোগ করা হয়নি।', 'coaching-centre' ); ?></p>
			<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'হোমপেজে ফিরে যান', 'coaching-centre' ); ?></a>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();