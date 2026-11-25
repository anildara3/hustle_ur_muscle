<?php
/**
 * Single Post Template
 *
 * @package HustleUrMuscle
 */

get_header();

$theme_uri     = get_template_directory_uri();
$instagram_url = hustleurmuscle_get_option( 'hum_instagram_url', 'https://www.instagram.com/ssagarsomahustleurmuscle/' );
$facebook_url  = hustleurmuscle_get_option( 'hum_facebook_url', 'https://www.facebook.com/hustleurmuscle/' );
$whatsapp_url  = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
$blog_url      = hustleurmuscle_get_page_url( array( 'blog' ) );
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$categories   = get_the_category();
	$primary_cat  = ! empty( $categories ) ? strtoupper( $categories[0]->name ) : 'FITNESS & NUTRITION';
	$featured_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : $theme_uri . '/assets/images/blog-1.jpg';
	$post_url     = rawurlencode( get_permalink() );
	$post_title   = rawurlencode( get_the_title() );
	?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-food">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( $primary_cat ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( has_excerpt() ? get_the_excerpt() : 'Written by Coach Sagar Soma at Hustle Ur Muscle.' ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<a href="<?php echo esc_url( $blog_url ); ?>">BLOG</a>
					<span class="separator">/</span>
					<span class="current">ARTICLE</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Single Post & Sidebar Section -->
	<section class="section-blog py-5">
		<div class="container px-lg-4 my-4">
			<div class="row g-5">

				<!-- Left: Main Article Content (col-lg-8) -->
				<div class="col-lg-8">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-content text-start' ); ?>>

						<!-- Meta Bar -->
						<div class="blog-meta mb-3 pb-3 border-bottom">
							<span class="badge bg-danger text-uppercase px-3 py-2 me-2"><?php echo esc_html( $primary_cat ); ?></span>
							<span><i class="fa-regular fa-calendar"></i> <?php echo esc_html( strtoupper( get_the_date( 'M d, Y' ) ) ); ?></span>
							<span><i class="fa-regular fa-user"></i> <?php echo esc_html( strtoupper( get_the_author() ) ); ?></span>
							<span><i class="fa-regular fa-clock"></i> <?php echo esc_html( hustleurmuscle_reading_time() ); ?></span>
							<span><i class="fa-regular fa-comment"></i> <?php echo esc_html( get_comments_number() ); ?> COMMENTS</span>
						</div>

						<!-- Featured Image -->
						<img src="<?php echo esc_url( $featured_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="single-post-img-main">

						<div class="single-post-body">
							<?php the_content(); ?>
						</div>

						<!-- Tags -->
						<?php
						$tags = get_the_tags();
						if ( $tags ) :
							?>
							<div class="single-post-tags">
								<span class="fw-bold me-2 align-self-center text-uppercase fs-6">TAGS:</span>
								<?php foreach ( $tags as $tag ) : ?>
									<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-pill">#<?php echo esc_html( $tag->name ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Social Share Buttons -->
						<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 border-bottom">
							<span class="fw-bold text-uppercase fs-6">SHARE THIS ARTICLE:</span>
							<div class="d-flex gap-2">
								<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary"><i class="fa-brands fa-facebook-f me-1"></i> Share</a>
								<a href="<?php echo esc_url( 'https://api.whatsapp.com/send?text=' . $post_title . '%20' . $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp</a>
								<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-dark"><i class="fa-brands fa-x-twitter me-1"></i> Post</a>
							</div>
						</div>

						<!-- Author Box -->
						<div class="post-author-box">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/sagar-soma.png' ); ?>" alt="Coach Sagar Soma" class="post-author-avatar">
							<div>
								<h4 class="trainer-team-name text-white mb-1">COACH SAGAR SOMA</h4>
								<span class="text-danger fw-bold small text-uppercase">Head Coach &amp; Founder — Hustle Ur Muscle</span>
								<p class="text-white-50 small mt-2 mb-3">
									Sagar is a certified biomechanics personal trainer and nutrition consultant with 12+ years of hands-on athlete conditioning experience.
								</p>
								<div class="d-flex gap-2">
									<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-danger fs-5 me-2"><i class="fa-brands fa-instagram"></i></a>
									<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-white fs-5 me-2"><i class="fa-brands fa-facebook-f"></i></a>
									<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="text-success fs-5"><i class="fa-brands fa-whatsapp"></i></a>
								</div>
							</div>
						</div>

						<!-- Post Navigation -->
						<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();
						if ( $prev_post || $next_post ) :
							?>
							<div class="row g-3 py-3 border-top border-bottom">
								<div class="col-6">
									<?php if ( $prev_post ) : ?>
										<span class="text-muted small text-uppercase d-block">← PREVIOUS POST</span>
										<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="fw-bold text-dark text-decoration-none"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></a>
									<?php endif; ?>
								</div>
								<div class="col-6 text-end">
									<?php if ( $next_post ) : ?>
										<span class="text-muted small text-uppercase d-block">NEXT POST →</span>
										<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="fw-bold text-dark text-decoration-none"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

					</article>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();
