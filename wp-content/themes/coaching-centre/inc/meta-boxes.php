<?php
/**
 * Post meta registration and editor meta boxes.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Full field map for a registration / exam entry.
 *
 * Used by the admin detail panel, the admin tables, the receipt and the CSV
 * export so that a field only ever has to be defined once.
 *
 * @return array
 */
function cc_registration_fields() {
	return array(
		'_cc_kind'           => array(
			'label' => __( 'ধরন', 'coaching-centre' ),
			'type'  => 'kind',
		),
		'_cc_code'           => array(
			'label' => __( 'রেজিস্ট্রেশন আইডি', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_student_bn'     => array(
			'label' => __( 'শিক্ষার্থীর নাম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_student_en'     => array(
			'label' => __( 'Name (English)', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_dob'            => array(
			'label' => __( 'জন্ম তারিখ', 'coaching-centre' ),
			'type'  => 'date',
		),
		'_cc_gender'         => array(
			'label'   => __( 'লিঙ্গ', 'coaching-centre' ),
			'type'    => 'select',
			'options' => array(
				'ছেলে' => __( 'ছেলে', 'coaching-centre' ),
				'মেয়ে'  => __( 'মেয়ে', 'coaching-centre' ),
			),
		),
		'_cc_student_mobile' => array(
			'label' => __( 'শিক্ষার্থীর মোবাইল', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_email'          => array(
			'label' => __( 'ইমেইল', 'coaching-centre' ),
			'type'  => 'email',
		),
		'_cc_school'         => array(
			'label' => __( 'স্কুল / কলেজ', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_address'        => array(
			'label' => __( 'ঠিকানা', 'coaching-centre' ),
			'type'  => 'textarea',
		),
		'_cc_photo_id'       => array(
			'label' => __( 'ছবি', 'coaching-centre' ),
			'type'  => 'attachment',
		),
		'_cc_class'          => array(
			'label' => __( 'শ্রেণি', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_program'        => array(
			'label' => __( 'প্রোগ্রাম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_group'          => array(
			'label'   => __( 'গ্রুপ', 'coaching-centre' ),
			'type'    => 'select',
			'options' => array(
				'বিজ্ঞান'        => __( 'বিজ্ঞান', 'coaching-centre' ),
				'ব্যবসায় শিক্ষা' => __( 'ব্যবসায় শিক্ষা', 'coaching-centre' ),
				'মানবিক'        => __( 'মানবিক', 'coaching-centre' ),
			),
		),
		'_cc_version'        => array(
			'label'   => __( 'ভার্সন', 'coaching-centre' ),
			'type'    => 'select',
			'options' => array(
				'বাংলা'  => __( 'বাংলা', 'coaching-centre' ),
				'ইংরেজি' => __( 'ইংরেজি', 'coaching-centre' ),
			),
		),
		'_cc_mode'           => array(
			'label' => __( 'মাধ্যম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_branch'         => array(
			'label' => __( 'শাখা', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_last_result'    => array(
			'label' => __( 'সর্বশেষ পরীক্ষার ফল', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_father'         => array(
			'label' => __( 'পিতার নাম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_mother'         => array(
			'label' => __( 'মাতার নাম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_guardian_mobile' => array(
			'label' => __( 'অভিভাবকের মোবাইল', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_occupation'     => array(
			'label' => __( 'পেশা', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_source'         => array(
			'label' => __( 'কীভাবে জানলেন', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_payment'        => array(
			'label' => __( 'পেমেন্ট মাধ্যম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_fee'            => array(
			'label' => __( 'ফি', 'coaching-centre' ),
			'type'  => 'number',
		),
	);
}

/**
 * Field map for contact messages.
 *
 * @return array
 */
function cc_message_fields() {
	return array(
		'_cc_msg_name'    => array(
			'label' => __( 'নাম', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_msg_mobile'  => array(
			'label' => __( 'মোবাইল', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_msg_topic'   => array(
			'label' => __( 'বিষয়', 'coaching-centre' ),
			'type'  => 'text',
		),
		'_cc_msg_body'    => array(
			'label' => __( 'বার্তা', 'coaching-centre' ),
			'type'  => 'textarea',
		),
		'_cc_msg_source'  => array(
			'label' => __( 'আসার উৎস', 'coaching-centre' ),
			'type'  => 'text',
		),
	);
}

/**
 * Every meta key the theme owns, keyed by post type.
 *
 * @return array
 */
function cc_meta_registry() {
	$registry = array(
		'cc_course'      => array(
			'_cc_class'    => 'string',
			'_cc_fee'      => 'number',
			'_cc_modes'    => 'string',
			'_cc_badge'    => 'string',
			'_cc_features' => 'string',
			'_cc_group'    => 'string',
			'_cc_hidden'   => 'integer',
		),
		'cc_teacher'     => array(
			'_cc_subject'     => 'string',
			'_cc_designation' => 'string',
		),
		'cc_testimonial' => array(
			'_cc_role' => 'string',
		),
		'cc_registration' => array(
			'_cc_kind'           => 'string',
			'_cc_code'           => 'string',
			'_cc_student_bn'     => 'string',
			'_cc_student_en'     => 'string',
			'_cc_dob'            => 'string',
			'_cc_gender'         => 'string',
			'_cc_student_mobile' => 'string',
			'_cc_email'          => 'string',
			'_cc_school'         => 'string',
			'_cc_address'        => 'string',
			'_cc_photo_id'       => 'integer',
			'_cc_class'          => 'string',
			'_cc_program'        => 'string',
			'_cc_group'          => 'string',
			'_cc_version'        => 'string',
			'_cc_mode'           => 'string',
			'_cc_branch'         => 'string',
			'_cc_last_result'    => 'string',
			'_cc_father'         => 'string',
			'_cc_mother'         => 'string',
			'_cc_guardian_mobile' => 'string',
			'_cc_occupation'     => 'string',
			'_cc_source'         => 'string',
			'_cc_payment'        => 'string',
			'_cc_fee'            => 'number',
		),
		'cc_message'     => array(
			'_cc_msg_name'   => 'string',
			'_cc_msg_mobile' => 'string',
			'_cc_msg_topic'  => 'string',
			'_cc_msg_body'   => 'string',
			'_cc_msg_source' => 'string',
			'_cc_msg_read'   => 'integer',
		),
	);

	/**
	 * Filter the meta registry.
	 *
	 * @param array $registry Meta definitions keyed by post type.
	 */
	return apply_filters( 'cc_meta_registry', $registry );
}

/**
 * Register the meta so it is protected, typed and available to get_post_meta().
 */
function cc_register_meta() {
	foreach ( cc_meta_registry() as $post_type => $keys ) {
		foreach ( $keys as $key => $type ) {
			register_post_meta(
				$post_type,
				$key,
				array(
					'type'          => $type,
					'single'        => true,
					'show_in_rest'  => false,
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}
add_action( 'init', 'cc_register_meta' );

/**
 * Read one registration field.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key.
 * @return string
 */
function cc_reg_field( $post_id, $key ) {
	return (string) get_post_meta( $post_id, $key, true );
}

/**
 * Read a course field.
 *
 * @param int    $post_id Course ID.
 * @param string $key     Meta key.
 * @param mixed  $default Fallback.
 * @return string
 */
function cc_course_field( $post_id, $key, $default = '' ) {
	$value = get_post_meta( $post_id, $key, true );

	return '' === $value || null === $value ? $default : $value;
}

/**
 * Course fee as a float.
 *
 * @param int $post_id Course ID.
 * @return float
 */
function cc_course_fee( $post_id ) {
	return (float) cc_course_field( $post_id, '_cc_fee', 0 );
}

/**
 * Available attendance modes for a course.
 *
 * @param int $post_id Course ID.
 * @return array
 */
function cc_course_modes( $post_id ) {
	$modes = cc_lines( cc_course_field( $post_id, '_cc_modes', '' ) );

	return $modes ? $modes : array( __( 'অফলাইন', 'coaching-centre' ) );
}

/**
 * Feature bullet list for a course.
 *
 * @param int $post_id Course ID.
 * @return array
 */
function cc_course_features( $post_id ) {
	return cc_lines( cc_course_field( $post_id, '_cc_features', '' ) );
}

/**
 * Add the theme meta boxes to the editors that need them.
 */
function cc_add_meta_boxes() {
	if ( ! function_exists( 'rwmb_meta' ) ) {
		add_meta_box(
			'cc-course-details',
			__( 'কোর্সের তথ্য', 'coaching-centre' ),
			'cc_course_meta_box',
			'cc_course',
			'normal',
			'high'
		);

		add_meta_box(
			'cc-teacher-details',
			__( 'শিক্ষকের তথ্য', 'coaching-centre' ),
			'cc_teacher_meta_box',
			'cc_teacher',
			'normal',
			'high'
		);

		add_meta_box(
			'cc-testimonial-details',
			__( 'মতামতের তথ্য', 'coaching-centre' ),
			'cc_testimonial_meta_box',
			'cc_testimonial',
			'side',
			'default'
		);
	}


	add_meta_box(
		'cc-registration-details',
		__( 'আবেদনের বিবরণ', 'coaching-centre' ),
		'cc_registration_meta_box',
		'cc_registration',
		'normal',
		'high'
	);

	add_meta_box(
		'cc-message-details',
		__( 'বার্তার বিবরণ', 'coaching-centre' ),
		'cc_message_meta_box',
		'cc_message',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cc_add_meta_boxes' );

/**
 * Render a simple labelled text/textarea/select field.
 *
 * @param string $key   Meta key.
 * @param string $label Field label.
 * @param string $type  Field type.
 * @param mixed  $value Current value.
 * @param array  $args  Extra args (options, description, min).
 */
function cc_field( $key, $label, $type, $value, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'options'     => array(),
			'description' => '',
			'min'         => 0,
			'placeholder' => '',
		)
	);

	$id = 'cc-field-' . sanitize_key( $key );
	?>
	<p class="cc-field">
		<label for="<?php echo esc_attr( $id ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<?php if ( 'textarea' === $type ) : ?>
			<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="4" class="widefat" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
		<?php elseif ( 'select' === $type ) : ?>
			<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $key ); ?>" class="widefat">
				<?php foreach ( $args['options'] as $option_value => $option_label ) : ?>
					<option value="<?php echo esc_attr( is_int( $option_value ) ? '' : $option_value ); ?>" <?php selected( (string) $value, (string) $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php else : ?>
			<input
				type="<?php echo esc_attr( 'number' === $type ? 'number' : 'text' ); ?>"
				id="<?php echo esc_attr( $id ); ?>"
				name="<?php echo esc_attr( $key ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
				class="widefat"
				placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
				<?php if ( 'number' === $type && $args['min'] ) : ?>min="<?php echo esc_attr( $args['min'] ); ?>"<?php endif; ?>
			>
		<?php endif; ?>
		<?php if ( $args['description'] ) : ?>
			<span class="description"><?php echo esc_html( $args['description'] ); ?></span>
		<?php endif; ?>
	</p>
	<?php
}

/**
 * Course meta box.
 *
 * @param WP_Post $post Course.
 */
function cc_course_meta_box( $post ) {
	wp_nonce_field( 'cc_save_course', 'cc_course_nonce' );
	$groups = array(
		'বিজ্ঞান'        => __( 'বিজ্ঞান', 'coaching-centre' ),
		'ব্যবসায় শিক্ষা' => __( 'ব্যবসায় শিক্ষা', 'coaching-centre' ),
		'মানবিক'        => __( 'মানবিক', 'coaching-centre' ),
	);

	cc_field( '_cc_class', __( 'শ্রেণি', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_class' ), array( 'placeholder' => __( 'যেমন: ৮ম শ্রেণি', 'coaching-centre' ), 'description' => __( 'ভর্তি ফর্মে এই কোর্সটি কোন শ্রেণির অধীনে দেখাবে।', 'coaching-centre' ) ) );
	cc_field( '_cc_fee', __( 'কোর্স ফি (৳)', 'coaching-centre' ), 'number', cc_course_field( $post->ID, '_cc_fee' ), array( 'min' => 0 ) );
	cc_field( '_cc_modes', __( 'অংশগ্রহণের মাধ্যম', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_modes' ), array( 'placeholder' => 'অফলাইন, অনলাইন', 'description' => __( 'কমা দিয়ে আলাদা করুন।', 'coaching-centre' ) ) );
	cc_field( '_cc_group', __( 'গ্রুপ', 'coaching-centre' ), 'select', cc_course_field( $post->ID, '_cc_group' ), array( 'options' => array( '' => '—' ) + $groups ) );
	cc_field( '_cc_badge', __( 'ব্যাজ', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_badge' ), array( 'placeholder' => __( 'যেমন: অফলাইন', 'coaching-centre' ) ) );
	cc_field( '_cc_features', __( 'কোর্সের বৈশিষ্ট্য', 'coaching-centre' ), 'textarea', cc_course_field( $post->ID, '_cc_features' ), array( 'description' => __( 'প্রতি লাইনে একটি আইটেম।', 'coaching-centre' ) ) );
	?>
	<p>
		<label>
			<input type="checkbox" name="_cc_hidden" value="1" <?php checked( 1, (int) cc_course_field( $post->ID, '_cc_hidden', 0 ) ); ?>>
			<?php esc_html_e( 'হোমপেজের কোর্স গ্রিডে দেখাবেন না', 'coaching-centre' ); ?>
		</label>
		<span class="description"><?php esc_html_e( 'শুধু ভর্তি ফর্মে দেখানোর জন্য (যেমন সাপ্তাহিক মডেল পরীক্ষা)।', 'coaching-centre' ); ?></span>
	</p>
	<p class="description"><?php esc_html_e( 'হোমপেজের কোর্স তালিকায় প্রদর্শনের ক্রম বদলাতে "অর্ডার" ফিল্ড ব্যবহার করুন।', 'coaching-centre' ); ?></p>
	<?php
}

/**
 * Teacher meta box.
 *
 * @param WP_Post $post Teacher.
 */
function cc_teacher_meta_box( $post ) {
	wp_nonce_field( 'cc_save_teacher', 'cc_teacher_nonce' );

	cc_field( '_cc_subject', __( 'বিভাগ', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_subject' ), array( 'placeholder' => __( 'যেমন: গণিত বিভাগ', 'coaching-centre' ) ) );
	cc_field( '_cc_designation', __( 'পদবি', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_designation' ), array( 'placeholder' => __( 'যেমন: সহকারী অধ্যাপক', 'coaching-centre' ) ) );
	echo '<p class="description">' . esc_html__( 'শিক্ষকের নামটি উপরের টাইটেল ফিল্ডে লিখুন এবং ছবিটি ফিচার্ড ইমেজ হিসেবে সেট করুন।', 'coaching-centre' ) . '</p>';
}

/**
 * Testimonial meta box.
 *
 * @param WP_Post $post Testimonial.
 */
function cc_testimonial_meta_box( $post ) {
	wp_nonce_field( 'cc_save_testimonial', 'cc_testimonial_nonce' );

	echo '<p class="description">' . esc_html__( 'উদ্ধৃতিটি উপরের এডিটরে লিখুন এবং মানুষের নামটি টাইটেল হিসেবে রাখুন।', 'coaching-centre' ) . '</p>';
	cc_field( '_cc_role', __( 'পরিচয়', 'coaching-centre' ), 'text', cc_course_field( $post->ID, '_cc_role' ), array( 'placeholder' => __( 'যেমন: শিক্ষার্থী, SSC', 'coaching-centre' ) ) );
}

/**
 * Save the course meta box.
 *
 * @param int $post_id Course ID.
 */
function cc_save_course( $post_id ) {
	if ( ! isset( $_POST['cc_course_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['cc_course_nonce'] ) ), 'cc_save_course' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array( '_cc_class', '_cc_modes', '_cc_badge', '_cc_group' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, cc_sanitize_textarea( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	if ( isset( $_POST['_cc_fee'] ) ) {
		update_post_meta( $post_id, '_cc_fee', (float) sanitize_text_field( wp_unslash( $_POST['_cc_fee'] ) ) );
	}

	if ( isset( $_POST['_cc_features'] ) ) {
		update_post_meta( $post_id, '_cc_features', cc_sanitize_textarea( wp_unslash( $_POST['_cc_features'] ) ) );
	}

	update_post_meta( $post_id, '_cc_hidden', empty( $_POST['_cc_hidden'] ) ? 0 : 1 );
}
add_action( 'save_post_cc_course', 'cc_save_course' );

/**
 * Save the teacher meta box.
 *
 * @param int $post_id Teacher ID.
 */
function cc_save_teacher( $post_id ) {
	if ( ! isset( $_POST['cc_teacher_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['cc_teacher_nonce'] ) ), 'cc_save_teacher' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array( '_cc_subject', '_cc_designation' ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, cc_sanitize_text( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_cc_teacher', 'cc_save_teacher' );

/**
 * Save the testimonial meta box.
 *
 * @param int $post_id Testimonial ID.
 */
function cc_save_testimonial( $post_id ) {
	if ( ! isset( $_POST['cc_testimonial_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['cc_testimonial_nonce'] ) ), 'cc_save_testimonial' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['_cc_role'] ) ) {
		update_post_meta( $post_id, '_cc_role', cc_sanitize_text( wp_unslash( $_POST['_cc_role'] ) ) );
	}
}
add_action( 'save_post_cc_testimonial', 'cc_save_testimonial' );

/**
 * Render the registration detail panel.
 *
 * @param WP_Post $post Registration.
 */
function cc_registration_meta_box( $post ) {
	wp_nonce_field( 'cc_registration_save', 'cc_registration_nonce' );

	$fields = cc_registration_fields();
	$kinds  = cc_kinds();
	$status = cc_statuses();
	?>
	<p>
		<label for="cc-reg-status"><strong><?php esc_html_e( 'স্ট্যাটাস', 'coaching-centre' ); ?></strong></label>
		<select id="cc-reg-status" name="cc_reg_status" class="widefat">
			<?php foreach ( $status as $status_key => $status_label ) : ?>
				<option value="<?php echo esc_attr( $status_key ); ?>" <?php selected( $post->post_status, $status_key ); ?>><?php echo esc_html( $status_label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="cc-reg-note"><strong><?php esc_html_e( 'অ্যাডমিন নোট', 'coaching-centre' ); ?></strong></label>
		<textarea id="cc-reg-note" name="cc_reg_note" rows="3" class="widefat"><?php echo esc_textarea( get_post_meta( $post->ID, '_cc_admin_note', true ) ); ?></textarea>
	</p>
	<hr>
	<table class="widefat striped cc-detail-table">
		<tbody>
		<?php foreach ( $fields as $key => $field ) : ?>
			<?php
			$value = cc_reg_field( $post->ID, $key );

			if ( 'kind' === $field['type'] ) {
				$value = isset( $kinds[ $value ] ) ? $kinds[ $value ] : $value;
			} elseif ( 'attachment' === $field['type'] ) {
				$value = $value ? wp_get_attachment_image( (int) $value, array( 90, 90 ) ) : '';
			}
			?>
			<tr>
				<th style="width:200px"><?php echo esc_html( $field['label'] ); ?></th>
				<td>
					<?php if ( 'attachment' === $field['type'] ) : ?>
						<?php echo $value ? wp_kses_post( $value ) : '<span class="description">—</span>'; ?>
					<?php elseif ( 'number' === $field['type'] ) : ?>
						<?php echo '' !== $value ? esc_html( cc_money( $value ) ) : '<span class="description">—</span>'; ?>
					<?php else : ?>
						<?php echo '' !== $value ? nl2br( esc_html( $value ) ) : '<span class="description">—</span>'; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<th><?php esc_html_e( 'জমা দিয়েছেন', 'coaching-centre' ); ?></th>
				<td><?php echo esc_html( get_the_date( 'd/m/Y H:i', $post ) ); ?></td>
			</tr>
		</tbody>
	</table>
	<p>
		<a class="button" href="<?php echo esc_url( get_edit_post_link( $post ) ); ?>"><?php esc_html_e( 'সম্পাদনা করুন', 'coaching-centre' ); ?></a>
		<a class="button" target="_blank" rel="noopener" href="<?php echo esc_url( cc_receipt_url( $post->ID ) ); ?>"><?php esc_html_e( 'রসিদ দেখুন', 'coaching-centre' ); ?></a>
	</p>
	<?php
}

/**
 * Persist the status select and admin note.
 *
 * @param int $post_id Registration ID.
 */
function cc_save_registration( $post_id ) {
	if ( ! isset( $_POST['cc_registration_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['cc_registration_nonce'] ) ), 'cc_registration_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$statuses = cc_statuses();

	if ( isset( $_POST['cc_reg_status'] ) ) {
		$status = sanitize_key( wp_unslash( $_POST['cc_reg_status'] ) );

		if ( isset( $statuses[ $status ] ) && get_post_status( $post_id ) !== $status ) {
			wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => $status,
				)
			);
		}
	}

	if ( isset( $_POST['cc_reg_note'] ) ) {
		update_post_meta( $post_id, '_cc_admin_note', cc_sanitize_textarea( wp_unslash( $_POST['cc_reg_note'] ) ) );
	}
}
add_action( 'save_post_cc_registration', 'cc_save_registration' );

/**
 * Render the message detail panel.
 *
 * @param WP_Post $post Message.
 */
function cc_message_meta_box( $post ) {
	wp_nonce_field( 'cc_message_save', 'cc_message_nonce' );

	$fields = cc_message_fields();
	$read   = (int) get_post_meta( $post->ID, '_cc_msg_read', true );
	?>
	<p>
		<label>
			<input type="checkbox" name="cc_msg_read" value="1" <?php checked( 1, $read ); ?>>
			<?php esc_html_e( 'পঠিত হিসেবে চিহ্নিত', 'coaching-centre' ); ?>
		</label>
	</p>
	<hr>
	<table class="widefat striped cc-detail-table">
		<tbody>
		<?php foreach ( $fields as $key => $field ) : ?>
			<?php if ( '_cc_msg_read' === $key ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<tr>
				<th style="width:180px"><?php echo esc_html( $field['label'] ); ?></th>
				<td><?php echo '' !== cc_reg_field( $post->ID, $key ) ? nl2br( esc_html( cc_reg_field( $post->ID, $key ) ) ) : '<span class="description">—</span>'; ?></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<th><?php esc_html_e( 'প্রাপ্ত', 'coaching-centre' ); ?></th>
				<td><?php echo esc_html( get_the_date( 'd/m/Y H:i', $post ) ); ?></td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * Persist the read flag.
 *
 * @param int $post_id Message ID.
 */
function cc_save_message( $post_id ) {
	if ( ! isset( $_POST['cc_message_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['cc_message_nonce'] ) ), 'cc_message_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_cc_msg_read', empty( $_POST['cc_msg_read'] ) ? 0 : 1 );
}
add_action( 'save_post_cc_message', 'cc_save_message' );

/**
 * Useful admin columns for the registration list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function cc_registration_columns( $columns ) {
	$new = array();

	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;

		if ( 'title' === $key ) {
			$new['cc_student']  = __( 'শিক্ণার্থী', 'coaching-centre' );
			$new['cc_class']    = __( 'শ্রেণি', 'coaching-centre' );
			$new['cc_program']  = __( 'প্রোগ্রাম', 'coaching-centre' );
			$new['cc_mobile']   = __( 'মোবাইল', 'coaching-centre' );
			$new['cc_fee']      = __( 'ফি', 'coaching-centre' );
			$new['cc_payment']  = __( 'পেমেন্ট', 'coaching-centre' );
		}
	}

	$new['cc_kind'] = __( 'ধরন', 'coaching-centre' );

	return $new;
}
add_filter( 'manage_cc_registration_posts_columns', 'cc_registration_columns' );

/**
 * Populate the registration columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function cc_registration_column_content( $column, $post_id ) {
	$map = array(
		'cc_student' => '_cc_student_bn',
		'cc_class'   => '_cc_class',
		'cc_program' => '_cc_program',
		'cc_mobile'  => '_cc_student_mobile',
		'cc_payment' => '_cc_payment',
	);

	if ( isset( $map[ $column ] ) ) {
		echo esc_html( cc_reg_field( $post_id, $map[ $column ] ) );
		return;
	}

	if ( 'cc_fee' === $column ) {
		$fee = cc_reg_field( $post_id, '_cc_fee' );
		echo '' !== $fee ? esc_html( cc_money( $fee ) ) : '—';
		return;
	}

	if ( 'cc_kind' === $column ) {
		$kinds = cc_kinds();
		$kind  = cc_reg_field( $post_id, '_cc_kind' );
		echo esc_html( isset( $kinds[ $kind ] ) ? $kinds[ $kind ] : $kind );
	}
}
add_action( 'manage_cc_registration_posts_custom_column', 'cc_registration_column_content', 10, 2 );

/**
 * Columns for the message list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function cc_message_columns( $columns ) {
	$new = array();

	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;

		if ( 'title' === $key ) {
			$new['cc_msg_contact'] = __( 'যোগাযোগ', 'coaching-centre' );
			$new['cc_msg_topic']   = __( 'বিষয়', 'coaching-centre' );
			$new['cc_msg_state']   = __( 'অবস্থা', 'coaching-centre' );
		}
	}

	return $new;
}
add_filter( 'manage_cc_message_posts_columns', 'cc_message_columns' );

/**
 * Populate the message columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function cc_message_column_content( $column, $post_id ) {
	if ( 'cc_msg_contact' === $column ) {
		printf(
			'%s<br><small>%s</small>',
			esc_html( cc_reg_field( $post_id, '_cc_msg_name' ) ),
			esc_html( cc_reg_field( $post_id, '_cc_msg_mobile' ) )
		);
		return;
	}

	if ( 'cc_msg_topic' === $column ) {
		echo esc_html( cc_reg_field( $post_id, '_cc_msg_topic' ) );
		return;
	}

	if ( 'cc_msg_state' === $column ) {
		$read = (int) get_post_meta( $post_id, '_cc_msg_read', true );
		echo $read
			? esc_html__( 'পঠিত', 'coaching-centre' )
			: '<strong>' . esc_html__( 'নতুন', 'coaching-centre' ) . '</strong>';
	}
}
add_action( 'manage_cc_message_posts_custom_column', 'cc_message_column_content', 10, 2 );

/**
 * Highlight unread messages in the list table.
 *
 * @param array $classes Existing row classes.
 * @param string $post_id Post ID.
 * @return array
 */
function cc_message_row_class( $classes, $post_id ) {
	if ( 'cc_message' === get_post_type( $post_id ) && ! (int) get_post_meta( $post_id, '_cc_msg_read', true ) ) {
		$classes[] = 'cc-unread';
	}

	return $classes;
}
add_filter( 'post_class', 'cc_message_row_class', 10, 2 );

/**
 * Columns for the course list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function cc_course_columns( $columns ) {
	$new = array();

	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;

		if ( 'title' === $key ) {
			$new['cc_course_class'] = __( 'শ্রেণি', 'coaching-centre' );
			$new['cc_course_fee']   = __( 'ফি', 'coaching-centre' );
		}
	}

	return $new;
}
add_filter( 'manage_cc_course_posts_columns', 'cc_course_columns' );

/**
 * Populate the course columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function cc_course_column_content( $column, $post_id ) {
	if ( 'cc_course_class' === $column ) {
		echo esc_html( cc_course_field( $post_id, '_cc_class', '—' ) );
		return;
	}

	if ( 'cc_course_fee' === $column ) {
		$fee = cc_course_fee( $post_id );
		echo $fee ? esc_html( cc_money( $fee ) ) : '—';
	}
}
add_action( 'manage_cc_course_posts_custom_column', 'cc_course_column_content', 10, 2 );