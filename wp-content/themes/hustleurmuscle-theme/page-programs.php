<?php
/**
 * Template Name: Training Programs (hum_program CPT + ACF Free)
 *
 * @package HustleUrMuscle
 */

get_header();

$theme_uri = get_template_directory_uri();
$page_id   = get_queried_object_id();
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-gym">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'programs_banner_tag', $page_id, 'PROVEN METHODS' ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( hum_get_field( 'programs_banner_title', $page_id, 'TRAINING PROGRAMS' ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( hum_get_field( 'programs_banner_desc', $page_id, 'Structured physical conditioning, progressive overload hypertrophy, and targeted nutrition protocols designed for sustainable transformations.' ) ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">PROGRAMS</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Programs Grid Section -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">

			<div class="text-center mb-5" data-aos="fade-up">
				<span class="section-tag tag-center"><?php echo esc_html( hum_get_field( 'programs_grid_tag', $page_id, 'INDIVIDUAL PLANS' ) ); ?></span>
				<h2 class="services-title"><?php echo esc_html( hum_get_field( 'programs_grid_title', $page_id, 'DEVELOPED WITH CARE AND YEARS OF EXPERIENCE' ) ); ?></h2>
				<div class="trainer-name-divider">
					<span class="trainer-name-text">SAGAR SOMA</span>
				</div>
			</div>

			<!-- Programs Grid (hum_program CPT) -->
			<div class="row g-4 text-start">
				<?php
				$prog_query = new WP_Query(
					array(
						'post_type'      => 'hum_program',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
					)
				);

				if ( $prog_query->have_posts() ) :
					$delay = 100;
					while ( $prog_query->have_posts() ) :
						$prog_query->the_post();
						$pid       = get_the_ID();
						$badge     = hum_get_field( 'program_badge', $pid, 'FITNESS' );
						$duration  = hum_get_field( 'program_duration', $pid, '12 WEEKS' );
						$price     = hum_get_field( 'program_price', $pid, '$129' );
						$unit      = hum_get_field( 'program_price_unit', $pid, '/ plan' );
						$featured  = hum_get_bool_field( 'program_featured_border', $pid, false );
						$features  = hum_split_lines( hum_get_field( 'program_features', $pid, '' ) );
						$img_url   = has_post_thumbnail( $pid ) ? get_the_post_thumbnail_url( $pid, 'medium_large' ) : $theme_uri . '/assets/images/banner-gym.jpg';
						?>
						<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<div class="program-card<?php echo $featured ? ' border-danger' : ''; ?>">
								<div class="program-img-wrap">
									<span class="program-badge-cat<?php echo $featured ? ' bg-danger' : ''; ?>"><?php echo esc_html( strtoupper( $badge ) ); ?></span>
									<span class="program-badge-duration"><i class="fa-regular fa-clock me-1"></i> <?php echo esc_html( strtoupper( $duration ) ); ?></span>
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="program-img">
								</div>
								<div class="program-content">
									<h3 class="program-title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h3>
									<p class="program-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
									<?php if ( ! empty( $features ) ) : ?>
										<ul class="program-features-list">
											<?php foreach ( $features as $feat ) : ?>
												<li><i class="fa-solid fa-circle-check"></i> <?php echo esc_html( $feat ); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
									<div class="program-footer-bar">
										<div class="program-price"><?php echo esc_html( $price ); ?> <span><?php echo esc_html( $unit ); ?></span></div>
										<a href="<?php the_permalink(); ?>" class="btn-fitness-red py-2 px-3 fs-6">
											VIEW DETAILS <i class="fa-solid fa-arrow-right ms-1"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
						$delay = ( $delay % 600 ) + 100;
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>

			<!-- Assessment Banner -->
			<div class="mt-5 p-4 p-md-5 bg-dark text-white rounded border border-secondary text-center" data-aos="fade-up">
				<h3 class="heading-font text-uppercase text-white mb-2"><?php echo esc_html( hum_get_field( 'programs_cta_title', $page_id, 'NOT SURE WHICH PROGRAM FITS YOUR BODY?' ) ); ?></h3>
				<p class="text-white-50 max-w-600 mx-auto mb-4">
					<?php echo esc_html( hum_get_field( 'programs_cta_desc', $page_id, 'Book a complimentary 1-on-1 assessment with Coach Sagar Soma. We analyze your body composition and recommend the ideal protocol.' ) ); ?>
				</p>
				<a href="#" class="btn-fitness-blue" data-bs-toggle="modal" data-bs-target="#consultationModal">
					SCHEDULE FREE EVALUATION <i class="fa-solid fa-calendar-check ms-2"></i>
				</a>
			</div>

		</div>
	</section>

<?php
get_footer();
