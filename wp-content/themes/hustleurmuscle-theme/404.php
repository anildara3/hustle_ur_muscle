<?php
/**
 * 404 Error Page Template
 *
 * @package HustleUrMuscle
 */

get_header();

$contact_url = hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) );
?>

	<!-- 404 Section -->
	<section class="section-404">
		<div class="container px-lg-4" data-aos="fade-up">
			<div class="error-404-glitch">
				4<span>0</span>4
			</div>
			<h1 class="error-404-subtitle">
				OOPS! LOOKS LIKE YOU DROPPED THE WEIGHT.
			</h1>
			<p class="error-404-text">
				The page you are looking for might have been moved, deleted, or does not exist. Even champion athletes miss a rep—let’s get you back in the game!
			</p>

			<div class="d-flex justify-content-center gap-3 flex-wrap">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-fitness-red">
					<i class="fa-solid fa-house me-2"></i> BACK TO HOME
				</a>
				<a href="<?php echo esc_url( home_url( '/#services' ) ); ?>" class="btn-fitness-blue">
					EXPLORE PROGRAMS <i class="fa-solid fa-dumbbell ms-2"></i>
				</a>
				<a href="<?php echo esc_url( $contact_url ); ?>" class="btn-fitness-outline">
					CONTACT COACH SAGAR
				</a>
			</div>

			<!-- Quick Search Bar inside 404 -->
			<div class="mt-5 mx-auto max-w-480">
				<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
					<div class="input-group">
						<input type="search" name="s" class="form-control bg-dark text-white border-secondary py-3 px-4" placeholder="Try searching for a workout or topic...">
						<button class="btn btn-danger px-4" type="submit">
							<i class="fa-solid fa-magnifying-glass"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</section>

<?php
get_footer();
