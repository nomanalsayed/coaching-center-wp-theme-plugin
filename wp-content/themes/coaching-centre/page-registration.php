<?php
/**
 * Template Name: Registration — ভর্তি ফর্ম
 *
 * Replaces the static registration.html prototype. Field names must stay in
 * sync with cc_handle_registration() in inc/forms.php.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

/* phpcs:disable WordPress.Security.NonceVerification.Recommended -- reading our own redirect state. */
$cc_token = isset( $_GET['cc_reg_token'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_reg_token'] ) ) : '';
$cc_state = $cc_token ? cc_take_state( 'reg', $cc_token ) : array();
$cc_rp    = isset( $_GET['cc_receipt'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_receipt'] ) ) : '';
$cc_receipt = $cc_rp ? cc_resolve_receipt( $cc_rp ) : null;
/* phpcs:enable */

$cc_errors  = isset( $cc_state['errors'] ) ? (array) $cc_state['errors'] : array();
$cc_success = isset( $cc_state['success'] ) ? (string) $cc_state['success'] : '';
$cc_values  = isset( $cc_state['values'] ) ? (array) $cc_state['values'] : array();

$cc_program      = cc_program_map();
$cc_versions     = cc_lines( cc_opt( 'cc_reg_versions' ) );
$cc_groups       = cc_lines( cc_opt( 'cc_reg_groups' ) );
$cc_sources      = cc_lines( cc_opt( 'cc_reg_sources' ) );
$cc_payments     = cc_lines( cc_opt( 'cc_reg_payment_methods' ) );
$cc_steps        = cc_lines( cc_opt( 'cc_reg_steps' ) );
$cc_docs         = cc_lines( cc_opt( 'cc_reg_documents' ) );
$cc_branch_names = wp_list_pluck( cc_branches(), 'name' );
$cc_return       = remove_query_arg( array( 'cc_reg_token', 'cc_receipt' ), cc_current_url() );

/* Current selection, used to re-render the dependent fields without JavaScript. */
$cc_sel_class  = isset( $cc_values['_cc_class'] ) ? $cc_values['_cc_class'] : '';
$cc_sel_prog   = isset( $cc_values['_cc_program'] ) ? $cc_values['_cc_program'] : '';
$cc_sel_modes  = array();
$cc_sel_fee    = 0;
$cc_needs_group = (bool) preg_match( '/৯ম|১০ম/', $cc_sel_class );

if ( $cc_sel_class && isset( $cc_program[ $cc_sel_class ] ) ) {
	foreach ( $cc_program[ $cc_sel_class ] as $cc_item ) {
		if ( $cc_item['label'] === $cc_sel_prog ) {
			$cc_sel_modes = $cc_item['modes'];
			$cc_sel_fee   = $cc_item['fee'];
			break;
		}
	}
}

/** Print the validation message stored for a field. */
$cc_error = static function ( $key ) use ( $cc_errors ) {
	if ( isset( $cc_errors[ $key ] ) ) {
		printf( '<span class="err" style="display:block">%s</span>', esc_html( $cc_errors[ $key ] ) );
	}
};

/** Print the "has-error" class when a field failed validation. */
$cc_has_error = static function ( $key ) use ( $cc_errors ) {
	echo isset( $cc_errors[ $key ] ) ? ' has-error' : '';
};

/** Render the `label.opt` radio items used by the original design. */
$cc_radio_row = static function ( $name, $options, $current, $required = true ) {
	if ( ! $options ) {
		return;
	}

	$first = true;

	foreach ( $options as $cc_option ) {
		printf(
			'<label class="opt"><input type="radio" name="%1$s" value="%2$s" %3$s%4$s><span>%2$s</span></label>',
			esc_attr( $name ),
			esc_attr( $cc_option ),
			checked( $current, $cc_option, false ),
			$required && $first ? 'required' : ''
		);

		$first = false;
	}
};
?>

<div class="top top-reg">
	<div class="wrap">
		<h1><?php echo esc_html( cc_opt( 'cc_reg_heading' ) ); ?></h1>
		<p><?php echo esc_html( cc_opt( 'cc_reg_sub' ) ); ?></p>

		<?php if ( $cc_receipt || $cc_success ) : ?>
			<div class="done" style="display:block">
				<div class="ck">✅</div>
				<h2 class="no-m"><?php esc_html_e( 'আবেদন গ্রহণ করা হয়েছে!', 'coaching-centre' ); ?></h2>
				<?php if ( $cc_receipt ) : ?>
					<p><?php esc_html_e( 'আপনার রেজিস্ট্রেশন আইডি', 'coaching-centre' ); ?></p>
					<div class="id"><?php echo esc_html( cc_reg_field( $cc_receipt->ID, '_cc_code' ) ); ?></div>
				<?php elseif ( $cc_success ) : ?>
					<p><?php echo wp_kses( $cc_success, array( 'b' => array() ) ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="wrap">
	<?php if ( $cc_receipt ) : ?>
		<?php get_template_part( 'template-parts/registration/receipt', null, array( 'post_id' => $cc_receipt->ID ) ); ?>
	<?php endif; ?>

	<div class="box">
		<?php if ( $cc_steps ) : ?>
			<div class="steps">
				<?php foreach ( $cc_steps as $cc_i => $cc_step ) : ?>
					<div class="s"><b><?php echo esc_html( cc_bn( $cc_i + 1 ) ); ?></b> <small><?php echo esc_html( $cc_step ); ?></small></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! $cc_program ) : ?>
			<h2 class="no-m"><?php esc_html_e( 'ফর্মটি এখনো প্রস্তুত নয়', 'coaching-centre' ); ?></h2>
			<p><?php esc_html_e( 'এখনো কোনো কোর্স যোগ করা হয়নি। অ্যাডমিন → কোচিং সেন্টার → কোর্স থেকে কোর্স যোগ করলে ফর্মটি এখানে দেখা যাবে।', 'coaching-centre' ); ?></p>
		<?php else : ?>
			<form class="reg" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="cc_register">
				<input type="hidden" name="cc_return" value="<?php echo esc_url( $cc_return ); ?>">
				<?php wp_nonce_field( 'cc_register', 'cc_reg_nonce' ); ?>
				<?php cc_honeypot(); ?>

				<fieldset>
					<legend><?php esc_html_e( 'শিক্ষার্থীর তথ্য', 'coaching-centre' ); ?></legend>

					<div class="fg">
						<div class="f<?php $cc_has_error( 'student_bn' ); ?>">
							<label for="cc-n-bn"><?php esc_html_e( 'শিক্ষার্থীর নাম (বাংলা)', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-n-bn" name="student_bn" required value="<?php echo esc_attr( isset( $cc_values['_cc_student_bn'] ) ? $cc_values['_cc_student_bn'] : '' ); ?>">
							<?php $cc_error( 'student_bn' ); ?>
						</div>

						<div class="f">
							<label for="cc-n-en"><?php esc_html_e( 'Name (English)', 'coaching-centre' ); ?></label>
							<input id="cc-n-en" name="student_en" value="<?php echo esc_attr( isset( $cc_values['_cc_student_en'] ) ? $cc_values['_cc_student_en'] : '' ); ?>">
						</div>

						<div class="f<?php $cc_has_error( 'dob' ); ?>">
							<label for="cc-n-dob"><?php esc_html_e( 'জন্ম তারিখ', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-n-dob" name="dob" type="date" required value="<?php echo esc_attr( isset( $cc_values['_cc_dob'] ) ? $cc_values['_cc_dob'] : '' ); ?>">
							<?php $cc_error( 'dob' ); ?>
						</div>

						<div class="f">
							<span class="lbl"><?php esc_html_e( 'লিঙ্গ', 'coaching-centre' ); ?> <i>*</i></span>
							<div class="opts">
								<?php
								$cc_radio_row(
									'gender',
									array( 'ছেলে', 'মেয়ে' ),
									isset( $cc_values['_cc_gender'] ) ? $cc_values['_cc_gender'] : ''
								);
								?>
							</div>
							<?php $cc_error( 'gender' ); ?>
						</div>

						<div class="f<?php $cc_has_error( 'student_mobile' ); ?>">
							<label for="cc-n-mobile"><?php esc_html_e( 'শিক্ষার্থীর মোবাইল', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-n-mobile" name="student_mobile" inputmode="numeric" pattern="01[3-9][0-9]{8}" placeholder="01XXXXXXXXX" required value="<?php echo esc_attr( isset( $cc_values['_cc_student_mobile'] ) ? cc_bn( $cc_values['_cc_student_mobile'] ) : '' ); ?>">
							<?php $cc_error( 'student_mobile' ); ?>
						</div>

						<div class="f">
							<label for="cc-n-email"><?php esc_html_e( 'ইমেইল (ঐচ্ছিক)', 'coaching-centre' ); ?></label>
							<input id="cc-n-email" name="email" type="email" value="<?php echo esc_attr( isset( $cc_values['_cc_email'] ) ? $cc_values['_cc_email'] : '' ); ?>">
							<?php $cc_error( 'email' ); ?>
						</div>

						<div class="f w<?php $cc_has_error( 'school' ); ?>">
							<label for="cc-n-school"><?php esc_html_e( 'বর্তমান স্কুল / কলেজ', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-n-school" name="school" required value="<?php echo esc_attr( isset( $cc_values['_cc_school'] ) ? $cc_values['_cc_school'] : '' ); ?>">
							<?php $cc_error( 'school' ); ?>
						</div>

						<div class="f w<?php $cc_has_error( 'address' ); ?>">
							<label for="cc-n-address"><?php esc_html_e( 'বর্তমান ঠিকানা', 'coaching-centre' ); ?> <i>*</i></label>
							<textarea id="cc-n-address" name="address" rows="2" required><?php echo esc_textarea( isset( $cc_values['_cc_address'] ) ? $cc_values['_cc_address'] : '' ); ?></textarea>
							<?php $cc_error( 'address' ); ?>
						</div>

						<div class="f w">
							<label for="cc-n-photo"><?php esc_html_e( 'শিক্ষার্থীর ছবি (ঐচ্ছিক)', 'coaching-centre' ); ?></label>
							<input id="cc-n-photo" name="cc_photo" type="file" accept="image/*">
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?php esc_html_e( 'কোর্স নির্বাচন', 'coaching-centre' ); ?></legend>

					<div class="fg">
						<div class="f<?php $cc_has_error( 'course_class' ); ?>">
							<label for="cc-c-class"><?php esc_html_e( 'শ্রেণি / লেভেল', 'coaching-centre' ); ?> <i>*</i></label>
							<select id="cc-c-class" name="course_class" required data-programs="#cc-c-prog" data-modes="#cc-c-modes" data-group="#cc-c-grp-box" data-fee="#cc-sum">
								<option value=""><?php esc_html_e( '-- শ্রেণি বেছে নিন --', 'coaching-centre' ); ?></option>
								<?php foreach ( $cc_program as $cc_class => $cc_items ) : ?>
									<option value="<?php echo esc_attr( $cc_class ); ?>" <?php selected( $cc_sel_class, $cc_class ); ?>><?php echo esc_html( $cc_class ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php $cc_error( 'course_class' ); ?>
						</div>

						<div class="f<?php $cc_has_error( 'program' ); ?>">
							<label for="cc-c-prog"><?php esc_html_e( 'প্রোগ্রাম', 'coaching-centre' ); ?> <i>*</i></label>
							<select id="cc-c-prog" name="program" required>
								<option value=""><?php esc_html_e( $cc_sel_class ? '-- প্রোগ্রাম বেছে নিন --' : '-- আগে শ্রেণি বেছে নিন --', 'coaching-centre' ); ?></option>
								<?php if ( $cc_sel_class && isset( $cc_program[ $cc_sel_class ] ) ) : ?>
									<?php foreach ( $cc_program[ $cc_sel_class ] as $cc_item ) : ?>
										<option value="<?php echo esc_attr( $cc_item['label'] ); ?>" data-fee="<?php echo esc_attr( $cc_item['fee'] ); ?>" <?php selected( $cc_sel_prog, $cc_item['label'] ); ?>><?php echo esc_html( $cc_item['label'] ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<?php $cc_error( 'program' ); ?>
						</div>

						<div class="f" id="cc-c-grp-box" <?php echo $cc_needs_group ? '' : 'hidden'; ?>>
							<label for="cc-c-grp"><?php esc_html_e( 'গ্রুপ', 'coaching-centre' ); ?></label>
							<select id="cc-c-grp" name="group">
								<option value=""><?php esc_html_e( '-- গ্রুপ --', 'coaching-centre' ); ?></option>
								<?php foreach ( $cc_groups as $cc_group ) : ?>
									<option value="<?php echo esc_attr( $cc_group ); ?>" <?php selected( isset( $cc_values['_cc_group'] ) ? $cc_values['_cc_group'] : '', $cc_group ); ?>><?php echo esc_html( $cc_group ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php $cc_error( 'group' ); ?>
						</div>

						<div class="f<?php $cc_has_error( 'version' ); ?>">
							<label for="cc-c-ver"><?php esc_html_e( 'ভার্সন', 'coaching-centre' ); ?> <i>*</i></label>
							<select id="cc-c-ver" name="version" required>
								<option value=""><?php esc_html_e( '--', 'coaching-centre' ); ?></option>
								<?php foreach ( $cc_versions as $cc_version ) : ?>
									<option value="<?php echo esc_attr( $cc_version ); ?>" <?php selected( isset( $cc_values['_cc_version'] ) ? $cc_values['_cc_version'] : '', $cc_version ); ?>><?php echo esc_html( $cc_version ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php $cc_error( 'version' ); ?>
						</div>

						<div class="f w">
							<span class="lbl"><?php esc_html_e( 'অংশগ্রহণের মাধ্যম', 'coaching-centre' ); ?> <i>*</i></span>
							<div class="opts" id="cc-c-modes">
								<?php $cc_radio_row( 'mode', $cc_sel_modes, isset( $cc_values['_cc_mode'] ) ? $cc_values['_cc_mode'] : '', (bool) $cc_sel_modes ); ?>
							</div>
							<?php $cc_error( 'mode' ); ?>
						</div>

						<div class="f" id="cc-c-br-box">
							<label for="cc-c-br"><?php esc_html_e( 'শাখা (কোর্স ও পরীক্ষার জন্য)', 'coaching-centre' ); ?></label>
							<select id="cc-c-br" name="branch">
								<option value=""><?php esc_html_e( '-- শাখা --', 'coaching-centre' ); ?></option>
								<?php foreach ( $cc_branch_names as $cc_branch_name ) : ?>
									<option value="<?php echo esc_attr( $cc_branch_name ); ?>" <?php selected( isset( $cc_values['_cc_branch'] ) ? $cc_values['_cc_branch'] : '', $cc_branch_name ); ?>><?php echo esc_html( $cc_branch_name ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="f">
							<label for="cc-c-last"><?php esc_html_e( 'সর্বশেষ পরীক্ষার ফল', 'coaching-centre' ); ?></label>
							<input id="cc-c-last" name="last_result" placeholder="<?php esc_attr_e( 'যেমন: গণিতে ৭৮', 'coaching-centre' ); ?>" value="<?php echo esc_attr( isset( $cc_values['_cc_last_result'] ) ? $cc_values['_cc_last_result'] : '' ); ?>">
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend><?php esc_html_e( 'অভিভাবকের তথ্য', 'coaching-centre' ); ?></legend>

					<div class="fg">
						<div class="f<?php $cc_has_error( 'father' ); ?>">
							<label for="cc-g-father"><?php esc_html_e( 'পিতার নাম', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-g-father" name="father" required value="<?php echo esc_attr( isset( $cc_values['_cc_father'] ) ? $cc_values['_cc_father'] : '' ); ?>">
							<?php $cc_error( 'father' ); ?>
						</div>

						<div class="f<?php $cc_has_error( 'mother' ); ?>">
							<label for="cc-g-mother"><?php esc_html_e( 'মাতার নাম', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-g-mother" name="mother" required value="<?php echo esc_attr( isset( $cc_values['_cc_mother'] ) ? $cc_values['_cc_mother'] : '' ); ?>">
							<?php $cc_error( 'mother' ); ?>
						</div>

						<div class="f<?php $cc_has_error( 'guardian_mobile' ); ?>">
							<label for="cc-g-mobile"><?php esc_html_e( 'অভিভাবকের মোবাইল (SMS রেজাল্টের জন্য)', 'coaching-centre' ); ?> <i>*</i></label>
							<input id="cc-g-mobile" name="guardian_mobile" inputmode="numeric" pattern="01[3-9][0-9]{8}" placeholder="01XXXXXXXXX" required value="<?php echo esc_attr( isset( $cc_values['_cc_guardian_mobile'] ) ? cc_bn( $cc_values['_cc_guardian_mobile'] ) : '' ); ?>">
							<?php $cc_error( 'guardian_mobile' ); ?>
						</div>

						<div class="f">
							<label for="cc-g-job"><?php esc_html_e( 'পেশা', 'coaching-centre' ); ?></label>
							<input id="cc-g-job" name="occupation" value="<?php echo esc_attr( isset( $cc_values['_cc_occupation'] ) ? $cc_values['_cc_occupation'] : '' ); ?>">
						</div>

						<div class="f w">
							<label for="cc-g-src"><?php esc_html_e( 'আমাদের সম্পর্কে কীভাবে জানলেন?', 'coaching-centre' ); ?></label>
							<select id="cc-g-src" name="source">
								<option value=""><?php esc_html_e( '--', 'coaching-centre' ); ?></option>
								<?php foreach ( $cc_sources as $cc_source ) : ?>
									<option value="<?php echo esc_attr( $cc_source ); ?>" <?php selected( isset( $cc_values['_cc_source'] ) ? $cc_values['_cc_source'] : '', $cc_source ); ?>><?php echo esc_html( $cc_source ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</fieldset>

				<div class="sum" id="cc-sum">
					<?php if ( $cc_sel_fee ) : ?>
						<div><span><?php esc_html_e( 'প্রোগ্রাম', 'coaching-centre' ); ?></span><span><?php echo esc_html( $cc_sel_prog ); ?></span></div>
						<div><span><?php esc_html_e( 'কোর্স ফি', 'coaching-centre' ); ?></span><span><?php echo esc_html( cc_money( $cc_sel_fee ) ); ?></span></div>
						<div class="t"><span><?php esc_html_e( 'মোট', 'coaching-centre' ); ?></span><span><?php echo esc_html( cc_money( $cc_sel_fee ) ); ?></span></div>
					<?php else : ?>
						<div><?php esc_html_e( 'কোর্স নির্বাচন করুন', 'coaching-centre' ); ?></div>
					<?php endif; ?>
				</div>

				<?php if ( $cc_docs ) : ?>
					<div class="mb">
						<b><?php esc_html_e( 'সঙ্গে আনতে হবে', 'coaching-centre' ); ?></b>
						<?php cc_checklist( $cc_docs, 'chk sm' ); ?>
					</div>
				<?php endif; ?>

				<fieldset>
					<legend><?php esc_html_e( 'পেমেন্ট', 'coaching-centre' ); ?></legend>

					<div class="pay<?php $cc_has_error( 'payment' ); ?>">
						<?php $cc_radio_row( 'payment', $cc_payments, isset( $cc_values['_cc_payment'] ) ? $cc_values['_cc_payment'] : '' ); ?>
						<?php $cc_error( 'payment' ); ?>
					</div>

					<label class="check">
						<input type="checkbox" name="terms" value="1" <?php checked( ! empty( $cc_values['terms'] ) ); ?>>
						<span><?php echo esc_html( cc_opt( 'cc_reg_terms' ) ); ?></span>
					</label>
					<?php $cc_error( 'terms' ); ?>
				</fieldset>

				<?php if ( $cc_errors ) : ?>
					<div class="err" style="display:block"><?php esc_html_e( 'অনুগ্রহ করে চিহ্নিত সব ঘর সঠিকভাবে পূরণ করুন।', 'coaching-centre' ); ?></div>
				<?php endif; ?>
				<?php if ( isset( $cc_errors['_cc_form'] ) ) : ?>
					<div class="notice bad" role="alert"><?php echo esc_html( $cc_errors['_cc_form'] ); ?></div>
				<?php endif; ?>

				<button class="btn" type="submit"><?php esc_html_e( 'ভর্তি নিশ্চিত করুন', 'coaching-centre' ); ?> ✓</button>
			</form>
		<?php endif; ?>
	</div>

	<div class="cta">
		<h2><?php esc_html_e( 'ফর্ম পাঠাতে সমস্যা হচ্ছে?', 'coaching-centre' ); ?></h2>
		<p class="op9 mt0"><?php esc_html_e( 'সরাসরি ফোন করুন অথবা যোগাযোগ পেজ থেকে বার্তা দিন।', 'coaching-centre' ); ?></p>
		<a class="btn acc" href="<?php echo esc_url( cc_tel_href() ); ?>">📞 <?php echo esc_html( cc_opt( 'cc_phone' ) ); ?></a>
		<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'যোগাযোগ করুন', 'coaching-centre' ); ?></a>
	</div>
</div>

<?php
get_footer();