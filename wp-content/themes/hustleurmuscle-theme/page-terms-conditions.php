<?php
/**
 * Template Name: Terms & Conditions
 *
 * @package HustleUrMuscle
 */

get_header();

$phone = hustleurmuscle_get_option( 'hum_phone', '9948660025' );
$email = hustleurmuscle_get_option( 'hum_email', 'info@hustleurmuscle.in' );
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-gym">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white">LEGAL AGREEMENT</span>
				<h1 class="page-header-title">TERMS &amp; CONDITIONS</h1>
				<p class="page-header-desc">
					Please review the conditions governing personal training, gym facility use, and program purchases at Hustle Ur Muscle.
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">TERMS &amp; CONDITIONS</span>
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
							<span class="policy-date-badge"><i class="fa-regular fa-calendar-check me-2"></i> Effective Date: August 2026</span>
							<span class="badge bg-danger text-uppercase px-3 py-2">Client Agreement</span>
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
								<h4 class="policy-toc-title"><i class="fa-solid fa-file-contract text-danger me-2"></i> Terms of Service Structure</h4>
								<ol class="policy-toc-list">
									<li><a href="#term-acceptance">1. Acceptance of Terms</a></li>
									<li><a href="#term-medical">2. Physical Fitness &amp; Medical Disclosure Disclaimer</a></li>
									<li><a href="#term-coaching">3. Personal Training, Sessions &amp; Cancellation Policy</a></li>
									<li><a href="#term-payments">4. Payments, Subscriptions &amp; Refund Terms</a></li>
									<li><a href="#term-ip">5. Proprietary Content &amp; Intellectual Property</a></li>
									<li><a href="#term-gym">6. Gym Facility Rules &amp; Code of Conduct</a></li>
									<li><a href="#term-liability">7. Limitation of Liability &amp; Risk Assumption</a></li>
									<li><a href="#term-governing">8. Governing Law &amp; Contact Inquiries</a></li>
								</ol>
							</div>

							<!-- Section 1 -->
							<div class="policy-section" id="term-acceptance">
								<h2 class="policy-section-title">1. Acceptance of Terms</h2>
								<p class="policy-text">
									By accessing our website, registering for personal training packages, purchasing workout plans, or utilizing the gym facilities of <strong>Hustle Ur Muscle</strong>, you confirm that you have read, understood, and agree to be bound by these Terms and Conditions.
								</p>
								<p class="policy-text">
									These terms constitute a legally binding agreement between you and <strong>Coach Sagar Soma</strong> / Hustle Ur Muscle. If you do not agree to all terms stated herein, you must refrain from utilizing our services.
								</p>
							</div>

							<!-- Section 2 -->
							<div class="policy-section" id="term-medical">
								<h2 class="policy-section-title">2. Physical Fitness &amp; Medical Disclosure Disclaimer</h2>
								<p class="policy-text">
									Strenuous athletic resistance training, powerlifting, cardiovascular conditioning, and caloric alteration carry inherent risks of bodily injury. You expressly acknowledge that you are voluntary participants in these physical activities.
								</p>

								<div class="policy-callout">
									<p><strong><i class="fa-solid fa-heart-pulse text-danger me-2"></i> Physician Clearance Requirement:</strong> We strongly advise all clients to obtain physician clearance before starting any new exercise or nutritional regimen. You agree to disclose all pre-existing cardiovascular conditions, joint injuries, surgeries, or prescription medications prior to participating in coaching sessions.</p>
								</div>

								<p class="policy-text">
									Nutritional guidelines provided by Coach Sagar Soma represent athletic dietary recommendations for healthy adults and are not intended to substitute for formal clinical or medical diagnosis.
								</p>
							</div>

							<!-- Section 3 -->
							<div class="policy-section" id="term-coaching">
								<h2 class="policy-section-title">3. Personal Training, Sessions &amp; Cancellation Policy</h2>
								<p class="policy-text">
									To protect scheduling for all clients and maintain coaching discipline, the following policies apply to all 1-on-1 and group appointments:
								</p>
								<ul class="list-unstyled ps-3">
									<li class="mb-2"><i class="fa-solid fa-clock text-danger me-2"></i> <strong>24-Hour Cancellation Notice:</strong> Clients must notify Coach Sagar Soma at least twenty-four (24) hours in advance to reschedule a private training session without penalty.</li>
									<li class="mb-2"><i class="fa-solid fa-ban text-danger me-2"></i> <strong>Late Cancellations &amp; No-Shows:</strong> Sessions cancelled with less than 24 hours notice or missed entirely will be billed in full as a completed session.</li>
									<li class="mb-2"><i class="fa-solid fa-hourglass-half text-danger me-2"></i> <strong>Package Validity:</strong> Multi-session packages and monthly coaching blocks must be completed within their designated term unless paused for certified medical reasons.</li>
								</ul>
							</div>

							<!-- Section 4 -->
							<div class="policy-section" id="term-payments">
								<h2 class="policy-section-title">4. Payments, Subscriptions &amp; Refund Terms</h2>
								<p class="policy-text">
									All package prices, digital training programs, and subscription fees are listed in USD or applicable local currency. Payments must be settled prior to commencing workouts or receiving digital program downloads.
								</p>
								<div class="policy-callout-info">
									<p><strong><i class="fa-solid fa-receipt text-primary me-2"></i> Digital Program Refund Policy:</strong> Because custom diet protocols, workout schedules, and video libraries are delivered immediately in full, payments for digital plans (such as the 12-Week Hypertrophy or 8-Week Fat Loss plans) are non-refundable once downloaded or accessed in the client app.</p>
								</div>
							</div>

							<!-- Section 5 -->
							<div class="policy-section" id="term-ip">
								<h2 class="policy-section-title">5. Proprietary Content &amp; Intellectual Property</h2>
								<p class="policy-text">
									All instructional video footage, custom PDF templates, periodization algorithms, brand emblems, and workout spreadsheets created by Coach Sagar Soma remain the exclusive intellectual property of Hustle Ur Muscle.
								</p>
								<p class="policy-text">
									Purchasing a program grants a single-user personal license. Clients are strictly prohibited from redistributing, reselling, or publicly broadcasting our proprietary training materials.
								</p>
							</div>

							<!-- Section 6 -->
							<div class="policy-section" id="term-gym">
								<h2 class="policy-section-title">6. Gym Facility Rules &amp; Code of Conduct</h2>
								<p class="policy-text">
									When training at the Hustle Ur Muscle facility, clients must observe safety and community standards:
								</p>
								<ul class="list-unstyled ps-3">
									<li class="mb-2"><i class="fa-solid fa-dumbbell text-danger me-2"></i> <strong>Equipment Etiquette:</strong> Always rerack weights and bumper plates after completing sets. Wipe down equipment after use.</li>
									<li class="mb-2"><i class="fa-solid fa-shoe-prints text-danger me-2"></i> <strong>Footwear &amp; Attire:</strong> Clean, athletic shoes and appropriate gym apparel are required in all lifting zones at all times.</li>
									<li class="mb-2"><i class="fa-solid fa-handshake-angle text-danger me-2"></i> <strong>Zero Harassment:</strong> We maintain a zero-tolerance policy for aggressive behavior, harassment, or verbal abuse toward fellow athletes or staff.</li>
								</ul>
							</div>

							<!-- Section 7 -->
							<div class="policy-section" id="term-liability">
								<h2 class="policy-section-title">7. Limitation of Liability &amp; Risk Assumption</h2>
								<p class="policy-text">
									To the fullest extent permitted by law, you agree to indemnify, hold harmless, and release Coach Sagar Soma, Hustle Ur Muscle, and its instructors from any claims, damages, losses, or liabilities arising out of your participation in our training programs or gym equipment usage.
								</p>
							</div>

							<!-- Section 8 -->
							<div class="policy-section" id="term-governing">
								<h2 class="policy-section-title">8. Governing Law &amp; Contact Inquiries</h2>
								<p class="policy-text">
									These terms shall be governed by and construed in accordance with the laws of the operating jurisdiction without regard to conflict of law provisions.
								</p>
								<div class="p-4 bg-light rounded border">
									<div class="fw-bold fs-5 text-dark">Hustle Ur Muscle — Client Services</div>
									<div class="text-muted mt-1">Founder &amp; Head Coach: Sagar Soma</div>
									<div class="mt-2"><i class="fa-solid fa-envelope text-danger me-2"></i> <strong>Email:</strong> <a href="<?php echo esc_attr( 'mailto:' . $email ); ?>" class="text-danger"><?php echo esc_html( $email ); ?></a></div>
									<div class="mt-1"><i class="fa-solid fa-phone text-danger me-2"></i> <strong>Phone:</strong> <?php echo esc_html( $phone ); ?></div>
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
