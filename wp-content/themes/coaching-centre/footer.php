<?php
/**
 * Site footer.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;

$cc_branches = cc_branches();
$cc_social   = cc_social_links();
?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="wrap">
			<div class="grid g3 cc-footer-grid">

				<div>
					<h4><?php echo esc_html( cc_opt( 'cc_logo_text' ) ); ?></h4>
					<p data-cc="footer_about"><?php echo esc_html( cc_opt( 'cc_footer_about' ) ); ?></p>
					<?php if ( $cc_social ) : ?>
						<div class="soc cc-footer-social">
							<?php foreach ( $cc_social as $cc_link ) : ?>
								<a href="<?php echo esc_url( $cc_link['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $cc_link['icon'] . ' ' . $cc_link['label'] ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<div>
					<h4><?php esc_html_e( 'যোগাযোগ', 'coaching-centre' ); ?></h4>
					<p>
						<?php esc_html_e( 'ঠিকানা', 'coaching-centre' ); ?>: <span data-cc="address"><?php echo esc_html( cc_opt( 'cc_address' ) ); ?></span><br>
						<?php esc_html_e( 'ফোন', 'coaching-centre' ); ?>: <a data-cc="phone" href="<?php echo esc_url( cc_tel_href() ); ?>"><?php echo esc_html( cc_opt( 'cc_phone' ) ); ?></a><br>
						<?php esc_html_e( 'ইমেইল', 'coaching-centre' ); ?>: <a data-cc="email" href="<?php echo esc_url( 'mailto:' . cc_opt( 'cc_email' ) ); ?>"><?php echo esc_html( cc_opt( 'cc_email' ) ); ?></a>
					</p>
					<?php if ( $cc_branches ) : ?>
						<p><?php esc_html_e( 'শাখা', 'coaching-centre' ); ?>:
							<?php
							$cc_names = wp_list_pluck( $cc_branches, 'name' );
							echo esc_html( implode( ', ', $cc_names ) );
							?>
						</p>
					<?php endif; ?>
				</div>

				<div>
					<h4><?php esc_html_e( 'লিংক', 'coaching-centre' ); ?></h4>
					<?php
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'menu_class'     => 'cc-footer-menu',
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);
					} else {
						$cc_fallback = array(
							home_url( '/' )           => __( 'হোম', 'coaching-centre' ),
							cc_page_url( 'about-us' ) => __( 'আমাদের সম্পর্কে', 'coaching-centre' ),
							cc_registration_url()      => __( 'ভর্তি ফর্ম', 'coaching-centre' ),
							cc_page_url( 'contact' )  => __( 'যোগাযোগ', 'coaching-centre' ),
							home_url( '/#programs' )  => __( 'কোর্সসমূহ', 'coaching-centre' ),
							home_url( '/#exam' )       => __( 'সাপ্তাহিক পরীক্ষা', 'coaching-centre' ),
							home_url( '/#faq' )        => __( 'প্রশ্নোত্তর', 'coaching-centre' ),
						);

						echo '<ul class="cc-footer-menu">';

						foreach ( $cc_fallback as $cc_url => $cc_label ) {
							printf(
								'<li><a href="%s">%s</a></li>',
								esc_url( $cc_url ),
								esc_html( $cc_label )
							);
						}

						echo '</ul>';
					}
					?>
				</div>
			</div>

			<small data-cc="copyright"><?php cc_copyright(); ?></small>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>