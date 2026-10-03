<?php
/**
 * Custom admin panel: dashboard, registrations, messages and CSV export.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Capability required to manage the coaching data.
 *
 * @return string
 */
function cc_admin_cap() {
	/**
	 * Filter the capability that guards the coaching admin screens.
	 *
	 * @param string $capability Capability name.
	 */
	return apply_filters( 'cc_admin_capability', 'edit_posts' );
}

/**
 * Admin menu.
 */
function cc_admin_menu() {
	$cap = cc_admin_cap();

	$pending = cc_pending_count();
	$unread  = cc_unread_count();

	add_menu_page(
		__( 'কোচিং সেন্টার', 'coaching-centre' ),
		__( 'কোচিং সেন্টার', 'coaching-centre' ),
		$cap,
		'cc-dashboard',
		'cc_render_dashboard',
		'dashicons-welcome-learn-more',
		3
	);

	add_submenu_page(
		'cc-dashboard',
		__( 'ড্যাশবোর্ড', 'coaching-centre' ),
		__( 'ড্যাশবোর্ড', 'coaching-centre' ),
		$cap,
		'cc-dashboard',
		'cc_render_dashboard'
	);

	add_submenu_page(
		'cc-dashboard',
		__( 'আবেদনসমূহ', 'coaching-centre' ),
		$pending ? sprintf(
			/* translators: %s: number of pending registrations */
			__( 'আবেদনসমূহ', 'coaching-centre' ) . ' <span class="awaiting-mod"><span class="pending-count">' . number_format_i18n( $pending ) . '</span></span>',
			$pending
		) : __( 'আবেদনসমূহ', 'coaching-centre' ),
		$cap,
		'cc-registrations',
		'cc_render_registrations'
	);

	add_submenu_page(
		'cc-dashboard',
		__( 'বার্তাসমূহ', 'coaching-centre' ),
		$unread ? sprintf(
			/* translators: %s: number of unread messages */
			__( 'বার্তাসমূহ', 'coaching-centre' ) . ' <span class="awaiting-mod"><span class="pending-count">' . number_format_i18n( $unread ) . '</span></span>',
			$unread
		) : __( 'বার্তাসমূহ', 'coaching-centre' ),
		$cap,
		'cc-messages',
		'cc_render_messages'
	);

	add_submenu_page( 'cc-dashboard', __( 'কোর্স', 'coaching-centre' ), __( 'কোর্স', 'coaching-centre' ), $cap, 'edit.php?post_type=cc_course' );
	add_submenu_page( 'cc-dashboard', __( 'শিক্ষকমণ্ডলী', 'coaching-centre' ), __( 'শিক্ষকমণ্ডলী', 'coaching-centre' ), $cap, 'edit.php?post_type=cc_teacher' );
	add_submenu_page( 'cc-dashboard', __( 'মতামত', 'coaching-centre' ), __( 'মতামত', 'coaching-centre' ), $cap, 'edit.php?post_type=cc_testimonial' );
	add_submenu_page( 'cc-dashboard', __( 'প্রশ্নোত্তর', 'coaching-centre' ), __( 'প্রশ্নোত্তর', 'coaching-centre' ), $cap, 'edit.php?post_type=cc_faq' );

	if ( current_user_can( 'edit_theme_options' ) ) {
		add_submenu_page(
			'cc-dashboard',
			__( 'থিম সেটিংস', 'coaching-centre' ),
			__( 'থিম সেটিংস', 'coaching-centre' ),
			'edit_theme_options',
			'themes.php?autofocus%5Bsection%5D=cc_general'
		);
	}
}
add_action( 'admin_menu', 'cc_admin_menu' );

/**
 * Admin assets.
 *
 * @param string $hook Current admin page.
 */
