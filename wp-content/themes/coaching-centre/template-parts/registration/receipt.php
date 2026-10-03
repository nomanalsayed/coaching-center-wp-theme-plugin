<?php
/**
 * Admission receipt, rendered on the registration page.
 *
 * @package Coaching_Centre
 *
 * @var array $args Template arguments: `post_id`.
 */

defined( 'ABSPATH' ) || exit;

$cc_post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : 0;

if ( ! $cc_post_id ) {
	return;
}

$cc_rows = array(
	__( 'রেজিস্ট্রেশন আইডি', 'coaching-centre' ) => cc_reg_field( $cc_post_id, '_cc_code' ),
	__( 'ধরন', 'coaching-centre' )               => cc_reg_field( $cc_post_id, '_cc_kind' ),
	__( 'শিক্ষার্থীর নাম', 'coaching-centre' )     => cc_reg_field( $cc_post_id, '_cc_student_bn' ),
	__( 'শ্রেণি', 'coaching-centre' )            => cc_reg_field( $cc_post_id, '_cc_class' ),
	__( 'প্রোগ্রাম', 'coaching-centre' )          => cc_reg_field( $cc_post_id, '_cc_program' ),
	__( 'মোবাইল', 'coaching-centre' )            => cc_reg_field( $cc_post_id, '_cc_student_mobile' ),
	__( 'পেমেন্ট মাধ্যম', 'coaching-centre' )     => cc_reg_field( $cc_post_id, '_cc_payment' ),
	__( 'ফি', 'coaching-centre' )                => cc_money( cc_reg_field( $cc_post_id, '_cc_fee' ) ),
	__( 'তারিখ', 'coaching-centre' )             => get_the_date( 'd/m/Y', $cc_post_id ),
);
?>
<div class="rcpt" id="cc-receipt">
	<?php foreach ( $cc_rows as $cc_label => $cc_value ) : ?>
		<?php if ( '' === $cc_value ) : ?>
			<?php continue; ?>
		<?php endif; ?>
		<div>
			<span class="mute"><?php echo esc_html( $cc_label ); ?></span>
			<b><?php echo esc_html( $cc_value ); ?></b>
		</div>
	<?php endforeach; ?>
</div>

<p class="row no-print">
	<span class="cc-status cc-status-<?php echo esc_attr( sanitize_html_class( get_post_status( $cc_post_id ) ) ); ?>">
		<?php echo esc_html( cc_status_label( get_post_status( $cc_post_id ) ) ); ?>
	</span>
	<button class="btn o sm" type="button" onclick="window.print();"><?php esc_html_e( 'রসিদ প্রিন্ট করুন', 'coaching-centre' ); ?></button>
</p>

<p class="mute sm"><?php esc_html_e( 'এই পাতার লিংকটি সংরক্ষণ করে রাখুন — ভর্তি নিশ্চিত করার জন্য এটি প্রয়োজন হতে পারে।', 'coaching-centre' ); ?></p>