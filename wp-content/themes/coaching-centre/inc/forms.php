<?php
/**
 * Front-end form handling: admission, weekly exam and contact messages.
 *
 * Every handler uses the post/redirect/get pattern so a refresh never
 * re-submits a form, and errors survive the redirect in a short-lived
 * transient keyed by a one-time token.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * How long a form state transient lives.
 */
const CC_FORM_TTL = 900;

/**
 * Stop the request unless it is a valid POST from one of our forms.
 *
 * @param string $nonce_action Nonce action.
 * @param string $nonce_name   Nonce field name.
 * @return string Safe redirect URL.
 */
function cc_form_guard( $nonce_action, $nonce_name = 'cc_nonce' ) {
	$fallback = home_url( '/' );

	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== strtoupper( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) ) ) {
		wp_safe_redirect( $fallback );
		exit;
	}

	$nonce = isset( $_POST[ $nonce_name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nonce_name ] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, $nonce_action ) ) {
		wp_die(
			esc_html__( 'সেশনের মেয়াদ শেষ হয়েছে। ফর্মটি আবার জমা দিন।', 'coaching-centre' ),
			esc_html__( 'ফর্ম যাচাই ব্যর্থ', 'coaching-centre' ),
			array(
				'response'  => 403,
				'back_link' => true,
			)
		);
	}

	$return = isset( $_POST['cc_return'] ) ? esc_url_raw( wp_unslash( $_POST['cc_return'] ) ) : '';

	return wp_validate_redirect( $return, $fallback );
}

/**
 * Read a posted value as trimmed text.
 *
 * @param string $key Field name.
 * @return string
 */
function cc_post( $key ) {
	if ( ! isset( $_POST[ $key ] ) || ! is_string( $_POST[ $key ] ) ) {
		return '';
	}

	return trim( wp_unslash( $_POST[ $key ] ) );
}

/**
 * Validate a Bangladeshi mobile number in either numeral set.
 *
 * @param string $value Raw value.
 * @return string Normalised digits, or an empty string when invalid.
 */
function cc_clean_mobile( $value ) {
	$value = preg_replace( '/\D/', '', cc_latin( $value ) );

	return preg_match( '/^01[3-9]\d{8}$/', $value ) ? $value : '';
}

/**
 * Persist the form state and bounce back to the form page.
 *
 * @param string $key     State bucket, e.g. `registration`.
 * @param array  $errors  Validation errors keyed by field.
 * @param array  $values  Submitted values for re-rendering.
 * @param string $success Optional success message.
 * @param string $return  Redirect URL.
 * @param array  $extra   Extra payload (e.g. the new post ID).
 */
function cc_redirect_with_state( $key, $errors, $values, $success, $return, $extra = array() ) {
	$token = wp_generate_password( 24, false, false );

	set_transient(
		'cc_form_' . $key . '_' . $token,
		array(
			'errors'  => $errors,
			'values'  => $values,
			'success' => $success,
			'extra'   => $extra,
		),
		CC_FORM_TTL
	);

	$args = array( 'cc_' . $key . '_token' => $token );

	if ( $success ) {
		$args['cc_' . $key . '_ok'] = 1;
	}

	wp_safe_redirect( add_query_arg( $args, remove_query_arg( array( 'cc_' . $key . '_token' ), $return ) ) );
	exit;
}

/**
 * Fetch (and delete) the stored state for a form.
 *
 * @param string $key   State bucket.
 * @param string $token Token from the query string.
 * @return array
 */
function cc_take_state( $key, $token ) {
	if ( ! $token ) {
		return array();
	}

	$state = get_transient( 'cc_form_' . $key . '_' . $token );

	if ( ! is_array( $state ) ) {
		return array();
	}

	delete_transient( 'cc_form_' . $key . '_' . $token );

	return $state;
}

/**
 * A honeypot was filled: treat the submission as a success but store nothing.
 *
 * @param string $return Redirect URL.
 * @param string $key    State bucket so the right form shows the message.
 */
function cc_bot_blocked( $return, $key = 'exam' ) {
	cc_redirect_with_state( $key, array(), array(), __( 'ধন্যবাদ! আপনার আবেদন গ্রহণ করা হয়েছে।', 'coaching-centre' ), $return );
}

/**
 * Handle the full admission form.
 */
