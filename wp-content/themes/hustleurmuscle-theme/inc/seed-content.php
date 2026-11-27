<?php
/**
 * One-Time Idempotent Content & Media Seeder
 * Populates WordPress Pages, CPTs (Slides, Programs, Testimonials, FAQs, Trainers),
 * ACF default field metadata, and Contact Form 7 forms so everything is immediately editable in Dashboard.
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HUM_SEED_VERSION', '1.4.0' );

/**
 * Helper: attach a theme image file into the WP Media Library once and return attachment ID.
 */
function hum_sideload_theme_image( $relative_path ) {
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'meta_key'    => '_hum_source_asset',
			'meta_value'  => $relative_path,
			'numberposts' => 1,
		)
	);
	if ( ! empty( $existing ) ) {
		return (int) $existing[0]->ID;
	}

	$source_file = get_template_directory() . '/' . ltrim( $relative_path, '/' );
	if ( ! file_exists( $source_file ) ) {
		return 0;
	}

	$upload_dir = wp_upload_dir();
	$filename   = wp_unique_filename( $upload_dir['path'], basename( $source_file ) );
	$dest_file  = trailingslashit( $upload_dir['path'] ) . $filename;

	if ( ! @copy( $source_file, $dest_file ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $filename, null );
	$attach   = array(
		'guid'           => trailingslashit( $upload_dir['url'] ) . $filename,
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $source_file ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	$attach_id = wp_insert_attachment( $attach, $dest_file );
	if ( is_wp_error( $attach_id ) || ! $attach_id ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$meta = wp_generate_attachment_metadata( $attach_id, $dest_file );
	wp_update_attachment_metadata( $attach_id, $meta );
	update_post_meta( $attach_id, '_hum_source_asset', $relative_path );

	return (int) $attach_id;
}

/**
 * Helper: insert a CPT post if none with the same post_type exist yet, or check by slug.
 */
function hum_seed_cpt_if_empty( $post_type, $items ) {
	$existing = wp_count_posts( $post_type );
	$total    = isset( $existing->publish ) ? (int) $existing->publish : 0;
	if ( $total > 0 ) {
		return;
	}

	foreach ( $items as $order => $item ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => $post_type,
				'post_title'   => $item['title'],
				'post_content' => isset( $item['content'] ) ? $item['content'] : '',
				'post_excerpt' => isset( $item['excerpt'] ) ? $item['excerpt'] : '',
				'post_status'  => 'publish',
				'menu_order'   => $order + 1,
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		if ( ! empty( $item['thumbnail'] ) ) {
			$thumb_id = hum_sideload_theme_image( $item['thumbnail'] );
			if ( $thumb_id ) {
				set_post_thumbnail( $post_id, $thumb_id );
			}
		}

		if ( ! empty( $item['meta'] ) && is_array( $item['meta'] ) ) {
			foreach ( $item['meta'] as $m_key => $m_val ) {
				if ( is_string( $m_val ) && 0 === strpos( $m_val, 'ASSET:' ) ) {
					$asset_rel = substr( $m_val, 6 );
					$aid       = hum_sideload_theme_image( $asset_rel );
					update_post_meta( $post_id, $m_key, $aid ? $aid : '' );
				} else {
					update_post_meta( $post_id, $m_key, $m_val );
				}
			}
		}

		if ( ! empty( $item['terms'] ) && is_array( $item['terms'] ) ) {
			foreach ( $item['terms'] as $tax => $slugs ) {
				wp_set_object_terms( $post_id, $slugs, $tax );
			}
		}
	}
}

/**
 * Seed default Pages, ACF meta fields, CPT entries, and CF7 forms.
 */
function hum_run_full_seed() {
	// 1. Ensure Pages exist & assign templates
	$pages = array(
		'home'             => array( 'title' => 'Home', 'template' => '' ),
		'about'            => array( 'title' => 'About Us', 'template' => 'page-about.php' ),
		'programs'         => array( 'title' => 'Programs', 'template' => 'page-programs.php' ),
		'program-single'   => array( 'title' => 'Strength & Hypertrophy', 'template' => 'page-program-single.php' ),
		'gallery'          => array( 'title' => 'Gallery', 'template' => 'page-gallery.php' ),
		'faqs'             => array( 'title' => 'FAQs', 'template' => 'page-faqs.php' ),
		'blog'             => array( 'title' => 'Blog', 'template' => '' ),
		'contact'          => array( 'title' => 'Contact', 'template' => 'page-contact.php' ),
		'privacy-policy'   => array( 'title' => 'Privacy Policy', 'template' => 'page-privacy-policy.php' ),
		'terms-conditions' => array( 'title' => 'Terms & Conditions', 'template' => 'page-terms-conditions.php' ),
	);

	$page_ids = array();
	foreach ( $pages as $slug => $data ) {
		$existing = get_page_by_path( $slug );
		if ( $existing instanceof WP_Post ) {
			$pid = (int) $existing->ID;
		} else {
			$pid = wp_insert_post(
				array(
					'post_title'   => $data['title'],
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
		}
		if ( $pid && ! is_wp_error( $pid ) ) {
			if ( ! empty( $data['template'] ) ) {
				update_post_meta( $pid, '_wp_page_template', $data['template'] );
			}
			$page_ids[ $slug ] = (int) $pid;
		}
	}

	if ( isset( $page_ids['home'] ) && 'page' !== get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
	}
	if ( isset( $page_ids['blog'] ) && ! get_option( 'page_for_posts' ) ) {
		update_option( 'page_for_posts', $page_ids['blog'] );
	}

	// 2. Provision Contact Form 7 forms
	if ( function_exists( 'hum_provision_cf7_forms' ) ) {
		hum_provision_cf7_forms();
	}

	// 3. Seed Hero Slides
	hum_seed_cpt_if_empty(
		'hum_slide',
		array(
			array(
				'title'     => 'KEEP YOUR BODY FIT & STRONG',
				'thumbnail' => 'assets/images/hero-bg.jpg',
				'meta'      => array(
					'slide_tag'         => 'COACH SAGAR SOMA — HUSTLE UR MUSCLE',
					'slide_title_top'   => 'KEEP YOUR',
					'slide_highlight'   => 'BODY FIT & STRONG',
					'slide_description' => 'Transform your physique with science-based personal training, tailored nutrition protocols, and 1-on-1 expert coaching designed for life-changing results with Sagar Soma at Hustle Ur Muscle.',
				),
			),
			array(
				'title'     => 'UNLEASH YOUR TRUE POWER & AGILITY',
				'thumbnail' => 'assets/images/about-1.jpg',
				'meta'      => array(
					'slide_tag'         => 'NO PAIN NO GAIN',
					'slide_title_top'   => 'UNLEASH YOUR',
					'slide_highlight'   => 'TRUE POWER & AGILITY',
					'slide_description' => 'Elevate your performance and endurance. Our customized functional strength conditioning at Hustle Ur Muscle unlocks peak athletic capability.',
				),
			),
			array(
				'title'     => 'BUILD LEAN MUSCLE & PEAK RESILIENCE',
				'thumbnail' => 'assets/images/banner-gym.jpg',
				'meta'      => array(
					'slide_tag'         => 'ELITE TRAINING METHOD',
					'slide_title_top'   => 'BUILD LEAN MUSCLE',
					'slide_highlight'   => '& PEAK RESILIENCE',
					'slide_description' => 'Step into the personal training zone with professional equipment, certified guidance from Coach Sagar Soma, and relentless motivation.',
				),
			),
		)
	);

	// 4. Seed Programs (first 4 also populate the 4 Home service cards)
	hum_seed_cpt_if_empty(
		'hum_program',
		array(
			array(
				'title'     => 'STRENGTH & HYPERTROPHY',
				'thumbnail' => 'assets/images/banner-gym.jpg',
				'excerpt'   => 'Scientific progressive overload routines engineered to build dense, functional muscle while packing raw strength onto compound lifts.',
				'content'   => "<p>Most lifters spend years grinding in the gym without making substantial physical changes because their training lacks progressive overload structure and targeted mechanical tension. The <strong>12-Week Strength &amp; Hypertrophy Acceleration Program</strong> at Hustle Ur Muscle removes all guesswork.</p>\n<p>Engineered directly by Coach Sagar Soma, this protocol blends functional compound barbell work with high-density hypertrophy accessory volume. You will stimulate maximum myofibrillar growth while preserving joint integrity through bio-mechanical form cues.</p>",
				'meta'      => array(
					'show_on_home'          => 1,
					'home_icon'             => 'ASSET:assets/images/icon-strength.png',
					'home_subtitle'         => '12 WEEKS TO BUILD MUSCLE',
					'home_excerpt'          => 'Targeted progressive overload protocols designed to build maximum raw power, muscle density, and functional athletic endurance.',
					'program_badge'         => 'HYPERTROPHY',
					'program_duration'      => '12 WEEKS',
					'program_price'         => '$129',
					'program_price_unit'    => '/ plan',
					'program_featured_border' => 0,
					'program_features'      => "4-5 Periodized lifting sessions / week\nCustomized macro diet protocol\nWeekly video lift analysis by Sagar\nMobile app workout tracking",
					'program_banner_tag'    => '12-WEEK TRANSFORMATION',
					'program_intensity'     => 'INTERMEDIATE+',
					'program_frequency'     => '5 DAYS / WK',
					'program_goal'          => 'LEAN MUSCLE',
					'program_quote'         => '"Muscle hypertrophy is not an accident—it is a calculated biological adaptation to progressive tension and intelligent recovery."',
					'program_quote_author'  => 'Coach Sagar Soma',
					'program_phase_1_badge' => 'PHASE 1: WEEKS 1 – 4',
					'program_phase_1_title' => 'Structural Balance & Movement Groove',
					'program_phase_1_desc'  => 'Focus on mastering baseline compound movement mechanics (Squat, Overhead Press, Romanian Deadlift, Bench Press). Establishing working 1RM baselines, correcting postural imbalances, and prepping connective tissue for heavy load capacity.',
					'program_phase_1_meta'  => 'Rep Range: 8–10, Volume: Moderate, RPE: 7–8',
					'program_phase_2_badge' => 'PHASE 2: WEEKS 5 – 8',
					'program_phase_2_title' => 'Mechanical Tension & Volume Overload',
					'program_phase_2_desc'  => 'This phase triggers maximum muscle fiber recruitment. Incorporating progressive overload with drop sets, rest-pause sets, and specialized hypertrophy accessory work that forces sarcoplasmic and myofibrillar adaptation.',
					'program_phase_2_meta'  => 'Rep Range: 6–12, Volume: High, RPE: 8–9',
					'program_phase_3_badge' => 'PHASE 3: WEEKS 9 – 12',
					'program_phase_3_title' => 'Peak Density, Definition & PR Testing',
					'program_phase_3_desc'  => 'The final consolidation phase. Peaking intensity while tuning volume to lock in dense, vascular definition and testing your new compound personal records under Sagar’s direct guidance.',
					'program_phase_3_meta'  => 'Rep Range: 4–8, Volume: Peak Load, RPE: 9–9.5',
					'program_included'      => "Gram-by-Gram Nutrition Blueprint: Tailored specifically to your metabolic rate, body fat percentage, and muscle target.\nHD Exercise Video Demos: Comprehensive video library showing bio-mechanical cues directly by Coach Sagar.\nWeekly Video Form Audits: Upload your heaviest lifting sets for direct critique and adjustments.\nHustle Ur Muscle Mobile App: Digital workout log with rest timers, weight progression charts, and circumference scans.\nDirect Coach WhatsApp Hotline: Priority support whenever you have nutritional or recovery queries.",
					'sidebar_cta_desc'      => 'Complete 12-Week Access & Personalized Coaching Blueprint.',
					'sidebar_includes'      => "Instant Download & Mobile App Login\nCustom Macro Meal Plan by Sagar Soma\n12 Weeks of Periodized Workouts\nWeekly Video Form Critique\nDirect Coach WhatsApp Channel",
					'program_review_name'   => 'Steve Rogers',
					'program_review_role'   => 'Strength Athlete • Gained 9 lbs Lean Mass',
					'program_review_text'   => '"Following Coach Sagar’s 12-week hypertrophy program took my bench from 225 to 275 and completely reshaped my shoulders and back. The weekly video check-ins kept my form sharp and injury-free. Best investment I\'ve made in fitness."',
					'program_review_photo'  => 'ASSET:assets/images/client-2.jpg',
					'program_faq_1_q'       => 'What gym equipment is needed for this program?',
					'program_faq_1_a'       => 'Standard commercial gym equipment: Olympic barbells, squat rack, adjustable bench, dumbbells, cable station, and basic leg machines (leg press/leg curl).',
					'program_faq_2_q'       => 'Can I do this program if I am vegetarian?',
					'program_faq_2_a'       => 'Yes! Coach Sagar provides custom vegetarian meal options using high-leucine proteins such as paneer, whey isolate, soy, Greek yogurt, lentils, and amino acid pairings.',
				),
			),
			array(
				'title'     => 'HEALTH & CARDIO MOBILITY',
				'thumbnail' => 'assets/images/goal-2.jpg',
				'excerpt'   => 'Holistic cardiovascular conditioning, functional mobility drills, and stamina sessions designed to boost vitality and longevity.',
				'content'   => '<p>Engineered to improve cardiovascular endurance, joint flexibility, and everyday athletic vitality through low-impact conditioning and core stability routines.</p>',
				'meta'      => array(
					'show_on_home'       => 1,
					'home_icon'          => 'ASSET:assets/images/icon-health.png',
					'home_subtitle'      => '7 WEEKS TO SHAPE YOUR BODY',
					'home_excerpt'       => 'Holistic cardiovascular conditioning, mobility drills, and stamina sessions crafted to boost vitality and longevity.',
					'program_badge'      => 'HEALTH',
					'program_duration'   => '7 WEEKS',
					'program_price'      => '$89',
					'program_price_unit' => '/ plan',
					'program_features'   => "Aerobic capacity & VO2 max pacing\nJoint mobility & spinal posture\nAnti-inflammatory meal strategies\nPerfect for desk-bound workers",
					'program_banner_tag' => '7-WEEK CONDITIONING',
					'program_intensity'  => 'ALL LEVELS',
					'program_frequency'  => '4 DAYS / WK',
					'program_goal'       => 'VITALITY & STAMINA',
				),
			),
			array(
				'title'     => 'RAPID FAT LOSS & CONDITIONING',
				'thumbnail' => 'assets/images/about-1.jpg',
				'excerpt'   => 'High-efficiency metabolic circuits combined with sustainable caloric budgeting to strip stubborn fat while preserving lean muscle mass.',
				'content'   => '<p>A structured 8-week metabolic fat-loss system combining sustainable caloric deficits, resistance circuits, and weekly body scan accountability.</p>',
				'meta'      => array(
					'show_on_home'       => 1,
					'home_icon'          => 'ASSET:assets/images/icon-weight-loss.png',
					'home_subtitle'      => '8 WEEKS TO LOSE EXTRA WEIGHT',
					'home_excerpt'       => 'High-efficiency calorie burn circuits paired with balanced nutritional meal plans for sustainable, rapid fat reduction.',
					'program_badge'      => 'FAT LOSS',
					'program_duration'   => '8 WEEKS',
					'program_price'      => '$99',
					'program_price_unit' => '/ plan',
					'program_features'   => "High-intensity anaerobic intervals\nCaloric deficit with macro balance\nWeekly body circumference scans\n24/7 WhatsApp coach guidance",
					'program_banner_tag' => '8-WEEK FAT LOSS',
					'program_intensity'  => 'MODERATE - HIGH',
					'program_frequency'  => '5 DAYS / WK',
					'program_goal'       => 'RAPID FAT LOSS',
				),
			),
			array(
				'title'     => 'VIP 1-ON-1 COACHING',
				'thumbnail' => 'assets/images/contact-trainer.jpg',
				'excerpt'   => 'Direct personal mentorship with Coach Sagar Soma. Maximum accountability, bespoke exercise selections, and private gym hours.',
				'content'   => '<p>Exclusive private mentorship directly with Coach Sagar Soma featuring weekly biomechanics assessments, real-time programming adjustments, and priority hotline support.</p>',
				'meta'      => array(
					'show_on_home'            => 1,
					'home_icon'               => 'ASSET:assets/images/icon-personal-coach.png',
					'home_subtitle'           => 'GET THE BODY OF YOUR DREAMS',
					'home_excerpt'            => 'Exclusive 1-on-1 private mentoring with Coach Sagar Soma, weekly biomechanics checkups, and bespoke coaching.',
					'program_badge'           => 'VIP PRIVATE',
					'program_duration'        => '16 WEEKS',
					'program_price'           => '$249',
					'program_price_unit'      => '/ mo',
					'program_featured_border' => 1,
					'program_features'        => "1-on-1 mentoring with Coach Sagar\nWeekly private biomechanics scans\nReal-time workout modifications\nPriority direct hotline access",
					'program_banner_tag'      => 'PRIVATE MENTORSHIP',
					'program_intensity'       => 'TAILORED',
					'program_frequency'       => 'CUSTOM',
					'program_goal'            => 'TOTAL TRANSFORMATION',
				),
			),
			array(
				'title'     => 'GLOBAL DISTANCE COACHING',
				'thumbnail' => 'assets/images/blog-2.jpg',
				'excerpt'   => 'Live anywhere in the world and train directly with Sagar. Complete digital coaching app integration with video technique feedback.',
				'content'   => '<p>Train from any gym or home setup worldwide with full mobile app periodization, video form critiques, and weekly strategy calls with Coach Sagar Soma.</p>',
				'meta'      => array(
					'show_on_home'       => 0,
					'program_badge'      => 'VIRTUAL',
					'program_duration'   => '12 WEEKS',
					'program_price'      => '$119',
					'program_price_unit' => '/ mo',
					'program_features'   => "Dedicated mobile workout app\nHD exercise video demonstrations\nWeekly Zoom progress strategy calls\nFlexible home/hotel gym alternatives",
					'program_banner_tag' => 'ONLINE COACHING',
					'program_intensity'  => 'CUSTOMIZED',
					'program_frequency'  => '4–5 DAYS / WK',
					'program_goal'       => 'REMOTE RESULTS',
				),
			),
			array(
				'title'     => 'POWERLIFTING & FORM MASTERY',
				'thumbnail' => 'assets/images/blog-3.jpg',
				'excerpt'   => 'Master the barbell. Dissect your squat, bench press, and deadlift mechanics to break plateaus and lift pain-free with maximum leverage.',
				'content'   => '<p>A focused 10-week peaking and biomechanics cycle designed to elevate your squat, bench press, and deadlift numbers safely and efficiently.</p>',
				'meta'      => array(
					'show_on_home'       => 0,
					'program_badge'      => 'POWER',
					'program_duration'   => '10 WEEKS',
					'program_price'      => '$139',
					'program_price_unit' => '/ plan',
					'program_features'   => "Kinematic video form breakdown\nCentral nervous system management\nPeaking cycle for personal records\nAuxiliary accessory lift protocols",
					'program_banner_tag' => 'STRENGTH PEAKING',
					'program_intensity'  => 'HIGH',
					'program_frequency'  => '4 DAYS / WK',
					'program_goal'       => 'MAX STRENGTH',
				),
			),
		)
	);

	// 5. Seed Testimonials
	hum_seed_cpt_if_empty(
		'hum_testimonial',
		array(
			array(
				'title'     => 'DONNA COLE',
				'thumbnail' => 'assets/images/client-1.jpg',
				'meta'      => array(
					'client_role'       => 'Client • Lost 16 lbs',
					'testimonial_quote' => '"Training with Sagar Soma at Hustle Ur Muscle completely reshaped my fitness journey. In just 12 weeks I dropped 16 lbs of pure fat and gained solid muscle tone. The nutrition plan was so easy to follow!"',
					'rating_stars'      => 5,
				),
			),
			array(
				'title'     => 'STEVE ROGERS',
				'thumbnail' => 'assets/images/client-2.jpg',
				'meta'      => array(
					'client_role'       => 'Client • Strength Athlete',
					'testimonial_quote' => '"Coach Sagar\'s guidance is attentive, professional, and kept me motivated every single workout session. Hustle Ur Muscle provided the exact environment I needed to succeed."',
					'rating_stars'      => 5,
				),
			),
			array(
				'title'     => 'ALEX MORGAN',
				'thumbnail' => 'assets/images/client-3.jpg',
				'meta'      => array(
					'client_role'       => 'Client • Muscle Toning',
					'testimonial_quote' => '"As an entrepreneur, I struggled to stay consistent. The personalized workouts and meal strategies from Hustle Ur Muscle fit seamlessly into my schedule. Highest level of coaching!"',
					'rating_stars'      => 5,
				),
			),
			array(
				'title'     => 'MARCUS VANCE',
				'thumbnail' => 'assets/images/client-4.jpg',
				'meta'      => array(
					'client_role'       => 'Client • Powerlifting',
					'testimonial_quote' => '"The atmosphere and expertise at Hustle Ur Muscle are unmatched. Sagar corrected my squat mechanics within two sessions, preventing injury and boosting my personal records."',
					'rating_stars'      => 5,
				),
			),
		)
	);

	// 6. Seed FAQs (8 items; first 4 also appear on Contact page)
	hum_seed_cpt_if_empty(
		'hum_faq',
		array(
			array(
				'title'   => '1. How do I get started with Coach Sagar Soma?',
				'content' => 'Getting started is straightforward. You can either book a complimentary 1-on-1 consultation through our website or reach out directly on WhatsApp. During this first session, Coach Sagar evaluates your current posture, movement mechanics, training history, and lifestyle factors to map out your customized periodized program.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 1 ),
			),
			array(
				'title'   => '2. What makes Hustle Ur Muscle different from a regular gym membership?',
				'content' => 'In commercial gyms, you are left to figure out workouts alone, leading to frustration and injury. At Hustle Ur Muscle, every workout is monitored, structured, and logged. Coach Sagar provides bio-mechanical cueing, customized nutrition with macro flexibility, and weekly accountability check-ins so you never hit a plateau.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 0 ),
			),
			array(
				'title'   => '3. Can beginners with zero lifting experience join?',
				'content' => 'Absolutely! More than 45% of our successful clients had never stepped into a weight room before training with Sagar Soma. We emphasize proper movement foundations, safety, and progressive overload at a pace suited to your biomechanics.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 1 ),
			),
			array(
				'title'   => '4. How does distance / online coaching work?',
				'content' => 'Clients worldwide train with Sagar through our distance coaching program. You receive customized workout splits and meal plans via our app, upload form videos for critique, and have weekly 1-on-1 strategy video calls to evaluate progress and make adjustments.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 1 ),
			),
			array(
				'title'   => '5. Do I need to follow a strict or boring meal plan?',
				'content' => 'No crash diets or bland boiled food! We focus on flexible macronutrient budgeting. Coach Sagar tailors meal strategies according to your cultural, dietary (vegetarian, vegan, or non-veg), and schedule preferences while ensuring optimum protein and micronutrient thresholds are met.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 1 ),
			),
			array(
				'title'   => '6. Can I train if I have previous injuries or lower back pain?',
				'content' => 'Yes. Coach Sagar specializes in corrective exercise and joint-friendly training variations. We work around existing limitations, strengthen stabilizer muscles, and correct muscular imbalances to rehabilitate your body safely.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 0 ),
			),
			array(
				'title'   => '7. How fast can I expect to see visible physical changes?',
				'content' => 'With 100% adherence to Coach Sagar\'s protocol, most clients observe significant improvements in energy, core strength, and stamina within 2 to 3 weeks. Visible fat loss and muscle tone typically become prominent within 4 to 8 weeks.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 0 ),
			),
			array(
				'title'   => '8. What equipment is available at the Hustle Ur Muscle facility?',
				'content' => 'Our 2,000 m² club features competition Olympic barbells, calibrated bumper plates, functional power racks, dual adjustable pulleys, specialized hypertrophy machines, battle ropes, sled tracks, and private assessment rooms.',
				'meta'    => array( 'show_in_faqs_page' => 1, 'show_on_contact' => 0 ),
			),
		)
	);

	// 7. Seed Trainers
	hum_seed_cpt_if_empty(
		'hum_trainer',
		array(
			array(
				'title'     => 'SAGAR SOMA',
				'thumbnail' => 'assets/images/sagar-soma.png',
				'meta'      => array(
					'trainer_role'      => 'Head Coach & Founder',
					'trainer_bio'       => 'Specialist in Hypertrophy, Body Recomposition & Biomechanics.',
					'trainer_instagram' => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
					'trainer_facebook'  => 'https://www.facebook.com/hustleurmuscle/',
					'trainer_whatsapp'  => 'https://wa.me/',
				),
			),
			array(
				'title'     => 'ALEX VANCE',
				'thumbnail' => 'assets/images/trainer-2.jpg',
				'meta'      => array(
					'trainer_role'      => 'Senior Strength Specialist',
					'trainer_bio'       => 'Focus on Powerlifting, Olympic Lifts & Core Stability.',
					'trainer_instagram' => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
					'trainer_facebook'  => 'https://www.facebook.com/hustleurmuscle/',
				),
			),
			array(
				'title'     => 'ELENA ROCHE',
				'thumbnail' => 'assets/images/trainer-3.jpg',
				'meta'      => array(
					'trainer_role'      => 'Lead Nutritionist & HIIT Coach',
					'trainer_bio'       => 'Specialist in High-Intensity Conditioning & Metabolic Health.',
					'trainer_instagram' => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
					'trainer_facebook'  => 'https://www.facebook.com/hustleurmuscle/',
				),
			),
		)
	);

	// 8. Seed Footer (hum_footer CPT)
	hum_seed_cpt_if_empty(
		'hum_footer',
		array(
			array(
				'title' => 'Main Site Footer',
				'meta'  => array(
					'footer_logo'            => 'ASSET:assets/images/logo-transparent.png',
					'footer_banner_heading'  => "JOIN HUSTLE UR MUSCLE TO\nSTART A NEW LIFE",
					'footer_founder_label'   => 'HEAD COACH & FOUNDER:',
					'footer_founder_name'    => 'SAGAR SOMA',
					'footer_cta_text'        => 'JOIN NOW',
					'footer_cta_url'         => '',
					'footer_about_title'     => 'ABOUT HUSTLE UR MUSCLE',
					'footer_about_text'      => 'Hustle Ur Muscle, founded by Coach Sagar Soma, is dedicated to scientific strength conditioning, body transformation, and empowering individuals with peak athletic discipline.',
					'footer_email'           => 'info@hustleurmuscle.in',
					'footer_phone'           => '9948660025',
					'footer_location'        => 'Hustle Ur Muscle Training Club',
					'footer_social_title'    => 'SOCIAL',
					'footer_facebook_url'    => 'https://www.facebook.com/hustleurmuscle/',
					'footer_instagram_url'   => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
					'footer_twitter_url'     => 'https://twitter.com',
					'footer_youtube_url'     => 'https://youtube.com',
					'footer_links_title'     => 'QUICK LINKS',
					'footer_quick_links'     => "Home | /\nAbout Us | /about/\nPrograms | /programs/\nGallery | /gallery/\nFAQs | /faqs/\nBlog | /blog/\nContact | /contact/",
					'footer_instagram_title' => 'INSTAGRAM',
					'footer_reel_1'          => 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4',
					'footer_reel_1_img'      => 'ASSET:assets/images/hero-bg.jpg',
					'footer_reel_2'          => 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj',
					'footer_reel_2_img'      => 'ASSET:assets/images/trainer-2.jpg',
					'footer_reel_3'          => 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==',
					'footer_reel_3_img'      => 'ASSET:assets/images/about-2.jpg',
					'footer_reel_4'          => 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4',
					'footer_reel_4_img'      => 'ASSET:assets/images/banner-gym.jpg',
					'footer_reel_5'          => 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj',
					'footer_reel_5_img'      => 'ASSET:assets/images/trainer-3.jpg',
					'footer_reel_6'          => 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==',
					'footer_reel_6_img'      => 'ASSET:assets/images/contact-trainer.jpg',
					'footer_copyright'       => 'Hustle Ur Muscle © {year}. All rights reserved. Directed by Coach Sagar Soma.',
					'footer_privacy_label'   => 'Privacy Policy',
					'footer_privacy_url'     => '',
					'footer_terms_label'     => 'Terms & Conditions',
					'footer_terms_url'       => '',
				),
			),
		)
	);

	// 9. Seed Header (hum_header CPT)
	hum_seed_cpt_if_empty(
		'hum_header',
		array(
			array(
				'title' => 'Main Site Header',
				'meta'  => array(
					'header_logo'             => 'ASSET:assets/images/logo-transparent.png',
					'header_favicon'          => 'ASSET:assets/images/favicon.png',
					'header_brand_main'       => 'HUSTLE UR',
					'header_brand_highlight'  => 'MUSCLE',
					'header_brand_subtext'    => 'BY SAGAR SOMA',
					'header_brand_url'        => '',
					'header_instagram_url'    => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
					'header_facebook_url'     => 'https://www.facebook.com/hustleurmuscle/',
					'header_show_search'      => 1,
					'header_show_bmi'         => 1,
					'header_cta_text'         => 'GET STARTED',
					'header_cta_url'          => '',
					'header_show_quick_tools' => 1,
					'header_show_whatsapp'    => 1,
					'header_whatsapp_url'     => 'https://wa.me/',
					'header_contact_url'      => '',
					'header_show_back_to_top' => 1,
				),
			),
		)
	);

	// 10. Seed Gallery Categories & Starter Items (hum_gallery CPT + hum_gallery_cat)
	$gallery_cats = array(
		'workout'           => 'Workout',
		'group-training'    => 'Group Training',
		'personal-training' => 'Personal (1-on-1) Training',
		'massage-training'  => 'Massage Training',
		'diet-food'         => 'Diet Food',
	);
	foreach ( $gallery_cats as $cat_slug => $cat_name ) {
		if ( ! term_exists( $cat_slug, 'hum_gallery_cat' ) ) {
			wp_insert_term( $cat_name, 'hum_gallery_cat', array( 'slug' => $cat_slug ) );
		}
	}

	hum_seed_cpt_if_empty(
		'hum_gallery',
		array(
			array(
				'title'     => 'High-Intensity Barbell & Strength Workout',
				'thumbnail' => 'assets/images/banner-gym.jpg',
				'terms'     => array( 'hum_gallery_cat' => array( 'workout' ) ),
				'meta'      => array(
					'gallery_media_type' => 'photo',
					'gallery_caption'    => 'Progressive overload barbell and compound resistance work inside Hustle Ur Muscle.',
				),
			),
			array(
				'title'     => 'Group Conditioning & Team Circuit',
				'thumbnail' => 'assets/images/blog-3.jpg',
				'terms'     => array( 'hum_gallery_cat' => array( 'group-training' ) ),
				'meta'      => array(
					'gallery_media_type' => 'photo',
					'gallery_caption'    => 'High-energy group metabolic conditioning and battle ropes sessions.',
				),
			),
			array(
				'title'     => '1-on-1 Private Coaching With Sagar Soma',
				'thumbnail' => 'assets/images/sagar-soma.png',
				'terms'     => array( 'hum_gallery_cat' => array( 'personal-training' ) ),
				'meta'      => array(
					'gallery_media_type' => 'photo',
					'gallery_caption'    => 'Direct biomechanical assessment and personalized form coaching with Head Coach Sagar Soma.',
				),
			),
			array(
				'title'     => 'Recovery, Stretching & Massage Training',
				'thumbnail' => 'assets/images/blog-5.jpg',
				'terms'     => array( 'hum_gallery_cat' => array( 'massage-training' ) ),
				'meta'      => array(
					'gallery_media_type' => 'photo',
					'gallery_caption'    => 'Guided myofascial release, mobility therapy, and post-lift muscular recovery.',
				),
			),
			array(
				'title'     => 'Clean Macro Nutrition & Diet Food',
				'thumbnail' => 'assets/images/blog-1.jpg',
				'terms'     => array( 'hum_gallery_cat' => array( 'diet-food' ) ),
				'meta'      => array(
					'gallery_media_type' => 'photo',
					'gallery_caption'    => 'Balanced high-protein meals and sustainable macro meal prep engineered for lean gains.',
				),
			),
			array(
				'title'     => 'Athletic Training Video Showcase',
				'thumbnail' => 'assets/images/hero-bg.jpg',
				'terms'     => array( 'hum_gallery_cat' => array( 'workout' ) ),
				'meta'      => array(
					'gallery_media_type' => 'video',
					'gallery_video_url'  => 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4',
					'gallery_caption'    => 'Replace with any YouTube, Instagram, or MP4 upload in Dashboard → Gallery.',
				),
			),
		)
	);

	// 11. Pre-fill default ACF page fields (non-destructive: only sets if empty)
	if ( isset( $page_ids['home'] ) ) {
		$home_defaults = array(
			'site_phone'          => '9948660025',
			'site_email'          => 'info@hustleurmuscle.in',
			'site_club_name'      => 'Hustle Ur Muscle Training Club',
			'site_whatsapp_url'   => 'https://wa.me/',
			'site_instagram_url'  => 'https://www.instagram.com/ssagarsomahustleurmuscle/',
			'site_facebook_url'   => 'https://www.facebook.com/hustleurmuscle/',
			'site_twitter_url'    => 'https://twitter.com',
			'site_youtube_url'    => 'https://youtube.com',
			'site_reel_1'         => 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4',
			'site_reel_2'         => 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj',
			'site_reel_3'         => 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==',
			'site_reel_4'         => 'https://www.instagram.com/reel/DZozDKoi8xf/?hvrq=bzN0cTdjYjM2a2d4',
			'site_reel_5'         => 'https://www.instagram.com/reel/DZP9VWWS_ae/?jplx=NXNwZDlxNm1oeWlj',
			'site_reel_6'         => 'https://www.instagram.com/reel/DLKqflwhSqb/?avpt=MWExNzBvazE2czBvYg==',
			'home_about_tag'      => 'TRAIN WITH SAGAR SOMA',
			'home_about_title_1'  => 'FULL-SERVICE',
			'home_about_title_2'  => 'FITNESS CLUB & GYM',
			'home_about_lead'     => 'Welcome to Hustle Ur Muscle training program.',
			'home_about_desc'     => 'At Hustle Ur Muscle, Coach Sagar Soma brings years of high-performance athletic training experience, dedicated to helping you sculpt your dream body, break personal records, and achieve sustainable wellness through customized science-based routines and nutritional precision.',
			'home_about_years'    => 12,
			'home_services_tag'   => 'HEALTHY LIFE',
			'home_services_title' => 'INDIVIDUAL FITNESS AND NUTRITION PLANS, DEVELOPED WITH CARE AND BASED ON YEARS OF EXPERIENCE.',
			'home_services_divider' => 'SAGAR SOMA',
			'home_goal_tag'       => 'ABOUT COACH SAGAR SOMA',
			'home_goal_title'     => 'OUR GOAL IS TO MAKE YOU STRONG & HEALTHY',
			'home_goal_lead'      => 'There are 2,000 square meters of our personal trainer zone at Hustle Ur Muscle, equipped with best-in-class gear and coaching by Sagar Soma designed to push your limits.',
			'home_goal_checklist' => "Personalized training plans tailored to your body type and current fitness level\nComprehensive nutrition guidance with simple, delicious and sustainable meal prep\nConstant progress tracking with weekly check-ins and scientific body metrics",
			'home_banner_1_tag'   => 'CUSTOM NUTRITION',
			'home_banner_1_title' => 'WANT TO START NOW?',
			'home_banner_1_desc'  => 'Get an individual meal and workout plan crafted for your lifestyle by Hustle Ur Muscle.',
			'home_banner_1_btn'   => 'GET A PLAN',
			'home_banner_2_tag'   => 'JOIN OUR TEAM',
			'home_banner_2_title' => 'WANT TO WORK WITH US?',
			'home_banner_2_desc'  => "Passionate about coaching? Join Sagar Soma's elite Hustle Ur Muscle fitness community.",
			'home_banner_2_btn'   => 'JOIN TEAM',
			'home_test_tag'       => 'TESTIMONIALS',
			'home_test_title'     => 'OUR CLIENTS CHOOSE US BECAUSE WE ARE THE BEST',
			'home_contact_tag'    => 'SEND US A LINE',
			'home_contact_title'  => 'HAVE QUESTIONS? GET IN TOUCH WITH SAGAR!',
			'home_blog_tag'       => 'LATEST NEWS',
			'home_blog_title'     => 'LATEST ARTICLES',
		);
		foreach ( $home_defaults as $k => $v ) {
			if ( '' === get_post_meta( $page_ids['home'], $k, true ) ) {
				update_post_meta( $page_ids['home'], $k, $v );
			}
		}
	}

	if ( isset( $page_ids['about'] ) ) {
		$about_defaults = array(
			'about_banner_tag'    => 'WHO WE ARE',
			'about_banner_title'  => 'ABOUT HUSTLE UR MUSCLE',
			'about_banner_desc'   => 'Founded by Coach Sagar Soma, we are on a relentless mission to build stronger bodies, bulletproof mindsets, and sustainable athletic lifestyles.',
			'about_story_tag'     => 'THE HUSTLE STORY',
			'about_story_title_1' => 'WE ARE PASSIONATE ABOUT',
			'about_story_title_2' => 'REAL TRANSFORMATION',
			'about_story_lead'    => 'Founded by Head Coach Sagar Soma',
			'about_story_p1'      => 'Hustle Ur Muscle was created out of a desire to eliminate the guesswork, fad diets, and generic routines that dominate the fitness industry. Coach Sagar Soma developed a scientifically backed, results-driven coaching framework that bridges the gap between raw discipline and nutritional intelligence.',
			'about_story_p2'      => 'With 12+ years in personal physical conditioning, Sagar has helped hundreds of clients—from complete gym beginners to elite athletes—shatter plateaus, lose stubborn fat, and build dense muscular aesthetics.',
			'about_story_checks'  => "Certified Bio-mechanics Form\nFlexible Macro Nutrition\nPrivate 1-on-1 Mentorship\nIn-Gym & Virtual Remote",
			'pillar_1_title'      => 'SCIENCE-BASED DESIGN',
			'pillar_1_desc'       => 'No generic cookie-cutter templates. Every exercise, rep scheme, and rest period is chosen according to your structural mechanics.',
			'pillar_2_title'      => 'CUSTOM MACRO DIETS',
			'pillar_2_desc'       => 'Enjoy wholesome nutrition with precise protein, carbohydrate, and fat allocations that fuel workouts while keeping hunger under control.',
			'pillar_3_title'      => 'WEEKLY AUDITS',
			'pillar_3_desc'       => 'We track circumference scans, scale metrics, and strength progression weekly, adjusting your volume to eliminate stagnation.',
			'pillar_4_title'      => 'UNSTOPPABLE MOTIVATION',
			'pillar_4_desc'       => 'Direct access to Coach Sagar Soma. Whenever you struggle with consistency or mindset, you have an expert pushing you forward.',
		);
		foreach ( $about_defaults as $k => $v ) {
			if ( '' === get_post_meta( $page_ids['about'], $k, true ) ) {
				update_post_meta( $page_ids['about'], $k, $v );
			}
		}
	}

	if ( isset( $page_ids['contact'] ) ) {
		$contact_defaults = array(
			'contact_banner_tag'     => 'REACH OUT ANYTIME',
			'contact_banner_title'   => 'CONTACT COACH SAGAR SOMA',
			'contact_banner_desc'    => 'Ready to start your body transformation at Hustle Ur Muscle? Connect with Coach Sagar directly for 1-on-1 coaching, customized meal blueprints, or gym membership inquiries.',
			'contact_loc_title'      => 'OUR LOCATION',
			'contact_loc_line1'      => '123 Fitness Boulevard, Suite 500',
			'contact_loc_line2'      => 'New York, NY 10001',
			'contact_phone_subtext'  => 'Instant Coach Hotline',
			'contact_coach_quote'    => '"Whether your objective is gaining dense lean muscle, stripping off unwanted fat, or correcting your lifting biomechanics, I review every single message personally. Let\'s design the exact protocol your body needs."',
			'contact_map_url'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d-74.119763973046!3d40.69766374874431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin',
			'contact_directions_url' => 'https://maps.google.com',
			'contact_parking_note'   => 'Ample parking & locker room facilities available',
		);
		foreach ( $contact_defaults as $k => $v ) {
			if ( '' === get_post_meta( $page_ids['contact'], $k, true ) ) {
				update_post_meta( $page_ids['contact'], $k, $v );
			}
		}
	}

	// Flush rewrite rules for newly registered CPT permalinks (/training-program/...)
	flush_rewrite_rules();
	update_option( 'hum_seed_version', HUM_SEED_VERSION );
}
add_action( 'after_switch_theme', 'hum_run_full_seed' );

/**
 * Also run seeding once in admin_init if updating an already-active theme.
 */
function hum_maybe_seed_on_admin_init() {
	if ( HUM_SEED_VERSION !== get_option( 'hum_seed_version' ) ) {
		hum_run_full_seed();
	}
}
add_action( 'admin_init', 'hum_maybe_seed_on_admin_init' );
