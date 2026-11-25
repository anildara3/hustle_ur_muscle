<?php
/**
 * The Blog Sidebar template
 *
 * @package HustleUrMuscle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri     = get_template_directory_uri();
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$whatsapp_url  = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$blog_url      = hustleurmuscle_get_page_url( array( 'blog' ) );
?>
<div class="col-lg-4">
	<aside class="blog-sidebar">

		<!-- Search Widget -->
		<div class="blog-sidebar-widget" data-aos="fade-left">
			<h4 class="widget-title">SEARCH BLOG</h4>
			<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
				<div class="input-group">
					<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="form-control" placeholder="Search keywords...">
					<button class="btn btn-danger" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
				</div>
			</form>
		</div>

		<!-- Author Bio Widget -->
		<div class="blog-sidebar-widget text-center" data-aos="fade-left" data-aos-delay="100">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/about-2.jpg' ); ?>" alt="Coach Sagar Soma" class="rounded-circle mb-3 border border-3 border-danger avatar-100">
			<h4 class="trainer-team-name mb-1">COACH SAGAR SOMA</h4>
			<span class="text-danger fw-bold small text-uppercase">Founder &amp; Head Trainer</span>
			<p class="text-muted small mt-2 mb-3">
				12+ years specializing in hypertrophy, body recomposition, and bio-mechanical strength coaching.
			</p>
			<div class="d-flex justify-content-center gap-2">
				<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-danger"><i class="fa-brands fa-instagram"></i></a>
				<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary"><i class="fa-brands fa-facebook-f"></i></a>
				<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success"><i class="fa-brands fa-whatsapp"></i></a>
			</div>
		</div>

		<!-- Categories Widget -->
		<div class="blog-sidebar-widget" data-aos="fade-left" data-aos-delay="200">
			<h4 class="widget-title">CATEGORIES</h4>
			<ul class="category-list">
				<?php
				$categories = get_categories(
					array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'hide_empty' => true,
					)
				);
				if ( ! empty( $categories ) ) :
					foreach ( $categories as $cat ) :
						?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
								<span><i class="fa-solid fa-angle-right text-danger me-2"></i> <?php echo esc_html( $cat->name ); ?></span>
								<span class="category-count"><?php echo esc_html( $cat->count ); ?></span>
							</a>
						</li>
						<?php
					endforeach;
				else :
					?>
					<li><a href="<?php echo esc_url( $blog_url ); ?>"><span><i class="fa-solid fa-angle-right text-danger me-2"></i> Strength Training</span> <span class="category-count">14</span></a></li>
					<li><a href="<?php echo esc_url( $blog_url ); ?>"><span><i class="fa-solid fa-angle-right text-danger me-2"></i> Nutrition &amp; Macro Diets</span> <span class="category-count">19</span></a></li>
					<li><a href="<?php echo esc_url( $blog_url ); ?>"><span><i class="fa-solid fa-angle-right text-danger me-2"></i> Fat Loss &amp; Conditioning</span> <span class="category-count">11</span></a></li>
					<li><a href="<?php echo esc_url( $blog_url ); ?>"><span><i class="fa-solid fa-angle-right text-danger me-2"></i> Personal Coaching</span> <span class="category-count">8</span></a></li>
					<li><a href="<?php echo esc_url( $blog_url ); ?>"><span><i class="fa-solid fa-angle-right text-danger me-2"></i> Recovery &amp; Mobility</span> <span class="category-count">6</span></a></li>
				<?php endif; ?>
			</ul>
		</div>

		<!-- Recent Posts Widget -->
		<div class="blog-sidebar-widget" data-aos="fade-left" data-aos-delay="300">
			<h4 class="widget-title">RECENT ARTICLES</h4>
			<?php
			$recent_query = new WP_Query(
				array(
					'posts_per_page'      => 3,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			);
			if ( $recent_query->have_posts() ) :
				while ( $recent_query->have_posts() ) :
					$recent_query->the_post();
					$thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) : $theme_uri . '/assets/images/blog-1.jpg';
					?>
					<div class="recent-post-item">
						<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="recent-post-thumb">
						<div>
							<h5 class="recent-post-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></h5>
							<div class="recent-post-date"><i class="fa-regular fa-calendar me-1"></i> <?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="recent-post-item">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-1.jpg' ); ?>" alt="Meal prep" class="recent-post-thumb">
					<div>
						<h5 class="recent-post-title"><a href="<?php echo esc_url( $blog_url ); ?>">Healthy Food Options: Complete Nutrition Guide</a></h5>
						<div class="recent-post-date"><i class="fa-regular fa-calendar me-1"></i> Aug 12, 2026</div>
					</div>
				</div>
				<div class="recent-post-item">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-2.jpg' ); ?>" alt="Barbell training" class="recent-post-thumb">
					<div>
						<h5 class="recent-post-title"><a href="<?php echo esc_url( $blog_url ); ?>">The Right Way to Start Heavy Weight Training</a></h5>
						<div class="recent-post-date"><i class="fa-regular fa-calendar me-1"></i> Aug 10, 2026</div>
					</div>
				</div>
				<div class="recent-post-item">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-3.jpg' ); ?>" alt="Battle ropes" class="recent-post-thumb">
					<div>
						<h5 class="recent-post-title"><a href="<?php echo esc_url( $blog_url ); ?>">Top Ten Body Toning Fitness Pieces of Training</a></h5>
						<div class="recent-post-date"><i class="fa-regular fa-calendar me-1"></i> Aug 06, 2026</div>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Free Consultation Promo Box in Sidebar -->
		<div class="blog-sidebar-widget bg-dark text-white p-4 text-center border-danger" data-aos="fade-left" data-aos-delay="400">
			<i class="fa-solid fa-dumbbell text-danger fs-1 mb-2"></i>
			<h4 class="heading-font text-uppercase text-white">READY TO TRANSFORM?</h4>
			<p class="text-white-50 small mb-3">Claim your complimentary 1-on-1 assessment with Sagar Soma today.</p>
			<a href="#" class="btn-fitness-red w-100 py-2 fs-6" data-bs-toggle="modal" data-bs-target="#consultationModal">
				BOOK FREE TRIAL
			</a>
		</div>

	</aside>
</div>
