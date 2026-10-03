<?php
/**
 * Home: final call to action.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_link = cc_opt( 'cc_cta_link' );
$cc_href = 'tel' === $cc_link ? cc_tel_href() : ( $cc_link ? $cc_link : cc_registration_url() );
?>
<section id="admission" class="cc-section">
	<div class="wrap">
		<div class="final">
			<h2 data-cc="cta_title"><?php echo esc_html( cc_hp( '_hp_cta_title', 'cc_cta_title' ) ); ?></h2>
			<p class="op9" data-cc="cta_text"><?php echo esc_html( cc_hp( '_hp_cta_text', 'cc_cta_text' ) ); ?></p>


			<a class="btn acc" href="<?php echo esc_url( $cc_href ); ?>">📞 <?php echo esc_html( cc_opt( 'cc_phone' ) ); ?></a>
			<a class="btn ghost ml8" href="<?php echo esc_url( cc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'শাখার ঠিকানা', 'coaching-centre' ); ?></a>
			<a class="btn ghost ml8" href="<?php echo esc_url( cc_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'আমাদের সম্পর্কে', 'coaching-centre' ); ?></a>
		</div>
	</div>
</section>