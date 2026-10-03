<?php
/**
 * Home: hero.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_hero_tag   = cc_hp( '_hp_hero_tag', 'cc_hero_tag' );
$cc_hero_title = cc_hp( '_hp_hero_title', 'cc_hero_title' );
$cc_hero_text  = cc_hp( '_hp_hero_text', 'cc_hero_text' );
$cc_btn1_txt   = cc_hp( '_hp_hero_btn1_txt', 'cc_hero_btn1_txt' );
$cc_btn2_txt   = cc_hp( '_hp_hero_btn2_txt', 'cc_hero_btn2_txt' );
$cc_hero_image = cc_hp( '_hp_hero_image', 'cc_hero_image' );
?>
<section class="hero">
	<div class="wrap in">
		<div>
			<?php if ( $cc_hero_tag ) : ?>
				<span class="tag" data-cc="hero_tag"><?php echo esc_html( $cc_hero_tag ); ?></span>
			<?php endif; ?>

			<h1 data-cc="hero_title"><?php echo nl2br( esc_html( $cc_hero_title ) ); ?></h1>

			<?php if ( $cc_hero_text ) : ?>
				<p data-cc="hero_text"><?php echo esc_html( $cc_hero_text ); ?></p>
			<?php endif; ?>

			<div class="cta">
				<a class="btn acc" data-cc="hero_btn1_txt" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php echo esc_html( $cc_btn1_txt ); ?></a>
				<a class="btn ghost" data-cc="hero_btn2_txt" href="#exam"><?php echo esc_html( $cc_btn2_txt ); ?></a>
			</div>
		</div>

		<?php
		echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
			(int) $cc_hero_image,
			__( 'হিরো ইমেজ (শিক্ষার্থীদের ছবি)', 'coaching-centre' ),
			'hero-media',
			'cc-hero',
			'height:340px;border-radius:14px;background:rgba(255,255,255,.12);color:#fff'
		);
		?>
	</div>
</section>