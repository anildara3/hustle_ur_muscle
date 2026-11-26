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
$header_id     = hum_get_active_header_id();
$default_logo  = $front_id ? hum_get_image_url( 'site_logo', $front_id, 'assets/images/logo-transparent.png' ) : $theme_uri . '/assets/images/logo-transparent.png';
$logo_url      = $header_id ? hum_get_image_url( 'header_logo', $header_id, '' ) : '';
if ( '' === $logo_url ) {
	$logo_url = $default_logo;
}
$favicon_url   = $header_id ? hum_get_image_url( 'header_favicon', $header_id, '' ) : '';
if ( '' === $favicon_url ) {
	$favicon_url = $theme_uri . '/assets/images/favicon.png';
}

$brand_main    = $header_id ? hum_get_field( 'header_brand_main', $header_id, 'HUSTLE UR' ) : 'HUSTLE UR';
$brand_hl      = $header_id ? hum_get_field( 'header_brand_highlight', $header_id, 'MUSCLE' ) : 'MUSCLE';
$brand_sub     = $header_id ? hum_get_field( 'header_brand_subtext', $header_id, 'BY SAGAR SOMA' ) : 'BY SAGAR SOMA';
$brand_url_raw = $header_id ? hum_get_field( 'header_brand_url', $header_id, '' ) : '';
$brand_href    = '' !== trim( (string) $brand_url_raw ) ? hum_resolve_theme_url( $brand_url_raw ) : ( is_front_page() ? '#hero' : home_url( '/' ) );

$instagram_url = hum_get_cpt_optional_field( 'header_instagram_url', $header_id, hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' ) );
$facebook_url  = hum_get_cpt_optional_field( 'header_facebook_url', $header_id, hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' ) );
$whatsapp_url  = hum_get_cpt_optional_field( 'header_whatsapp_url', $header_id, hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' ) );

$contact_raw   = $header_id ? hum_get_field( 'header_contact_url', $header_id, '' ) : '';
$contact_url   = '' !== trim( (string) $contact_raw ) ? hum_resolve_theme_url( $contact_raw ) : ( is_front_page() ? '#contact' : hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) ) );

$show_search      = $header_id ? hum_get_bool_field( 'header_show_search', $header_id, true ) : true;
$show_bmi         = $header_id ? hum_get_bool_field( 'header_show_bmi', $header_id, true ) : true;
$show_quick_tools = $header_id ? hum_get_bool_field( 'header_show_quick_tools', $header_id, true ) : true;
$show_whatsapp    = $header_id ? hum_get_bool_field( 'header_show_whatsapp', $header_id, true ) : true;
$show_back_to_top = $header_id ? hum_get_bool_field( 'header_show_back_to_top', $header_id, true ) : true;

$cta_text      = $header_id ? hum_get_field( 'header_cta_text', $header_id, 'GET STARTED' ) : 'GET STARTED';
$cta_url_raw   = $header_id ? hum_get_field( 'header_cta_url', $header_id, '' ) : '';
$cta_url       = hum_resolve_theme_url( $cta_url_raw );

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
	<link rel="icon" type="image/png" href="<?php echo esc_url( $favicon_url ); ?>">

	<!-- Google Fonts Preconnect -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="100">
<?php wp_body_open(); ?>

<?php if ( ! is_404() ) : ?>
	<?php if ( $show_quick_tools ) : ?>
	<!-- ===================================================================
	     SIDE QUICK TOOLS & FLOATING WIDGETS
	     =================================================================== -->
	<div class="side-quick-tools d-none d-lg-flex">
		<?php if ( $instagram_url ) : ?>
		<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="side-tool-btn btn-instagram-gradient" title="Follow on Instagram">
			<i class="fa-brands fa-instagram"></i>
		</a>
		<?php endif; ?>
		<?php if ( $facebook_url ) : ?>
		<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="side-tool-btn btn-facebook-brand" title="Facebook Page">
			<i class="fa-brands fa-facebook-f"></i>
		</a>
		<?php endif; ?>
		<?php if ( $show_bmi ) : ?>
		<a href="#" class="side-tool-btn" data-bs-toggle="modal" data-bs-target="#bmiModal" title="BMI Calculator">
			<i class="fa-solid fa-calculator"></i>
		</a>
		<?php endif; ?>
		<a href="<?php echo esc_url( $contact_url ); ?>" class="side-tool-btn" title="Send a Message">
			<i class="fa-solid fa-envelope"></i>
		</a>
		<a href="#" class="side-tool-btn" data-bs-toggle="modal" data-bs-target="#consultationModal" title="Book Free Trial">
			<i class="fa-solid fa-calendar-check"></i>
		</a>
	</div>
	<?php endif; ?>

	<?php if ( $show_whatsapp && $whatsapp_url ) : ?>
	<!-- WhatsApp Floating Widget -->
	<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="floating-whatsapp" title="Chat on WhatsApp">
		<i class="fa-brands fa-whatsapp"></i>
	</a>
	<?php endif; ?>

	<?php if ( $show_back_to_top ) : ?>
	<!-- Back to Top Button -->
	<a href="<?php echo esc_attr( $top_anchor ); ?>" class="back-to-top" id="backToTop" title="Back to top">
		<i class="fa-solid fa-arrow-up"></i>
	</a>
	<?php endif; ?>
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
						<span class="brand-text"><?php echo esc_html( $brand_main ); ?><?php if ( '' !== $brand_hl ) : ?> <span><?php echo esc_html( $brand_hl ); ?></span><?php endif; ?></span>
						<?php if ( '' !== $brand_sub ) : ?>
							<span class="brand-subtext"><?php echo esc_html( $brand_sub ); ?></span>
						<?php endif; ?>
					</div>
				</a>

				<!-- Mobile Toggler -->
				<button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa-solid fa-bars text-white fs-3"></i>
				</button>

				<!-- Navbar Menu Links (Appearance -> Menus) -->
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
						<?php if ( $instagram_url ) : ?>
						<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="nav-icon-btn d-none d-md-inline-block" title="Instagram">
							<i class="fa-brands fa-instagram"></i>
						</a>
						<?php endif; ?>
						<?php if ( $facebook_url ) : ?>
						<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="nav-icon-btn d-none d-md-inline-block" title="Facebook">
							<i class="fa-brands fa-facebook-f"></i>
						</a>
						<?php endif; ?>
						<?php if ( $show_search ) : ?>
						<button class="nav-icon-btn" id="searchTriggerBtn" title="Search" type="button">
							<i class="fa-solid fa-magnifying-glass"></i>
						</button>
						<?php endif; ?>
						<?php if ( $show_bmi ) : ?>
						<button class="nav-icon-btn d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#bmiModal" title="Calculate BMI" type="button">
							<i class="fa-solid fa-heart-pulse"></i>
						</button>
						<?php endif; ?>
						<?php if ( '' !== $cta_url ) : ?>
						<a href="<?php echo esc_url( $cta_url ); ?>" class="btn-fitness-blue ms-lg-2">
							<?php echo esc_html( $cta_text ); ?>
						</a>
						<?php else : ?>
						<a href="#" class="btn-fitness-blue ms-lg-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
							<?php echo esc_html( $cta_text ); ?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</nav>
		</div>
	</header>

<?php if ( ! is_front_page() && ! is_404() ) : ?>
	<div id="top"></div>
<?php endif; ?>
