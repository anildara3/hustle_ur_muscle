<?php
/**
 * Front Page Template (Home Page — CPT + ACF Free + Contact Form 7 powered)
 *
 * @package HustleUrMuscle
 */

get_header();

$theme_uri          = get_template_directory_uri();
$front_id           = get_queried_object_id();
$phone              = hustleurmuscle_get_option( 'hum_phone', '9948660025' );
$phone_href         = preg_replace( '/[^0-9+]/', '', $phone );
$programs_url       = hustleurmuscle_get_page_url( array( 'programs' ) );
$program_single_url = hustleurmuscle_get_page_url( array( 'program-single' ) );
$blog_url           = hustleurmuscle_get_page_url( array( 'blog' ) );
$slides             = hum_get_hero_slides_data();
$first_slide        = $slides[0];
?>

	<!-- ===================================================================
	     HERO SECTION (BANNER WITH SLIDER - hum_slide CPT)
	     =================================================================== -->
	<section class="hero-section" id="hero">
		<div class="hero-slider-container">
			<?php foreach ( $slides as $idx => $s ) : ?>
				<div class="hero-slide<?php echo 0 === $idx ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( $idx ); ?>" style="background-image: url('<?php echo esc_url( $s['image'] ); ?>');"></div>
			<?php endforeach; ?>
		</div>

		<div class="container-fluid px-lg-5 position-relative z-index-5">
			<div class="row min-vh-100 align-items-center">
				<div class="col-xl-7 col-lg-8 col-md-10">
					<div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
						<span class="hero-tag" id="heroTag"><?php echo esc_html( $first_slide['tag'] ); ?></span>

						<h1 class="hero-title" id="heroTitle">
							<?php echo wp_kses( $first_slide['title'], array( 'span' => array( 'class' => array() ) ) ); ?>
						</h1>

						<p class="hero-description" id="heroDesc">
							<?php echo esc_html( $first_slide['description'] ); ?>
						</p>

						<div class="hero-btn-group">
							<a href="#services" class="btn-fitness-red">
								OUR PROGRAMS <i class="fa-solid fa-arrow-right-long"></i>
							</a>
							<a href="#" class="btn-fitness-outline" data-bs-toggle="modal" data-bs-target="#consultationModal">
								FREE TRIAL SESSION
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Hero Numeric Slider Pagination -->
		<div class="hero-pagination">
			<?php foreach ( $slides as $idx => $s ) : ?>
				<span class="hero-dot<?php echo 0 === $idx ? ' active' : ''; ?>" data-index="<?php echo esc_attr( $idx ); ?>">
					<?php echo esc_html( str_pad( (string) ( $idx + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
				</span>
			<?php endforeach; ?>
		</div>
	</section>

	<!-- ===================================================================
	     SECTION 2: FULL-SERVICE FITNESS CLUB & GYM (DARK - ACF Fields)
	     =================================================================== -->
	<section class="section-full-service" id="about">
		<div class="container px-lg-4">
			<div class="row align-items-center g-5">

				<div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
					<span class="section-tag with-line"><?php echo esc_html( hum_get_field( 'home_about_tag', $front_id, 'TRAIN WITH SAGAR SOMA' ) ); ?></span>

					<h2 class="about-title">
						<?php echo esc_html( hum_get_field( 'home_about_title_1', $front_id, 'FULL-SERVICE' ) ); ?>
						<span class="text-danger-custom"><?php echo esc_html( hum_get_field( 'home_about_title_2', $front_id, 'FITNESS CLUB & GYM' ) ); ?></span>
					</h2>

					<h5 class="about-lead"><?php echo esc_html( hum_get_field( 'home_about_lead', $front_id, 'Welcome to Hustle Ur Muscle training program.' ) ); ?></h5>

					<p class="about-desc">
						<?php echo esc_html( hum_get_field( 'home_about_desc', $front_id, 'At Hustle Ur Muscle, Coach Sagar Soma brings years of high-performance athletic training experience, dedicated to helping you sculpt your dream body, break personal records, and achieve sustainable wellness through customized science-based routines and nutritional precision.' ) ); ?>
					</p>

					<!-- Contact Phone Box -->
					<div class="about-phone-box">
						<div class="phone-icon-circle">
							<i class="fa-solid fa-phone-volume"></i>
						</div>
						<div>
							<div class="phone-details-title">HAVE QUESTIONS? CALL ANYTIME:</div>
							<a href="<?php echo esc_attr( 'tel:' . $phone_href ); ?>" class="phone-number"><?php echo esc_html( $phone ); ?></a>
						</div>
					</div>
				</div>

				<div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
					<div class="about-collage">
						<div class="about-img-main-wrap">
							<img src="<?php echo esc_url( hum_get_image_url( 'home_about_img_1', $front_id, 'assets/images/about-1.jpg' ) ); ?>" alt="Fitness Training with Barbell" class="about-img-main">
						</div>

						<div class="about-img-overlay-card">
							<img src="<?php echo esc_url( hum_get_image_url( 'home_about_img_2', $front_id, 'assets/images/about-2.jpg' ) ); ?>" alt="Personal Trainer Coach" class="about-img-sub">
						</div>

						<?php $exp_years = hum_get_field( 'home_about_years', $front_id, '12' ); ?>
						<div class="experience-badge">
							<div class="experience-years count-number" data-count="<?php echo esc_attr( $exp_years ); ?>"><?php echo esc_html( $exp_years ); ?></div>
							<div class="experience-label">YEARS OF<br>EXPERIENCE</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     SECTION 3: INDIVIDUAL FITNESS & NUTRITION PLANS (hum_program CPT)
	     =================================================================== -->
	<section class="section-services text-center" id="services">
		<div class="container px-lg-4">

			<span class="section-tag tag-center" data-aos="fade-up"><?php echo esc_html( hum_get_field( 'home_services_tag', $front_id, 'HEALTHY LIFE' ) ); ?></span>
			<h2 class="services-title" data-aos="fade-up" data-aos-delay="100">
				<?php echo esc_html( hum_get_field( 'home_services_title', $front_id, 'INDIVIDUAL FITNESS AND NUTRITION PLANS, DEVELOPED WITH CARE AND BASED ON YEARS OF EXPERIENCE.' ) ); ?>
			</h2>
			<div class="trainer-name-divider" data-aos="fade-up" data-aos-delay="150">
				<span class="trainer-name-text"><?php echo esc_html( hum_get_field( 'home_services_divider', $front_id, 'SAGAR SOMA' ) ); ?></span>
			</div>

			<!-- 4 Service Cards Grid -->
			<div class="row g-4">
				<?php
				$home_programs = new WP_Query(
					array(
						'post_type'      => 'hum_program',
						'posts_per_page' => 4,
						'post_status'    => 'publish',
						'meta_key'       => 'show_on_home',
						'meta_value'     => '1',
						'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
					)
				);

				if ( $home_programs->have_posts() ) :
					$delay        = 200;
					$default_icons = array(
						0 => 'assets/images/icon-strength.png',
						1 => 'assets/images/icon-health.png',
						2 => 'assets/images/icon-weight-loss.png',
						3 => 'assets/images/icon-personal-coach.png',
					);
					$card_idx = 0;
					while ( $home_programs->have_posts() ) :
						$home_programs->the_post();
						$pid         = get_the_ID();
						$fallback_ic = isset( $default_icons[ $card_idx ] ) ? $default_icons[ $card_idx ] : 'assets/images/icon-strength.png';
						$icon_url    = hum_get_image_url( 'home_icon', $pid, $fallback_ic );
						$subtitle    = hum_get_field( 'home_subtitle', $pid, hum_get_field( 'program_duration', $pid, '' ) );
						$excerpt     = hum_get_field( 'home_excerpt', $pid, get_the_excerpt() );
						?>
						<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<div class="service-card">
								<div class="service-icon-box has-png-icon">
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr( get_the_title() . ' Icon' ); ?>" class="service-icon-img">
								</div>
								<h3 class="service-card-title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h3>
								<?php if ( $subtitle ) : ?>
									<span class="service-card-duration"><?php echo esc_html( strtoupper( $subtitle ) ); ?></span>
								<?php endif; ?>
								<p class="service-card-text"><?php echo esc_html( $excerpt ); ?></p>
								<a href="<?php the_permalink(); ?>" class="service-link">
									LEARN MORE <i class="fa-solid fa-arrow-right"></i>
								</a>
							</div>
						</div>
						<?php
						$delay += 100;
						$card_idx++;
					endwhile;
					wp_reset_postdata();
				else :
					$static_cards = array(
						array( 'icon-strength.png', 'STRENGTH TRAINING', '12 WEEKS TO BUILD MUSCLE', 'Targeted progressive overload protocols designed to build maximum raw power, muscle density, and functional athletic endurance.', $program_single_url, 200 ),
						array( 'icon-health.png', 'HEALTH PROGRAMS', '7 WEEKS TO SHAPE YOUR BODY', 'Holistic cardiovascular conditioning, mobility drills, and stamina sessions crafted to boost vitality and longevity.', $programs_url, 300 ),
						array( 'icon-weight-loss.png', 'WEIGHT LOSS', '8 WEEKS TO LOSE EXTRA WEIGHT', 'High-efficiency calorie burn circuits paired with balanced nutritional meal plans for sustainable, rapid fat reduction.', $programs_url, 400 ),
						array( 'icon-personal-coach.png', 'PERSONAL COACH', 'GET THE BODY OF YOUR DREAMS', 'Exclusive 1-on-1 private mentoring with Coach Sagar Soma, weekly biomechanics checkups, and bespoke coaching.', $program_single_url, 500 ),
					);
					foreach ( $static_cards as $sc ) :
						?>
						<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $sc[5] ); ?>">
							<div class="service-card">
								<div class="service-icon-box has-png-icon">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/' . $sc[0] ); ?>" alt="<?php echo esc_attr( $sc[1] . ' Icon' ); ?>" class="service-icon-img">
								</div>
								<h3 class="service-card-title"><?php echo esc_html( $sc[1] ); ?></h3>
								<span class="service-card-duration"><?php echo esc_html( $sc[2] ); ?></span>
								<p class="service-card-text"><?php echo esc_html( $sc[3] ); ?></p>
								<a href="<?php echo esc_url( $sc[4] ); ?>" class="service-link">
									LEARN MORE <i class="fa-solid fa-arrow-right"></i>
								</a>
							</div>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>

		</div>
	</section>

	<!-- ===================================================================
	     SECTION 4: GOAL & MISSION (STRONG & HEALTHY - ACF Fields)
	     =================================================================== -->
	<section class="section-goal">
		<div class="container px-lg-4">
			<div class="row align-items-center g-5">

				<div class="col-lg-6" data-aos="fade-right">
					<div class="goal-gallery-wrap">
						<img src="<?php echo esc_url( hum_get_image_url( 'home_goal_img_1', $front_id, 'assets/images/goal-1.jpg' ) ); ?>" alt="Athletic training woman with headphones" class="goal-img-left">
						<img src="<?php echo esc_url( hum_get_image_url( 'home_goal_img_2', $front_id, 'assets/images/goal-2.jpg' ) ); ?>" alt="Sporty woman outdoors" class="goal-img-right">
					</div>
				</div>

				<div class="col-lg-6" data-aos="fade-left">
					<span class="section-tag"><?php echo esc_html( hum_get_field( 'home_goal_tag', $front_id, 'ABOUT COACH SAGAR SOMA' ) ); ?></span>

					<h2 class="goal-title">
						<?php echo esc_html( hum_get_field( 'home_goal_title', $front_id, 'OUR GOAL IS TO MAKE YOU STRONG & HEALTHY' ) ); ?>
					</h2>

					<p class="goal-lead">
						<?php echo esc_html( hum_get_field( 'home_goal_lead', $front_id, 'There are 2,000 square meters of our personal trainer zone at Hustle Ur Muscle, equipped with best-in-class gear and coaching by Sagar Soma designed to push your limits.' ) ); ?>
					</p>

					<?php
					$goal_checks = hum_split_lines(
						hum_get_field(
							'home_goal_checklist',
							$front_id,
							"Personalized training plans tailored to your body type and current fitness level\nComprehensive nutrition guidance with simple, delicious and sustainable meal prep\nConstant progress tracking with weekly check-ins and scientific body metrics"
						)
					);
					?>
					<ul class="goal-checklist">
						<?php foreach ( $goal_checks as $chk ) : ?>
							<li>
								<i class="fa-solid fa-circle-check"></i>
								<span><?php echo esc_html( $chk ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>

					<a href="#" class="btn-fitness-blue" data-bs-toggle="modal" data-bs-target="#consultationModal">
						START TODAY <i class="fa-solid fa-arrow-right-long"></i>
					</a>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     SECTION 5: DUAL BANNER SPLIT (ACF Fields)
	     =================================================================== -->
	<section class="section-dual-banners">
		<div class="container-fluid p-0">
			<div class="row g-0">

				<div class="col-lg-6 dual-banner-col" data-aos="fade-up">
					<div class="dual-banner-bg dual-banner-bg-food" style="background-image: url('<?php echo esc_url( hum_get_image_url( 'home_banner_1_img', $front_id, 'assets/images/banner-food.jpg' ) ); ?>');"></div>
					<div class="dual-banner-overlay"></div>
					<div class="dual-banner-content">
						<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'home_banner_1_tag', $front_id, 'CUSTOM NUTRITION' ) ); ?></span>
						<h3 class="dual-banner-title"><?php echo esc_html( hum_get_field( 'home_banner_1_title', $front_id, 'WANT TO START NOW?' ) ); ?></h3>
						<p class="text-white-50 mb-4">
							<?php echo esc_html( hum_get_field( 'home_banner_1_desc', $front_id, 'Get an individual meal and workout plan crafted for your lifestyle by Hustle Ur Muscle.' ) ); ?>
						</p>
						<a href="#contact" class="btn-fitness-outline">
							<?php echo esc_html( hum_get_field( 'home_banner_1_btn', $front_id, 'GET A PLAN' ) ); ?>
						</a>
					</div>
				</div>

				<div class="col-lg-6 dual-banner-col" data-aos="fade-up" data-aos-delay="200">
					<div class="dual-banner-bg dual-banner-bg-gym" style="background-image: url('<?php echo esc_url( hum_get_image_url( 'home_banner_2_img', $front_id, 'assets/images/banner-gym.jpg' ) ); ?>');"></div>
					<div class="dual-banner-overlay"></div>
					<div class="dual-banner-content">
						<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'home_banner_2_tag', $front_id, 'JOIN OUR TEAM' ) ); ?></span>
						<h3 class="dual-banner-title"><?php echo esc_html( hum_get_field( 'home_banner_2_title', $front_id, 'WANT TO WORK WITH US?' ) ); ?></h3>
						<p class="text-white-50 mb-4">
							<?php echo esc_html( hum_get_field( 'home_banner_2_desc', $front_id, "Passionate about coaching? Join Sagar Soma's elite Hustle Ur Muscle fitness community." ) ); ?>
						</p>
						<a href="#contact" class="btn-fitness-outline">
							<?php echo esc_html( hum_get_field( 'home_banner_2_btn', $front_id, 'JOIN TEAM' ) ); ?>
						</a>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     SECTION 6: TESTIMONIALS (hum_testimonial CPT)
	     =================================================================== -->
	<section class="section-testimonials text-center" id="testimonials">
		<div class="container px-lg-4">

			<span class="section-tag tag-center" data-aos="fade-up"><?php echo esc_html( hum_get_field( 'home_test_tag', $front_id, 'TESTIMONIALS' ) ); ?></span>
			<h2 class="testimonials-title" data-aos="fade-up" data-aos-delay="100">
				<?php echo esc_html( hum_get_field( 'home_test_title', $front_id, 'OUR CLIENTS CHOOSE US BECAUSE WE ARE THE BEST' ) ); ?>
			</h2>

			<div class="swiper testimonial-swiper" data-aos="fade-up" data-aos-delay="200">
				<div class="swiper-wrapper">
					<?php
					$test_query = new WP_Query(
						array(
							'post_type'      => 'hum_testimonial',
							'posts_per_page' => 12,
							'post_status'    => 'publish',
							'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
						)
					);

					if ( $test_query->have_posts() ) :
						$t_idx = 1;
						while ( $test_query->have_posts() ) :
							$test_query->the_post();
							$tid        = get_the_ID();
							$stars      = max( 1, min( 5, (int) hum_get_field( 'rating_stars', $tid, 5 ) ) );
							$role       = hum_get_field( 'client_role', $tid, '' );
							$quote      = hum_get_field( 'testimonial_quote', $tid, '' );
							$avatar_url = hum_get_image_url( 'client_avatar', $tid );
							if ( ! $avatar_url && has_post_thumbnail( $tid ) ) {
								$avatar_url = get_the_post_thumbnail_url( $tid, 'thumbnail' );
							}
							if ( ! $avatar_url ) {
								$avatar_url = $theme_uri . '/assets/images/client-' . ( ( ( $t_idx - 1 ) % 4 ) + 1 ) . '.jpg';
							}
							?>
							<div class="swiper-slide">
								<div class="testimonial-card text-start">
									<div class="testimonial-stars">
										<?php for ( $i = 0; $i < $stars; $i++ ) : ?>
											<i class="fa-solid fa-star"></i>
										<?php endfor; ?>
									</div>
									<p class="testimonial-quote"><?php echo esc_html( $quote ); ?></p>
									<div class="testimonial-author-wrap">
										<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="testimonial-avatar">
										<div>
											<h4 class="testimonial-name"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h4>
											<?php if ( $role ) : ?>
												<div class="testimonial-role"><?php echo esc_html( $role ); ?></div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
							<?php
							$t_idx++;
						endwhile;
						wp_reset_postdata();
					else :
						$static_tests = array(
							array( 'client-1.jpg', 'DONNA COLE', 'Client • Lost 16 lbs', '"Training with Sagar Soma at Hustle Ur Muscle completely reshaped my fitness journey. In just 12 weeks I dropped 16 lbs of pure fat and gained solid muscle tone. The nutrition plan was so easy to follow!"' ),
							array( 'client-2.jpg', 'STEVE ROGERS', 'Client • Strength Athlete', '"Coach Sagar\'s guidance is attentive, professional, and kept me motivated every single workout session. Hustle Ur Muscle provided the exact environment I needed to succeed."' ),
							array( 'client-3.jpg', 'ALEX MORGAN', 'Client • Muscle Toning', '"As an entrepreneur, I struggled to stay consistent. The personalized workouts and meal strategies from Hustle Ur Muscle fit seamlessly into my schedule. Highest level of coaching!"' ),
							array( 'client-4.jpg', 'MARCUS VANCE', 'Client • Powerlifting', '"The atmosphere and expertise at Hustle Ur Muscle are unmatched. Sagar corrected my squat mechanics within two sessions, preventing injury and boosting my personal records."' ),
						);
						foreach ( $static_tests as $st ) :
							?>
							<div class="swiper-slide">
								<div class="testimonial-card text-start">
									<div class="testimonial-stars">
										<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
									</div>
									<p class="testimonial-quote"><?php echo esc_html( $st[3] ); ?></p>
									<div class="testimonial-author-wrap">
										<img src="<?php echo esc_url( $theme_uri . '/assets/images/' . $st[0] ); ?>" alt="<?php echo esc_attr( $st[1] ); ?>" class="testimonial-avatar">
										<div>
											<h4 class="testimonial-name"><?php echo esc_html( $st[1] ); ?></h4>
											<div class="testimonial-role"><?php echo esc_html( $st[2] ); ?></div>
										</div>
									</div>
								</div>
							</div>
							<?php
						endforeach;
					endif;
					?>
				</div>

				<div class="testimonial-swiper-pagination"></div>
			</div>

		</div>
	</section>

	<!-- ===================================================================
	     SECTION 7: CONTACT / CONSULTATION (Contact Form 7 Powered)
	     =================================================================== -->
	<section class="section-contact" id="contact">
		<div class="container-fluid p-0">
			<div class="row g-0 align-items-stretch">

				<div class="col-lg-6" data-aos="fade-right">
					<img src="<?php echo esc_url( hum_get_image_url( 'home_contact_img', $front_id, 'assets/images/contact-trainer.jpg' ) ); ?>" alt="Coach Sagar Soma Hustle Ur Muscle" class="contact-img-side">
				</div>

				<div class="col-lg-6 d-flex align-items-center" data-aos="fade-left">
					<div class="contact-form-wrap w-100">
						<span class="section-tag with-line"><?php echo esc_html( hum_get_field( 'home_contact_tag', $front_id, 'SEND US A LINE' ) ); ?></span>
						<h2 class="contact-title">
							<?php echo nl2br( esc_html( hum_get_field( 'home_contact_title', $front_id, "HAVE QUESTIONS?\nGET IN TOUCH WITH SAGAR!" ) ) ); ?>
						</h2>

						<?php hum_render_cf7_or_fallback( hum_get_field( 'home_cf7_shortcode', $front_id, '' ), 'home' ); ?>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     SECTION 8: LATEST ARTICLES (BLOG)
	     =================================================================== -->
	<section class="section-blog text-center" id="blog">
		<div class="container px-lg-4">

			<span class="section-tag tag-center" data-aos="fade-up"><?php echo esc_html( hum_get_field( 'home_blog_tag', $front_id, 'LATEST NEWS' ) ); ?></span>
			<h2 class="blog-section-title" data-aos="fade-up" data-aos-delay="100">
				<?php echo esc_html( hum_get_field( 'home_blog_title', $front_id, 'LATEST ARTICLES' ) ); ?>
			</h2>

			<div class="row g-4 text-start">
				<?php
				$latest_posts     = new WP_Query(
					array(
						'post_type'           => 'post',
						'posts_per_page'      => 4,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => true,
					)
				);
				$has_custom_posts = $latest_posts->have_posts() && ! ( 1 === (int) $latest_posts->post_count && 'hello-world' === $latest_posts->posts[0]->post_name );
				if ( $has_custom_posts ) :
					$delay = 200;
					while ( $latest_posts->have_posts() ) :
						$latest_posts->the_post();
						get_template_part(
							'template-parts/blog-card',
							null,
							array(
								'col_class' => 'col-xl-3 col-md-6',
								'delay'     => $delay,
								'cta_text'  => 'READ MORE',
							)
						);
						$delay += 100;
					endwhile;
					wp_reset_postdata();
				else :
					wp_reset_postdata();
					$static_posts = array(
						array( 'FOOD', 'blog-1.jpg', 'Healthy Meal Prep', 'AUG 12, 2026', '3', 'HEALTHY FOOD OPTIONS: COMPLETE GUIDE', 'Master the essential balance of lean proteins, complex carbs, and healthy fats to accelerate recovery.', 200 ),
						array( 'WORKOUT', 'blog-2.jpg', 'Heavy Weight Training', 'AUG 10, 2026', '5', 'THE RIGHT WAY TO START HEAVY WEIGHT TRAINING', 'Safe cues and progressive overload strategies to safely build muscle without putting joints at risk.', 300 ),
						array( 'TIPS', 'blog-3.jpg', 'Battle Ropes Training', 'AUG 06, 2026', '2', 'TOP TEN BODY TONING FITNESS PIECES OF TRAINING', 'High-intensity full-body circuits that boost anaerobic stamina and define every muscle group.', 400 ),
						array( 'CARDIO', 'blog-4.jpg', 'Outdoor Running Stairs', 'JUL 28, 2026', '4', 'RUNNING FOR EVERYONE: BASIC TRAINING TO IMPROVE SPEED', 'Proven interval splits and breathing techniques to develop aerobic capacity and effortless pace.', 500 ),
					);
					foreach ( $static_posts as $sp ) :
						?>
						<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $sp[7] ); ?>">
							<div class="blog-card">
								<div class="blog-img-wrap">
									<span class="blog-badge"><?php echo esc_html( $sp[0] ); ?></span>
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/' . $sp[1] ); ?>" alt="<?php echo esc_attr( $sp[2] ); ?>" class="blog-img">
								</div>
								<div class="blog-content">
									<div class="blog-meta">
										<span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( $sp[3] ); ?></span>
										<span><i class="fa-regular fa-comment"></i> <?php echo esc_html( $sp[4] ); ?></span>
									</div>
									<h3 class="blog-title">
										<a href="<?php echo esc_url( $blog_url ); ?>"><?php echo esc_html( $sp[5] ); ?></a>
									</h3>
									<p class="blog-excerpt"><?php echo esc_html( $sp[6] ); ?></p>
									<a href="<?php echo esc_url( $blog_url ); ?>" class="blog-read-more">
										READ MORE <i class="fa-solid fa-arrow-right"></i>
									</a>
								</div>
							</div>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>

		</div>
	</section>

<?php
get_footer();