function cc_handle_registration() {
	$return = cc_form_guard( 'cc_register', 'cc_reg_nonce' );

	if ( cc_post( 'cc_hp' ) ) {
		cc_bot_blocked( $return, 'reg' );
	}

	$values = array(
		'_cc_student_bn'      => cc_post( 'student_bn' ),
		'_cc_student_en'      => cc_post( 'student_en' ),
		'_cc_dob'             => cc_post( 'dob' ),
		'_cc_gender'          => cc_post( 'gender' ),
		'_cc_student_mobile'  => cc_post( 'student_mobile' ),
		'_cc_email'           => cc_post( 'email' ),
		'_cc_school'          => cc_post( 'school' ),
		'_cc_address'         => cc_post( 'address' ),
		'_cc_class'           => cc_post( 'course_class' ),
		'_cc_program'         => cc_post( 'program' ),
		'_cc_group'           => cc_post( 'group' ),
		'_cc_version'         => cc_post( 'version' ),
		'_cc_mode'            => cc_post( 'mode' ),
		'_cc_branch'          => cc_post( 'branch' ),
		'_cc_last_result'     => cc_post( 'last_result' ),
		'_cc_father'          => cc_post( 'father' ),
		'_cc_mother'          => cc_post( 'mother' ),
		'_cc_guardian_mobile' => cc_post( 'guardian_mobile' ),
		'_cc_occupation'      => cc_post( 'occupation' ),
		'_cc_source'          => cc_post( 'source' ),
		'_cc_payment'         => cc_post( 'payment' ),
		'terms'               => cc_post( 'terms' ),
	);

	$errors = array();

	/* Required text. */
	$required = array(
		'student_bn'      => __( 'শিক্ণার্থীর নাম', 'coaching-centre' ),
		'school'          => __( 'বর্তমান স্কুল / কলেজ', 'coaching-centre' ),
		'address'         => __( 'বর্তমান ঠিকানা', 'coaching-centre' ),
		'father'          => __( 'পিতার নাম', 'coaching-centre' ),
		'mother'          => __( 'মাতার নাম', 'coaching-centre' ),
		'version'         => __( 'ভার্সন', 'coaching-centre' ),
		'mode'            => __( 'অংশগ্রহণের মাধ্যম', 'coaching-centre' ),
		'payment'         => __( 'পেমেন্ট মাধ্যম', 'coaching-centre' ),
	);

	foreach ( $required as $field => $label ) {
		if ( '' === cc_post( $field ) ) {
			$errors[ $field ] = $label . ' ' . __( 'পূরণ করা আবশ্যক।', 'coaching-centre' );
		}
	}

	/* Gender. */
	if ( ! in_array( $values['_cc_gender'], array( 'ছেলে', 'মেয়ে' ), true ) ) {
		$errors['gender'] = __( 'লিঙ্গ নির্বাচন করুন।', 'coaching-centre' );
	}

	/* Date of birth. */
	if ( '' === $values['_cc_dob'] ) {
		$errors['dob'] = __( 'জন্ম তারিখ দিন।', 'coaching-centre' );
	} elseif ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $values['_cc_dob'] ) ) {
		$errors['dob'] = __( 'জন্ম তারিখ সঠিক নয়।', 'coaching-centre' );
	}

	/* Mobile numbers. */
	foreach ( array( 'student_mobile', 'guardian_mobile' ) as $field ) {
		$clean = cc_clean_mobile( cc_post( $field ) );

		if ( '' === $clean ) {
			$errors[ $field ] = __( 'সঠিক মোবাইল নম্বর দিন (০১XXXXXXXXX)।', 'coaching-centre' );
		} else {
			$values[ '_cc_' . $field ] = $clean;
		}
	}

	/* Email. */
	if ( '' !== $values['_cc_email'] && ! is_email( $values['_cc_email'] ) ) {
		$errors['email'] = __( 'ইমেইল ঠিকানাটি সঠিক নয়।', 'coaching-centre' );
	}

	/* Course lookup — the fee always comes from the database, never from POST. */
	$program_map = cc_program_map();
	$fee         = 0;
	$course_id   = 0;
	$modes       = array();

	if ( ! isset( $program_map[ $values['_cc_class'] ] ) ) {
		$errors['course_class'] = __( 'শ্রেণি নির্বাচন করুন।', 'coaching-centre' );
	} else {
		foreach ( $program_map[ $values['_cc_class'] ] as $program ) {
			if ( $program['label'] === $values['_cc_program'] ) {
				$fee       = $program['fee'];
				$course_id = $program['id'];
				$modes     = $program['modes'];
				break;
			}
		}

		if ( ! $course_id ) {
			$errors['program'] = __( 'সঠিক প্রোগ্রাম নির্বাচন করুন।', 'coaching-centre' );
		}
	}

	if ( ! $errors && ! in_array( $values['_cc_mode'], $modes, true ) ) {
		$errors['mode'] = __( 'অংশগ্রহণের মাধ্যমটি সঠিক নয়।', 'coaching-centre' );
	}

	/* Group is required for the senior classes only. */
	if ( ! $errors && preg_match( '/৯ম|১০ম/', $values['_cc_class'] ) && '' === $values['_cc_group'] ) {
		$errors['group'] = __( 'গ্রুপ নির্বাচন করুন।', 'coaching-centre' );
	}

	/* Terms. */
	if ( empty( $_POST['terms'] ) ) {
		$errors['terms'] = __( 'নিয়ম ও শর্তাবলী মেনে নিতে হবে।', 'coaching-centre' );
	}

	if ( $errors ) {
		cc_redirect_with_state( 'reg', $errors, $values, '', $return );
	}

	/* The terms checkbox is only re-rendering state, never stored as meta. */
