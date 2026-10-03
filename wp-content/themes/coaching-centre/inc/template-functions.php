<?php
/**
 * Template helpers shared by the front-end templates.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

/**
 * Nonce that authorises a receipt link.
 *
 * @param int $post_id Registration ID.
 * @return string
 */
function cc_receipt_token( $post_id ) {
	return wp_create_nonce( 'cc-receipt-' . (int) $post_id );
}

/**
 * Shareable receipt URL.
 *
 * @param int $post_id Registration ID.
 * @return string
 */
function cc_receipt_url( $post_id ) {
	return add_query_arg(
		'cc_receipt',
		(int) $post_id . '.' . cc_receipt_token( $post_id ),
		cc_registration_url()
	);
}

/**
 * Resolve `cc_receipt=ID.token` into a registration post.
 *
 * @param string $param Raw query value.
 * @return WP_Post|null
 */
function cc_resolve_receipt( $param ) {
	$parts = explode( '.', (string) $param );

	if ( 2 !== count( $parts ) ) {
		return null;
	}

	$post_id = absint( $parts[0] );
	$token   = sanitize_text_field( $parts[1] );

	if ( ! $post_id || ! wp_verify_nonce( $token, 'cc-receipt-' . $post_id ) ) {
		return null;
	}

	$post = get_post( $post_id );

	if ( ! $post instanceof WP_Post || 'cc_registration' !== $post->post_type ) {
		return null;
	}

	return $post;
}

/**
 * Group the published courses by class, ready for the registration form.
 *
 * @return array
 */
function cc_program_map() {
	$map = array();

	foreach ( cc_get_courses() as $course ) {
		$class = cc_course_field( $course->ID, '_cc_class' );

		if ( '' === $class ) {
			continue;
		}

		if ( ! isset( $map[ $class ] ) ) {
			$map[ $class ] = array();
		}

		$map[ $class ][] = array(
			'id'    => $course->ID,
			'label' => get_the_title( $course ),
			'fee'   => cc_course_fee( $course->ID ),
			'modes' => cc_course_modes( $course->ID ),
			'group' => cc_course_field( $course->ID, '_cc_group' ),
		);
	}

	return $map;
}

/**
 * JSON payload consumed by the registration form script.
 *
 * @return array
 */
function cc_program_json() {
	$map = cc_program_map();
	$out = array();

	foreach ( $map as $class => $programs ) {
		$items = array();

		foreach ( $programs as $program ) {
			$items[] = array(
				'label' => $program['label'],
				'fee'   => $program['fee'],
				'modes' => $program['modes'],
			);
		}

		$out[ $class ] = $items;
	}

	return $out;
}

/**
 * Course tabs for the home page, always starting with "সব কোর্স".
 *
 * @return WP_Term[]
 */
function cc_course_tabs() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'cc_course_cat',
			'hide_empty' => true,
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Human label of a post status.
 *
 * @param string $status Status slug.
 * @return string
 */
function cc_status_label( $status ) {
	$statuses = cc_statuses();

	return isset( $statuses[ $status ] ) ? $statuses[ $status ] : $status;
}

/**
 * Print a `✓` checklist.
 *
 * @param array|string $points Items.
 * @param string       $class  Wrapper class.
 */
function cc_checklist( $points, $class = 'chk' ) {
	$points = cc_lines( $points );

	if ( ! $points ) {
		return;
	}

	printf( '<ul class="%s">', esc_attr( $class ) );

	foreach ( $points as $point ) {
		printf( '<li>%s</li>', esc_html( $point ) );
	}

	echo '</ul>';
}

/**
 * Print a `•` bullet list.
 *
 * @param array|string $points Items.
 * @param string       $class  Wrapper class.
 */
function cc_bullets( $points, $class = '' ) {
	$points = cc_lines( $points );

	if ( ! $points ) {
		return;
	}

	printf( '<ul%s>', $class ? ' class="' . esc_attr( $class ) . '"' : '' );

	foreach ( $points as $point ) {
		printf( '<li>%s</li>', esc_html( $point ) );
	}

	echo '</ul>';
}

/**
 * Print the site title, using the custom logo when one is set.
 */
function cc_site_branding() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<a class="logo" data-cc="logo_text" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<?php echo esc_html( cc_opt( 'cc_logo_text' ) ); ?>
	</a>
	<?php
}

/**
 * Render the copyright line.
 */
function cc_copyright() {
	$text = cc_opt( 'cc_copyright' );

	printf(
		/* translators: 1: current year, 2: copyright text */
		esc_html__( '© %1$s %2$s', 'coaching-centre' ),
		esc_html( cc_bn( wp_date( 'Y' ) ) ),
		esc_html( $text )
	);
}

/**
 * Render the opening hours table rows.
 */
