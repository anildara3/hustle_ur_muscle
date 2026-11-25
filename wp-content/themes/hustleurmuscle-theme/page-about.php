<?php
/**
 * Template Name: About Us (ACF Free + hum_trainer CPT)
 *
 * @package HustleUrMuscle
 */

get_header();

$theme_uri     = get_template_directory_uri();
$page_id       = get_queried_object_id();
$contact_url   = hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) );
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$whatsapp_url  = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$youtube_url   = hustleurmuscle_get_option( 'hum_youtube_url', 'https://www.youtube.com' );
?>

	<!-- ===================================================================
	     BREADCRUMB BANNER
	     =================================================================== -->
	<section class="page-header-banner page-header-bg-hero" style="background-image: url('<?php echo esc_url( hum_get_image_url( 'about_banner_img', $page_id, 'assets/images/hero-bg.jpg' ) ); ?>');">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'about_banner_tag', $page_id, 'WHO WE ARE' ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( hum_get_field( 'about_banner_title', $page_id, 'ABOUT HUSTLE UR MUSCLE' ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( hum_get_field( 'about_banner_desc', $page_id, 'Founded by Coach Sagar Soma, we are on a relentless mission to build stronger bodies, bulletproof mindsets, and sustainable athletic lifestyles.' ) ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">ABOUT US</span>
				</div>
			</div>
		</div>
	</section>

	<!-- ===================================================================
	     STORY & MISSION SECTION (COLLAGE)
	     =================================================================== -->
	<section class="section-full-service py-5">
		<div class="container px-lg-4 my-4">
			<div class="row align-items-center g-5">

				<div class="col-lg-6" data-aos="fade-right">
					<span class="section-tag with-line"><?php echo esc_html( hum_get_field( 'about_story_tag', $page_id, 'THE HUSTLE STORY' ) ); ?></span>
					<h2 class="about-title">
						<?php echo esc_html( hum_get_field( 'about_story_title_1', $page_id, 'WE ARE PASSIONATE ABOUT' ) ); ?>
						<span class="text-danger-custom"><?php echo esc_html( hum_get_field( 'about_story_title_2', $page_id, 'REAL TRANSFORMATION' ) ); ?></span>
					</h2>

					<h5 class="about-lead"><?php echo esc_html( hum_get_field( 'about_story_lead', $page_id, 'Founded by Head Coach Sagar Soma' ) ); ?></h5>

					<p class="about-desc">
						<?php echo esc_html( hum_get_field( 'about_story_p1', $page_id, 'Hustle Ur Muscle was created out of a desire to eliminate the guesswork, fad diets, and generic routines that dominate the fitness industry. Coach Sagar Soma developed a scientifically backed, results-driven coaching framework that bridges the gap between raw discipline and nutritional intelligence.' ) ); ?>
					</p>

					<p class="about-desc">
						<?php echo esc_html( hum_get_field( 'about_story_p2', $page_id, 'With 12+ years in personal physical conditioning, Sagar has helped hundreds of clients—from complete gym beginners to elite athletes—shatter plateaus, lose stubborn fat, and build dense muscular aesthetics.' ) ); ?>
					</p>

					<?php
					$story_checks = hum_split_lines(
						hum_get_field(
							'about_story_checks',
							$page_id,
							"Certified Bio-mechanics Form\nFlexible Macro Nutrition\nPrivate 1-on-1 Mentorship\nIn-Gym & Virtual Remote"
						)
					);
					?>
					<div class="row g-3 mt-2">
						<?php foreach ( $story_checks as $item ) : ?>
							<div class="col-sm-6">
								<div class="d-flex align-items-center gap-2 fw-bold text-white">
									<i class="fa-solid fa-circle-check text-danger"></i>
									<span><?php echo esc_html( $item ); ?></span>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="mt-4 pt-3">
						<a href="<?php echo esc_url( $contact_url ); ?>" class="btn-fitness-red me-3">
							TRAIN WITH SAGAR <i class="fa-solid fa-arrow-right-long ms-2"></i>
						</a>
					</div>
				</div>

				<div class="col-lg-6" data-aos="fade-left">
					<div class="about-collage">
						<div class="about-img-main-wrap">
							<img src="<?php echo esc_url( hum_get_image_url( 'about_story_img_1', $page_id, 'assets/images/about-1.jpg' ) ); ?>" alt="Coach Sagar Soma Workout" class="about-img-main">
						</div>
						<div class="about-img-overlay-card">
							<img src="<?php echo esc_url( hum_get_image_url( 'about_story_img_2', $page_id, 'assets/images/about-2.jpg' ) ); ?>" alt="Coach Sagar Soma" class="about-img-sub">
						</div>
						<div class="experience-badge">
							<div class="experience-years count-number" data-count="12">12</div>
							<div class="experience-label">YEARS OF<br>EXPERIENCE</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ===================================================================
	     STATS COUNTER SECTION (DARK)
	     =================================================================== -->
	<section class="section-stats-dark">
		<div class="container px-lg-4">
			<div class="row g-4">
				<?php
				$stats = array(
					array( hum_get_field( 'stat_1_num', $page_id, '1500' ), hum_get_field( 'stat_1_suffix', $page_id, '+' ), hum_get_field( 'stat_1_label', $page_id, 'Clients Transformed' ), 100 ),
					array( hum_get_field( 'stat_2_num', $page_id, '12' ), hum_get_field( 'stat_2_suffix', $page_id, '+' ), hum_get_field( 'stat_2_label', $page_id, 'Years of Coaching' ), 200 ),
					array( hum_get_field( 'stat_3_num', $page_id, '98' ), hum_get_field( 'stat_3_suffix', $page_id, '%' ), hum_get_field( 'stat_3_label', $page_id, 'Success Rate' ), 300 ),
					array( hum_get_field( 'stat_4_num', $page_id, '2000' ), hum_get_field( 'stat_4_suffix', $page_id, 'm²' ), hum_get_field( 'stat_4_label', $page_id, 'Modern Training Zone' ), 400 ),
				);
				foreach ( $stats as $st ) :
					?>
					<div class="col-lg-3 col-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $st[3] ); ?>">
						<div class="stat-item">
							<div class="stat-number"><span class="count-number" data-count="<?php echo esc_attr( $st[0] ); ?>"><?php echo esc_html( $st[0] ); ?></span><span><?php echo esc_html( $st[1] ); ?></span></div>
							<div class="stat-label"><?php echo esc_html( $st[2] ); ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ===================================================================
	     WHY CHOOSE US / CORE PILLARS (PNG Icons + ACF Fields)
	     =================================================================== -->
	<section class="section-services text-center py-5">
		<div class="container px-lg-4 my-4">
			<span class="section-tag tag-center" data-aos="fade-up"><?php echo esc_html( hum_get_field( 'pillars_tag', $page_id, 'WHY HUSTLE UR MUSCLE' ) ); ?></span>
			<h2 class="services-title" data-aos="fade-up" data-aos-delay="100">
				<?php echo esc_html( hum_get_field( 'pillars_title', $page_id, 'THE 4 PILLARS OF OUR ATHLETIC PHILOSOPHY' ) ); ?>
			</h2>
			<div class="trainer-name-divider" data-aos="fade-up" data-aos-delay="150">
				<span class="trainer-name-text">SAGAR SOMA</span>
			</div>

			<div class="row g-4 text-start">
				<?php
				$pillars = array(
					array( 'pillar_1_icon', 'assets/images/icon-science.png', 'pillar_1_title', 'SCIENCE-BASED DESIGN', 'pillar_1_desc', 'No generic cookie-cutter templates. Every exercise, rep scheme, and rest period is chosen according to your structural mechanics.', 200 ),
					array( 'pillar_2_icon', 'assets/images/icon-nutrition.png', 'pillar_2_title', 'CUSTOM MACRO DIETS', 'pillar_2_desc', 'Enjoy wholesome nutrition with precise protein, carbohydrate, and fat allocations that fuel workouts while keeping hunger under control.', 300 ),
					array( 'pillar_3_icon', 'assets/images/icon-audits.png', 'pillar_3_title', 'WEEKLY AUDITS', 'pillar_3_desc', 'We track circumference scans, scale metrics, and strength progression weekly, adjusting your volume to eliminate stagnation.', 400 ),
					array( 'pillar_4_icon', 'assets/images/icon-motivation.png', 'pillar_4_title', 'UNSTOPPABLE MOTIVATION', 'pillar_4_desc', 'Direct access to Coach Sagar Soma. Whenever you struggle with consistency or mindset, you have an expert pushing you forward.', 500 ),
				);
				foreach ( $pillars as $pil ) :
					$p_icon  = hum_get_image_url( $pil[0], $page_id, $pil[1] );
					$p_title = hum_get_field( $pil[2], $page_id, $pil[3] );
					$p_desc  = hum_get_field( $pil[4], $page_id, $pil[5] );
					?>
					<div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $pil[6] ); ?>">
						<div class="service-card">
							<div class="service-icon-box has-png-icon">
								<img src="<?php echo esc_url( $p_icon ); ?>" alt="<?php echo esc_attr( $p_title . ' Icon' ); ?>" class="service-icon-img">
							</div>
							<h3 class="service-card-title"><?php echo esc_html( strtoupper( $p_title ) ); ?></h3>
							<p class="service-card-text"><?php echo esc_html( $p_desc ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ===================================================================
	     MEET THE COACHING TEAM (hum_trainer CPT)
	     =================================================================== -->
	<section class="section-blog text-center py-5 bg-light">
		<div class="container px-lg-4 my-4">
			<span class="section-tag tag-center" data-aos="fade-up">EXPERT COACHES</span>
			<h2 class="blog-section-title" data-aos="fade-up" data-aos-delay="100">
				MEET THE HUSTLE UR MUSCLE TEAM
			</h2>

			<div class="row g-4 text-start justify-content-center">
				<?php
				$trainer_query = new WP_Query(
					array(
						'post_type'      => 'hum_trainer',
						'posts_per_page' => 12,
						'post_status'    => 'publish',
						'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
					)
				);

				if ( $trainer_query->have_posts() ) :
					$delay      = 200;
					$t_fallback = array( 'contact-trainer.jpg', 'trainer-2.jpg', 'trainer-3.jpg' );
					$idx        = 0;
					while ( $trainer_query->have_posts() ) :
						$trainer_query->the_post();
						$tid      = get_the_ID();
						$img_url  = hum_get_image_url( 'trainer_photo', $tid );
						if ( ! $img_url && has_post_thumbnail( $tid ) ) {
							$img_url = get_the_post_thumbnail_url( $tid, 'medium_large' );
						}
						if ( ! $img_url ) {
							$img_url = $theme_uri . '/assets/images/' . $t_fallback[ $idx % 3 ];
						}
						$role = hum_get_field( 'trainer_role', $tid, '' );
						$bio  = hum_get_field( 'trainer_bio', $tid, '' );
						$ig   = hum_get_field( 'trainer_instagram', $tid, $instagram_url );
						$fb   = hum_get_field( 'trainer_facebook', $tid, $facebook_url );
						$wa   = hum_get_field( 'trainer_whatsapp', $tid, '' );
						?>
						<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<div class="trainer-team-card">
								<div class="trainer-team-img-wrap">
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="trainer-team-img">
									<div class="trainer-social-overlay">
										<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
										<?php if ( $fb ) : ?><a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
										<?php if ( $wa ) : ?><a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp"></i></a><?php endif; ?>
									</div>
								</div>
								<div class="trainer-team-info">
									<h4 class="trainer-team-name"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h4>
									<?php if ( $role ) : ?><div class="trainer-team-role"><?php echo esc_html( $role ); ?></div><?php endif; ?>
									<?php if ( $bio ) : ?><p class="text-muted small mt-2 mb-0"><?php echo esc_html( $bio ); ?></p><?php endif; ?>
								</div>
							</div>
						</div>
						<?php
						$delay += 100;
						$idx++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</section>

	<!-- ===================================================================
	     VIDEO MOTIVATION BANNER
	     =================================================================== -->
	<section class="video-cta-banner video-cta-bg-gym" style="background-image: url('<?php echo esc_url( hum_get_image_url( 'about_video_img', $page_id, 'assets/images/banner-gym.jpg' ) ); ?>');">
		<div class="container px-lg-4 position-relative z-index-2" data-aos="zoom-in">
			<a href="<?php echo esc_url( hum_get_field( 'about_video_url', $page_id, $youtube_url ) ); ?>" target="_blank" rel="noopener noreferrer" class="video-play-btn" title="Watch Workout Showcase">
				<i class="fa-solid fa-play"></i>
			</a>
			<h2 class="display-4 fw-bold heading-font text-uppercase mb-3">
				<?php echo esc_html( hum_get_field( 'about_video_title', $page_id, 'PUSH BEYOND YOUR LIMITS WITH COACH SAGAR SOMA' ) ); ?>
			</h2>
			<p class="text-white-50 fs-5 mx-auto mb-4 max-w-650">
				<?php echo esc_html( hum_get_field( 'about_video_desc', $page_id, 'Join Hustle Ur Muscle today and unlock the body and mindset you have always envisioned.' ) ); ?>
			</p>
			<a href="<?php echo esc_url( $contact_url ); ?>" class="btn-fitness-red">
				GET STARTED TODAY <i class="fa-solid fa-arrow-right-long ms-2"></i>
			</a>
		</div>
	</section>

<?php
get_footer();
