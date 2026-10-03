<?php
/**
 * Home: "why us" feature cards.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_features = cc_hp( '_hp_features', 'cc_features' );

if ( ! is_array( $cc_features ) || ! $cc_features ) {
	return;
}
?>
<section id="why" class="alt cc-section">
	<div class="wrap">
		<h2 data-cc="features_title"><?php echo esc_html( cc_hp( '_hp_features_title', 'cc_features_title' ) ); ?></h2>
		<p class="sub" data-cc="features_sub"><?php echo esc_html( cc_hp( '_hp_features_sub', 'cc_features_sub' ) ); ?></p>

		<div class="grid g4">
			<?php foreach ( $cc_features as $cc_feature ) : ?>
				<div class="card">
					<?php if ( ! empty( $cc_feature['ico'] ) ) : ?>
						<div class="ico"><?php echo esc_html( $cc_feature['ico'] ); ?></div>
					<?php endif; ?>
					<h3><?php echo esc_html( $cc_feature['title'] ); ?></h3>
					<?php echo esc_html( $cc_feature['text'] ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>