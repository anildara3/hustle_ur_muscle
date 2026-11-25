<?php
/**
 * Default WordPress Page Template
 *
 * @package HustleUrMuscle
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-about">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white">HUSTLE UR MUSCLE</span>
				<h1 class="page-header-title"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></h1>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current"><?php echo esc_html( strtoupper( get_the_title() ) ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<!-- Page Content -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="policy-card text-start" data-aos="fade-up">
						<div class="single-post-body">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