unset( $values['terms'] );

/* Optional photo upload. */
	$values['_cc_photo_id'] = cc_store_upload( 'cc_photo' );

	$values['_cc_kind'] = 'admission';
	$values['_cc_fee']  = $fee;

	$post_id = cc_insert_registration( $values );

	if ( is_wp_error( $post_id ) ) {
		$errors['_cc_form'] = __( 'আবেদনটি সংরক্ষণ করা যায়নি। আবার চেষ্টা করুন।', 'coaching-centre' );
		cc_redirect_with_state( 'reg', $errors, $values, '', $return );
	}

	do_action( 'cc_registration_created', $post_id );

	cc_notify_new_registration( $post_id );

	wp_safe_redirect( add_query_arg( 'cc_receipt', $post_id . '.' . cc_receipt_token( $post_id ), remove_query_arg( 'cc_reg_token', $return ) ) );
	exit;
}
add_action( 'admin_post_nopriv_cc_register', 'cc_handle_registration' );
add_action( 'admin_post_cc_register', 'cc_handle_registration' );

/**
 * Handle the weekly model exam sign-up from the home page.
 */
function cc_handle_exam_registration() {
	$return = cc_form_guard( 'cc_exam', 'cc_exam_nonce' );

	if ( cc_post( 'cc_hp' ) ) {
		cc_bot_blocked( $return );
	}

	$name    = cc_post( 'exam_name' );
	$mobile  = cc_clean_mobile( cc_post( 'exam_mobile' ) );
	$class   = cc_post( 'exam_class' );
	$classes = cc_lines( cc_opt( 'cc_exam_class_opt' ) );

	$values = array(
		'exam_name'   => $name,
		'exam_mobile' => cc_post( 'exam_mobile' ),
		'exam_class'  => $class,
	);

	$errors = array();

	if ( '' === $name ) {
		$errors['exam_name'] = __( 'শিক্ণার্থীর নাম লিখুন।', 'coaching-centre' );
	}

	if ( '' === $mobile ) {
		$errors['exam_mobile'] = __( 'সঠিক মোবাইল নম্বর দিন (০১XXXXXXXXX)।', 'coaching-centre' );
	}

	if ( ! $classes || ! in_array( $class, $classes, true ) ) {
		$errors['exam_class'] = __( 'শ্রেণি / পরীক্ষা বেছে নিন।', 'coaching-centre' );
	}

	if ( $errors ) {
		cc_redirect_with_state( 'exam', $errors, $values, '', $return );
	}

	$post_id = cc_insert_registration(
		array(
			'_cc_kind'           => 'exam',
			'_cc_student_bn'     => $name,
			'_cc_student_mobile' => $mobile,
			'_cc_class'          => $class,
			'_cc_program'        => __( 'সাপ্তাহিক মডেল পরীক্ষা', 'coaching-centre' ),
			'_cc_mode'           => __( 'অফলাইন', 'coaching-centre' ),
			'_cc_payment'        => cc_opt( 'cc_exam_payment' ),
			'_cc_fee'            => (float) cc_opt( 'cc_exam_price' ),
		)
	);

	if ( is_wp_error( $post_id ) ) {
		$errors['_cc_form'] = __( 'রেজিস্ট্রেশনটি সংরক্ষণ করা যায়নি। আবার চেষ্টা করুন।', 'coaching-centre' );
		cc_redirect_with_state( 'exam', $errors, $values, '', $return );
	}

	do_action( 'cc_registration_created', $post_id );

	cc_notify_new_registration( $post_id );

	wp_safe_redirect( add_query_arg( 'cc_exam_receipt', $post_id . '.' . cc_receipt_token( $post_id ), $return . '#exam' ) );
	exit;
}
add_action( 'admin_post_nopriv_cc_exam_register', 'cc_handle_exam_registration' );
add_action( 'admin_post_cc_exam_register', 'cc_handle_exam_registration' );

