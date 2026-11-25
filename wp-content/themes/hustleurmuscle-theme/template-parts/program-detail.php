<?php
/**
 * Shared Program Detail Layout (used by single-hum_program.php and page-program-single.php)
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri    = get_template_directory_uri();
$programs_url = hustleurmuscle_get_page_url( array( 'programs' ) );
$whatsapp_url = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$pid          = isset( $args['program_id'] ) ? (int) $args['program_id'] : get_the_ID();

$title        = $pid ? get_the_title( $pid ) : 'STRENGTH & HYPERTROPHY';
$excerpt      = $pid && has_excerpt( $pid ) ? get_the_excerpt( $pid ) : 'Complete periodized training schedule, mechanical overload progression, and personalized macro nutrition engineered by Coach Sagar Soma.';
$banner_tag   = hum_get_field( 'program_banner_tag', $pid, '12-WEEK TRANSFORMATION' );
$duration     = hum_get_field( 'program_duration', $pid, '12 WEEKS' );
$intensity    = hum_get_field( 'program_intensity', $pid, 'INTERMEDIATE+' );
$frequency    = hum_get_field( 'program_frequency', $pid, '5 DAYS / WK' );
$goal         = hum_get_field( 'program_goal', $pid, 'LEAN MUSCLE' );
$price        = hum_get_field( 'program_price', $pid, '$129' );
$price_unit   = hum_get_field( 'program_price_unit', $pid, '/ one-time' );
$feat_img     = ( $pid && has_post_thumbnail( $pid ) ) ? get_the_post_thumbnail_url( $pid, 'large' ) : $theme_uri . '/assets/images/banner-gym.jpg';

$quote        = hum_get_field( 'program_quote', $pid, '"Muscle hypertrophy is not an accident—it is a calculated biological adaptation to progressive tension and intelligent recovery."' );
$quote_author = hum_get_field( 'program_quote_author', $pid, 'Coach Sagar Soma' );

$included_raw = hum_get_field(
	'program_included',
	$pid,
	"Gram-by-Gram Nutrition Blueprint: Tailored specifically to your metabolic rate, body fat percentage, and muscle target.\nHD Exercise Video Demos: Comprehensive video library showing bio-mechanical cues directly by Coach Sagar.\nWeekly Video Form Audits: Upload your heaviest lifting sets for direct critique and adjustments.\nHustle Ur Muscle Mobile App: Digital workout log with rest timers, weight progression charts, and circumference scans.\nDirect Coach WhatsApp Hotline: Priority support whenever you have nutritional or recovery queries."
);
$included_lines = hum_split_lines( $included_raw );

$sidebar_desc = hum_get_field( 'sidebar_cta_desc', $pid, 'Complete 12-Week Access & Personalized Coaching Blueprint.' );
$sidebar_inc  = hum_split_lines(
	hum_get_field(
		'sidebar_includes',
		$pid,
		"Instant Download & Mobile App Login\nCustom Macro Meal Plan by Sagar Soma\n12 Weeks of Periodized Workouts\nWeekly Video Form Critique\nDirect Coach WhatsApp Channel"
	)
);

$rev_name  = hum_get_field( 'program_review_name', $pid, 'Steve Rogers' );
$rev_role  = hum_get_field( 'program_review_role', $pid, 'Strength Athlete • Gained 9 lbs Lean Mass' );
$rev_text  = hum_get_field( 'program_review_text', $pid, '"Following Coach Sagar’s 12-week hypertrophy program took my bench from 225 to 275 and completely reshaped my shoulders and back. The weekly video check-ins kept my form sharp and injury-free. Best investment I\'ve made in fitness."' );
$rev_photo = hum_get_image_url( 'program_review_photo', $pid, 'assets/images/client-2.jpg' );

$faq1_q = hum_get_field( 'program_faq_1_q', $pid, 'What gym equipment is needed for this program?' );
$faq1_a = hum_get_field( 'program_faq_1_a', $pid, 'Standard commercial gym equipment: Olympic barbells, squat rack, adjustable bench, dumbbells, cable station, and basic leg machines (leg press/leg curl).' );
$faq2_q = hum_get_field( 'program_faq_2_q', $pid, 'Can I do this program if I am vegetarian?' );
$faq2_a = hum_get_field( 'program_faq_2_a', $pid, 'Yes! Coach Sagar provides custom vegetarian meal options using high-leucine proteins such as paneer, whey isolate, soy, Greek yogurt, lentils, and amino acid pairings.' );

$phases = array();
for ( $n = 1; $n <= 3; $n++ ) {
	$p_title = hum_get_field( "program_phase_{$n}_title", $pid, '' );
	if ( $p_title ) {
		$meta_raw = hum_get_field( "program_phase_{$n}_meta", $pid, '' );
		$phases[] = array(
			'badge' => hum_get_field( "program_phase_{$n}_badge", $pid, "PHASE {$n}" ),
			'title' => $p_title,
			'desc'  => hum_get_field( "program_phase_{$n}_desc", $pid, '' ),
			'tags'  => $meta_raw ? array_filter( array_map( 'trim', explode( ',', $meta_raw ) ) ) : array(),
		);
	}
}
if ( empty( $phases ) ) {
	$phases = array(
		array(
			'badge' => 'PHASE 1: WEEKS 1 – 4',
			'title' => 'Structural Balance & Movement Groove',
			'desc'  => 'Focus on mastering baseline compound movement mechanics (Squat, Overhead Press, Romanian Deadlift, Bench Press). Establishing working 1RM baselines, correcting postural imbalances, and prepping connective tissue for heavy load capacity.',
			'tags'  => array( 'Rep Range: 8–10', 'Volume: Moderate', 'RPE: 7–8' ),
		),
		array(
			'badge' => 'PHASE 2: WEEKS 5 – 8',
			'title' => 'Mechanical Tension & Volume Overload',
			'desc'  => 'This phase triggers maximum muscle fiber recruitment. Incorporating progressive overload with drop sets, rest-pause sets, and specialized hypertrophy accessory work that forces sarcoplasmic and myofibrillar adaptation.',
			'tags'  => array( 'Rep Range: 6–12', 'Volume: High', 'RPE: 8–9' ),
		),
		array(
			'badge' => 'PHASE 3: WEEKS 9 – 12',
			'title' => 'Peak Density, Definition & PR Testing',
			'desc'  => 'The final consolidation phase. Peaking intensity while tuning volume to lock in dense, vascular definition and testing your new compound personal records under Sagar’s direct guidance.',
			'tags'  => array( 'Rep Range: 4–8', 'Volume: Peak Load', 'RPE: 9–9.5' ),
		),
	);
}

$content_html = $pid ? apply_filters( 'the_content', get_post_field( 'post_content', $pid ) ) : '';
if ( '' === trim( wp_strip_all_tags( $content_html ) ) ) {
	$content_html = '<p>Most lifters spend years grinding in the gym without making substantial physical changes because their training lacks progressive overload structure and targeted mechanical tension. The <strong>12-Week Strength &amp; Hypertrophy Acceleration Program</strong> at Hustle Ur Muscle removes all guesswork.</p><p>Engineered directly by Coach Sagar Soma, this protocol blends functional compound barbell work with high-density hypertrophy accessory volume. You will stimulate maximum myofibrillar growth while preserving joint integrity through bio-mechanical form cues.</p>';
}
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-gym">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( strtoupper( $banner_tag ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( strtoupper( $title ) ); ?></h1>
				<p class="page-header-desc"><?php echo esc_html( $excerpt ); ?></p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<a href="<?php echo esc_url( $programs_url ); ?>">PROGRAMS</a>
					<span class="separator">/</span>
					<span class="current"><?php echo esc_html( strtoupper( $title ) ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- Program Details & Sticky Sidebar Section -->
	<section class="section-blog py-5">
		<div class="container px-lg-4 my-4">
			<div class="row g-5">

				<!-- Main Program Content (col-lg-8) -->
				<div class="col-lg-8">
					<div class="single-post-content text-start">

						<!-- Meta Information Strip -->
						<div class="program-meta-strip" data-aos="fade-up">
							<div class="meta-strip-item">
								<div class="meta-strip-label">DURATION</div>
								<div class="meta-strip-val"><?php echo esc_html( strtoupper( $duration ) ); ?></div>
							</div>
							<div class="meta-strip-item">
								<div class="meta-strip-label">INTENSITY</div>
								<div class="meta-strip-val"><?php echo esc_html( strtoupper( $intensity ) ); ?></div>
							</div>
							<div class="meta-strip-item">
								<div class="meta-strip-label">FREQUENCY</div>
								<div class="meta-strip-val"><?php echo esc_html( strtoupper( $frequency ) ); ?></div>
							</div>
							<div class="meta-strip-item">
								<div class="meta-strip-label">PRIMARY GOAL</div>
								<div class="meta-strip-val"><?php echo esc_html( strtoupper( $goal ) ); ?></div>
							</div>
						</div>

						<!-- Featured Image -->
						<img src="<?php echo esc_url( $feat_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="single-post-img-main" data-aos="fade-up">

						<!-- Program Body Content -->
						<div class="single-post-body">
							<h2>Overview: The Science of Muscle Acceleration</h2>
							<?php echo wp_kses_post( $content_html ); ?>

							<?php if ( $quote ) : ?>
								<blockquote class="quote-highlight">
									<?php echo esc_html( $quote ); ?>
									<div class="mt-2 text-danger fw-bold small text-uppercase">— <?php echo esc_html( $quote_author ); ?></div>
								</blockquote>
							<?php endif; ?>

							<h2 class="mt-5 mb-4">Curriculum: 3-Phase Periodization Timeline</h2>
							<?php foreach ( $phases as $phase ) : ?>
								<div class="curriculum-phase-card" data-aos="fade-up">
									<span class="phase-number-badge"><?php echo esc_html( $phase['badge'] ); ?></span>
									<h3 class="phase-card-title"><?php echo esc_html( $phase['title'] ); ?></h3>
									<p class="text-muted mb-3"><?php echo esc_html( $phase['desc'] ); ?></p>
									<?php if ( ! empty( $phase['tags'] ) ) : ?>
										<div class="d-flex flex-wrap gap-2">
											<?php foreach ( $phase['tags'] as $tag ) : ?>
												<span class="badge bg-light text-dark border"><?php echo esc_html( $tag ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>

							<?php if ( ! empty( $included_lines ) ) : ?>
								<h2 class="mt-5 mb-4">What’s Included Inside The Program:</h2>
								<ul class="program-features-list pb-0 border-0 mb-4">
									<?php foreach ( $included_lines as $line ) : ?>
										<?php
										$parts = explode( ':', $line, 2 );
										?>
										<li>
											<i class="fa-solid fa-circle-check text-danger me-2"></i>
											<?php if ( 2 === count( $parts ) ) : ?>
												<strong><?php echo esc_html( trim( $parts[0] ) ); ?>:</strong> <?php echo esc_html( trim( $parts[1] ) ); ?>
											<?php else : ?>
												<?php echo esc_html( $line ); ?>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<!-- Testimonial Highlight Box -->
							<div class="p-4 bg-dark text-white rounded border border-danger my-5" data-aos="fade-up">
								<div class="d-flex align-items-center gap-3 mb-3">
									<img src="<?php echo esc_url( $rev_photo ); ?>" alt="<?php echo esc_attr( $rev_name ); ?>" class="rounded-circle border border-2 border-danger avatar-60">
									<div>
										<h5 class="text-white mb-0 fw-bold"><?php echo esc_html( $rev_name ); ?></h5>
										<small class="text-danger"><?php echo esc_html( $rev_role ); ?></small>
									</div>
								</div>
								<p class="text-white-50 fst-italic mb-0"><?php echo esc_html( $rev_text ); ?></p>
							</div>

							<!-- Program Specific FAQ -->
							<h3 class="heading-font text-uppercase mt-5 mb-3">FREQUENT QUESTIONS ABOUT THIS PLAN</h3>
							<div class="accordion faq-accordion mb-4" id="progFaqAccordion">
								<div class="accordion-item">
									<h2 class="accordion-header" id="pfH1">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pfC1" aria-expanded="true">
											<?php echo esc_html( $faq1_q ); ?>
										</button>
									</h2>
									<div id="pfC1" class="accordion-collapse collapse show" data-bs-parent="#progFaqAccordion">
										<div class="accordion-body"><?php echo esc_html( $faq1_a ); ?></div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="pfH2">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pfC2">
											<?php echo esc_html( $faq2_q ); ?>
										</button>
									</h2>
									<div id="pfC2" class="accordion-collapse collapse" data-bs-parent="#progFaqAccordion">
										<div class="accordion-body"><?php echo esc_html( $faq2_a ); ?></div>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<!-- Sticky Enrollment Sidebar (col-lg-4) -->
				<div class="col-lg-4">
					<aside class="program-pricing-sidebar" data-aos="fade-left">

						<div class="sidebar-price-tag">
							<?php echo esc_html( $price ); ?> <span><?php echo esc_html( $price_unit ); ?></span>
						</div>
						<p class="text-white-50 small mb-4"><?php echo esc_html( $sidebar_desc ); ?></p>

						<a href="#" class="btn-fitness-red w-100 py-3 fs-5 mb-3" data-bs-toggle="modal" data-bs-target="#consultationModal">
							ENROLL IN PROGRAM <i class="fa-solid fa-arrow-right-long ms-2"></i>
						</a>

						<div class="text-center text-white-50 small mb-4">
							<i class="fa-solid fa-shield-check text-success me-1"></i> 100% Satisfaction &amp; Results Guarantee
						</div>

						<div class="pt-4 border-top border-secondary">
							<div class="fw-bold text-uppercase fs-6 mb-3 text-white">WHAT YOU RECEIVE:</div>
							<ul class="list-unstyled text-white-50 small mb-4">
								<?php foreach ( $sidebar_inc as $item ) : ?>
									<li class="mb-2"><i class="fa-solid fa-check text-danger me-2"></i> <?php echo esc_html( $item ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>

						<!-- Coach Box -->
						<div class="pt-4 border-top border-secondary text-center">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/sagar-soma.png' ); ?>" alt="Coach Sagar Soma" class="rounded-circle border border-2 border-danger mb-2 avatar-70">
							<h5 class="text-white mb-0 fw-bold">COACH SAGAR SOMA</h5>
							<small class="text-danger text-uppercase fw-bold">Program Director</small>
							<div class="mt-3">
								<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success btn-sm w-100">
									<i class="fa-brands fa-whatsapp me-1"></i> Ask a Question on WhatsApp
								</a>
							</div>
						</div>

					</aside>
				</div>

			</div>
		</div>
	</section>
