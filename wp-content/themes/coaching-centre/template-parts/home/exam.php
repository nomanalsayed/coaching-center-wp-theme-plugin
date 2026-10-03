<?php
/**
 * Home: weekly model exam with its own sign-up form.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/* phpcs:disable WordPress.Security.NonceVerification.Recommended -- reading our own redirect state. */
$cc_token = isset( $_GET['cc_exam_token'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_exam_token'] ) ) : '';
$cc_state = $cc_token ? cc_take_state( 'exam', $cc_token ) : array();

$cc_receipt_param = isset( $_GET['cc_exam_receipt'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_exam_receipt'] ) ) : '';
$cc_receipt       = $cc_receipt_param ? cc_resolve_receipt( $cc_receipt_param ) : null;
/* phpcs:enable */

$cc_errors   = isset( $cc_state['errors'] ) ? (array) $cc_state['errors'] : array();
$cc_success  = isset( $cc_state['success'] ) ? (string) $cc_state['success'] : '';
$cc_values   = isset( $cc_state['values'] ) ? (array) $cc_state['values'] : array();
$cc_classes  = cc_lines( cc_hp( '_hp_exam_class_opt', 'cc_exam_class_opt' ) );
$cc_points   = cc_lines( cc_hp( '_hp_exam_points', 'cc_exam_points' ) );
$cc_return   = remove_query_arg( array( 'cc_exam_token', 'cc_exam_receipt' ), cc_current_url() );

if ( ! $cc_success && $cc_receipt ) {
	$cc_success = sprintf(
		/* translators: %s: registration ID */
		__( 'ধন্যবাদ %s! আপনার রেজিস্ট্রেশন গ্রহণ করা হয়েছে। পরীক্ষার দিন ও সময় শিক্ষার্থীর মোবাইলে SMS দিয়ে জানানো হবে।', 'coaching-centre' ),
		'<b>' . esc_html( cc_reg_field( $cc_receipt->ID, '_cc_code' ) ) . '</b>'
	);
}
?>
<section id="exam" class="cc-section" data-cc="exam">
	<div class="wrap">
		<div class="exam">
			<div>
				<span class="tag tag-dark"><?php esc_html_e( 'সবার জন্য উন্মুক্ত', 'coaching-centre' ); ?></span>
				<h2 data-cc="exam_title"><?php echo esc_html( cc_hp( '_hp_exam_title', 'cc_exam_title' ) ); ?></h2>
				<p data-cc="exam_text"><?php echo esc_html( cc_hp( '_hp_exam_text', 'cc_exam_text' ) ); ?></p>

				<?php if ( $cc_points ) : ?>
					<ul>
						<?php foreach ( $cc_points as $cc_point ) : ?>
							<li><?php echo esc_html( $cc_point ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="price"><?php echo esc_html( '৳ ' . cc_bn( cc_hp( '_hp_exam_price', 'cc_exam_price' ) ) ); ?> <small><?php esc_html_e( '/ প্রতি পরীক্ষা', 'coaching-centre' ); ?></small></div>
				<small><?php esc_html_e( 'পেমেন্ট', 'coaching-centre' ); ?>: <?php echo esc_html( cc_hp( '_hp_exam_payment', 'cc_exam_payment' ) ); ?></small>
			</div>


			<form class="reg" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<h3 class="no-m"><?php esc_html_e( 'পরীক্ষার রেজিস্ট্রেশন', 'coaching-centre' ); ?></h3>

				<input type="hidden" name="action" value="cc_exam_register">
				<input type="hidden" name="cc_return" value="<?php echo esc_url( $cc_return ); ?>">
				<?php wp_nonce_field( 'cc_exam', 'cc_exam_nonce' ); ?>
				<?php cc_honeypot(); ?>

				<div class="f<?php echo isset( $cc_errors['exam_name'] ) ? ' has-error' : ''; ?>">
					<label for="cc-exam-name"><?php esc_html_e( 'শিক্ণার্থীর নাম', 'coaching-centre' ); ?> <i>*</i></label>
					<input id="cc-exam-name" name="exam_name" required value="<?php echo esc_attr( isset( $cc_values['exam_name'] ) ? $cc_values['exam_name'] : '' ); ?>">
					<?php if ( isset( $cc_errors['exam_name'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['exam_name'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="f<?php echo isset( $cc_errors['exam_mobile'] ) ? ' has-error' : ''; ?>">
					<label for="cc-exam-mobile"><?php esc_html_e( 'মোবাইল নম্বর', 'coaching-centre' ); ?> <i>*</i></label>
					<input id="cc-exam-mobile" name="exam_mobile" inputmode="numeric" pattern="01[3-9][0-9]{8}" placeholder="01XXXXXXXXX" required value="<?php echo esc_attr( isset( $cc_values['exam_mobile'] ) ? cc_bn( $cc_values['exam_mobile'] ) : '' ); ?>">
					<?php if ( isset( $cc_errors['exam_mobile'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['exam_mobile'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="f<?php echo isset( $cc_errors['exam_class'] ) ? ' has-error' : ''; ?>">
					<label for="cc-exam-class"><?php esc_html_e( 'শ্রেণি / পরীক্ষা', 'coaching-centre' ); ?> <i>*</i></label>
					<select id="cc-exam-class" name="exam_class" required>
						<option value=""><?php esc_html_e( 'শ্রেণি / পরীক্ষা বেছে নিন', 'coaching-centre' ); ?></option>
						<?php foreach ( $cc_classes as $cc_class_option ) : ?>
							<option value="<?php echo esc_attr( $cc_class_option ); ?>" <?php selected( isset( $cc_values['exam_class'] ) ? $cc_values['exam_class'] : '', $cc_class_option ); ?>>
								<?php echo esc_html( $cc_class_option ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $cc_errors['exam_class'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['exam_class'] ); ?></span>
					<?php endif; ?>
				</div>

				<button class="btn" type="submit"><?php esc_html_e( 'রেজিস্ট্রেশন ও পেমেন্ট করুন', 'coaching-centre' ); ?></button>

				<?php if ( $cc_success ) : ?>
					<div class="notice ok" role="status"><?php echo wp_kses( $cc_success, array( 'b' => array() ) ); ?></div>
				<?php endif; ?>
				<?php if ( isset( $cc_errors['_cc_form'] ) ) : ?>
					<div class="notice bad" role="alert"><?php echo esc_html( $cc_errors['_cc_form'] ); ?></div>
				<?php endif; ?>
			</form>
		</div>
	</div>
</section>