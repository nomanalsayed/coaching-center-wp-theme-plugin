<?php
/**
 * Site header.
 *
 * @package Coaching_Centre
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'মূল অংশে যান', 'coaching-centre' ); ?></a>

<div id="page" class="site">

	<header id="masthead" class="site-header">
		<div class="wrap nav">
			<div class="nav-brand">
				<?php cc_site_branding(); ?>
			</div>

<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => 'nav',
				'container_id'    => 'cc-primary-nav',
				'container_class' => '',
				'menu_class'      => '',
				'depth'           => 2,
				'fallback_cb'     => 'cc_nav_fallback',
			)
		);
		?>

		<div class="nav-actions">
			<button class="nav-theme" type="button" data-cc-theme-toggle aria-label="<?php esc_attr_e( 'গাঢ় / উজ্জ্বল থিম বদলান', 'coaching-centre' ); ?>">🌙</button>
			<a class="btn nav-cta" href="<?php echo esc_url( cc_registration_url() ); ?>"><?php esc_html_e( 'ভর্তি হোন', 'coaching-centre' ); ?></a>
			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="cc-primary-nav" aria-label="<?php esc_attr_e( 'মেনু খুলুন', 'coaching-centre' ); ?>">☰</button>
		</div>
		</div>
	</header>

	<div id="content" class="site-content">