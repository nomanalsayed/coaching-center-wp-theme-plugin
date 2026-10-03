<?php
/**
 * Home: headline statistics.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_stats = cc_stat_rows( 'cc_stats' );

if ( ! $cc_stats ) {
	return;
}
?>
<div class="wrap stats">
	<?php foreach ( $cc_stats as $cc_stat ) : ?>
		<div class="card stat">
			<b><?php echo esc_html( $cc_stat['value'] ); ?></b>
			<?php echo esc_html( $cc_stat['label'] ); ?>
		</div>
	<?php endforeach; ?>
</div>