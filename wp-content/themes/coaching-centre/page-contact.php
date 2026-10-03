<?php
/**
 * Template Name: Contact — যোগাযোগ
 *
 * Replaces the static contact.html prototype.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

get_header();

/* phpcs:disable WordPress.Security.NonceVerification.Recommended -- reading our own redirect state. */
$cc_token = isset( $_GET['cc_contact_token'] ) ? sanitize_text_field( wp_unslash( $_GET['cc_contact_token'] ) ) : '';
$cc_state = $cc_token ? cc_take_state( 'contact', $cc_token ) : array();
$cc_sent  = isset( $_GET['cc_sent'] );
/* phpcs:enable */

$cc_errors   = isset( $cc_state['errors'] ) ? (array) $cc_state['errors'] : array();
$cc_values   = isset( $cc_state['values'] ) ? (array) $cc_state['values'] : array();
$cc_contact_id = get_queried_object_id();
$cc_topics     = cc_lines( cc_page_meta( '_contact_topics', 'cc_contact_topics', '', $cc_contact_id ) );
$cc_hours      = cc_lines( cc_opt( 'cc_open_hours' ) );
$mb_branches   = cc_page_meta( '_contact_branches', '', array(), $cc_contact_id );
$cc_branches   = ( $mb_branches && is_array( $mb_branches ) ) ? $mb_branches : cc_branches();
$cc_social     = cc_social_links();
$cc_map        = cc_page_meta( '_contact_map_embed', 'cc_map_embed', '', $cc_contact_id );
$cc_return     = remove_query_arg( array( 'cc_contact_token', 'cc_sent' ), cc_current_url() );
?>

<div class="top">
	<div class="wrap">
		<h1><?php echo esc_html( cc_page_meta( '_contact_heading', 'cc_contact_heading', '', $cc_contact_id ) ); ?></h1>
		<p><?php echo esc_html( cc_page_meta( '_contact_intro', 'cc_contact_intro', '', $cc_contact_id ) ); ?></p>
	</div>
</div>