function cc_open_hours() {
	foreach ( cc_lines( cc_opt( 'cc_open_hours' ) ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );

		printf(
			'<div><span>%s</span><b>%s</b></div>',
			esc_html( $parts[0] ),
			esc_html( isset( $parts[1] ) ? $parts[1] : '' )
		);
	}
}

/**
 * Turn a Google Maps share link into an embeddable iframe URL.
 *
 * Accepts anything from a plain `maps/embed` URL to a normal share link with
 * the place in the query string or the path.
 *
 * @param string $url Map URL from the Customizer.
 * @return string Embeddable URL, or an empty string when it cannot be parsed.
 */
function cc_embed_map( $url ) {
	$url = trim( (string) $url );

	if ( '' === $url ) {
		return '';
	}

	/* Already an embed URL — use it as-is. */
	if ( false !== strpos( $url, '/maps/embed' ) ) {
		return $url;
	}

	$parts = wp_parse_url( $url );
	$place = '';

	if ( ! empty( $parts['query'] ) ) {
		parse_str( $parts['query'], $args );

		foreach ( array( 'q', 'query', 'destination', 'address' ) as $key ) {
			if ( ! empty( $args[ $key ] ) ) {
				$place = $args[ $key ];
				break;
			}
		}
	}

	if ( '' === $place && ! empty( $parts['path'] ) ) {
		$path = rawurldecode( $parts['path'] );
		$path = preg_replace( '#^/maps/(place/)?#', '', $path );
		$path = preg_replace( '#/data=.*$#', '', $path );
		$place = trim( $path, '/' );
	}

	if ( '' === $place ) {
		return '';
	}

	return add_query_arg(
		array(
			'q'      => $place,
			'output' => 'embed',
		),
		'https://maps.google.com/maps'
	);
}

/**
 * Allowed HTML for the map iframe.
 *
 * @return array
 */
function cc_allowed_iframe_html() {
	return array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'title'           => true,
			'loading'         => true,
			'allowfullscreen' => true,
			'referrerpolicy'  => true,
			'aria-hidden'     => true,
		),
	);
}

/**
 * Wrap an embeddable map URL in an iframe.
 *
 * @param string $url Map URL from the Customizer.
 * @return string
 */
function cc_embed_map_html( $url ) {
	$embed = cc_embed_map( $url );

	if ( ! $embed ) {
		return '';
	}

	return sprintf(
		'<iframe src="%s" title="%s" width="100%%" height="100%%" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>',
		esc_url( $embed ),
		esc_attr__( 'গুগল ম্যাপ', 'coaching-centre' )
	);
}

/**
 * The URL of the page currently being viewed, safe to hand to a form.
 *
 * @return string
 */
function cc_current_url() {
	// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitised below.
	$host = isset( $_SERVER['HTTP_HOST'] ) ? wp_unslash( $_SERVER['HTTP_HOST'] ) : '';
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	// phpcs:enable

	$host = preg_replace( '/[^A-Za-z0-9\.\-:\[\]]/', '', (string) $host );
	$uri  = preg_replace( '/[^\x20-\x7E]/', '', (string) $uri );

	if ( ! $uri ) {
		return home_url( '/' );
	}

	return $uri ? esc_url_raw( $host ? '//' . $host . $uri : home_url( $uri ) ) : home_url( '/' );
}

/**
 * Output the `admin-post.php` action URL for a theme form.
 *
 * @param string $action Action name.
 * @return string
 */
function cc_form_action( $action ) {
	return esc_url( admin_url( 'admin-post.php' ) ) . '#';
}

/**
 * A hidden honeypot field that real people never see.
 */
function cc_honeypot() {
	printf(
		'<div class="cc-hp" aria-hidden="true"><label>%s<input type="text" name="cc_hp" tabindex="-1" autocomplete="off"></label></div>',
		esc_html__( 'এই ঘরটি খালি রাখুন', 'coaching-centre' )
	);
}

/**
 * Number of registrations waiting for confirmation.
 *
 * @return int
 */
function cc_pending_count() {
	$counts = wp_count_posts( 'cc_registration' );

	return isset( $counts->{'cc-pending'} ) ? (int) $counts->{'cc-pending'} : 0;
}


/**
 * Number of unread messages.
 *
 * @return int
 */
function cc_unread_count() {
	global $wpdb;

	return (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '_cc_msg_read' AND meta_value = '0'"
		)
	);
}

/**
 * Trim an excerpt to a readable length for the card layouts.
 *
 * @param int $length Word count.
 * @return string
 */
function cc_short_excerpt( $length = 22 ) {
	$text = get_the_excerpt();
	$text = wp_strip_all_tags( $text );

	if ( ! $text ) {
		return '';
	}

	return wp_trim_words( $text, $length, '…' );
}