/**
 * Handle the contact form.
 */
function cc_handle_contact() {
	$return = cc_form_guard( 'cc_contact', 'cc_contact_nonce' );

	if ( cc_post( 'cc_hp' ) ) {
		wp_safe_redirect( add_query_arg( 'cc_sent', 1, remove_query_arg( 'cc_contact_token', $return ) ) );
		exit;
	}

	$values = array(
		'_cc_msg_name'   => cc_post( 'contact_name' ),
		'_cc_msg_mobile' => cc_post( 'contact_mobile' ),
		'_cc_msg_topic'  => cc_post( 'contact_topic' ),
		'_cc_msg_body'   => cc_post( 'contact_message' ),
	);

	$errors = array();

	if ( '' === $values['_cc_msg_name'] ) {
		$errors['contact_name'] = __( 'আপনার নাম লিখুন।', 'coaching-centre' );
	}

	if ( '' === cc_clean_mobile( $values['_cc_msg_mobile'] ) ) {
		$errors['contact_mobile'] = __( 'সঠিক মোবাইল নম্বর দিন (০১XXXXXXXXX)।', 'coaching-centre' );
	} else {
		$values['_cc_msg_mobile'] = cc_clean_mobile( $values['_cc_msg_mobile'] );
	}

	if ( '' === $values['_cc_msg_topic'] ) {
		$errors['contact_topic'] = __( 'বিষয় বেছে নিন।', 'coaching-centre' );
	}

	if ( mb_strlen( $values['_cc_msg_body'] ) < 10 ) {
		$errors['contact_message'] = __( 'বার্তা কমপক্ষে ১০ অক্ষরের হতে হবে।', 'coaching-centre' );
	}

	if ( $errors ) {
		cc_redirect_with_state( 'contact', $errors, $values, '', $return );
	}

	$values['_cc_msg_source'] = wp_get_referer() ? wp_parse_url( wp_get_referer(), PHP_URL_HOST ) : '';
	$values['_cc_msg_read']   = 0;

	$post_id = cc_insert_message( $values );

	if ( is_wp_error( $post_id ) ) {
		$errors['_cc_form'] = __( 'বার্তাটি পাঠানো যায়নি। আবার চেষ্টা করুন।', 'coaching-centre' );
		cc_redirect_with_state( 'contact', $errors, $values, '', $return );
	}

	/**
	 * Fires after a contact message has been stored.
	 *
	 * @param int   $post_id Message ID.
	 * @param array $values  Stored values.
	 */
	do_action( 'cc_message_created', $post_id, $values );

	wp_safe_redirect( add_query_arg( 'cc_sent', 1, remove_query_arg( 'cc_contact_token', $return ) ) );
	exit;
}
add_action( 'admin_post_nopriv_cc_contact', 'cc_handle_contact' );
add_action( 'admin_post_cc_contact', 'cc_handle_contact' );

/**
 * Store a single uploaded image and return its attachment ID.
 *
 * @param string $key File input name.
 * @return int Attachment ID, or 0.
 */
