<?php
/**
 * Template Name: Privacy Policy
 *
 * @package HustleUrMuscle
 */

get_header();

$phone = hustleurmuscle_get_option( 'hum_phone', '9948660025' );
$email = hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' );
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-about">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white">LEGAL &amp; PRIVACY</span>
				<h1 class="page-header-title">PRIVACY POLICY</h1>
				<p class="page-header-desc">
					How Hustle Ur Muscle and Coach Sagar Soma collect, utilize, and protect your personal and biometric data.
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">PRIVACY POLICY</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Main Policy Content Section -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">
			<div class="row justify-content-center">
				<div class="col-lg-10">

					<div class="policy-card text-start" data-aos="fade-up">

						<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
							<span class="policy-date-badge"><i class="fa-regular fa-calendar-check me-2"></i> Last Updated: August 2026</span>
							<span class="badge bg-danger text-uppercase px-3 py-2">Official Policy</span>
						</div>

						<?php
						$raw_content = get_post_field( 'post_content', get_queried_object_id() );
						if ( '' !== trim( wp_strip_all_tags( $raw_content ) ) ) :
							?>
							<div class="single-post-body">
								<?php echo wp_kses_post( apply_filters( 'the_content', $raw_content ) ); ?>
							</div>
						<?php else : ?>
							<!-- Table of Contents -->
							<div class="policy-toc-box">
								<h4 class="policy-toc-title"><i class="fa-solid fa-list-check text-danger me-2"></i> Table of Contents</h4>
								<ol class="policy-toc-list">
									<li><a href="#section-intro">1. Introduction &amp; Scope</a></li>
									<li><a href="#section-collection">2. Personal &amp; Health Information We Collect</a></li>
									<li><a href="#section-use">3. How We Use Your Information</a></li>
									<li><a href="#section-security">4. Data Security &amp; Encryption</a></li>
									<li><a href="#section-sharing">5. Third-Party Sharing &amp; Processors</a></li>
									<li><a href="#section-cookies">6. Cookies &amp; Digital Tracking</a></li>
									<li><a href="#section-rights">7. Client Rights &amp; Access</a></li>
									<li><a href="#section-contact">8. Contacting the Data Protection Officer</a></li>
								</ol>
							</div>

							<!-- Section 1 -->
							<div class="policy-section" id="section-intro">
								<h2 class="policy-section-title">1. Introduction &amp; Scope</h2>
								<p class="policy-text">
									Welcome to <strong>Hustle Ur Muscle</strong> (referred to herein as "we," "our," or "the Club"), operated by <strong>Coach Sagar Soma</strong>. We provide bespoke personal fitness training, customized dietary guidance, competition preparation, and distance online coaching services.
								</p>
								<p class="policy-text">
									This Privacy Policy sets forth our practices regarding the collection, handling, and security of information obtained from clients, website visitors, and program subscribers. We are committed to safeguarding your privacy in compliance with applicable international privacy standards.
								</p>
							</div>

							<!-- Section 2 -->
							<div class="policy-section" id="section-collection">
								<h2 class="policy-section-title">2. Personal &amp; Health Information We Collect</h2>
								<p class="policy-text">
									To engineer safe and personalized training protocols, we collect certain personal and physical data:
								</p>
								<ul class="list-unstyled ps-3">
									<li class="mb-2"><i class="fa-solid fa-circle-dot text-danger me-2"></i> <strong>Contact Information:</strong> Full name, telephone/WhatsApp number, email address, and residential city.</li>
									<li class="mb-2"><i class="fa-solid fa-circle-dot text-danger me-2"></i> <strong>Physical &amp; Health Metrics:</strong> Age, gender, height, body weight, circumference measurements, training history, past orthopedic injuries, and cardiovascular health disclosures.</li>
									<li class="mb-2"><i class="fa-solid fa-circle-dot text-danger me-2"></i> <strong>Nutritional Data:</strong> Dietary restrictions, caloric history, food allergies, and vegetarian/vegan preferences.</li>
									<li class="mb-2"><i class="fa-solid fa-circle-dot text-danger me-2"></i> <strong>Payment Records:</strong> Transaction identifiers and payment confirmation (all credit card details are processed through encrypted PCI-DSS compliant gateways; we never store raw card numbers).</li>
								</ul>

								<div class="policy-callout">
									<p><strong><i class="fa-solid fa-triangle-exclamation text-danger me-2"></i> Special Health Data Notice:</strong> Any medical or physical condition disclosed to Coach Sagar Soma is treated with absolute confidentiality and used exclusively to avoid injury and tailor appropriate movement patterns.</p>
								</div>
							</div>

							<!-- Section 3 -->
							<div class="policy-section" id="section-use">
								<h2 class="policy-section-title">3. How We Use Your Information</h2>
								<p class="policy-text">
									All collected data serves explicit, client-focused coaching operations:
								</p>
								<ul class="list-unstyled ps-3">
									<li class="mb-2"><i class="fa-solid fa-check text-danger me-2"></i> Generating customized periodized resistance routines and caloric/macronutrient splits.</li>
									<li class="mb-2"><i class="fa-solid fa-check text-danger me-2"></i> Conducting weekly progress reviews, bio-scan audits, and movement video evaluations.</li>
									<li class="mb-2"><i class="fa-solid fa-check text-danger me-2"></i> Delivering administrative updates, appointment reminders, and coaching notifications via WhatsApp, email, or telephone.</li>
									<li class="mb-2"><i class="fa-solid fa-check text-danger me-2"></i> Enhancing website performance, mobile app responsiveness, and user experience.</li>
								</ul>
							</div>

							<!-- Section 4 -->
							<div class="policy-section" id="section-security">
								<h2 class="policy-section-title">4. Data Security &amp; Encryption</h2>
								<p class="policy-text">
									Hustle Ur Muscle employs multi-layered industry safeguards. Website traffic is protected via Secure Socket Layer (SSL) 256-bit encryption. Private coaching documentation and biometric logs are maintained on restricted, access-controlled databases accessible only by Coach Sagar Soma and authorized staff.
								</p>
							</div>

							<!-- Section 5 -->
							<div class="policy-section" id="section-sharing">
								<h2 class="policy-section-title">5. Third-Party Sharing &amp; Processors</h2>
								<p class="policy-text">
									<strong>We never sell, rent, or trade your personal or health data.</strong> Information is shared only with trusted technical processors necessary to facilitate our service (such as cloud hosting providers, secure payment gateways, and our dedicated coaching mobile application platform).
								</p>
							</div>

							<!-- Section 6 -->
							<div class="policy-section" id="section-cookies">
								<h2 class="policy-section-title">6. Cookies &amp; Digital Tracking</h2>
								<p class="policy-text">
									Our website utilizes standard cookies to remember user preferences, maintain session state, and aggregate anonymized visitor metrics. You may disable cookies in your web browser settings; however, certain interactive features (such as the BMI calculator and consultation modal) may require cookies for optimal operation.
								</p>
							</div>

							<!-- Section 7 -->
							<div class="policy-section" id="section-rights">
								<h2 class="policy-section-title">7. Client Rights &amp; Access</h2>
								<p class="policy-text">
									You have the full right to inspect, correct, or request the deletion of your personal data at any point. If you wish to receive an export of your physical metrics or request complete record erasure from our databases, simply contact us in writing.
								</p>
							</div>

							<!-- Section 8 -->
							<div class="policy-section" id="section-contact">
								<h2 class="policy-section-title">8. Contacting the Data Protection Officer</h2>
								<p class="policy-text">
									If you have questions regarding this Privacy Policy or wish to exercise your data rights, reach out to Coach Sagar Soma directly:
								</p>
								<div class="p-4 bg-light rounded border">
									<div class="fw-bold fs-5 text-dark">Hustle Ur Muscle — Privacy Office</div>
									<div class="text-muted mt-1">Founder &amp; Head Coach: Sagar Soma</div>
									<div class="mt-2"><i class="fa-solid fa-envelope text-danger me-2"></i> <strong>Email:</strong> <a href="<?php echo esc_attr( 'mailto:' . $email ); ?>" class="text-danger"><?php echo esc_html( $email ); ?></a></div>
									<div class="mt-1"><i class="fa-solid fa-phone text-danger me-2"></i> <strong>Telephone:</strong> <?php echo esc_html( $phone ); ?></div>
								</div>
							</div>
						<?php endif; ?>

					</div>

				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