<div class="wrap">
	<div class="cards">
		<div class="card ci">
			<div class="ico">📞</div>
			<h3><?php esc_html_e( 'হেল্পলাইন', 'coaching-centre' ); ?></h3>
			<a href="<?php echo esc_url( cc_tel_href() ); ?>"><?php echo esc_html( cc_opt( 'cc_phone' ) ); ?></a><br>
			<small class="mute"><?php esc_html_e( 'সকাল ৯টা – রাত ৯টা', 'coaching-centre' ); ?></small>
		</div>

		<div class="card ci">
			<div class="ico">✉️</div>
			<h3><?php esc_html_e( 'ইমেইল', 'coaching-centre' ); ?></h3>
			<a href="mailto:<?php echo esc_attr( cc_opt( 'cc_email' ) ); ?>"><?php echo esc_html( cc_opt( 'cc_email' ) ); ?></a><br>
			<small class="mute"><?php esc_html_e( '২৪ ঘণ্টার মধ্যে উত্তর', 'coaching-centre' ); ?></small>
		</div>

		<div class="card ci">
			<div class="ico">💬</div>
			<h3><?php esc_html_e( 'হোয়াটসঅ্যাপ', 'coaching-centre' ); ?></h3>
			<a href="<?php echo esc_url( cc_whatsapp_href() ); ?>"><?php esc_html_e( 'মেসেজ করুন', 'coaching-centre' ); ?></a><br>
			<small class="mute"><?php esc_html_e( 'দ্রুত সাড়া', 'coaching-centre' ); ?></small>
		</div>

		<div class="card ci">
			<div class="ico">📍</div>
			<h3><?php esc_html_e( 'প্রধান কার্যালয়', 'coaching-centre' ); ?></h3>
			<span><?php echo esc_html( cc_opt( 'cc_address' ) ); ?></span>
		</div>
	</div>

	<div class="cmain">
		<div class="card">
			<h2><?php esc_html_e( 'বার্তা পাঠান', 'coaching-centre' ); ?></h2>

			<?php if ( $cc_sent ) : ?>
				<div class="notice ok" role="status">
					<?php
					printf(
						/* translators: %s: sender name */
						esc_html__( 'ধন্যবাদ %s! আপনার বার্তা পেয়েছি, শীঘ্রই যোগাযোগ করা হবে।', 'coaching-centre' ),
						'<b>' . esc_html( cc_opt( 'cc_phone' ) ) . '</b>'
					);
					?>
				</div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="cc_contact">
				<input type="hidden" name="cc_return" value="<?php echo esc_url( $cc_return ); ?>">
				<?php wp_nonce_field( 'cc_contact', 'cc_contact_nonce' ); ?>
				<?php cc_honeypot(); ?>

				<div class="f mb<?php echo isset( $cc_errors['contact_name'] ) ? ' has-error' : ''; ?>">
					<label for="cc-c-name"><?php esc_html_e( 'আপনার নাম', 'coaching-centre' ); ?> <i>*</i></label>
					<input id="cc-c-name" name="contact_name" required value="<?php echo esc_attr( isset( $cc_values['_cc_msg_name'] ) ? $cc_values['_cc_msg_name'] : '' ); ?>">
					<?php if ( isset( $cc_errors['contact_name'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['contact_name'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="f mb<?php echo isset( $cc_errors['contact_mobile'] ) ? ' has-error' : ''; ?>">
					<label for="cc-c-mobile"><?php esc_html_e( 'মোবাইল নম্বর', 'coaching-centre' ); ?> <i>*</i></label>
					<input id="cc-c-mobile" name="contact_mobile" inputmode="numeric" pattern="01[3-9][0-9]{8}" placeholder="01XXXXXXXXX" required value="<?php echo esc_attr( isset( $cc_values['_cc_msg_mobile'] ) ? cc_bn( $cc_values['_cc_msg_mobile'] ) : '' ); ?>">
					<?php if ( isset( $cc_errors['contact_mobile'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['contact_mobile'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="f mb<?php echo isset( $cc_errors['contact_topic'] ) ? ' has-error' : ''; ?>">
					<label for="cc-c-topic"><?php esc_html_e( 'বিষয়', 'coaching-centre' ); ?> <i>*</i></label>
					<select id="cc-c-topic" name="contact_topic" required>
						<option value=""><?php esc_html_e( '-- বিষয় বেছে নিন --', 'coaching-centre' ); ?></option>
						<?php foreach ( $cc_topics as $cc_topic ) : ?>
							<option value="<?php echo esc_attr( $cc_topic ); ?>" <?php selected( isset( $cc_values['_cc_msg_topic'] ) ? $cc_values['_cc_msg_topic'] : '', $cc_topic ); ?>>
								<?php echo esc_html( $cc_topic ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $cc_errors['contact_topic'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['contact_topic'] ); ?></span>
					<?php endif; ?>
				</div>

				<div class="f mb<?php echo isset( $cc_errors['contact_message'] ) ? ' has-error' : ''; ?>">
					<label for="cc-c-message"><?php esc_html_e( 'আপনার বার্তা', 'coaching-centre' ); ?> <i>*</i></label>
					<textarea id="cc-c-message" name="contact_message" rows="4" required><?php echo esc_textarea( isset( $cc_values['_cc_msg_body'] ) ? $cc_values['_cc_msg_body'] : '' ); ?></textarea>
					<?php if ( isset( $cc_errors['contact_message'] ) ) : ?>
						<span class="err" style="display:block"><?php echo esc_html( $cc_errors['contact_message'] ); ?></span>
					<?php endif; ?>
				</div>

				<button class="btn" type="submit"><?php esc_html_e( 'বার্তা পাঠান', 'coaching-centre' ); ?></button>

				<?php if ( isset( $cc_errors['_cc_form'] ) ) : ?>
					<div class="notice bad" role="alert"><?php echo esc_html( $cc_errors['_cc_form'] ); ?></div>
				<?php endif; ?>
			</form>
		</div>

		<div>
			<div class="card mb16">
				<h2><?php esc_html_e( 'অফিস সময়', 'coaching-centre' ); ?></h2>
				<div class="hrs">
					<?php cc_open_hours(); ?>
					<div>
						<span><?php esc_html_e( 'ক্লাসরুমে Q&A সাপোর্ট', 'coaching-centre' ); ?></span>
						<span class="badge"><?php esc_html_e( 'প্রতিদিন', 'coaching-centre' ); ?></span>
					</div>
				</div>
			</div>

			<?php if ( $cc_social ) : ?>
				<div class="card">
					<h2><?php esc_html_e( 'সোশ্যাল মিডিয়া', 'coaching-centre' ); ?></h2>
					<div class="soc">
						<?php foreach ( $cc_social as $cc_link ) : ?>
							<a href="<?php echo esc_url( $cc_link['url'] ); ?>" target="_blank" rel="noopener">
								<?php echo esc_html( $cc_link['icon'] . ' ' . $cc_link['label'] ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $cc_branches ) : ?>
		<h2><?php echo esc_html( cc_opt( 'cc_branch_label' ) ); ?></h2>

		<div class="br">
			<?php foreach ( $cc_branches as $cc_branch ) : ?>
				<div class="card cc-branch">
					<?php if ( $cc_branch['map'] ) : ?>
						<a class="map map-sm framed" href="<?php echo esc_url( $cc_branch['map'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $cc_branch['name'] ); ?>">
							<span><?php esc_html_e( 'ম্যাপে দেখুন', 'coaching-centre' ); ?></span>
						</a>
					<?php else : ?>
						<div class="map map-sm"><?php esc_html_e( 'ম্যাপ', 'coaching-centre' ); ?></div>
					<?php endif; ?>

					<h4><?php echo esc_html( $cc_branch['name'] ); ?></h4>
					<?php if ( $cc_branch['address'] ) : ?>
						<p>📍 <?php echo esc_html( $cc_branch['address'] ); ?></p>
					<?php endif; ?>
					<?php if ( $cc_branch['phone'] ) : ?>
						<p>📞 <a href="<?php echo esc_url( cc_tel_href( $cc_branch['phone'] ) ); ?>"><?php echo esc_html( $cc_branch['phone'] ); ?></a></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $cc_map ) : ?>
		<div class="card mb26">
			<h2><?php echo esc_html( cc_opt( 'cc_map_title' ) ); ?></h2>
			<div class="map map-lg framed">
				<?php
				/* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- iframe built with escaped parts. */
				echo cc_embed_map_html( $cc_map );
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="cta">
		<h2><?php esc_html_e( 'সরাসরি ভর্তি হতে চান?', 'coaching-centre' ); ?></h2>
		<p class="op9 mt0"><?php esc_html_e( 'শাখায় এসে সরাসরি আজই আসন নিশ্চিত করুন।', 'coaching-centre' ); ?></p>
		<a class="btn acc" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'ভর্তি ফর্মে যান', 'coaching-centre' ); ?></a>
		<a class="btn o ml8" href="<?php echo esc_url( cc_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'আমাদের সম্পর্কে', 'coaching-centre' ); ?></a>
	</div>
</div>

<?php
get_footer();