function cc_store_upload( $key ) {
	if ( empty( $_FILES[ $key ]['name'] ) || UPLOAD_ERR_OK !== (int) $_FILES[ $key ]['error'] ) {
		return 0;
	}

	if ( (int) $_FILES[ $key ]['size'] > 5 * MB_IN_BYTES ) {
		return 0;
	}

	$check = wp_check_filetype_and_ext( $_FILES[ $key ]['tmp_name'], $_FILES[ $key ]['name'], array( 'jpg|jpeg|jpe' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'gif' => 'image/gif' ) );

	if ( empty( $check['type'] ) || 0 !== strpos( $check['type'], 'image/' ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$overrides = array(
		'test_form' => false,
		'mimes'     => array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'png'          => 'image/png',
			'webp'         => 'image/webp',
			'gif'          => 'image/gif',
		),
	);

	$upload = wp_handle_upload( $_FILES[ $key ], $overrides );

	if ( isset( $upload['error'] ) ) {
		return 0;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $upload['type'],
			'post_title'     => sanitize_file_name( wp_basename( $_FILES[ $key ]['name'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		return 0;
	}

	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );

	return (int) $attachment_id;
}

/**
 * Generate a human friendly registration code.
 *
 * @return string
 */
function cc_generate_code() {
	return sprintf( 'GD-%s-%s', wp_date( 'Y' ), wp_rand( 10000, 99999 ) );
}

/**
 * Insert a registration post from an array of meta values.
 *
 * @param array $values Meta values.
 * @return int|WP_Error Post ID.
 */
function cc_insert_registration( $values ) {
	$values = wp_parse_args(
		$values,
		array(
			'_cc_kind' => 'admission',
		)
	);

	$name   = isset( $values['_cc_student_bn'] ) ? $values['_cc_student_bn'] : '';
	$class  = isset( $values['_cc_class'] ) ? $values['_cc_class'] : '';
	$mobile = isset( $values['_cc_student_mobile'] ) ? $values['_cc_student_mobile'] : '';

	$title = trim( $name . ( $class ? ' — ' . $class : '' ) . ( $mobile ? ' (' . $mobile . ')' : '' ) );

	if ( '' === $title ) {
		$title = __( 'আবেদন', 'coaching-centre' );
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'cc_registration',
			'post_status' => 'cc-pending',
			'post_title'  => $title,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	$values['_cc_code'] = cc_generate_code();

	foreach ( $values as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	return (int) $post_id;
}

/**
 * Insert a contact message post.
 *
 * @param array $values Meta values.
 * @return int|WP_Error Post ID.
 */
function cc_insert_message( $values ) {
	$name = isset( $values['_cc_msg_name'] ) ? $values['_cc_msg_name'] : '';

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'cc_message',
			'post_status' => 'publish',
			'post_title'  => $name ? $name : __( 'বার্তা', 'coaching-centre' ),
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	foreach ( $values as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}

	return (int) $post_id;
}

/**
 * Email the site administrator about a new registration.
 *
 * @param int $post_id Registration ID.
 */
function cc_notify_new_registration( $post_id ) {
	if ( ! apply_filters( 'cc_send_notification', true, $post_id ) ) {
		return;
	}

	$kinds  = cc_kinds();
	$kind   = cc_reg_field( $post_id, '_cc_kind' );
	$to     = apply_filters( 'cc_notification_email', get_option( 'admin_email' ) );

	$subject = sprintf(
		/* translators: %s: site name */
		__( '[%s] নতুন আবেদন পেয়েছেন — %s', 'coaching-centre' ),
		wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		isset( $kinds[ $kind ] ) ? $kinds[ $kind ] : $kind
	);

	$lines = array(
		__( 'নতুন একটি আবেদন জমা পড়েছে।', 'coaching-centre' ),
		'',
		sprintf( '%s: %s', __( 'আইডি', 'coaching-centre' ), cc_reg_field( $post_id, '_cc_code' ) ),
		sprintf( '%s: %s', __( 'নাম', 'coaching-centre' ), cc_reg_field( $post_id, '_cc_student_bn' ) ),
		sprintf( '%s: %s', __( 'মোবাইল', 'coaching-centre' ), cc_reg_field( $post_id, '_cc_student_mobile' ) ),
		sprintf( '%s: %s', __( 'শ্রেণি', 'coaching-centre' ), cc_reg_field( $post_id, '_cc_class' ) ),
		sprintf( '%s: %s', __( 'প্রোগ্রাম', 'coaching-centre' ), cc_reg_field( $post_id, '_cc_program' ) ),
		sprintf( '%s: %s', __( 'ফি', 'coaching-centre' ), cc_money( cc_reg_field( $post_id, '_cc_fee' ) ) ),
		'',
		get_edit_post_link( $post_id, 'raw' ),
	);

	wp_mail( $to, $subject, implode( "\n", $lines ) );
}