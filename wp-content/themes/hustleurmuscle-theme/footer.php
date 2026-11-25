<?php
/**
 * The template for displaying the footer
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$front_id      = hum_get_front_page_id();
$logo_url      = $front_id ? hum_get_image_url( 'site_logo', $front_id, 'assets/images/logo-transparent.png' ) : get_template_directory_uri() . '/assets/images/logo-transparent.png';
$phone         = hustleurmuscle_get_option( 'hum_phone', '9948660025' );
$phone_href    = preg_replace( '/[^0-9+]/', '', $phone );
$email         = hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' );
$club_name     = hum_get_site_setting( 'site_club_name', '', 'Hustle Ur Muscle Training Club' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$twitter_url   = hustleurmuscle_get_option( 'hum_twitter_url', 'https://twitter.com' );
$youtube_url   = hustleurmuscle_get_option( 'hum_youtube_url', 'https://youtube.com' );
$privacy_url   = hustleurmuscle_get_page_url( array( 'privacy-policy' ) );
$terms_url     = hustleurmuscle_get_page_url( array( 'terms-conditions', 'terms-and-conditions' ) );
$contact_url   = hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) );
$modal_cf7     = $front_id ? hum_get_field( 'modal_cf7_shortcode', $front_id, '' ) : '';
?>

<?php if ( is_404() ) : ?>
	<footer class="main-footer">
		<div class="container px-lg-4">
			<div class="footer-bottom-bar mt-0 pt-4">
				<div class="row align-items-center">
					<div class="col-md-6">
						<p class="copyright-text">Hustle Ur Muscle &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>. All rights reserved. Directed by Coach Sagar Soma.</p>
					</div>
					<div class="col-md-6">
						<div class="footer-legal-links">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
							<a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a>
							<a href="<?php echo esc_url( $terms_url ); ?>">Terms &amp; Conditions</a>
							<a href="<?php echo esc_url( $contact_url ); ?>">Contact</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
<?php else : ?>
	<!-- ===================================================================
	     SECTION 9: FOOTER (DARK)
	     =================================================================== -->
	<footer class="main-footer">
		<div class="container px-lg-4">

			<!-- Top Banner in Footer -->
			<div class="footer-top-banner">
				<div class="footer-top-wrap">
					<div class="footer-brand-side">
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="Hustle Ur Muscle Official Emblem" class="footer-brand-logo-img">
						<div>
							<h2 class="footer-top-heading">
								JOIN HUSTLE UR MUSCLE TO<br>START A NEW LIFE
							</h2>
							<span class="footer-founder-subtext">
								HEAD COACH &amp; FOUNDER: <span class="text-white">SAGAR SOMA</span>
							</span>
						</div>
					</div>
					<div class="footer-cta-btn">
						<a href="#" class="btn-fitness-red" data-bs-toggle="modal" data-bs-target="#consultationModal">
							JOIN NOW <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>

			<!-- Main Footer Columns -->
			<div class="row g-4 g-lg-5">

				<!-- Column 1: About Our Club -->
				<div class="col-lg-4 col-md-6">
					<h4 class="footer-widget-title">ABOUT HUSTLE UR MUSCLE</h4>
					<p class="footer-about-text">
						Hustle Ur Muscle, founded by Coach Sagar Soma, is dedicated to scientific strength conditioning, body transformation, and empowering individuals with peak athletic discipline.
					</p>
					<div class="footer-address">
						<span><i class="fa-solid fa-envelope text-danger me-2"></i> <?php echo esc_html( $email ); ?></span>
						<span><i class="fa-solid fa-phone text-danger me-2"></i> <a href="<?php echo esc_attr( 'tel:' . $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a></span>
						<span><i class="fa-solid fa-location-dot text-danger me-2"></i> <?php echo esc_html( $club_name ); ?></span>
					</div>
				</div>

				<!-- Column 2: Social -->
				<div class="col-lg-2 col-md-6 col-6">
					<h4 class="footer-widget-title">SOCIAL</h4>
					<ul class="footer-social-list">
						<li>
							<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
								<i class="fa-brands fa-facebook-f"></i> Facebook
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
								<i class="fa-brands fa-instagram"></i> Instagram
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
								<i class="fa-brands fa-x-twitter"></i> Twitter
							</a>
						</li>
						<li>
							<a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link">
								<i class="fa-brands fa-youtube"></i> YouTube
							</a>
						</li>
					</ul>
				</div>

				<!-- Column 3: Quick Links -->
				<div class="col-lg-2 col-md-6 col-6">
					<h4 class="footer-widget-title">QUICK LINKS</h4>
					<?php
					if ( has_nav_menu( 'footer_quick_links' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer_quick_links',
								'container'      => false,
								'menu_class'     => 'footer-links-list',
								'depth'          => 1,
								'fallback_cb'    => 'hustleurmuscle_footer_menu_fallback',
							)
						);
					} else {
						hustleurmuscle_footer_menu_fallback();
					}
					?>
				</div>

				<!-- Column 4: Instagram Reels -->
				<div class="col-lg-4 col-md-6">
					<h4 class="footer-widget-title">INSTAGRAM</h4>
					<?php get_template_part( 'template-parts/instagram-reels' ); ?>
				</div>

			</div>

			<!-- Footer Bottom Bar -->
			<div class="footer-bottom-bar">
				<div class="row align-items-center">
					<div class="col-md-6">
						<p class="copyright-text">
							Hustle Ur Muscle &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>. All rights reserved. Directed by Coach Sagar Soma.
						</p>
					</div>
					<div class="col-md-6">
						<div class="footer-legal-links">
							<a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a>
							<a href="<?php echo esc_url( $terms_url ); ?>">Terms &amp; Conditions</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</footer>
<?php endif; ?>

	<!-- ===================================================================
	     MODAL: FULLSCREEN SEARCH OVERLAY
	     =================================================================== -->
	<div class="search-overlay" id="searchOverlay">
		<button class="search-close-btn" id="searchCloseBtn" aria-label="Close search" type="button">
			<i class="fa-solid fa-xmark"></i>
		</button>
		<div class="search-input-wrap">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="search-bar-input" placeholder="SEARCH HUSTLE UR MUSCLE..." autofocus>
			</form>
			<div class="text-white-50 mt-3 text-uppercase font-monospace fs-6">
				Press ENTER to search or ESC to close
			</div>
		</div>
	</div>

	<!-- ===================================================================
	     MODAL: FREE TRIAL & BOOKING (Contact Form 7 Powered)
	     =================================================================== -->
	<div class="modal fade modal-fitness-dark" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title heading-font" id="consultationModalLabel">
						<i class="fa-solid fa-calendar-check text-danger me-2"></i> BOOK WITH COACH SAGAR SOMA
					</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-4">
					<p class="text-white-50 mb-4">
						Claim your complimentary 1-on-1 fitness consultation and biomechanics movement analysis at Hustle Ur Muscle with Sagar Soma.
					</p>
					<?php hum_render_cf7_or_fallback( $modal_cf7, 'modal' ); ?>
				</div>
			</div>
		</div>
	</div>

	<!-- ===================================================================
	     MODAL: BMI CALCULATOR
	     =================================================================== -->
	<div class="modal fade modal-fitness-dark" id="bmiModal" tabindex="-1" aria-labelledby="bmiModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title heading-font" id="bmiModalLabel">
						<i class="fa-solid fa-calculator text-danger me-2"></i> BODY MASS INDEX (BMI)
					</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body p-4">
					<div class="row g-3">
						<div class="col-6">
							<label class="form-label text-uppercase fs-6 fw-bold">Weight (kg)</label>
							<input type="number" id="bmiWeight" class="form-control bg-dark text-white border-secondary" placeholder="e.g. 78">
						</div>
						<div class="col-6">
							<label class="form-label text-uppercase fs-6 fw-bold">Height (cm)</label>
							<input type="number" id="bmiHeight" class="form-control bg-dark text-white border-secondary" placeholder="e.g. 178">
						</div>
					</div>
					<button type="button" class="btn-fitness-blue w-100 mt-4" id="calculateBmiBtn">
						CALCULATE BMI
					</button>

					<!-- Result Display -->
					<div id="bmiResultWrap" class="mt-4 p-3 bg-black border border-secondary rounded text-center bmi-result-hidden">
						<div class="text-white-50 text-uppercase fs-6">Your BMI Result</div>
						<div class="display-5 fw-bold text-white my-1" id="bmiScoreVal">24.2</div>
						<div id="bmiCategoryBadge" class="badge bg-success fs-6 py-2 px-3">Normal weight</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ===================================================================
	     TOAST NOTIFICATION FOR FORM FEEDBACK
	     =================================================================== -->
	<div class="position-fixed bottom-0 end-0 p-3 toast-container-custom">
		<div id="contactSuccessToast" class="toast text-white bg-dark border-danger" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header bg-danger text-white">
				<i class="fa-solid fa-circle-check me-2"></i>
				<strong class="me-auto heading-font">MESSAGE RECEIVED</strong>
				<small>Just now</small>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body py-3">
				Thank you for reaching out! Coach Sagar Soma from Hustle Ur Muscle will contact you within 24 hours.
			</div>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
