<?php
/**
 * Home: cadet coaching block.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_cadet_image  = cc_hp( '_hp_cadet_image', 'cc_cadet_image' );
$cc_cadet_tag    = cc_hp( '_hp_cadet_tag', 'cc_cadet_tag' );
$cc_cadet_title  = cc_hp( '_hp_cadet_title', 'cc_cadet_title' );
$cc_cadet_text   = cc_hp( '_hp_cadet_text', 'cc_cadet_text' );
$cc_cadet_points = cc_hp( '_hp_cadet_points', 'cc_cadet_points' );
?>
<section id="cadet" class="alt cc-section" data-cc="cadet">
	<div class="wrap cadet">
		<?php
		echo cc_media( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with escaped parts.
			(int) $cc_cadet_image,
			__( 'ক্যাডেট কোচিং ছবি', 'coaching-centre' ),
			'cadet-media',
			'cc-card',
			'height:280px'
		);
		?>

		<div>
			<?php if ( $cc_cadet_tag ) : ?>
				<span class="tag tag-solid" data-cc="cadet_tag"><?php echo esc_html( $cc_cadet_tag ); ?></span>
			<?php endif; ?>

			<h2 data-cc="cadet_title"><?php echo esc_html( $cc_cadet_title ); ?></h2>
			<p class="sub mb12" data-cc="cadet_text"><?php echo esc_html( $cc_cadet_text ); ?></p>

			<?php cc_checklist( $cc_cadet_points ); ?>

			<a href="<?php echo esc_url( cc_registration_url() ); ?>" class="btn"><?php esc_html_e( 'ক্যাডেট ব্যাচে ভর্তি', 'coaching-centre' ); ?></a>
		</div>
	</div>
</section>