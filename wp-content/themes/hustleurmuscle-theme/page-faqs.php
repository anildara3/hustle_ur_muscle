<?php
/**
 * Template Name: FAQs (hum_faq CPT + ACF Free)
 *
 * @package HustleUrMuscle
 */

get_header();

$page_id      = get_queried_object_id();
$contact_url  = hustleurmuscle_get_page_url( array( 'contact', 'contacts' ) );
$whatsapp_url = hustleurmuscle_get_option( 'hum_whatsapp_url', 'https://wa.me/' );
?>

	<!-- Breadcrumb Banner -->
	<section class="page-header-banner page-header-bg-food">
		<div class="container px-lg-4">
			<div class="page-header-content" data-aos="fade-up">
				<span class="section-tag tag-white"><?php echo esc_html( hum_get_field( 'faqs_banner_tag', $page_id, 'HELP & ANSWERS' ) ); ?></span>
				<h1 class="page-header-title"><?php echo esc_html( hum_get_field( 'faqs_banner_title', $page_id, 'FREQUENTLY ASKED QUESTIONS' ) ); ?></h1>
				<p class="page-header-desc">
					<?php echo esc_html( hum_get_field( 'faqs_banner_desc', $page_id, "Everything you need to know about Coach Sagar Soma's training programs, nutritional strategies, and joining Hustle Ur Muscle." ) ); ?>
				</p>
				<div class="breadcrumb-custom">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
					<span class="separator">/</span>
					<span class="current">FAQS</span>
				</div>
			</div>
		</div>
	</section>

	<!-- FAQs Section -->
	<section class="section-services py-5">
		<div class="container px-lg-4 my-4">
			<div class="row justify-content-center">
				<div class="col-lg-10">

					<div class="text-center mb-5" data-aos="fade-up">
						<span class="section-tag tag-center"><?php echo esc_html( hum_get_field( 'faqs_section_tag', $page_id, 'COMMON INQUIRIES' ) ); ?></span>
						<h2 class="services-title"><?php echo esc_html( hum_get_field( 'faqs_section_title', $page_id, 'ANSWERS FROM COACH SAGAR SOMA' ) ); ?></h2>
						<div class="trainer-name-divider">
							<span class="trainer-name-text">HUSTLE UR MUSCLE</span>
						</div>
					</div>

					<!-- FAQ Accordion (hum_faq CPT) -->
					<div class="accordion faq-accordion" id="mainFaqAccordion" data-aos="fade-up">
						<?php
						$faq_query = new WP_Query(
							array(
								'post_type'      => 'hum_faq',
								'posts_per_page' => -1,
								'post_status'    => 'publish',
								'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
							)
						);

						$faq_idx = 0;
						if ( $faq_query->have_posts() ) :
							while ( $faq_query->have_posts() ) :
								$faq_query->the_post();
								$fid = get_the_ID();
								if ( ! hum_get_bool_field( 'show_in_faqs_page', $fid, true ) ) {
									continue;
								}
								$faq_idx++;
								$is_first = ( 1 === $faq_idx );
								$h_id     = 'faqH' . $faq_idx;
								$c_id     = 'faqC' . $faq_idx;
								?>
								<div class="accordion-item">
									<h2 class="accordion-header" id="<?php echo esc_attr( $h_id ); ?>">
										<button class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $c_id ); ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $c_id ); ?>">
											<?php echo esc_html( get_the_title() ); ?>
										</button>
									</h2>
									<div id="<?php echo esc_attr( $c_id ); ?>" class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $h_id ); ?>" data-bs-parent="#mainFaqAccordion">
										<div class="accordion-body">
											<?php echo wp_kses_post( wpautop( get_the_content() ) ); ?>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>

					<!-- Quick Still Have Questions Box -->
					<div class="mt-5 p-4 p-md-5 bg-dark text-white rounded text-center border border-secondary" data-aos="fade-up">
						<div class="display-6 fw-bold heading-font text-uppercase mb-2">
							<?php echo esc_html( hum_get_field( 'faqs_cta_title', $page_id, 'STILL HAVE QUESTIONS?' ) ); ?>
						</div>
						<p class="text-white-50 fs-6 mx-auto mb-4 max-w-550">
							<?php echo esc_html( hum_get_field( 'faqs_cta_desc', $page_id, 'Can’t find the answer you’re looking for? Message Coach Sagar Soma directly and get personal guidance within 24 hours.' ) ); ?>
						</p>
						<div class="d-flex justify-content-center gap-3 flex-wrap">
							<a href="<?php echo esc_url( $contact_url ); ?>" class="btn-fitness-red">
								CONTACT COACH SAGAR <i class="fa-solid fa-arrow-right-long ms-2"></i>
							</a>
							<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn-fitness-outline">
								<i class="fa-brands fa-whatsapp text-success me-1"></i> CHAT ON WHATSAPP
							</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
