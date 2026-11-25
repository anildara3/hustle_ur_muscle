<?php
/**
 * Shared Blog / Archive / Search Layout Template Part
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri  = get_template_directory_uri();
$tag_label  = isset( $args['tag'] ) ? $args['tag'] : 'OUR FITNESS KNOWLEDGE';
$page_title = isset( $args['title'] ) ? $args['title'] : 'ARTICLES & BLOG';
$page_desc  = isset( $args['desc'] ) ? $args['desc'] : "Science-backed training guides, macro nutrition insights, and athletic development advice written by Coach Sagar Soma.";
$crumb_curr = isset( $args['crumb'] ) ? $args['crumb'] : 'BLOG';
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-about">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( $tag_label ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( $page_title ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( $page_desc ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current"><?php echo esc_html( $crumb_curr ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- Blog Listing & Sidebar Section -->
	<section class="section-blog py-5">
		<div class="container px-lg-4 my-4">
			<div class="row g-5">

				<!-- Left: Main Blog Articles (col-lg-8) -->
				<div class="col-lg-8">
					<div class="row g-4 text-start">
						<?php if ( have_posts() ) : ?>
							<?php
							$delay = 0;
							while ( have_posts() ) :
								the_post();
								get_template_part(
									'template-parts/blog-card',
									null,
									array(
										'col_class' => 'col-md-6',
										'delay'     => $delay,
										'cta_text'  => 'READ ARTICLE',
									)
								);
								$delay = ( $delay + 100 ) % 600;
							endwhile;
							?>
						<?php elseif ( is_search() ) : ?>
							<div class="col-12">
								<div class="p-5 bg-white border rounded text-center">
									<h3 class="heading-font text-uppercase mb-2">NO MATCHING RESULTS FOUND</h3>
									<p class="text-muted mb-4">Try another keyword or explore all training articles below.</p>
									<a href="<?php echo esc_url( hustleurmuscle_get_page_url( array( 'blog' ) ) ); ?>" class="btn-fitness-red">VIEW ALL ARTICLES</a>
								</div>
							</div>
						<?php else : ?>
							<?php
							$fallback_articles = array(
								array( 'FOOD', 'blog-1.jpg', 'Healthy Meal Prep', 'AUG 12, 2026', '5', 'HEALTHY FOOD OPTIONS: COMPLETE NUTRITION GUIDE', 'Master the essential balance of lean proteins, complex carbs, and essential fats to maximize muscle growth while burning body fat.', 0 ),
								array( 'WORKOUT', 'blog-2.jpg', 'Heavy Weight Training', 'AUG 10, 2026', '3', 'THE RIGHT WAY TO START HEAVY WEIGHT TRAINING', 'Safe barbell cues, biomechanical form checks, and progressive overload tactics to pack on lean muscle without risking joint injury.', 100 ),
								array( 'TIPS', 'blog-3.jpg', 'Battle Ropes Training', 'AUG 06, 2026', '4', 'TOP TEN BODY TONING FITNESS PIECES OF TRAINING', 'High-intensity functional conditioning circuits that torch stubborn body fat, build core stability, and sculpt athletic definition.', 200 ),
								array( 'CARDIO', 'blog-4.jpg', 'Running Stairs', 'JUL 28, 2026', '2', 'RUNNING FOR EVERYONE: BASIC TRAINING TO IMPROVE SPEED', 'Proven aerobic pacing protocols and breathing mechanics to expand your VO2 max and stamina without losing hard-earned muscle.', 300 ),
								array( 'RECOVERY', 'blog-5.jpg', 'Stretching and Mobility', 'JUL 15, 2026', '6', 'THE ROLE OF SLEEP & ACTIVE RECOVERY IN HYPERTROPHY', 'Why muscles grow outside the gym. Dive into central nervous system restoration, deep sleep phases, and targeted mobility drills.', 400 ),
								array( 'MINDSET', 'blog-6.jpg', 'Gym Discipline', 'JUL 02, 2026', '8', 'DEVELOPING CHAMPION DISCIPLINE: BEAT GYM BURNOUT', 'How Coach Sagar Soma coaches elite athletes through mental plateaus, maintaining relentless daily consistency year-round.', 500 ),
							);
							foreach ( $fallback_articles as $art ) :
								?>
								<div class="col-md-6" data-aos="fade-up"<?php echo $art[7] > 0 ? ' data-aos-delay="' . esc_attr( $art[7] ) . '"' : ''; ?>>
									<div class="blog-card">
										<div class="blog-img-wrap">
											<span class="blog-badge"><?php echo esc_html( $art[0] ); ?></span>
											<img src="<?php echo esc_url( $theme_uri . '/assets/images/' . $art[1] ); ?>" alt="<?php echo esc_attr( $art[2] ); ?>" class="blog-img">
										</div>
										<div class="blog-content">
											<div class="blog-meta">
												<span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( $art[3] ); ?></span>
												<span><i class="fa-regular fa-comment"></i> <?php echo esc_html( $art[4] ); ?></span>
											</div>
											<h3 class="blog-title">
												<a href="#"><?php echo esc_html( $art[5] ); ?></a>
											</h3>
											<p class="blog-excerpt"><?php echo esc_html( $art[6] ); ?></p>
											<a href="#" class="blog-read-more">READ ARTICLE <i class="fa-solid fa-arrow-right"></i></a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>

					<!-- Pagination -->
					<?php
					$pagination_links = paginate_links(
						array(
							'type'      => 'array',
							'prev_text' => '<i class="fa-solid fa-arrow-left me-1"></i> PREV',
							'next_text' => 'NEXT <i class="fa-solid fa-arrow-right ms-1"></i>',
						)
					);
					if ( ! empty( $pagination_links ) ) :
						?>
						<nav aria-label="Blog pagination">
							<ul class="pagination pagination-fitness">
								<?php foreach ( $pagination_links as $page_link ) : ?>
									<?php
									$is_active = false !== strpos( $page_link, 'current' );
									$styled    = str_replace( 'page-numbers', 'page-link', $page_link );
									?>
									<li class="page-item<?php echo $is_active ? ' active' : ''; ?>">
										<?php echo wp_kses_post( $styled ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
					<?php endif; ?>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</section>