function cc_admin_assets( $hook ) {
	$screen = get_current_screen();

	$is_ours = false;

	if ( in_array( $screen->post_type, array( 'cc_registration', 'cc_message', 'cc_course', 'cc_teacher', 'cc_testimonial', 'cc_faq' ), true ) ) {
		$is_ours = true;
	}

	if ( in_array( $hook, array( 'toplevel_page_cc-dashboard', 'cc-dashboard_page_cc-registrations', 'cc-dashboard_page_cc-messages' ), true ) ) {
		$is_ours = true;
	}

	if ( ! $is_ours ) {
		return;
	}

	wp_enqueue_style(
		'cc-admin',
		CC_URI . 'assets/css/admin.css',
		array(),
		CC_VERSION
	);

	wp_enqueue_script(
		'cc-admin',
		CC_URI . 'assets/js/admin.js',
		array( 'jquery' ),
		CC_VERSION,
		true
	);

	wp_localize_script(
		'cc-admin',
		'ccAdmin',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'cc_admin' ),
			'confirm' => __( 'সত্যিই মুছে ফেলবেন?', 'coaching-centre' ),
			'error'   => __( 'একটি সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'coaching-centre' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'cc_admin_assets' );

/**
 * Shared page header for the custom screens.
 *
 * @param string $title    Page title.
 * @param string $subtitle Supporting text.
 */
function cc_admin_header( $title, $subtitle = '' ) {
	?>
	<div class="wrap cc-admin-wrap">
		<h1 class="cc-admin-title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $subtitle ) : ?>
			<p class="cc-admin-sub"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	<?php
}

/**
 * Dashboard screen.
 */
function cc_render_dashboard() {
	$counts       = wp_count_posts( 'cc_registration' );
	$statuses     = cc_statuses();
	$total        = 0;

	foreach ( (array) $counts as $count ) {
		if ( is_numeric( $count ) ) {
			$total += (int) $count;
		}
	}

	$pending = isset( $counts->{'cc-pending'} ) ? (int) $counts->{'cc-pending'} : 0;
	$done    = ( isset( $counts->{'cc-confirmed'} ) ? (int) $counts->{'cc-confirmed'} : 0 ) + ( isset( $counts->{'cc-completed'} ) ? (int) $counts->{'cc-completed'} : 0 );

	$courses = wp_count_posts( 'cc_course' );
	$course_total = isset( $courses->publish ) ? (int) $courses->publish : 0;
	$unread       = cc_unread_count();

	cc_admin_header(
		__( 'কোচিং সেন্টার ড্যাশবোর্ড', 'coaching-centre' ),
		__( 'অনলাইন ভর্তি ও পরীক্ষার রেজিস্ট্রেশনের সারসংক্ষেপ।', 'coaching-centre' )
	);

	$notice = isset( $_GET['cc_notice'] ) ? sanitize_key( wp_unslash( $_GET['cc_notice'] ) ) : '';

	if ( 'seeded' === $notice ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'ডেমো কনটেন্ট যোগ করা হয়েছে।', 'coaching-centre' ) . '</p></div>';
	} elseif ( 'removed' === $notice ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'ডেমো কনটেন্ট মুছে ফেলা হয়েছে।', 'coaching-centre' ) . '</p></div>';
	}
	?>
	<div class="cc-stat-grid">
		<div class="cc-stat"><b><?php echo esc_html( number_format_i18n( $total ) ); ?></b><span><?php esc_html_e( 'মোট আবেদন', 'coaching-centre' ); ?></span></div>
		<div class="cc-stat"><b><?php echo esc_html( number_format_i18n( $pending ) ); ?></b><span><?php esc_html_e( 'অপেক্ষমাণ', 'coaching-centre' ); ?></span></div>
		<div class="cc-stat"><b><?php echo esc_html( number_format_i18n( $done ) ); ?></b><span><?php esc_html_e( 'নিশ্চিত / সম্পন্ন', 'coaching-centre' ); ?></span></div>
		<div class="cc-stat"><b><?php echo esc_html( cc_money( cc_income() ) ); ?></b><span><?php esc_html_e( 'সম্ভাব্য আয়', 'coaching-centre' ); ?></span></div>
		<div class="cc-stat"><b><?php echo esc_html( number_format_i18n( $course_total ) ); ?></b><span><?php esc_html_e( 'কোর্স', 'coaching-centre' ); ?></span></div>
		<div class="cc-stat"><b><?php echo esc_html( number_format_i18n( $unread ) ); ?></b><span><?php esc_html_e( 'নতুন বার্তা', 'coaching-centre' ); ?></span></div>
	</div>

	<div class="cc-quick-links">
		<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=cc-registrations' ) ); ?>"><?php esc_html_e( 'সব আবেদন দেখুন', 'coaching-centre' ); ?></a>
		<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cc_course' ) ); ?>"><?php esc_html_e( 'নতুন কোর্স যোগ করুন', 'coaching-centre' ); ?></a>
		<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cc_teacher' ) ); ?>"><?php esc_html_e( 'শিক্ষক যোগ করুন', 'coaching-centre' ); ?></a>
		<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cc_faq' ) ); ?>"><?php esc_html_e( 'প্রশ্নোত্তর যোগ করুন', 'coaching-centre' ); ?></a>
		<a class="button" href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=cc_general' ) ); ?>"><?php esc_html_e( 'থিম সেটিংস খুলুন', 'coaching-centre' ); ?></a>
	</div>

	<h2><?php esc_html_e( 'সাম্প্রতিক আবেদন', 'coaching-centre' ); ?></h2>
	<?php
	$recent = new WP_Query(
		array(
			'post_type'      => 'cc_registration',
			'posts_per_page' => 8,
			'post_status'    => array_keys( $statuses ),
			'no_found_rows'  => true,
		)
	);
	?>
	<table class="widefat striped cc-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'আইডি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'নাম', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'শ্রেণি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'ফি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'স্ট্যাটাস', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'তারিখ', 'coaching-centre' ); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( $recent->have_posts() ) : ?>
			<?php
			while ( $recent->have_posts() ) :
				$recent->the_post();
				$id = get_the_ID();
				?>
				<tr>
					<td><b><?php echo esc_html( cc_reg_field( $id, '_cc_code' ) ); ?></b></td>
					<td>
						<a href="<?php echo esc_url( get_edit_post_link( $id ) ); ?>"><?php echo esc_html( cc_reg_field( $id, '_cc_student_bn' ) ); ?></a>
					</td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_class' ) ); ?></td>
					<td><?php echo esc_html( cc_money( cc_reg_field( $id, '_cc_fee' ) ) ); ?></td>
					<td><span class="cc-pill cc-<?php echo esc_attr( sanitize_html_class( get_post_status( $id ) ) ); ?>"><?php echo esc_html( cc_status_label( get_post_status( $id ) ) ); ?></span></td>
					<td><?php echo esc_html( get_the_date( 'd/m/Y', $id ) ); ?></td>
				</tr>
			<?php endwhile; ?>
		<?php else : ?>
			<tr><td colspan="6"><?php esc_html_e( 'এখনো কোনো আবেদন আসেনি।', 'coaching-centre' ); ?></td></tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?php wp_reset_postdata(); ?>

	<hr>
	<h2><?php esc_html_e( 'ডেমো কনটেন্ট', 'coaching-centre' ); ?></h2>
	<p class="cc-admin-sub"><?php esc_html_e( 'থিমটি প্রথমবার চালু করার সময় পেজ, কোর্স, শিক্ষক, প্রশ্নোত্তর ও কিছু নমুনা আবেদন তৈরি করে দেয়। নিজের কনটেন্ট যোগ করার পরে নিচের বোতাম দিয়ে সেগুলো সরিয়ে ফেলতে পারেন।', 'coaching-centre' ); ?></p>
	<p class="cc-quick-links">
		<a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=cc_seed_demo' ), 'cc_seed_demo', 'cc_nonce' ) ); ?>"><?php esc_html_e( 'ডেমো কনটেন্ট আবার যোগ করুন', 'coaching-centre' ); ?></a>
		<a class="button button-link-delete" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=cc_remove_demo' ), 'cc_remove_demo', 'cc_nonce' ) ); ?>" onclick="return confirm('<?php echo esc_js( __( 'সব ডেমো কনটেন্ট মুছে ফেলবেন?', 'coaching-centre' ) ); ?>');"><?php esc_html_e( 'ডেমো কনটেন্ট মুছুন', 'coaching-centre' ); ?></a>
	</p>
	</div>
	<?php
}

