<?php
/**
 * Template Name: Contact Us (ACF Free + Contact Form 7 + hum_faq CPT)
 *
 * @package HustleUrMuscle
 */

get_header();

$page_id       = get_queried_object_id();
$phone         = hustleurmuscle_get_option( 'hum_phone', '9948660025' );
$phone_href    = preg_replace( '/[^0-9+]/', '', $phone );
$email         = hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' );
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$whatsapp_url  = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$default_map   = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin';
?>

	<!-- ===================================================================
	     BREADCRUMB PAGE HEADER BANNER
	     =================================================================== -->
	<section class="page-header-banner page-header-bg-gym">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'contact_banner_tag', $page_id, 'REACH OUT ANYTIME' ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( hum_get_field( 'contact_banner_title', $page_id, 'CONTACT COACH SAGAR SOMA' ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( hum_get_field( 'contact_banner_desc', $page_id, 'Ready to start your body transformation at Hustle Ur Muscle? Connect with Coach Sagar directly for 1-on-1 coaching, customized meal blueprints, or gym membership inquiries.' ) ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">CONTACTS</span>
				</div>
			</div>
		</div>
	</section>

	<!-- ===================================================================
	     CONTACT INFO CARDS (PNG Icons + ACF Fields)
	     =================================================================== -->
	<section class="section-contact-info">
		<div class="container px-lg-4">
			<div class="row g-4">

				<!-- Card 1: Location -->
				<div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
					<div class="contact-info-card">
						<div class="contact-info-icon has-png-icon">
							<img src="<?php echo esc_url( hum_get_image_url( 'contact_loc_icon', $page_id, 'assets/images/icon-location.png' ) ); ?>" alt="Location Icon" class="contact-info-img">
						</div>
						<h3 class="contact-info-title"><?php echo esc_html( hum_get_field( 'contact_loc_title', $page_id, 'OUR LOCATION' ) ); ?></h3>
						<p class="contact-info-text">
							<strong>Hustle Ur Muscle</strong><br>
							<?php echo esc_html( hum_get_field( 'contact_loc_line1', $page_id, '123 Fitness Boulevard, Suite 500' ) ); ?><br>
							<?php echo esc_html( hum_get_field( 'contact_loc_line2', $page_id, 'New York, NY 10001' ) ); ?>
						</p>
					</div>
				</div>

				<!-- Card 2: Phone & WhatsApp -->
				<div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
					<div class="contact-info-card">
						<div class="contact-info-icon has-png-icon">
							<img src="<?php echo esc_url( hum_get_image_url( 'contact_phone_icon', $page_id, 'assets/images/icon-phone.png' ) ); ?>" alt="Phone and WhatsApp Icon" class="contact-info-img">
						</div>
						<h3 class="contact-info-title">CALL &amp; WHATSAPP</h3>
						<p class="contact-info-text">
							Direct: <a href="<?php echo esc_attr( 'tel:' . $phone_href ); ?>" class="text-danger fw-bold"><?php echo esc_html( $phone ); ?></a><br>
							WhatsApp: <a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-success fw-bold"><?php echo esc_html( $phone ); ?></a><br>
							<?php echo esc_html( hum_get_field( 'contact_phone_subtext', $page_id, 'Instant Coach Hotline' ) ); ?>
						</p>
					</div>
				</div>

				<!-- Card 3: Email & Online -->
				<div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
					<div class="contact-info-card">
						<div class="contact-info-icon has-png-icon">
							<img src="<?php echo esc_url( hum_get_image_url( 'contact_email_icon', $page_id, 'assets/images/icon-email.png' ) ); ?>" alt="Email Us Icon" class="contact-info-img">
						</div>
						<h3 class="contact-info-title">EMAIL US</h3>
						<p class="contact-info-text">
							General: <a href="<?php echo esc_attr( 'mailto:' . $email ); ?>" class="text-dark fw-bold"><?php echo esc_html( $email ); ?></a>
						</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     MAIN CONTACT FORM (CF7) & COACH HIGHLIGHT SECTION
	     =================================================================== -->
	<section class="section-full-service py-5" id="contactSection">
		<div class="container px-lg-4 my-4">
			<div class="row g-5 align-items-stretch">

				<!-- Left Column: Coach Sagar Soma Profile Card -->
				<div class="col-lg-5" data-aos="fade-right">
					<div class="coach-contact-card">

						<div class="coach-contact-header">
							<img src="<?php echo esc_url( hum_get_image_url( 'contact_coach_photo', $page_id, 'assets/images/sagar-soma.png' ) ); ?>" alt="Coach Sagar Soma" class="coach-avatar-lg">
							<div class="coach-title-wrap">
								<h3>SAGAR SOMA</h3>
								<span>Founder &amp; Head Coach</span>
								<div class="mt-1">
									<span class="badge bg-danger text-uppercase px-2 py-1">Hustle Ur Muscle</span>
								</div>
							</div>
						</div>

						<p class="text-white-50 text-relaxed-sm">
							<?php echo esc_html( hum_get_field( 'contact_coach_quote', $page_id, '"Whether your objective is gaining dense lean muscle, stripping off unwanted fat, or correcting your lifting biomechanics, I review every single message personally. Let\'s design the exact protocol your body needs."' ) ); ?>
						</p>

						<div class="mt-4 pt-3 border-top border-secondary">
							<div class="d-flex align-items-center gap-3 mb-3">
								<i class="fa-solid fa-shield-halved text-danger fs-5"></i>
								<div>
									<div class="text-white fw-bold fs-6">100% Tailored Attention</div>
									<small class="text-white-50">Every inquiry receives a personalized response within 24 hours.</small>
								</div>
							</div>

							<div class="d-flex align-items-center gap-3 mb-3">
								<i class="fa-solid fa-laptop-medical text-danger fs-5"></i>
								<div>
									<div class="text-white fw-bold fs-6">In-Gym &amp; Online Distance Coaching</div>
									<small class="text-white-50">Available for local gym training or global virtual coaching.</small>
								</div>
							</div>
						</div>

						<div class="mt-4">
							<div class="text-uppercase text-white fw-bold fs-6 mb-2 letter-spacing-1">
								CONNECT DIRECTLY ON SOCIAL:
							</div>
							<div class="coach-social-buttons">
								<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn-social-contact btn-social-instagram">
									<i class="fa-brands fa-instagram"></i> Instagram
								</a>
								<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn-social-contact btn-social-facebook">
									<i class="fa-brands fa-facebook-f"></i> Facebook
								</a>
								<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn-social-contact btn-social-whatsapp">
									<i class="fa-brands fa-whatsapp"></i> WhatsApp
								</a>
							</div>
						</div>

					</div>
				</div>

				<!-- Right Column: Interactive Consultation & Contact Form 7 -->
				<div class="col-lg-7" data-aos="fade-left">
					<div class="contact-form-wrap bg-dark p-4 p-md-5 rounded border border-secondary h-100">
						<span class="section-tag with-line">SEND A DIRECT INQUIRY</span>
						<h2 class="contact-title text-white mb-4">
							WRITE TO COACH SAGAR SOMA
						</h2>
						<p class="text-white-50 mb-4">
							Fill out the details below. We will assess your fitness targets and schedule your initial movement evaluation.
						</p>

						<?php hum_render_cf7_or_fallback( hum_get_field( 'contact_cf7_shortcode', $page_id, '' ), 'contact' ); ?>

					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     INTERACTIVE MAP & FAQ SECTION (hum_faq CPT)
	     =================================================================== -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">

			<div class="text-center mb-5">
				<span class="section-tag tag-center" data-aos="fade-up">FIND US &amp; FAQS</span>
				<h2 class="services-title" data-aos="fade-up" data-aos-delay="100">
					VISIT HUSTLE UR MUSCLE &amp; FREQUENTLY ASKED QUESTIONS
				</h2>
			</div>

			<div class="row g-5 align-items-center">

				<!-- Left: Interactive Map -->
				<div class="col-lg-6" data-aos="fade-right">
					<div class="map-wrap">
						<iframe
							src="<?php echo esc_url( hum_get_field( 'contact_map_url', $page_id, $default_map ) ); ?>"
							allowfullscreen=""
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							title="Hustle Ur Muscle Location Map">
						</iframe>
					</div>
					<div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light border rounded">
						<div>
							<strong>Hustle Ur Muscle Fitness Gym</strong>
							<div class="text-muted small"><?php echo esc_html( hum_get_field( 'contact_parking_note', $page_id, 'Ample parking & locker room facilities available' ) ); ?></div>
						</div>
						<a href="<?php echo esc_url( hum_get_field( 'contact_directions_url', $page_id, 'https://maps.google.com' ) ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-danger fw-bold">
							GET DIRECTIONS <i class="fa-solid fa-diamond-turn-right ms-1"></i>
						</a>
					</div>
				</div>

				<!-- Right: FAQ Accordion -->
				<div class="col-lg-6" data-aos="fade-left">
					<div class="accordion faq-accordion" id="faqAccordion">
						<?php
						$c_faqs = new WP_Query(
							array(
								'post_type'      => 'hum_faq',
								'posts_per_page' => 6,
								'post_status'    => 'publish',
								'meta_key'       => 'show_on_contact',
								'meta_value'     => '1',
								'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
							)
						);
						if ( $c_faqs->have_posts() ) :
							$idx = 0;
							while ( $c_faqs->have_posts() ) :
								$c_faqs->the_post();
								$idx++;
								$first = ( 1 === $idx );
								$cid   = 'contactFaqCollapse' . $idx;
								$hid   = 'contactFaqHeading' . $idx;
								?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="<?php echo esc_attr( $hid ); ?>">
										<button class="accordion-button<?php echo $first ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $cid ); ?>" aria-expanded="<?php echo $first ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $cid ); ?>">
											<?php echo esc_html( preg_replace( '/^\d+\.\s*/', '', get_the_title() ) ); ?>
										</button>
									</h2>
									<div id="<?php echo esc_attr( $cid ); ?>" class="accordion-collapse collapse<?php echo $first ? ' show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $hid ); ?>" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											<?php echo wp_kses_post( wpautop( get_the_content() ) ); ?>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
				</div>

			</div>
		</div>
	</section>

<?php
get_footer();
