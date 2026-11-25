<?php
/**
 * The header for our theme
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri     = get_template_directory_uri();
$front_id      = hum_get_front_page_id();
$logo_url      = $front_id ? hum_get_image_url( 'site_logo', $front_id, 'assets/images/logo-transparent.png' ) : $theme_uri . '/assets/images/logo-transparent.png';
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$whatsapp_url  = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$contact_url   = is_front_page() ? '#contact' : hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) );
$brand_href    = is_front_page() ? '#hero' : home_url( '/' );
$header_class  = is_front_page() ? 'main-header' : 'main-header scrolled';
$top_anchor    = is_front_page() ? '#hero' : '#top';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ff3344">

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo esc_url( $theme_uri . '/assets/images/favicon.png' ); ?>">

	<!-- Google Fonts Preconnect -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="100">
<?php wp_body_open(); ?>

<?php if ( ! is_404() ) : ?>
	<!-- ===================================================================
	     SIDE QUICK TOOLS & FLOATING WIDGETS
	     =================================================================== -->
	<div class="side-quick-tools d-none d-lg-flex">
		<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="side-tool-btn btn-instagram-gradient" title="Follow on Instagram">
			<i class="fa-brands fa-instagram"></i>
		</a>
		<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="side-tool-btn btn-facebook-brand" title="Facebook Page">
			<i class="fa-brands fa-facebook-f"></i>
		</a>
		<a href="#" class="side-tool-btn" data-bs-toggle="modal" data-bs-target="#bmiModal" title="BMI Calculator">
			<i class="fa-solid fa-calculator"></i>
		</a>
		<a href="<?php echo esc_url( $contact_url ); ?>" class="side-tool-btn" title="Send a Message">
			<i class="fa-solid fa-envelope"></i>
		</a>
		<a href="#" class="side-tool-btn" data-bs-toggle="modal" data-bs-target="#consultationModal" title="Book Free Trial">
			<i class="fa-solid fa-calendar-check"></i>
		</a>
	</div>

	<!-- WhatsApp Floating Widget -->
	<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Chat on WhatsApp">
		<i class="fa-brands fa-whatsapp"></i>
	</a>

	<!-- Back to Top Button -->
	<a href="<?php echo esc_attr( $top_anchor ); ?>" class="back-to-top" id="backToTop" title="Back to top">
		<i class="fa-solid fa-arrow-up"></i>
	</a>
<?php endif; ?>

	<!-- ===================================================================
	     HEADER & NAVIGATION
	     =================================================================== -->
	<header class="<?php echo esc_attr( $header_class ); ?>" id="mainHeader">
		<div class="container-fluid px-lg-5">
			<nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
				<a class="navbar-brand navbar-brand-wrap" href="<?php echo esc_url( $brand_href ); ?>">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="Hustle Ur Muscle Logo" class="brand-logo-img">
					<div class="d-flex flex-column">
						<span class="brand-text">HUSTLE UR <span>MUSCLE</span></span>
						<span class="brand-subtext">BY SAGAR SOMA</span>
					</div>
				</a>

				<!-- Mobile Toggler -->
				<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa-solid fa-bars text-white fs-3"></i>
				</button>

				<!-- Navbar Menu Links -->
				<div class="collapse navbar-collapse" id="navbarContent">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'navbar-nav mx-auto mb-2 mb-lg-0',
								'fallback_cb'    => 'hustleurmuscle_primary_menu_fallback',
								'walker'         => new HustleUrMuscle_Nav_Walker(),
							)
						);
					} else {
						hustleurmuscle_primary_menu_fallback();
					}
					?>

					<!-- Nav Actions -->
					<div class="nav-actions">
						<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="nav-icon-btn d-none d-md-inline-block" title="Instagram">
							<i class="fa-brands fa-instagram"></i>
						</a>
						<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="nav-icon-btn d-none d-md-inline-block" title="Facebook">
							<i class="fa-brands fa-facebook-f"></i>
						</a>
						<button class="nav-icon-btn" id="searchTriggerBtn" title="Search" type="button">
							<i class="fa-solid fa-magnifying-glass"></i>
						</button>
						<button class="nav-icon-btn d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#bmiModal" title="Calculate BMI" type="button">
							<i class="fa-solid fa-heart-pulse"></i>
						</button>
						<a href="#" class="btn-fitness-blue ms-lg-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
							GET STARTED
						</a>
					</div>
				</div>
			</nav>
		</div>
	</header>

<?php if ( ! is_front_page() && ! is_404() ) : ?>
	<div id="top"></div>
<?php endif; ?>