/**
 * Total fee of every registration that is not cancelled.
 *
 * @return float
 */
function cc_income() {
	global $wpdb;

	$total = $wpdb->get_var(
		"SELECT SUM(CAST(meta_value AS DECIMAL(12,2)))
		 FROM {$wpdb->postmeta} m
		 INNER JOIN {$wpdb->posts} p ON p.ID = m.post_id
		 WHERE m.meta_key = '_cc_fee'
		   AND p.post_type = 'cc_registration'
		   AND p.post_status <> 'cc-cancelled'"
	);

	return (float) $total;
}

/**
 * Read the current registration filters from the request.
 *
 * @return array
 */
function cc_registration_filters() {
	return array(
		'q'    => isset( $_GET['cc_q'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_q'] ) ) : '',
		'cls'  => isset( $_GET['cc_cls'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_cls'] ) ) : '',
		'st'   => isset( $_GET['cc_st'] ) ? sanitize_key( wp_unslash( $_GET['cc_st'] ) ) : '',
		'kind' => isset( $_GET['cc_kind'] ) ? sanitize_key( wp_unslash( $_GET['cc_kind'] ) ) : '',
		'paged' => isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1,
	);
}

/**
 * Build the query arguments for a filtered registration list.
 *
 * @param array $filters Filters.
 * @return array
 */
function cc_registration_query_args( $filters ) {
	$statuses = array_keys( cc_statuses() );

	$args = array(
		'post_type'      => 'cc_registration',
		'post_status'    => array( 'cc-pending', 'cc-confirmed', 'cc-completed', 'cc-cancelled' ),
		'posts_per_page' => 25,
		'paged'          => $filters['paged'],
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $filters['st'] ) {
		$args['post_status'] = $filters['st'];
	} else {
		$args['post_status'] = $statuses;
	}

	$meta_query = array( 'relation' => 'AND' );

	if ( $filters['cls'] ) {
		$meta_query[] = array(
			'key'     => '_cc_class',
			'value'   => $filters['cls'],
			'compare' => '=',
		);
	}

	if ( $filters['kind'] ) {
		$meta_query[] = array(
			'key'     => '_cc_kind',
			'value'   => $filters['kind'],
			'compare' => '=',
		);
	}

	if ( $filters['q'] ) {
		$like        = '%' . $wpdb->esc_like( $filters['q'] ) . '%';
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => '_cc_student_bn',
				'value'   => $like,
				'compare' => 'LIKE',
			),
			array(
				'key'     => '_cc_student_en',
				'value'   => $like,
				'compare' => 'LIKE',
			),
			array(
				'key'     => '_cc_student_mobile',
				'value'   => $like,
				'compare' => 'LIKE',
			),
			array(
				'key'     => '_cc_guardian_mobile',
				'value'   => $like,
				'compare' => 'LIKE',
			),
			array(
				'key'     => '_cc_code',
				'value'   => $like,
				'compare' => 'LIKE',
			),
		);
	}

	if ( count( $meta_query ) > 1 ) {
		$args['meta_query'] = $meta_query;
	}

	return $args;
}

/**
 * Distinct class values present in the registrations.
 *
 * @return array
 */
function cc_registered_classes() {
	global $wpdb;

	$rows = $wpdb->get_col(
		"SELECT DISTINCT m.meta_value
		 FROM {$wpdb->postmeta} m
		 INNER JOIN {$wpdb->posts} p ON p.ID = m.post_id
		 WHERE m.meta_key = '_cc_class'
		   AND m.meta_value <> ''
		   AND p.post_type = 'cc_registration'
		 ORDER BY m.meta_value ASC"
	);

	return $rows ? $rows : array();
}

/**
 * Registration list screen.
 */
function cc_render_registrations() {
	$filters = cc_registration_filters();
	$query   = new WP_Query( cc_registration_query_args( $filters ) );
	$statuses = cc_statuses();
	$kinds   = cc_kinds();

	cc_admin_header(
		__( 'আবেদনসমূহ', 'coaching-centre' ),
		__( 'ওয়েবসাইটের ভর্তি ও মডেল পরীক্ষার ফর্ম থেকে আসা সব আবেদন।', 'coaching-centre' )
	);

	$export_url = wp_nonce_url(
		add_query_arg(
			array(
				'action'  => 'cc_reg_csv',
				'cc_q'    => $filters['q'],
				'cc_cls'  => $filters['cls'],
				'cc_st'   => $filters['st'],
				'cc_kind' => $filters['kind'],
			),
			admin_url( 'admin-post.php' )
		),
		'cc_reg_csv',
		'cc_nonce'
	);
	?>
	<form method="get" class="cc-filters">
		<input type="hidden" name="page" value="cc-registrations">
		<input type="search" name="cc_q" value="<?php echo esc_attr( $filters['q'] ); ?>" placeholder="<?php esc_attr_e( 'নাম, আইডি বা মোবাইল খুঁজুন…', 'coaching-centre' ); ?>">
		<select name="cc_cls">
			<option value=""><?php esc_html_e( 'সব শ্রেণি', 'coaching-centre' ); ?></option>
			<?php foreach ( cc_registered_classes() as $class ) : ?>
				<option value="<?php echo esc_attr( $class ); ?>" <?php selected( $filters['cls'], $class ); ?>><?php echo esc_html( $class ); ?></option>
			<?php endforeach; ?>
		</select>
		<select name="cc_st">
			<option value=""><?php esc_html_e( 'সব স্ট্যাটাস', 'coaching-centre' ); ?></option>
			<?php foreach ( $statuses as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $filters['st'], $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
		<select name="cc_kind">
			<option value=""><?php esc_html_e( 'সব ধরন', 'coaching-centre' ); ?></option>
			<?php foreach ( $kinds as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $filters['kind'], $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
		<button type="submit" class="button"><?php esc_html_e( 'ফিল্টার', 'coaching-centre' ); ?></button>
		<a class="button" href="<?php echo esc_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>"><?php esc_html_e( 'রিসেট', 'coaching-centre' ); ?></a>
		<a class="button button-primary cc-export" href="<?php echo esc_url( $export_url ); ?>"><?php esc_html_e( 'CSV ডাউনলোড', 'coaching-centre' ); ?></a>
	</form>

	<table class="widefat striped cc-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'আইডি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'নাম', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'শ্রেণি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'প্রোগ্রাম', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'মোবাইল', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'ফি', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'পেমেন্ট', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'স্ট্যাটাস', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'তারিখ', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'অ্যাকশন', 'coaching-centre' ); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( $query->have_posts() ) : ?>
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$id = get_the_ID();
				?>
				<tr>
					<td><b><?php echo esc_html( cc_reg_field( $id, '_cc_code' ) ); ?></b></td>
					<td>
						<a href="<?php echo esc_url( get_edit_post_link( $id ) ); ?>"><?php echo esc_html( cc_reg_field( $id, '_cc_student_bn' ) ); ?></a>
						<?php $kind = cc_reg_field( $id, '_cc_kind' ); ?>
						<?php if ( isset( $kinds[ $kind ] ) ) : ?>
							<br><small><?php echo esc_html( $kinds[ $kind ] ); ?></small>
						<?php endif; ?>
					</td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_class' ) ); ?></td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_program' ) ); ?></td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_student_mobile' ) ); ?></td>
					<td><?php echo esc_html( cc_money( cc_reg_field( $id, '_cc_fee' ) ) ); ?></td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_payment' ) ); ?></td>
					<td>
						<select class="cc-status-select" data-id="<?php echo esc_attr( $id ); ?>">
							<?php foreach ( $statuses as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( get_post_status( $id ), $key ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td><?php echo esc_html( get_the_date( 'd/m/Y', $id ) ); ?></td>
					<td>
						<a href="<?php echo esc_url( cc_receipt_url( $id ) ); ?>" target="_blank" rel="noopener" class="button button-small"><?php esc_html_e( 'রসিদ', 'coaching-centre' ); ?></a>
						<button type="button" class="button button-small cc-delete" data-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'মুছুন', 'coaching-centre' ); ?></button>
					</td>
				</tr>
			<?php endwhile; ?>
		<?php else : ?>
			<tr><td colspan="10"><?php esc_html_e( 'কোনো আবেদন পাওয়া যায়নি।', 'coaching-centre' ); ?></td></tr>
		<?php endif; ?>
		</tbody>
	</table>

	<?php
	$pagination = paginate_links(
		array(
			'base'      => add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'total'     => $query->max_num_pages,
			'current'   => $filters['paged'],
			'type'      => 'plain',
		)
	);

	if ( $pagination ) {
		echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post( $pagination ) . '</div></div>';
	}

	printf(
		'<p class="cc-count">%s</p>',
		esc_html(
			sprintf(
				/* translators: 1: shown rows, 2: total rows */
				__( 'মোট %1$s টি আবেদন দেখানো হচ্ছে (সর্বমোট %2$s)।', 'coaching-centre' ),
				number_format_i18n( $query->found_posts ),
				number_format_i18n( cc_registration_total() )
			)
		)
	);

	wp_reset_postdata();
	echo '</div>';
}

/**
 * Every registration, ignoring filters.
 *
 * @return int
 */
function cc_registration_total() {
	$counts = wp_count_posts( 'cc_registration' );
	$total  = 0;

	foreach ( (array) $counts as $count ) {
		if ( is_numeric( $count ) ) {
			$total += (int) $count;
		}
	}

	return $total;
}

/**
 * Message list screen.
 */
function cc_render_messages() {
	$q     = isset( $_GET['cc_q'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_q'] ) ) : '';
	$paged = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1;

	$args = array(
		'post_type'      => 'cc_message',
		'post_status'    => 'any',
		'posts_per_page' => 25,
		'paged'          => $paged,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $q ) {
		$args['s'] = $q;
	}

	$query = new WP_Query( $args );

	cc_admin_header(
		__( 'বার্তাসমূহ', 'coaching-centre' ),
		__( 'যোগাযোগ ফর্ম থেকে আসা সব বার্তা।', 'coaching-centre' )
	);
	?>
	<form method="get" class="cc-filters">
		<input type="hidden" name="page" value="cc-messages">
		<input type="search" name="cc_q" value="<?php echo esc_attr( $q ); ?>" placeholder="<?php esc_attr_e( 'নাম বা মোবাইল খুঁজুন…', 'coaching-centre' ); ?>">
		<button type="submit" class="button"><?php esc_html_e( 'খুঁজুন', 'coaching-centre' ); ?></button>
		<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=cc-messages' ) ); ?>"><?php esc_html_e( 'রিসেট', 'coaching-centre' ); ?></a>
	</form>

	<table class="widefat striped cc-table">
		<thead>
			<tr>
				<th><?php esc_html_e( 'নাম', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'মোবাইল', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'বিষয়', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'বার্তা', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'সময়', 'coaching-centre' ); ?></th>
				<th><?php esc_html_e( 'অ্যাকশন', 'coaching-centre' ); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( $query->have_posts() ) : ?>
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$id   = get_the_ID();
				$read = (int) get_post_meta( $id, '_cc_msg_read', true );
				?>
				<tr class="<?php echo $read ? '' : 'cc-unread-row'; ?>">
					<td><a href="<?php echo esc_url( get_edit_post_link( $id ) ); ?>"><?php echo esc_html( cc_reg_field( $id, '_cc_msg_name' ) ); ?></a></td>
					<td>
						<a href="tel:<?php echo esc_attr( cc_reg_field( $id, '_cc_msg_mobile' ) ); ?>"><?php echo esc_html( cc_reg_field( $id, '_cc_msg_mobile' ) ); ?></a>
					</td>
					<td><?php echo esc_html( cc_reg_field( $id, '_cc_msg_topic' ) ); ?></td>
					<td><?php echo esc_html( wp_trim_words( cc_reg_field( $id, '_cc_msg_body' ), 14, '…' ) ); ?></td>
					<td><?php echo esc_html( get_the_date( 'd/m/Y H:i', $id ) ); ?></td>
					<td>
						<button type="button" class="button button-small cc-read-toggle" data-id="<?php echo esc_attr( $id ); ?>" data-read="<?php echo $read ? '1' : '0'; ?>">
							<?php echo $read ? esc_html__( 'অপঠিত করুন', 'coaching-centre' ) : esc_html__( 'পঠিত করুন', 'coaching-centre' ); ?>
						</button>
						<button type="button" class="button button-small cc-delete" data-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'মুছুন', 'coaching-centre' ); ?></button>
					</td>
				</tr>
			<?php endwhile; ?>
		<?php else : ?>
			<tr><td colspan="6"><?php esc_html_e( 'কোনো বার্তা পাওয়া যায়নি।', 'coaching-centre' ); ?></td></tr>
		<?php endif; ?>
		</tbody>
	</table>

	<?php
	$pagination = paginate_links(
		array(
			'base'      => add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'total'     => $query->max_num_pages,
			'current'   => $paged,
			'type'      => 'plain',
		)
	);

	if ( $pagination ) {
		echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post( $pagination ) . '</div></div>';
	}

	wp_reset_postdata();
	echo '</div>';
}

/**
 * CSV export of the filtered registration list.
 */
function cc_admin_csv() {
	if ( ! current_user_can( cc_admin_cap() ) ) {
		wp_die( esc_html__( 'আপনার এই কাজটি করার অনুমতি নেই।', 'coaching-centre' ) );
	}

	check_admin_referer( 'cc_reg_csv', 'cc_nonce' );

	$filters = cc_registration_filters();
	$args    = cc_registration_query_args( $filters );

	$args['posts_per_page'] = -1;
	$args['fields']         = 'ids';
	unset( $args['paged'] );

	$query = new WP_Query( $args );

	$headers = array( __( 'আইডি', 'coaching-centre' ) );
	foreach ( cc_registration_fields() as $key => $field ) {
		if ( '_cc_photo_id' === $key ) {
			continue;
		}

		$headers[] = $field['label'];
	}
	$headers[] = __( 'স্ট্যাটাস', 'coaching-centre' );
	$headers[] = __( 'তারিখ', 'coaching-centre' );

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=registrations-' . wp_date( 'Y-m-d' ) . '.csv' );

	$output = fopen( 'php://output', 'w' );

	fwrite( $output, "\xEF\xBB\xBF" );
	fputcsv( $output, $headers );

	foreach ( $query->posts as $id ) {
		$row = array( cc_reg_field( $id, '_cc_code' ) );

		foreach ( array_keys( cc_registration_fields() ) as $key ) {
			if ( '_cc_photo_id' === $key ) {
				continue;
			}

			$value = cc_reg_field( $id, $key );

			if ( '_cc_kind' === $key ) {
				$kinds = cc_kinds();
				$value = isset( $kinds[ $value ] ) ? $kinds[ $value ] : $value;
			}

			if ( '_cc_fee' === $key ) {
				$value = cc_latin( $value );
			}

			$row[] = $value;
		}

		$row[] = cc_status_label( get_post_status( $id ) );
		$row[] = get_the_date( 'd/m/Y H:i', $id );

		fputcsv( $output, $row );
	}

	fclose( $output );
	exit;
}
add_action( 'admin_post_cc_reg_csv', 'cc_admin_csv' );

/**
 * AJAX: change a registration status.
 */
function cc_ajax_status() {
	check_ajax_referer( 'cc_admin', 'nonce' );

	if ( ! current_user_can( cc_admin_cap() ) ) {
		wp_send_json_error( array( 'message' => __( 'অনুমতি নেই।', 'coaching-centre' ) ), 403 );
	}

	$id     = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
	$status = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';

	if ( ! $id || ! array_key_exists( $status, cc_statuses() ) || ! current_user_can( 'edit_post', $id ) ) {
		wp_send_json_error( array( 'message' => __( 'অনুমতি নেই।', 'coaching-centre' ) ), 400 );
	}

	wp_update_post(
		array(
			'ID'          => $id,
			'post_status' => $status,
		)
	);

	wp_send_json_success(
		array(
			'status'  => $status,
			'label'   => cc_status_label( $status ),
			'message' => __( 'স্ট্যাটাস আপডেট হয়েছে।', 'coaching-centre' ),
		)
	);
}
add_action( 'wp_ajax_cc_status', 'cc_ajax_status' );

/**
 * AJAX: permanently delete a registration or message.
 */
function cc_ajax_delete() {
	check_ajax_referer( 'cc_admin', 'nonce' );

	$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

	if ( ! $id || ! current_user_can( 'delete_post', $id ) ) {
		wp_send_json_error( array( 'message' => __( 'অনুমতি নেই।', 'coaching-centre' ) ), 400 );
	}

	$post = get_post( $id );

	if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array( 'cc_registration', 'cc_message' ), true ) ) {
		wp_send_json_error( array( 'message' => __( 'অনুমতি নেই।', 'coaching-centre' ) ), 400 );
	}

	wp_delete_post( $id, true );

	wp_send_json_success( array( 'message' => __( 'মুছে ফেলা হয়েছে।', 'coaching-centre' ) ) );
}
add_action( 'wp_ajax_cc_delete', 'cc_ajax_delete' );

/**
 * AJAX: toggle the read flag of a message.
 */
function cc_ajax_toggle_read() {
	check_ajax_referer( 'cc_admin', 'nonce' );

	$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;

	if ( ! $id || ! current_user_can( 'edit_post', $id ) ) {
		wp_send_json_error( array( 'message' => __( 'অনুমতি নেই।', 'coaching-centre' ) ), 400 );
	}

	$read = (int) get_post_meta( $id, '_cc_msg_read', true );
	$new  = $read ? 0 : 1;

	update_post_meta( $id, '_cc_msg_read', $new );

	wp_send_json_success(
		array(
			'read'    => $new,
			'message' => __( 'আপডেট হয়েছে।', 'coaching-centre' ),
		)
	);
}
add_action( 'wp_ajax_cc_toggle_read', 'cc_ajax_toggle_read' );

/**
 * Highlight the admin menu when there is something waiting.
 *
 * @param array $menu Menu classes.
 * @return array
 */
function cc_menu_bubble( $menu ) {
	return $menu;
}
add_filter( 'add_menu_classes', 'cc_menu_bubble' );